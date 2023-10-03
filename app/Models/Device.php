<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'device_type',
        'device_name',
        'is_active',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
