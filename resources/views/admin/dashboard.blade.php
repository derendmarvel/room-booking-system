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
                                            Equipments
                                        </th>
                                        <th class="text-left py-3">
                                            Status
                                        </th>
                                        <th class="text-left py-3">
                                            Purpose
                                        </th>
                                        <th class="text-left py-3">
                                            User
                                        </th>

                                        <th class="text-left py-3">
                                            Role
                                        </th>
                                        <th class="text-right py-3">
                                            Actions
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

                                                    <div class="space-y-1">
                                                        @foreach($booking->equipmentBookings as $item)
                                                            <div class="text-sm">
                                                                • {{ $item->equipment->name }}
                                                                (x{{ $item->quantity }})
                                                            </div>
                                                        @endforeach
                                                    </div>

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
                                            <td class="py-3">
                                                {{ $booking->user->name }}
                                            </td>

                                            <td class="py-3 capitalize">
                                                {{ $booking->user->role }}
                                            </td>
                                            <td class="py-3">
                                                <div class="flex justify-end gap-2">

                                                    {{-- Approve Button --}}
                                                    @if($booking->status === 'pending')
                                                        <form action="{{ route('admin.bookings.approve', $booking->id) }}"
                                                            method="POST">

                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit"
                                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm">
                                                                Approve
                                                            </button>
                                                        </form>

                                                        {{-- Reject Button --}}
                                                        <form action="{{ route('admin.bookings.reject', $booking->id) }}"
                                                            method="POST">

                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit"
                                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 text-sm">
                                                            No Actions
                                                        </span>
                                                    @endif

                                                </div>
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

            <!-- Users List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">
                            All Users
                        </h3>

                        <a href="{{ route('admin.users.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                            Add User
                        </a>
                    </div>

                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">

                                <thead>
                                    <tr class="border-b border-gray-300 dark:border-gray-700">

                                        <th class="text-left py-3">
                                            Name
                                        </th>

                                        <th class="text-left py-3">
                                            Email
                                        </th>

                                        <th class="text-left py-3">
                                            Role
                                        </th>

                                        <th class="text-right py-3">
                                            Actions
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">

                                            <td class="py-3">
                                                {{ $user->name }}
                                            </td>

                                            <td class="py-3">
                                                {{ $user->email }}
                                            </td>

                                            <td class="py-3 capitalize">
                                                {{ $user->role }}
                                            </td>

                                            <td class="py-3">
                                                <div class="flex justify-end gap-2">

                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm">
                                                        Edit
                                                    </a>

                                                    <!-- Delete -->
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Delete this user?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">
                            No users found.
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

                        <a href=" {{ route('admin.rooms.create') }}"
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
                                            Building
                                        </th>

                                        <th class="text-left py-3">
                                            Capacity
                                        </th>

                                        <th class="text-left py-3">
                                            Floor
                                        </th>

                                        <th class="text-right py-3">
                                            Actions
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
                                                {{ $room->building }}
                                            </td>

                                            <td class="py-3">
                                                {{ $room->capacity }}
                                            </td>

                                            <td class="py-3">
                                                {{ $room->floor }}
                                            </td>

                                            <td class="py-3">
                                                <div class="flex justify-end items-center gap-2">

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm">
                                                        Edit
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this room?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </div>
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

            <!-- Equipment List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">
                            All Equipment
                        </h3>

                        <a href="{{ route('admin.equipments.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                            Add Equipment
                        </a>
                    </div>

                    @if($equipment->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">

                                <thead>
                                    <tr class="border-b border-gray-300 dark:border-gray-700">

                                        <th class="text-left py-3">
                                            Code
                                        </th>

                                        <th class="text-left py-3">
                                            Name
                                        </th>

                                        <th class="text-left py-3">
                                            Category
                                        </th>

                                        <th class="text-left py-3">
                                            Stock
                                        </th>

                                        <th class="text-right py-3">
                                            Actions
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($equipment as $item)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">

                                            <td class="py-3">
                                                {{ $item->code }}
                                            </td>

                                            <td class="py-3">
                                                {{ $item->name }}
                                            </td>

                                            <td class="py-3 capitalize">
                                                {{ $item->category }}
                                            </td>

                                            <td class="py-3">
                                                {{ $item->stock }}
                                            </td>

                                            <td class="py-3">
                                                <div class="flex justify-end items-center gap-2">

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.equipments.edit', $item->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm">
                                                        Edit
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('admin.equipments.destroy', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this equipment?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">
                            No equipment available.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>