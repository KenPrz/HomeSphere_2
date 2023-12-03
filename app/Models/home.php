<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Home extends Model
{
    use HasFactory, Notifiable;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->hasMany(HomeMember::class, 'home_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'home_id');
    }

}