<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ==========================================================
 * USER CRUD FEATURE TEST
 * ==========================================================
 * This test class verifies the functionality of
 * User Management (CRUD) in the system.
 *
 * Features tested:
 * - Admin can create user
 * - Admin can update user
 * - Admin can delete user
 * - Guest (unauthenticated user) cannot access CRUD
 *
 * These tests ensure role-based access control is working
 * properly in the application.
 * ==========================================================
 */
class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create an admin user for testing authorization.
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
     * TEST: ADMIN CAN CREATE USER
     * ==========================================================
     * Scenario:
     * - Admin submits a request to create a new user
     *
     * Expected:
     * - User is created in database
     * - System redirects to admin dashboard
     */
    public function test_admin_can_create_user()
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone_number' => '08123456789',
            'identity_number' => '1234567890',
            'role' => 'student',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'student',
        ]);
    }

    /**
     * ==========================================================
     * TEST: ADMIN CAN UPDATE USER
     * ==========================================================
     * Scenario:
     * - Admin updates existing user data
     *
     * Expected:
     * - User data is updated in database
     * - System redirects to admin dashboard
     */
    public function test_admin_can_update_user()
    {
        $admin = $this->admin();
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put("/admin/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone_number' => '08111111111',
            'identity_number' => '9999999999',
            'role' => 'lecturer',
        ]);

        $response->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * ==========================================================
     * TEST: ADMIN CAN DELETE USER
     * ==========================================================
     * Scenario:
     * - Admin deletes an existing user
     *
     * Expected:
     * - User is removed from database
     * - System redirects back
     */
    public function test_admin_can_delete_user()
    {
        $admin = $this->admin();
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/users/{$user->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * ==========================================================
     * TEST: GUEST CANNOT ACCESS USER CRUD
     * ==========================================================
     * Scenario:
     * - Unauthenticated user tries to access admin routes
     *
     * Expected:
     * - User is redirected to login page
     */
    public function test_guest_cannot_access_user_crud()
    {
        $user = User::factory()->create();

        $this->post('/admin/users', [])->assertRedirect('/login');
        $this->put("/admin/users/{$user->id}", [])->assertRedirect('/login');
        $this->delete("/admin/users/{$user->id}")->assertRedirect('/login');
    }
}