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

    public function test_guest_cannot_access_room_crud()
    {
        $room = Room::factory()->create();

        $this->post('/admin/rooms', [])->assertRedirect('/login');
        $this->put("/admin/rooms/{$room->id}", [])->assertRedirect('/login');
        $this->delete("/admin/rooms/{$room->id}")->assertRedirect('/login');
    }
}