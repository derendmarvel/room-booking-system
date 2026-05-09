<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipment = [
            // VIDEO
            [
                'code' => 'EQ001',
                'name' => 'Epson Projector HD',
                'stock' => 5,
                'category' => 'video',
            ],
            [
                'code' => 'EQ002',
                'name' => 'Sony 4K Camera',
                'stock' => 3,
                'category' => 'video',
            ],
            [
                'code' => 'EQ003',
                'name' => 'Canon DSLR Camera',
                'stock' => 4,
                'category' => 'video',
            ],

            // AUDIO
            [
                'code' => 'EQ004',
                'name' => 'JBL Wireless Microphone',
                'stock' => 8,
                'category' => 'audio',
            ],
            [
                'code' => 'EQ005',
                'name' => 'Shure Dynamic Mic',
                'stock' => 6,
                'category' => 'audio',
            ],
            [
                'code' => 'EQ006',
                'name' => 'Portable Speaker BOSE',
                'stock' => 4,
                'category' => 'audio',
            ],

            // ACCESSORY
            [
                'code' => 'EQ007',
                'name' => 'Tripod Stand Heavy Duty',
                'stock' => 6,
                'category' => 'accessory',
            ],
            [
                'code' => 'EQ008',
                'name' => 'HDMI Cable 5m',
                'stock' => 20,
                'category' => 'accessory',
            ],
            [
                'code' => 'EQ009',
                'name' => 'Extension Power Strip',
                'stock' => 10,
                'category' => 'accessory',
            ],

            // COMPUTER
            [
                'code' => 'EQ010',
                'name' => 'MacBook Pro 16"',
                'stock' => 2,
                'category' => 'computer',
            ],
            [
                'code' => 'EQ011',
                'name' => 'Windows Laptop Dell XPS',
                'stock' => 3,
                'category' => 'computer',
            ],
            [
                'code' => 'EQ012',
                'name' => 'Wireless Keyboard & Mouse Set',
                'stock' => 12,
                'category' => 'computer',
            ],

            // NETWORKING
            [
                'code' => 'EQ013',
                'name' => 'TP-Link Router AC1200',
                'stock' => 5,
                'category' => 'networking',
            ],
            [
                'code' => 'EQ014',
                'name' => 'Network Switch 8-Port',
                'stock' => 4,
                'category' => 'networking',
            ],
            [
                'code' => 'EQ015',
                'name' => 'LAN Cable Cat6 (10m)',
                'stock' => 25,
                'category' => 'networking',
            ],
        ];

        foreach ($equipment as $item) {
            Equipment::create($item);
        }
    }
}