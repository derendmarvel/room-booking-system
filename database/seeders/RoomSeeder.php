<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [

            // ======================
            // COMPUTER LABS
            // ======================
            [
                'name' => 'Lab Komputer 1',
                'building' => 'Gedung A',
                'floor' => 3,
                'capacity' => 30,
            ],
            [
                'name' => 'Lab Komputer 2',
                'building' => 'Gedung A',
                'floor' => 4,
                'capacity' => 35,
            ],
            [
                'name' => 'Lab AI & Data Science',
                'building' => 'Gedung C',
                'floor' => 2,
                'capacity' => 25,
            ],

            // ======================
            // CLASSROOMS
            // ======================
            [
                'name' => 'Ruang Kelas A101',
                'building' => 'Gedung A',
                'floor' => 1,
                'capacity' => 40,
            ],
            [
                'name' => 'Ruang Kelas A102',
                'building' => 'Gedung A',
                'floor' => 1,
                'capacity' => 40,
            ],
            [
                'name' => 'Ruang Kelas B201',
                'building' => 'Gedung B',
                'floor' => 2,
                'capacity' => 50,
            ],
            [
                'name' => 'Ruang Kelas B202',
                'building' => 'Gedung B',
                'floor' => 2,
                'capacity' => 50,
            ],

            // ======================
            // MEETING ROOMS
            // ======================
            [
                'name' => 'Meeting Room Alpha',
                'building' => 'Gedung B',
                'floor' => 5,
                'capacity' => 12,
            ],
            [
                'name' => 'Meeting Room Beta',
                'building' => 'Gedung B',
                'floor' => 5,
                'capacity' => 15,
            ],

            // ======================
            // SPECIAL ROOMS
            // ======================
            [
                'name' => 'Auditorium Utama',
                'building' => 'Gedung B',
                'floor' => 7,
                'capacity' => 500,
            ],
            [
                'name' => 'Studio Foto & Video',
                'building' => 'Gedung A',
                'floor' => 12,
                'capacity' => 12,
            ],
            [
                'name' => 'Music Recording Studio',
                'building' => 'Gedung C',
                'floor' => 6,
                'capacity' => 8,
            ],
            [
                'name' => 'Innovation Lab',
                'building' => 'Gedung C',
                'floor' => 3,
                'capacity' => 20,
            ],

            // ======================
            // SMALL ROOMS
            // ======================
            [
                'name' => 'Discussion Room 1',
                'building' => 'Gedung A',
                'floor' => 2,
                'capacity' => 6,
            ],
            [
                'name' => 'Discussion Room 2',
                'building' => 'Gedung A',
                'floor' => 2,
                'capacity' => 6,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}