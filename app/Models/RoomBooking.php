<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomBooking extends Model
{
    // RoomBooking has a factory
    use HasFactory;

    // RoomBooking Attributes
    protected $fillable = [
        'user_id',
        'room_id',
        'booking_date',
        'usage_date',
        'start_time',
        'end_time',
        'status',
        'purpose',
    ];

    // Each room booking belongs to one room 
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Each room booking belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each room can be found in many equipmentBookings
    public function equipmentBookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }
}