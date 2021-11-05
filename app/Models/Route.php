<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    public function substances()
    {
        return $this->morphedByMany(Substance::class, 'substance', 'substance_routes');
    }

    public function microOrganisms()
    {
        return $this->morphedByMany(MicroOrganism::class, 'substance', 'substance_routes');
    }
}
