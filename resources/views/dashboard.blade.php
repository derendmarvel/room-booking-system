<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Booking List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">
                        My Bookings
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
                                            Equipments
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
                                                @if($booking->equipmentBookings->count() > 0)

                                                    <ul class="list-disc pl-5">
                                                        @foreach($booking->equipmentBookings as $item)
                                                            <li>
                                                                {{ $item->equipment->name }}
                                                                (x{{ $item->quantity }})
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                @else
                                                    <span class="text-gray-400">
                                                        None
                                                    </span>
                                                @endif
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
                            No booking yet.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Room Booking Button -->
            <div>
                <a href="{{ route('room.view') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow">
                    Room Booking
                </a>
            </div>
        </div>
    </div>
</x-app-layout>