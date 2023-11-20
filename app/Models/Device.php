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
        'custom_name',
    ];

    public function find(){
        return $this->hasOne(Device::class,'id','');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function modes()
    {
        return $this->belongsToMany(Mode::class);
    }
}
