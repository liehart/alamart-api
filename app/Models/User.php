<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'telephone', 'dob', 'image', 'activation_token', 'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'activation_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
