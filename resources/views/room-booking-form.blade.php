<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 text-gray-800 dark:text-gray-200">

        <h1 class="text-2xl font-bold mb-6">
            Book Room
        </h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.store') }}"
              method="POST"
              class="space-y-5">

            @csrf

            <!-- Room -->
            <div>
                <x-input-label :value="__('Room')" />

                <!-- Hidden actual room ID -->
                <input type="hidden"
                    name="room_id"
                    value="{{ $room->id }}">

                <!-- Readonly display -->
                <div class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-900 px-3 py-2 text-gray-900 dark:text-gray-100">

                    {{ $room->name }}
                    -
                    {{ $room->building }}
                    (Floor {{ $room->floor }})

                </div>
            </div>

            <!-- Usage Date -->
            <div>
                <x-input-label for="usage_date" :value="__('Usage Date')" />

                <input id="usage_date"
                name="usage_date"
                type="text"
                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                required>

                <x-input-error :messages="$errors->get('usage_date')" class="mt-2" />
            </div>

            <!-- Start Time -->
            <div>
                <x-input-label for="start_time" :value="__('Start Time')" />

                <x-text-input id="start_time"
                              class="block mt-1 w-full"
                              type="time"
                              name="start_time"
                              required />

                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
            </div>

            <!-- End Time -->
            <div>
                <x-input-label for="end_time" :value="__('End Time')" />

                <x-text-input id="end_time"
                              class="block mt-1 w-full"
                              type="time"
                              name="end_time"
                              required />

                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
            </div>

            <!-- Purpose -->
            <div>
                <x-input-label for="purpose" :value="__('Purpose')" />

                <textarea name="purpose"
                          id="purpose"
                          rows="4"
                          class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>

                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Submit Booking') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#usage_date", {
            minDate: "today",

            disable: @json($bookedDates),

            dateFormat: "Y-m-d",

            theme: "dark",

            disableMobile: true
        });
    </script>
</x-app-layout>