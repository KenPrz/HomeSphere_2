<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode_name',
        'mode_type',
        'is_active',
    ];

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }
}
