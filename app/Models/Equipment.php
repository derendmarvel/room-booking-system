<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'code',
        'name',
        'stock',
        'category',
    ];

    public function equipmentBookings()
    {
        return $this->hasMany(equipmentBooking::class);
    }
}
