<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;
    public function clients(){
        return $this->belongsTo(client::class);
    }

    public function details(){
        return $this->hasMany(detail::class);
    }
}
