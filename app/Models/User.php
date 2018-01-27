<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public $userRoles = [
        0   => "Super Admin",
        1   => "Admin",
        2   => "User",
    ];

    public function isSuperAdmin() {
        return Auth::user()->role == 0;
    }

    public function isAdmin() {
        return Auth::user()->role == 1;
    }

    public function isUser() {
        return Auth::user()->role == 2;
    }
}
