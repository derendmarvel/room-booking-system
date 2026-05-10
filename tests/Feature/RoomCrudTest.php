<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ==========================================================
 * ROOM CRUD FEATURE TEST
 * ==========================================================
 * This test class verifies the functionality of Room
 * management in the system (Admin only access).
 *
 * Features tested:
 * - Admin can create room
 * - Admin can update room
 * - Admin can delete room
 * - Guest cannot access room CRUD routes
 *
 * This ensures role-based access control is enforced
 * correctly for room management functionality.
 * ==========================================================
 */
class RoomCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create admin user for testing authorization.
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
     * ==========================================================
     * TEST: ADMIN CAN CREATE ROOM
     * ==========================================================
     * Scenario:
     * - Admin submits request to create a new room
     *
     * Expected:
     * - Room is stored in database
     * - System redirects after successful creation
     */
    public function test_admin_can_create_room()
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/admin/rooms', [
            'name' => 'Room A',
            'building' => 'Building 1',
            'capacity' => 30,
            'floor' => 1,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rooms', [
            'name' => 'Room A',
            'building' => 'Building 1',
        ]);
    }

    /**
     * ==========================================================
     * TEST: ADMIN CAN UPDATE ROOM
     * ==========================================================
     * Scenario:
     * - Admin updates existing room data
     *
     * Expected:
     * - Room data is updated in database
     * - System redirects after update
     */
    public function test_admin_can_update_room()
    {
        $admin = $this->admin();

        $room = Room::factory()->create();

        $response = $this->actingAs($admin)->put("/admin/rooms/{$room->id}", [
            'name' => 'Updated Room',
            'building' => 'Updated Location',
            'capacity' => 50,
            'floor' => 4
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'name' => 'Updated Room',
        ]);
    }

    /**
     * ==========================================================
     * TEST: ADMIN CAN DELETE ROOM
     * ==========================================================
     * Scenario:
     * - Admin deletes an existing room
     *
     * Expected:
     * - Room is removed from database
     * - System redirects after deletion
     */
    public function test_admin_can_delete_room()
    {
        $admin = $this->admin();

        $room = Room::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/rooms/{$room->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('rooms', [
            'id' => $room->id,
        ]);
    }

    /**
     * ==========================================================
     * TEST: GUEST CANNOT ACCESS ROOM CRUD
     * ==========================================================
     * Scenario:
     * - Unauthenticated user tries to access admin room routes
     *
     * Expected:
     * - User is redirected to login page
     */
    public function test_guest_cannot_access_room_crud()
    {
        $room = Room::factory()->create();

        $this->post('/admin/rooms', [])->assertRedirect('/login');
        $this->put("/admin/rooms/{$room->id}", [])->assertRedirect('/login');
        $this->delete("/admin/rooms/{$room->id}")->assertRedirect('/login');
    }
}