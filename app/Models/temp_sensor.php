<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temp_sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'temperature'   
    ];

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }
}
