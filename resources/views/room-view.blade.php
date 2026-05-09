<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Book a Room
        </h2>
    </x-slot>

    <div class="py-12 text-gray-800 dark:text-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Room Table --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        Rooms
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700 text-left">
                                    <th class="py-3">Room Name</th>
                                    <th class="py-3">Floor</th>
                                    <th class="py-3">Capacity</th>
                                    <th class="py-3">Location</th>
                                    <th class="py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="py-3">
                                            {{ $room->name }}
                                        </td>
                                        <td class="py-3">
                                            {{ $room->floor ?? '-' }}
                                        </td>
                                        <td class="py-3">
                                            {{ $room->capacity ?? '-' }}
                                        </td>
                                        <td class="py-3">
                                            {{ $room->building ?? '-' }}
                                        </td>
                                        <td class="py-3 text-right">
                                            <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                                Book
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>