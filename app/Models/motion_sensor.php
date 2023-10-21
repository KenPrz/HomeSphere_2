<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class motion_sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'is_active',
        'motion_detected'
    ];

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }
}
