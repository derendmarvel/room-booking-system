<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Lab Komputer 1',
            'building' => 'Gedung A',
            'floor' => 3,
            'capacity' => 30,
        ]);

        Room::create([
            'name' => 'Auditorium',
            'building' => 'Gedung B',
            'floor' => 7,
            'capacity' => 500,
        ]);

        Room::create([
            'name' => 'Studio Foto',
            'building' => 'Gedung A',
            'floor' => 12,
            'capacity' => 12,
        ]);
    }
}
