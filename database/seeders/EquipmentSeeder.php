<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipment::create([
            'code' => 'EQ001',
            'name' => 'Epson Projector',
            'stock' => 5,
            'category' => 'video',
        ]);

        Equipment::create([
            'code' => 'EQ002',
            'name' => 'Sony Camera',
            'stock' => 3,
            'category' => 'video',
        ]);

        Equipment::create([
            'code' => 'EQ003',
            'name' => 'Wireless Mic JBL',
            'stock' => 8,
            'category' => 'audio',
        ]);

        Equipment::create([
            'code' => 'EQ004',
            'name' => 'Tripod Stand',
            'stock' => 6,
            'category' => 'accessory',
        ]);
    }
}