<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class humidity_sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'humidity'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
