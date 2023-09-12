<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_key extends Model
{
    public function home(){
        return $this->hasOne(Home::class);
    }
}
