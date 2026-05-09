<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 text-gray-800 dark:text-gray-200">

        <h1 class="text-2xl font-bold mb-6">
            Add New User
        </h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}"
              method="POST"
              class="space-y-5">

            @csrf

            {{-- Name --}}
            <div>
                <x-input-label for="name" :value="__('Full Name')" />

                <x-text-input id="name"
                              class="block mt-1 w-full"
                              type="text"
                              name="name"
                              :value="old('name')"
                              required />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email"
                              class="block mt-1 w-full"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Phone Number --}}
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />

                <x-text-input id="phone_number"
                              class="block mt-1 w-full"
                              type="text"
                              name="phone_number"
                              :value="old('phone_number')" />

                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            {{-- Identity Number --}}
            <div>
                <x-input-label for="identity_number" :value="__('Identity Number (NIM / NIP)')" />

                <x-text-input id="identity_number"
                              class="block mt-1 w-full"
                              type="text"
                              name="identity_number"
                              :value="old('identity_number')" />

                <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
            </div>

            {{-- Role --}}
            <div>
                <x-input-label for="role" :value="__('Role')" />

                <select id="role"
                        name="role"
                        class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required>

                    <option value="">
                        Select Role
                    </option>

                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>
                        Mahasiswa
                    </option>

                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>
                        Dosen
                    </option>

                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                </select>

                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password"
                              class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation"
                              class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation"
                              required />
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <x-primary-button>
                    Create User
                </x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>