<?php

namespace App\Models;

use App\Mail\RejectedForm;
use App\Models\GeneralFormDetails;
use App\Models\MicroOrganism;
use App\Models\User;
use App\Notifications\ApprovedForm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class Form extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'multi_user' => 'boolean',
        'eye_protection' => 'boolean',
        'face_protection' => 'boolean',
        'hand_protection' => 'boolean',
        'foot_protection' => 'boolean',
        'respiratory_protection' => 'boolean',
        'instructions' => 'boolean',
        'spill_neutralisation' => 'boolean',
        'eye_irrigation' => 'boolean',
        'body_shower' => 'boolean',
        'first_aid' => 'boolean',
        'breathing_apparatus' => 'boolean',
        'external_services' => 'boolean',
        'poison_antidote' => 'boolean',
        'routine_approval' => 'boolean',
        'specific_approval' => 'boolean',
        'personal_supervision' => 'boolean',
        'airborne_monitoring' => 'boolean',
        'biological_monitoring' => 'boolean',
        'inform_lab_occupants' => 'boolean',
        'inform_cleaners' => 'boolean',
        'inform_contractors' => 'boolean',
        'supervisor_approval' => 'boolean',
        'lab_guardian_approval' => 'boolean',
    ];

    protected $attributes = [
        'multi_user' => false,
        'eye_protection' => false,
        'face_protection' => false,
        'hand_protection' => false,
        'foot_protection' => false,
        'respiratory_protection' => false,
        'instructions' => false,
        'spill_neutralisation' => false,
        'eye_irrigation' => false,
        'body_shower' => false,
        'first_aid' => false,
        'breathing_apparatus' => false,
        'external_services' => false,
        'poison_antidote' => false,
        'routine_approval' => false,
        'specific_approval' => false,
        'personal_supervision' => false,
        'airborne_monitoring' => false,
        'biological_monitoring' => false,
        'inform_lab_occupants' => false,
        'inform_cleaners' => false,
        'inform_contractors' => false,
        'supervisor_approval' => null,
        'lab_guardian_approval' => null,
    ];

    /**
     * Additional attributes
     */

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/y g:ma');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d/m/y g:ma');
    }

    public function getNoRequirementsAttribute()
    {
        return (
            !$this->eye_protection &&
            !$this->face_protection &&
            !$this->hand_protection &&
            !$this->foot_protection &&
            !$this->respiratory_protection &&
            !$this->instructions &&
            !$this->spill_neutralisation &&
            !$this->eye_irrigation &&
            !$this->body_shower &&
            !$this->first_aid &&
            !$this->breathing_apparatus &&
            !$this->external_services &&
            !$this->poison_antidote &&
            !$this->routine_approval &&
            !$this->specific_approval &&
            !$this->personal_supervision &&
            !$this->airborne_monitoring &&
            !$this->biological_monitoring &&
            !$this->inform_lab_occupants &&
            !$this->inform_cleaners &&
            !$this->inform_contractors &&
            !$this->inform_other &&
            !$this->other_emergency &&
            !$this->other_protection
        );
    }

    public function getHasCommentsAttribute()
    {
        return $this->supervisor_comments || $this->lab_guardian_comments || $this->coshh_admin_comments;
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

    public function labGuardian()
    {
        return $this->belongsTo(User::class);
    }

    public function generalSection()
    {
        return $this->hasOne(GeneralFormDetails::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'form_users');
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

    public function updateRisk($risk)
    {
        $this->risks()->updateOrCreate(
            ['id' => $risk->id ?? null],
            $risk->attributesToArray()
        );
    }

    public function addGeneralSection($attributes = [])
    {
        GeneralFormDetails::updateOrCreate(
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
            'status' => $verdict ? 'Pending' : 'Rejected',
            'supervisor_approval' => $verdict,
            'supervisor_comments' => $comments
        ]);
        if ($verdict) {
            $this->user->notify(new ApprovedForm($this, 'supervisor'));
        } else {
            Mail::to($this->user)
                ->bcc([
                    $this->labGuardian,
                    User::coshhAdmin()->first()
                ])
                ->send(new RejectedForm($this, 'supervisor'));
        }
    }

    public function labGuardianApproval(bool $verdict, $comments = null)
    {
        $this->update([
            'status' => $verdict ? 'Pending' : 'Rejected',
            'lab_guardian_approval' => $verdict,
            'lab_guardian_comments' => $comments
        ]);
        if ($verdict) {
            $this->user->notify(new ApprovedForm($this, 'lab guardian'));
        } else {
            Mail::to($this->user)
                ->bcc([
                    $this->supervisor,
                    User::coshhAdmin()->first()
                ])
                ->send(new RejectedForm($this, 'lab guardian'));
        }
    }

    public function coshhAdminApproval(bool $verdict, $comments = null)
    {
        $this->update([
            'status' => $verdict ? 'Approved' : 'Rejected',
            'coshh_admin_approval' => $verdict,
            'coshh_admin_comments' => $comments
        ]);
        if ($verdict) {
            $this->user->notify(new ApprovedForm($this, 'school safety officer'));
        } else {
            Mail::to($this->user)
                ->bcc([
                    $this->supervisor,
                    $this->labGuardian,
                    User::coshhAdmin()->first()
                ])
                ->send(new RejectedForm($this, 'school safety officer'));
        }
    }
}
