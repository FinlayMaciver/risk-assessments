<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $appends = ['hazard_ids', 'route_ids'];

    // public function getHazardIdsAttribute()
    // {
    //     return $this->hazards->pluck('id');
    // }

    // public function getRouteIdsAttribute()
    // {
    //     return $this->routes->pluck('id');
    // }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function hazards()
    {
        return $this->belongsToMany(Hazard::class, 'substance_hazards', 'substance_id', 'hazard_id');
    }

    public function routes()
    {
        return $this->morphToMany(Route::class, 'substance', 'substance_routes');
    }
}
