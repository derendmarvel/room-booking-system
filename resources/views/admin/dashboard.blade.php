<x-app-layout>

    {{-- =========================================================
        ADMIN DASHBOARD PAGE
        This page displays all admin management features:
        - Booking management (approve/reject/export PDF)
        - User CRUD management
        - Room CRUD management
        - Equipment CRUD management
    ========================================================= --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= ERROR HANDLING ================= --}}
            {{-- Display first validation/system error if exists --}}
            @if($errors->any())
                <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif


            {{-- =====================================================
                SECTION 1: BOOKING MANAGEMENT
                - View all room bookings
                - Approve / Reject pending bookings
                - Export booking data to PDF
            ===================================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold mb-4">
                        All Bookings
                    </h3>

                    {{-- Export bookings as PDF using DomPDF --}}
                    <a href="{{ route('admin.bookings.export.pdf') }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg mb-4 inline-block">
                        Export PDF
                    </a>

                    {{-- Pagination for bookings --}}
                    <div class="my-2">
                        {{ $bookings->links('pagination::tailwind', ['pageName' => 'bookings_page']) }}
                    </div>

                    {{-- Booking Table --}}
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">

                                <thead>
                                    <tr class="border-b border-gray-300 dark:border-gray-700">
                                        <th class="text-left py-3">Room</th>
                                        <th class="text-left py-3">Schedule</th>
                                        <th class="text-left py-3">Equipments</th>
                                        <th class="text-left py-3">Status</th>
                                        <th class="text-left py-3">Purpose</th>
                                        <th class="text-left py-3">User</th>
                                        <th class="text-left py-3">Role</th>
                                        <th class="text-right py-3">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">

                                            <td class="py-3">{{ $booking->room->name }}</td>

                                            <td class="py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-semibold">
                                                        {{ $booking->usage_date }}
                                                    </span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $booking->start_time }} - {{ $booking->end_time }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="py-3">
                                                @if($booking->equipmentBookings->count() > 0)
                                                    <div class="space-y-1">
                                                        @foreach($booking->equipmentBookings as $item)
                                                            <div class="text-sm">
                                                                • {{ $item->equipment->name }} (x{{ $item->quantity }})
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">None</span>
                                                @endif
                                            </td>

                                            <td class="py-3">
                                                {{-- Booking status display --}}
                                                @if($booking->status == 'pending')
                                                    <span class="text-yellow-500 font-semibold">Pending</span>
                                                @elseif($booking->status == 'approved')
                                                    <span class="text-green-500 font-semibold">Approved</span>
                                                @elseif($booking->status == 'rejected')
                                                    <span class="text-red-500 font-semibold">Rejected</span>
                                                @elseif($booking->status == 'completed')
                                                    <span class="text-blue-500 font-semibold">Completed</span>
                                                @endif
                                            </td>

                                            <td class="py-3">{{ $booking->purpose }}</td>
                                            <td class="py-3">{{ $booking->user->name }}</td>
                                            <td class="py-3 capitalize">{{ $booking->user->role }}</td>

                                            <td class="py-3">
                                                <div class="flex justify-end gap-2">

                                                    {{-- Approve/Reject only for pending bookings --}}
                                                    @if($booking->status === 'pending')

                                                        <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm">
                                                                Approve
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                                                Reject
                                                            </button>
                                                        </form>

                                                    @else
                                                        <span class="text-gray-400 text-sm">No Actions</span>
                                                    @endif

                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No bookings yet.</p>
                    @endif
                </div>
            </div>


            {{-- =====================================================
                SECTION 2: USER MANAGEMENT (CRUD)
            ===================================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">All Users</h3>

                        <a href="{{ route('admin.users.create') }}"
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                            Add User
                        </a>
                    </div>

                    {{-- Pagination --}}
                    <div class="my-2">
                        {{ $users->links('pagination::tailwind', ['pageName' => 'users_page']) }}
                    </div>

                    {{-- User Table --}}
                    @if($users->count() > 0)
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-gray-300 dark:border-gray-700">
                                    <th class="text-left py-3">Name</th>
                                    <th class="text-left py-3">Email</th>
                                    <th class="text-left py-3">Phone</th>
                                    <th class="text-left py-3">Identity</th>
                                    <th class="text-left py-3">Role</th>
                                    <th class="text-right py-3">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                                <tr class="border-b border-gray-200 dark:border-gray-700">

                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3">{{ $user->email }}</td>
                                    <td class="py-3">{{ $user->phone_number }}</td>
                                    <td class="py-3">{{ $user->identity_number }}</td>
                                    <td class="py-3 capitalize">{{ $user->role }}</td>

                                    <td class="py-3 text-right">
                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="bg-yellow-500 px-3 py-1 rounded text-white">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 px-3 py-1 rounded text-white">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No users found.</p>
                    @endif

                </div>
            </div>


            {{-- =====================================================
                SECTION 3: ROOM MANAGEMENT (CRUD)
            ===================================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between mb-4">
                        <h3 class="text-2xl font-bold">All Rooms</h3>

                        <a href="{{ route('admin.rooms.create') }}"
                           class="bg-green-600 px-4 py-2 rounded text-white">
                            Add Room
                        </a>
                    </div>

                    {{-- Room table --}}
                    @if($rooms->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Building</th>
                                    <th class="text-left">Capacity</th>
                                    <th class="text-left">Floor</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td>{{ $room->name }}</td>
                                    <td>{{ $room->building }}</td>
                                    <td>{{ $room->capacity }}</td>
                                    <td>{{ $room->floor }}</td>

                                    <td class="text-right py-3">
                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                            class="bg-yellow-500 px-3 py-1 rounded text-white">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 px-3 py-1 rounded text-white">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No rooms available.</p>
                    @endif

                </div>
            </div>


            {{-- =====================================================
                SECTION 4: EQUIPMENT MANAGEMENT (CRUD)
            ===================================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between mb-4">
                        <h3 class="text-2xl font-bold">All Equipment</h3>

                        <a href="{{ route('admin.equipments.create') }}"
                           class="bg-green-600 px-4 py-2 rounded text-white">
                            Add Equipment
                        </a>
                    </div>

                    {{-- Equipment table --}}
                    @if($equipment->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left">Code</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Category</th>
                                    <th class="text-left">Stock</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($equipment as $item)
                                <tr>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="capitalize">{{ $item->category }}</td>
                                    <td>{{ $item->stock }}</td>

                                    <td class="text-right py-3">
                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('admin.equipments.edit', $item->id) }}"
                                            class="bg-yellow-500 px-3 py-1 rounded text-white">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.equipments.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 px-3 py-1 rounded text-white">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No equipment available.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>