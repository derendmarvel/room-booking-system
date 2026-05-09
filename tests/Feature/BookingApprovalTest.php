<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\RoomBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingApprovalTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_approve_booking()
    {
        $admin = $this->admin();

        $booking = RoomBooking::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->put("/admin/bookings/{$booking->id}/approve");

        $response->assertRedirect();

        $this->assertDatabaseHas('room_bookings', [
            'id' => $booking->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_reject_booking()
    {
        $admin = $this->admin();

        $booking = RoomBooking::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->put("/admin/bookings/{$booking->id}/reject");

        $response->assertRedirect();

        $this->assertDatabaseHas('room_bookings', [
            'id' => $booking->id,
            'status' => 'rejected',
        ]);
    }

    public function test_guest_cannot_approve_or_reject()
    {
        $booking = RoomBooking::factory()->create();

        $this->put("/admin/bookings/{$booking->id}/approve")
            ->assertRedirect('/login');

        $this->put("/admin/bookings/{$booking->id}/reject")
            ->assertRedirect('/login');
    }
}