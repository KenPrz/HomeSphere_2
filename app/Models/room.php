<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    public function home()
    {
        return $this->belongsTo(Home::class, 'home_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'room_owner_id');
    }

}