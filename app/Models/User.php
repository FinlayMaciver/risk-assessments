<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'remember_token',
    ];

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
}
