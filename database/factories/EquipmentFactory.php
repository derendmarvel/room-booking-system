<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        $items = [
            'Projector',
            'Laptop',
            'HDMI Cable',
            'Whiteboard Marker',
            'Speaker',
            'Microphone',
            'Extension Cable',
            'Camera',
        ];

        return [
            'name' => $this->faker->randomElement($items),
            'code' => strtoupper($this->faker->unique()->bothify('EQP-####')),
            'stock' => $this->faker->numberBetween(1, 20),
            'category' => $this->faker->randomElement(['audio', 'video'])
        ];
    }
}