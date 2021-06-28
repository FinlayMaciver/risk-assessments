<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/y g:ma');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d/m/y g:ma');
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

    public function substances()
    {
        return $this->hasMany(Substance::class);
    }

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
