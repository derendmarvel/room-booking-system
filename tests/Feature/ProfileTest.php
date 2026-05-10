<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ==========================================================
 * PROFILE FEATURE TEST
 * ==========================================================
 * This test class verifies user profile functionality
 * in the system.
 *
 * Features tested:
 * - Profile page access
 * - Profile information update
 * - Email verification behavior
 * - Account deletion
 * - Password validation for deletion
 *
 * This ensures that user account management features
 * work correctly and securely.
 * ==========================================================
 */
class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ==========================================================
     * TEST: PROFILE PAGE IS DISPLAYED
     * ==========================================================
     * Scenario:
     * - Authenticated user accesses profile page
     *
     * Expected:
     * - Page loads successfully (HTTP 200)
     */
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    /**
     * ==========================================================
     * TEST: PROFILE INFORMATION CAN BE UPDATED
     * ==========================================================
     * Scenario:
     * - User updates profile data (name, email, etc.)
     *
     * Expected:
     * - Data is updated in database
     * - No validation errors
     * - Redirect back to profile page
     */
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone_number' => '8578301013',
                'identity_number' => '278301013',
                'role' => $user->role,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    /**
     * ==========================================================
     * TEST: EMAIL VERIFICATION STATUS HANDLING
     * ==========================================================
     * Scenario:
     * - User updates profile without changing email
     *
     * Expected:
     * - Email verification status remains valid
     */
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
                'phone_number' => '8578301013',
                'identity_number' => '278301013',
                'role' => $user->role,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    /**
     * ==========================================================
     * TEST: USER CAN DELETE THEIR ACCOUNT
     * ==========================================================
     * Scenario:
     * - User deletes own account with correct password
     *
     * Expected:
     * - Account is removed from database
     * - User is logged out
     */
    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    /**
     * ==========================================================
     * TEST: WRONG PASSWORD PREVENTS ACCOUNT DELETION
     * ==========================================================
     * Scenario:
     * - User attempts to delete account with wrong password
     *
     * Expected:
     * - Validation error occurs
     * - Account is NOT deleted
     */
    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}