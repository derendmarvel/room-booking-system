<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    // Room has a factory
    use HasFactory;

    // Room Atrributes
    protected $fillable = [
        'name',
        'building',
        'floor',
        'capacity',
    ];

    // Each room can be found in many roomBookings
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}
