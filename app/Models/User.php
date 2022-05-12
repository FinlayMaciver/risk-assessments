<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'is_coshh_admin' => 'boolean',
    ];

    public function scopeCoshhAdmin($query)
    {
        return $query->where('is_coshh_admin', 1);
    }

    public function getFullNameAttribute()
    {
        return $this->forenames.' '.$this->surname;
    }

    public static function createFromLdap($guid)
    {
        $ldapSearch = \Ldap::findUser($guid);

        if (! $ldapSearch) {
            abort(404, 'Invalid GUID/matric.');
        }

        if (self::where('guid', $guid)->first()) {
            abort(422, 'Duplicate GUID/matric.');
        }

        if (self::where('email', $ldapSearch['email'])->first()) {
            abort(422, "Duplicate email address ({{$ldapSearch['email']}}).");
        }

        $user = new self();
        $user->forenames = $ldapSearch['forenames'];
        $user->surname = $ldapSearch['surname'];
        $user->guid = $guid;
        $user->email = $ldapSearch['email'];
        $user->save();

        return $user;
    }

    public function isCoshhAdmin(): bool
    {
        return (bool) $this->is_coshh_admin;
    }
}
