<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FormUser extends Pivot
{
    use HasFactory;

    protected $casts = [
        'signed' => 'boolean',
        'signed_at' => 'timestamp',
    ];

    public function getFormattedSignedAtAttribute()
    {
        return Carbon::createFromTimestamp($this->signed_at)->format('d/m/y g:ma');
    }
}
