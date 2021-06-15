<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubstance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hazards()
    {
        return $this->belongsToMany(Hazard::class, 'form_substance_hazards', 'form_substance_id', 'hazard_id');
    }
}
