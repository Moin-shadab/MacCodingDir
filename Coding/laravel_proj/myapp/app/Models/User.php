<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'password', 'is_active', 'is_admin'];

    protected $hidden = ['password', 'remember_token'];

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }
}