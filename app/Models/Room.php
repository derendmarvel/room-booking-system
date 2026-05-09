<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'building',
        'floor',
        'capacity',
    ];

    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}
