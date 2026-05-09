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

        $response = $this->actingAs($admin)->post('/admin/equipments', [
            'code' => 'EQ123',
            'name' => 'Projector',
            'stock' => 10,
            'category' => 'video',
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

        $response = $this->actingAs($admin)->put("/admin/equipments/{$equipment->id}", [
            'code' => 'EQ125',
            'name' => 'Updated Projector',
            'stock' => 20,
            'category' => 'networking',
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

        $response = $this->actingAs($admin)->delete("/admin/equipments/{$equipment->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('equipment', [
            'id' => $equipment->id,
        ]);
    }

    public function test_guest_cannot_access_equipment_crud()
    {
        $equipment = Equipment::factory()->create();

        $this->post('/admin/equipments', [])->assertRedirect('/login');
        $this->put("/admin/equipments/{$equipment->id}", [])->assertRedirect('/login');
        $this->delete("/admin/equipments/{$equipment->id}")->assertRedirect('/login');
    }
}