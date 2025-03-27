<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class worker extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function account(){
        return $this->hasOne(account::class);
    }
   
    public function orders(){
        return $this->hasMany(order::class);
    }
    
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'image',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
