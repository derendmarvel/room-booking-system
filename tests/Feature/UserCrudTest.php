<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

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

    public function test_guest_cannot_access_user_crud()
    {
        $user = User::factory()->create();

        $this->post('/admin/users', [])->assertRedirect('/login');
        $this->put("/admin/users/{$user->id}", [])->assertRedirect('/login');
        $this->delete("/admin/users/{$user->id}")->assertRedirect('/login');
    }
}