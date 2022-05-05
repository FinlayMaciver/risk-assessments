<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoshhFormDetails extends Model
{
    use HasFactory;

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
}
