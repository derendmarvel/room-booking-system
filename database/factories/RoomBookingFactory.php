<?php

namespace Database\Factories;

use App\Models\RoomBooking;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomBookingFactory extends Factory
{
    protected $model = RoomBooking::class;

    public function definition(): array
    {
        $startTime = $this->faker->time('H:i');
        $endTime = $this->faker->time('H:i', $startTime); // ensures valid ordering

        return [
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'booking_date' => $this->faker->date(),
            'usage_date' => $this->faker->date(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'purpose' => $this->faker->sentence(),
            'status' => 'pending',
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => [
            'status' => 'approved',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn () => [
            'status' => 'rejected',
        ]);
    }
}