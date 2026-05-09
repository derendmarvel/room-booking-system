<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Booking List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">
                        All Bookings
                    </h3>
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-300 dark:border-gray-700">
                                        <th class="text-left py-3">
                                            Room
                                        </th>
                                        <th class="text-left py-3">
                                            Date
                                        </th>
                                        <th class="text-left py-3">
                                            Time
                                        </th>
                                        <th class="text-left py-3">
                                            Status
                                        </th>
                                        <th class="text-left py-3">
                                            Purpose
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="py-3">
                                                {{ $booking->room->name }}
                                            </td>
                                            <td class="py-3">
                                                {{ $booking->usage_date }}
                                            </td>
                                            <td class="py-3">
                                                {{ $booking->start_time }}
                                                -
                                                {{ $booking->end_time }}
                                            </td>
                                            <td class="py-3">
                                                @if($booking->status == 'pending')
                                                    <span class="text-yellow-500 font-semibold">
                                                        Pending
                                                    </span>

                                                @elseif($booking->status == 'approved')
                                                    <span class="text-green-500 font-semibold">
                                                        Approved
                                                    </span>

                                                @elseif($booking->status == 'rejected')
                                                    <span class="text-red-500 font-semibold">
                                                        Rejected
                                                    </span>

                                                @elseif($booking->status == 'completed')
                                                    <span class="text-blue-500 font-semibold">
                                                        Completed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                {{ $booking->purpose }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">
                            No bookings yet.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Rooms List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">
                            All Rooms
                        </h3>

                        <a href="/"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                            Add Room
                        </a>
                    </div>

                    @if($rooms->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-300 dark:border-gray-700">
                                        <th class="text-left py-3">
                                            Room Name
                                        </th>

                                        <th class="text-left py-3">
                                            Capacity
                                        </th>

                                        <th class="text-left py-3">
                                            Location
                                        </th>

                                        <th class="text-left py-3">
                                            Facilities
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($rooms as $room)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            
                                            <td class="py-3">
                                                {{ $room->name }}
                                            </td>

                                            <td class="py-3">
                                                {{ $room->capacity }}
                                            </td>

                                            <td class="py-3">
                                                {{ $room->location }}
                                            </td>

                                            <td class="py-3">
                                                {{ $room->facilities }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">
                            No rooms available.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>