<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\Equipment;
use App\Models\RoomBooking;

class RoomBookingTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    private function actingUser()
    {
        // Explicitly defining role and a valid phone number 
        // to ensure it passes all internal validations
        return User::factory()->create([
            'role' => 'student',
            'phone_number' => '8123456789', 
            'identity_number' => '1231456789', 
        ]);
    }

    public function test_booking_requires_required_fields()
    {
        $user = $this->actingUser();

        // Changed from '/bookings' to route('bookings.store') -> '/book-room'
        $response = $this->actingAs($user)
            ->post(route('bookings.store'), []);

        $response->assertSessionHasErrors([
            'room_id',
            'usage_date',
            'start_time',
            'end_time',
            'purpose',
        ]);
    }

    public function test_end_time_must_be_after_start_time()
    {
        $user = $this->actingUser();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('bookings.store'), [
                'room_id' => $room->id,
                'usage_date' => now()->addDay()->toDateString(),
                'start_time' => '14:00',
                'end_time' => '12:00', // invalid
                'purpose' => 'Test',
            ]);

        $response->assertSessionHasErrors(['end_time']);
    }

    public function test_cannot_book_more_than_available_equipment_stock()
    {
        $user = $this->actingUser();
        $room = Room::factory()->create();

        $equipment = Equipment::factory()->create([
            'stock' => 5,
            'category' => 'audio',
        ]);

        $response = $this->actingAs($user)
            ->post(route('bookings.store'), [
                'room_id' => $room->id,
                'usage_date' => now()->addDay()->toDateString(),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'purpose' => 'Test booking',

                'equipments' => [
                    [
                        'equipment_id' => $equipment->id,
                        'quantity' => 10,
                    ]
                ]
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_valid_booking_is_created()
    {
        $user = $this->actingUser();
        $room = Room::factory()->create();

        $equipment = Equipment::factory()->create([
            'stock' => 10,
            'category' => 'audio',
        ]);

        $response = $this->actingAs($user)
            ->post(route('bookings.store'), [
                'room_id' => $room->id,
                'usage_date' => now()->addDay()->toDateString(),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'purpose' => 'Valid booking',

                'equipments' => [
                    [
                        'equipment_id' => $equipment->id,
                        'quantity' => 2,
                    ]
                ]
            ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('room_bookings', [
            'purpose' => 'Valid booking',
            'user_id' => $user->id,
        ]);
    }
}