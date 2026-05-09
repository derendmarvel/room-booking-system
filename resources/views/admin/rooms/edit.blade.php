<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 text-gray-800 dark:text-gray-200">

        <h1 class="text-2xl font-bold mb-6">
            Edit Room
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

        <form action="{{ route('rooms.update', $room->id) }}"
              method="POST"
              class="space-y-5">

            @csrf
            @method('PUT')

            {{-- Room Name --}}
            <div>
                <x-input-label for="name" :value="__('Room Name')" />

                <x-text-input id="name"
                              class="block mt-1 w-full"
                              type="text"
                              name="name"
                              :value="old('name', $room->name)"
                              required />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Building --}}
            <div>
                <x-input-label for="building" :value="__('Building')" />

                <x-text-input id="building"
                              class="block mt-1 w-full"
                              type="text"
                              name="building"
                              :value="old('building', $room->building)"
                              required />

                <x-input-error :messages="$errors->get('building')" class="mt-2" />
            </div>

            {{-- Floor --}}
            <div>
                <x-input-label for="floor" :value="__('Floor')" />

                <x-text-input id="floor"
                              class="block mt-1 w-full"
                              type="number"
                              name="floor"
                              :value="old('floor', $room->floor)"
                              required />

                <x-input-error :messages="$errors->get('floor')" class="mt-2" />
            </div>

            {{-- Capacity --}}
            <div>
                <x-input-label for="capacity" :value="__('Capacity')" />

                <x-text-input id="capacity"
                              class="block mt-1 w-full"
                              type="number"
                              name="capacity"
                              :value="old('capacity', $room->capacity)"
                              required />

                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Update Room') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>