<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    // Equipment has a factory
    use HasFactory;

    // Attributes
    protected $fillable = [
        'code',
        'name',
        'stock',
        'category',
    ];

    
    //Each equipment can be found in many equipmentBookings
    public function equipmentBookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }
}
