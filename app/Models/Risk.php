<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRatingWithAttribute()
    {
        return $this->likelihoodWith()->first()->value * $this->impactWith()->first()->value;
    }

    public function getRatingWithoutAttribute()
    {
        return $this->likelihoodWithout()->first()->value * $this->impactWithout()->first()->value;
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function likelihoodWith()
    {
        return $this->belongsTo(Likelihood::class, 'likelihood_with');
    }

    public function likelihoodWithout()
    {
        return $this->belongsTo(Likelihood::class, 'likelihood_without');
    }

    public function impactWith()
    {
        return $this->belongsTo(Impact::class, 'impact_with');
    }

    public function impactWithout()
    {
        return $this->belongsTo(Impact::class, 'impact_without');
    }
}
