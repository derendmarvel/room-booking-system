<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_create_room()
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/rooms', [
            'name' => 'Room A',
            'location' => 'Building 1',
            'capacity' => 30,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rooms', [
            'name' => 'Room A',
            'location' => 'Building 1',
        ]);
    }

    public function test_admin_can_update_room()
    {
        $admin = $this->admin();

        $room = Room::factory()->create();

        $response = $this->actingAs($admin)->put("/rooms/{$room->id}", [
            'name' => 'Updated Room',
            'location' => 'Updated Location',
            'capacity' => 50,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'name' => 'Updated Room',
        ]);
    }

    public function test_admin_can_delete_room()
    {
        $admin = $this->admin();

        $room = Room::factory()->create();

        $response = $this->actingAs($admin)->delete("/rooms/{$room->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('rooms', [
            'id' => $room->id,
        ]);
    }

    public function test_guest_cannot_access_room_crud()
    {
        $room = Room::factory()->create();

        $this->post('/rooms', [])->assertRedirect('/login');
        $this->put("/rooms/{$room->id}", [])->assertRedirect('/login');
        $this->delete("/rooms/{$room->id}")->assertRedirect('/login');
    }
}