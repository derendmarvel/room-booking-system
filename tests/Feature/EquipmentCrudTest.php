<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ==========================================================
 * EQUIPMENT CRUD FEATURE TEST
 * ==========================================================
 * This test class verifies the functionality of equipment
 * management in the system (Admin only access).
 *
 * Features tested:
 * - Admin can create equipment
 * - Admin can update equipment
 * - Admin can delete equipment
 * - Guest cannot access equipment CRUD routes
 *
 * This ensures role-based access control is properly
 * enforced for equipment management functionality.
 * ==========================================================
 */
class EquipmentCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create admin user for authorization testing.
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
     * TEST: ADMIN CAN CREATE EQUIPMENT
     * ==========================================================
     * Scenario:
     * - Admin submits request to create equipment
     *
     * Expected:
     * - Equipment is stored in database
     * - System redirects after creation
     */
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

    /**
     * ==========================================================
     * TEST: ADMIN CAN UPDATE EQUIPMENT
     * ==========================================================
     * Scenario:
     * - Admin updates existing equipment data
     *
     * Expected:
     * - Equipment data is updated in database
     * - System redirects after update
     */
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

    /**
     * ==========================================================
     * TEST: ADMIN CAN DELETE EQUIPMENT
     * ==========================================================
     * Scenario:
     * - Admin deletes an existing equipment
     *
     * Expected:
     * - Equipment is removed from database
     * - System redirects after deletion
     */
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

    /**
     * ==========================================================
     * TEST: GUEST CANNOT ACCESS EQUIPMENT CRUD
     * ==========================================================
     * Scenario:
     * - Unauthenticated user tries to access admin routes
     *
     * Expected:
     * - User is redirected to login page
     */
    public function test_guest_cannot_access_equipment_crud()
    {
        $equipment = Equipment::factory()->create();

        $this->post('/admin/equipments', [])->assertRedirect('/login');
        $this->put("/admin/equipments/{$equipment->id}", [])->assertRedirect('/login');
        $this->delete("/admin/equipments/{$equipment->id}")->assertRedirect('/login');
    }
}