<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
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
                    :value="old('phone_number', ltrim(str_replace('+62', '', $user->phone_number), '0'))"
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
                :value="old('identity_number', $user->identity_number)"
                placeholder="Enter NIM or NIK"
                required
            />

            <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />

            <select
                id="role"
                name="role"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required
            >

                {{-- Always available roles --}}
                <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>
                    Student
                </option>

                <option value="lecturer" {{ old('role', $user->role) == 'lecturer' ? 'selected' : '' }}>
                    Lecturer
                </option>

                {{-- Only admins can assign admin role --}}
                @if(Auth::user()->role === 'admin')
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                @endif

            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
