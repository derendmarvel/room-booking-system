<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_create_equipment()
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/equipment', [
            'name' => 'Projector',
            'stock' => 10,
            'description' => 'HD Projector',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('equipment', [
            'name' => 'Projector',
        ]);
    }

    public function test_admin_can_update_equipment()
    {
        $admin = $this->admin();

        $equipment = Equipment::factory()->create();

        $response = $this->actingAs($admin)->put("/equipment/{$equipment->id}", [
            'name' => 'Updated Projector',
            'stock' => 20,
            'description' => 'Updated desc',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'name' => 'Updated Projector',
        ]);
    }

    public function test_admin_can_delete_equipment()
    {
        $admin = $this->admin();

        $equipment = Equipment::factory()->create();

        $response = $this->actingAs($admin)->delete("/equipment/{$equipment->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('equipment', [
            'id' => $equipment->id,
        ]);
    }

    public function test_guest_cannot_access_equipment_crud()
    {
        $equipment = Equipment::factory()->create();

        $this->post('/equipment', [])->assertRedirect('/login');
        $this->put("/equipment/{$equipment->id}", [])->assertRedirect('/login');
        $this->delete("/equipment/{$equipment->id}")->assertRedirect('/login');
    }
}