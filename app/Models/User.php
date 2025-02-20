<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function isAdmin()
    {
        return $this->is_admin === 1;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
