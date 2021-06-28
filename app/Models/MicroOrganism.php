<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicroOrganism extends Model
{
    use HasFactory;

    public function routes()
    {
        return $this->morphToMany(Route::class, 'substance', 'substance_routes');
    }
}
