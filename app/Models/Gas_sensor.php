<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas_sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'gas_levels'   
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
