<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'stock',
        'category',
    ];

   public function equipmentBookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }
}
