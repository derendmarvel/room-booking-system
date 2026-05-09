<?php
namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'building' => $this->faker->word(),
            'capacity' => $this->faker->numberBetween(10, 100),
            'floor' => $this->faker->numberBetween(1, 20),
        ];
    }
}