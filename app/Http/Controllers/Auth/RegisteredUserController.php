<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['sometimes', 'regex:/^[0-9]+$/', 'min:9', 'max:13'],
            'identity_number' => [
                'sometimes',
                'string',
                'max:16',
                'unique:users'
            ],
            'role' => ['required', 'in:student,lecturer,admin'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create data on database
        $user = User::create([
            'name' => $request->name,
            'phone_number' => '+62' . $request->phone_number,
            'identity_number' => $request->identity_number,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Create session and login as user with logged in credentials
        Auth::login($user);
        $request->session()->regenerate();

        // Display dashboard
        return redirect(route('dashboard', absolute: false));
    }
}
