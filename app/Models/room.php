<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'home_id',
        'room_owner_id',
        'room_icon',
    ];

    public function home()
    {
        return $this->belongsTo(Home::class, 'home_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'room_owner_id');
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function tempSensor()
    {
        return $this->hasOne(Temp_sensor::class);
    }

    public function humiditySensor()
    {
        return $this->hasOne(Humidity_sensor::class);
    }

    public function motionSensor()
    {
        return $this->hasOne(Motion_sensor::class);
    }
}
