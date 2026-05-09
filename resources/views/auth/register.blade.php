@section('title', 'Register')

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />

            <div class="flex mt-1">
                
                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-white text-gray-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400">
                    +62
                </span>
                <x-text-input
                    id="phone_number"
                    class="block w-full rounded-l-none"
                    type="text"
                    name="phone_number"
                    :value="old('phone_number')"
                    required
                />
            </div>

            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- NIM / NIK -->
        <div class="mt-4">
            <x-input-label for="identity_number" :value="__('NIM / NIK')" />

            <x-text-input
                id="identity_number"
                class="block mt-1 w-full"
                type="text"
                name="identity_number"
                :value="old('identity_number')"
                placeholder="Enter NIM or NIK"
                required
            />

            <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Student or Lecturer')" />

            <select
                id="role"
                name="role"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required
            >
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                    Student
                </option>
                <option value="lecturer" {{ old('role') == 'lecturer' ? 'selected' : '' }}>
                    Lecturer
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already Registered? Login Here') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
