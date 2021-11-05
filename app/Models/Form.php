<?php

namespace App\Models;

use App\Models\GeneralFormDetails;
use App\Models\MicroOrganism;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Form extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
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
    ];

    protected $attributes = [
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
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/y g:ma');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d/m/y g:ma');
    }

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
}
