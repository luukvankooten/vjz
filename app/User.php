<?php

namespace App;

use App\Repositories\{HasRoles, HasPractitioner, HasConsult, HasGroup, HasAddress};
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,
        HasApiTokens,
        HasRoles,
        HasPractitioner,
        HasConsult,
        HasGroup,
        HasAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if id belongs to related id.
     *
     * @param $related
     * @return bool
     */
    public function owns($related)
    {
        return $this->id == $related->id;
    }

    public static function isAdmin()
    {
        return auth()->user()->hasRole('Admin');
    }
}
