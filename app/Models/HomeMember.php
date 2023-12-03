<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HomeMember extends Model
{
    use HasFactory, Notifiable;

    public function home()
    {
        return $this->belongsTo(Home::class, 'home_id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
