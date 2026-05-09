<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

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
