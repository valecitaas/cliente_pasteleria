<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //un cliente hace muchas ventas 
    public function sales(){
        return $this->hasMany(sale::class);
    }

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'image',
        'status',
        'verify_email',
        'social_media',
        'id_account'
    ];

}

