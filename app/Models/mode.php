<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'mode_name',
        'mode_description'
    ];

    public function device(){
        return $this->hasMany(Device::class);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'mode_device_activation')
            ->withPivot('activation_type', 'activation_details')
            ->withTimestamps();
    }

}
