<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\Equipment;
use App\Models\RoomBooking;

/**
 * ==========================================================
 * ROOM BOOKING FEATURE TEST
 * ==========================================================
 * This test class validates the room booking functionality
 * of the system.
 *
 * Features tested:
 * - Required field validation
 * - Time validation (end_time > start_time)
 * - Equipment stock validation
 * - Successful booking creation
 * - Basic route accessibility
 *
 * This ensures that booking logic, validation rules,
 * and database persistence work correctly.
 * ==========================================================
 */
class RoomBookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Basic route test to ensure application is running.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Create a standard authenticated user (student role)
     * used for booking tests.
     */
    private function actingUser()
    {
        return User::factory()->create([
            'role' => 'student',
            'phone_number' => '8123456789',
            'identity_number' => '1231456789',
        ]);
    }

    /**
     * ==========================================================
     * TEST: BOOKING REQUIRES REQUIRED FIELDS
     * ==========================================================
     * Scenario:
     * - User submits empty booking form
     *
     * Expected:
     * - Validation errors for required fields
     */
    public function test_booking_requires_required_fields()
    {
        $user = $this->actingUser();

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

    /**
     * ==========================================================
     * TEST: END TIME MUST BE AFTER START TIME
     * ==========================================================
     * Scenario:
     * - User submits invalid time range
     *
     * Expected:
     * - Validation error on end_time field
     */
    public function test_end_time_must_be_after_start_time()
    {
        $user = $this->actingUser();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('bookings.store'), [
                'room_id' => $room->id,
                'usage_date' => now()->addDay()->toDateString(),
                'start_time' => '14:00',
                'end_time' => '12:00',
                'purpose' => 'Test',
            ]);

        $response->assertSessionHasErrors(['end_time']);
    }

    /**
     * ==========================================================
     * TEST: CANNOT BOOK MORE THAN EQUIPMENT STOCK
     * ==========================================================
     * Scenario:
     * - User requests equipment quantity exceeding stock
     *
     * Expected:
     * - Validation error returned
     */
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

    /**
     * ==========================================================
     * TEST: VALID BOOKING IS CREATED
     * ==========================================================
     * Scenario:
     * - User submits valid booking request
     *
     * Expected:
     * - Booking is stored in database
     * - User is redirected to dashboard
     */
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