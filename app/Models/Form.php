<?php

namespace App\Models;

use App\Models\CoshhFormDetails;
use App\Models\MicroOrganism;
use App\Models\User;
use App\Notifications\ApprovedForm;
use App\Notifications\FormSubmitted;
use App\Notifications\RejectedForm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Form extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'multi_user' => 'boolean',
        'supervisor_approval' => 'boolean',
        'is_archived' => 'boolean',
        'review_date' => 'date:Y-m-d',
    ];

    protected $attributes = [
        'multi_user' => false,
        'supervisor_approval' => null,
    ];

    /**
     * Scopes
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeAwaitingReviewerApprovalFrom($query, User $user)
    {
        return $query->whereHas('reviewers', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('approved', null);
        });
    }

    public function scopeAwaitingSupervisorApprovalFrom($query, User $user)
    {
        return $query->where('supervisor_id', $user->id)->where('supervisor_approval', null);
    }

    /**
     * Additional attributes
     */
    public function getFormattedReviewDateAttribute()
    {
        return $this->review_date->format('d/m/y');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/y g:ma');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d/m/y g:ma');
    }

    public function awaitingReviewerApproval()
    {
        if ($this->reviewers()->wherePivot('approved', null)->exists()) {
            return true;
        }
        return false;
    }

    public function getNoRequirementsAttribute()
    {
        return
            ! $this->eye_protection &&
            ! $this->face_protection &&
            ! $this->hand_protection &&
            ! $this->foot_protection &&
            ! $this->respiratory_protection &&
            ! $this->instructions &&
            ! $this->spill_neutralisation &&
            ! $this->eye_irrigation &&
            ! $this->body_shower &&
            ! $this->first_aid &&
            ! $this->breathing_apparatus &&
            ! $this->external_services &&
            ! $this->poison_antidote &&
            ! $this->routine_approval &&
            ! $this->specific_approval &&
            ! $this->personal_supervision &&
            ! $this->airborne_monitoring &&
            ! $this->biological_monitoring &&
            ! $this->inform_lab_occupants &&
            ! $this->inform_cleaners &&
            ! $this->inform_contractors &&
            ! $this->inform_other &&
            ! $this->other_emergency &&
            ! $this->other_protection;
    }

    public function getHasCommentsAttribute()
    {
        return $this->supervisor_comments;
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'form_reviewers')->using(FormReviewer::class)->withPivot('approved', 'comments');
    }

    public function coshhSection()
    {
        return $this->hasOne(CoshhFormDetails::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'form_users')->using(FormUser::class);
    }

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }

    public function substances()
    {
        return $this->hasMany(Substance::class);
    }

    public function microOrganisms()
    {
        return $this->hasMany(MicroOrganism::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Methods
     */
    public function archive()
    {
        $this->is_archived = true;
        $this->save();
    }

    public function updateRisk($risk)
    {
        $this->risks()->updateOrCreate(
            ['id' => $risk->id ?? null],
            $risk->attributesToArray()
        );
    }

    public function addCoshhSection($attributes = [])
    {
        CoshhFormDetails::updateOrCreate(
            ['form_id' => $this->id],
            is_array($attributes) ? $attributes : $attributes->toArray()
        );
    }

    public function addSubstance($substance)
    {
        $savedSubstance = $this->substances()->updateOrCreate(['id' => $substance->id], $substance->makeHidden(['hazard_ids', 'route_ids'])->attributesToArray());
        $savedSubstance->hazards()->sync($substance->hazard_ids);
        $savedSubstance->routes()->sync($substance->route_ids);
        $savedSubstance->save();
    }

    public function deleteSubstance($substance)
    {
        $substance->routes()->detach();
        $substance->delete();
    }

    public function addMicroOrganism($microOrganism)
    {
        $savedMicroOrganism = $this->microOrganisms()->updateOrCreate(['id' => $microOrganism->id], $microOrganism->makeHidden('route_ids')->attributesToArray());
        $savedMicroOrganism->routes()->sync($microOrganism->route_ids);
        $savedMicroOrganism->save();
    }

    public function deleteMicroOrganism($microOrganism)
    {
        $microOrganism->routes()->detach();
        $microOrganism->delete();
    }

    public function addFile(UploadedFile $file)
    {
        $fileNumber = $this->fresh()->files->count() + 1;
        $filename = "form_{$this->id}/file_{$fileNumber}.dat";
        Storage::disk('coshh')->put($filename, $file->get());

        $this->files()->create([
            'form_id' => $this->id,
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'mimetype' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    public function deleteFile($file)
    {
        $this->files()->findOrFail($file->id)->delete();
        Storage::disk('coshh')->delete($file->filename);
    }

    public function supervisorApproval(bool $verdict, $comments = null)
    {
        $this->update([
            'status' => $verdict ? 'Approved' : 'Rejected',
            'supervisor_approval' => $verdict,
            'supervisor_comments' => $comments,
        ]);
        if ($verdict) {
            $this->user->notify(new ApprovedForm($this, 'supervisor'));
        } else {
            $this->user->notify(new RejectedForm($this, 'supervisor'));
        }
    }

    public function reviewerApproval(User $reviewer, bool $verdict, $comments = null)
    {
        $this->update([
            'status' => $verdict ? $this->status : 'Rejected',
        ]);
        $this->reviewers()->updateExistingPivot(
            $reviewer->id,
            [
                'approved' => $verdict,
                'comments' => $comments
            ]
        );

        if ($verdict) {
            $this->user->notify(new ApprovedForm($this, 'reviewer'));
            if ($this->reviewers()->wherePivot('approved', true)->count() == $this->reviewers->count()) {
                $this->supervisor->notify(new FormSubmitted($this, 'supervisor'));
            }
        } else {
            $this->user->notify(new RejectedForm($this, 'reviewer'));
        }
    }

    public function signForm(User $user)
    {
        $this->users()->attach($user);
    }

    public function toSearchableArray(): array
    {
        $fields = $this->toArray();
        $fields['user_name'] = $this->user?->full_name;
        $fields['supervisor_name'] = $this->supervisor?->full_name;
        foreach ($this->risks as $risk) {
            $fields['risk_' . $risk->id] = $risk->toArray();
        }
        foreach ($this->substances as $substance) {
            $fields['substance_' . $substance->id] = $substance->toArray();
        }
        foreach ($this->microOrganisms as $microOrganism) {
            $fields['micro_organism_' . $microOrganism->id] = $microOrganism->toArray();
        }

        return $fields;
    }
}
