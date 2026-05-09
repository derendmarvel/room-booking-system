<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBooking extends Model
{
    // Attributes
    protected $fillable = [
        'room_booking_id',
        'equipment_id',
        'quantity'
    ];

    /**
     * Each equipment booking belongs to one room booking
     */
    public function roomBooking()
    {
        return $this->belongsTo(RoomBooking::class);
    }

    /**
     * Each equipment booking refers to one equipment/tool
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}