<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\RoomBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature Test: Booking Approval System
 *
 * This test class verifies that:
 * - Admin users can approve bookings
 * - Admin users can reject bookings
 * - Unauthorized users (guests) cannot access booking approval endpoints
 *
 * This ensures that booking status management is restricted
 * only to users with the "admin" role.
 */
class BookingApprovalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create an admin user for testing purposes.
     *
     * @return \App\Models\User
     */
    private function admin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /**
     * Test: Admin can approve a booking request.
     *
     * Expected result:
     * - Booking status changes from "pending" to "approved"
     * - Database is updated correctly
     */
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

    /**
     * Test: Admin can reject a booking request.
     *
     * Expected result:
     * - Booking status changes from "pending" to "rejected"
     * - Database reflects updated status
     */
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

    /**
     * Test: Guest users cannot approve or reject bookings.
     *
     * Expected result:
     * - User is redirected to login page
     * - No unauthorized access to admin booking actions
     */
    public function test_guest_cannot_approve_or_reject()
    {
        $booking = RoomBooking::factory()->create();

        $this->put("/admin/bookings/{$booking->id}/approve")
            ->assertRedirect('/login');

        $this->put("/admin/bookings/{$booking->id}/reject")
            ->assertRedirect('/login');
    }
}