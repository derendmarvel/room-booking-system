<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Display profile edit form
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Retrieve validated input data from the request
        $data = $request->validated();

        // Normalize phone number into international Indonesian format (+62)
        // Removes leading 0 before appending country code
        $data['phone_number'] = '+62' . ltrim($data['phone_number'], '0');

        // Fill the authenticated user's model with updated data (not yet saved)
        $request->user()->fill($data);

        // If the email has been changed, reset email verification status
        // so the user must re-verify their new email address
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Save the updated user data to the database
        $request->user()->save();

        // Redirect back to profile page with a success flash message
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate that the provided password matches the current authenticated user
        // Errors are stored in a dedicated "userDeletion" error bag
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Get the currently authenticated user instance
        $user = $request->user();

        // Log the user out before deleting the account
        Auth::logout();

        // Delete the user's record from the database
        $user->delete();

        // Invalidate the session to clear all session data
        $request->session()->invalidate();

        // Regenerate CSRF token to prevent session fixation attacks
        $request->session()->regenerateToken();

        // Redirect user to the homepage after account deletion
        return Redirect::to('/');
    }
}
