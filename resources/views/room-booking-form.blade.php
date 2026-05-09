<x-app-layout>

    <div class="max-w-7xl mx-auto py-10 px-6 text-gray-800 dark:text-gray-200">

        <h1 class="text-3xl font-bold mb-6">
            Book Room
        </h1>

        {{-- Errors --}}
        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Room Info --}}
        <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow mb-6">
            <h2 class="text-xl font-semibold">
                {{ $room->name }}
            </h2>

            <p class="text-gray-500 dark:text-gray-400">
                {{ $room->building }} - Floor {{ $room->floor }}
            </p>
        </div>

        {{-- Booking Form --}}
        <form action="{{ route('bookings.store') }}"
              method="POST">

            @csrf

            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <input type="hidden" name="usage_date" id="usage_date">
            <input type="hidden" name="start_time" id="start_time">
            <input type="hidden" name="end_time" id="end_time">

            {{-- Calendar --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow mb-6">

                {{-- Date Picker --}}
                <div class="mb-4">
                    <x-input-label for="calendar_date" :value="__('Choose Date')" />

                    <input type="date"
                        id="calendar_date"
                        min="{{ now()->toDateString() }}"
                        class="mt-1 block w-64 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                </div>

                <div id="calendar"></div>
            </div>

            {{-- Purpose --}}
            <div class="mb-6">
                <x-input-label for="purpose" :value="__('Purpose')" />

                <textarea name="purpose"
                          id="purpose"
                          rows="4"
                          class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"></textarea>
            </div>

            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">

                    <h3 class="text-lg font-semibold">
                        Borrow Equipment
                    </h3>

                    <button type="button"
                            id="add-equipment"
                            class="w-10 h-10 flex items-center justify-center bg-green-600 hover:bg-green-700 text-white rounded-lg text-xl font-bold shadow">
                        +
                    </button>

                </div>

                <div id="equipment-container" class="space-y-4">

                    <!-- First Row -->
                    <div class="equipment-row grid grid-cols-12 gap-3">

                        <!-- Equipment Dropdown -->
                        <div class="col-span-10">
                            <select name="equipments[0][equipment_id]"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">

                                <option value="">
                                    Select Equipment
                                </option>

                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->id }}">
                                        {{ $equipment->name }}
                                        (Stock: {{ $equipment->stock }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="col-span-1">
                            <input type="number"
                                name="equipments[0][quantity]"
                                min="1"
                                placeholder="Qty"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>

                        <!-- Remove Button -->
                        <div class="col-span-1 flex items-end justify-end">
                            <button type="button"
                                    class="remove-equipment w-10 h-10 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold shadow">
                                x
                            </button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    Submit Booking
                </x-primary-button>
            </div>

        </form>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <script>
        const equipmentBookings = @json($equipmentBookings);
        const equipments = @json($equipments);

        function isOverlapping(startA, endA, startB, endB) {
            return startA < endB && endA > startB;
        }
        function calculateAvailableStock(equipmentId, date, startTime, endTime) {
            let used = 0;

            const selectedStart = new Date(date + 'T' + startTime);
            const selectedEnd = new Date(date + 'T' + endTime);

            equipmentBookings.forEach(booking => {

                if (booking.status !== 'approved') return;

                booking.equipment_bookings.forEach(item => {

                    if (item.equipment_id != equipmentId) return;

                    const bStart = new Date(booking.usage_date + 'T' + booking.start_time);
                    const bEnd = new Date(booking.usage_date + 'T' + booking.end_time);

                    if (isOverlapping(selectedStart, selectedEnd, bStart, bEnd)) {
                        used += item.quantity;
                    }
                });
            });

            const equipment = equipments.find(e => e.id == equipmentId);

            return equipment.stock - used;
        }

        function updateEquipmentDropdown() {
            const date = document.getElementById('usage_date').value;
            const start = document.getElementById('start_time').value;
            const end = document.getElementById('end_time').value;

            if (!date || !start || !end) return;

            document.querySelectorAll('select[name*="equipment_id"]').forEach(select => {

                const selectedId = select.value;

                Array.from(select.options).forEach(option => {

                    if (!option.value) return;

                    const available = calculateAvailableStock(option.value, date, start, end);

                    const original = equipments.find(e => e.id == option.value);

                    option.text = `${original.name} (Available: ${available})`;

                    if (available <= 0) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }
    </script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            let calendarEl = document.getElementById('calendar');

            let selectedEvent = null;

            let calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'timeGridWeek',

                validRange: {
                    start: new Date().toISOString().split('T')[0]
                },

                height: 'auto',

                slotMinTime: '07:00:00',
                slotMaxTime: '18:00:00',

                allDaySlot: false,

                selectable: true,

                editable: true,

                selectMirror: true,

                slotDuration: '01:00:00',

                // ADD THIS
                slotLabelInterval: '01:00',

                // ADD THIS
                expandRows: true,

                // ADD THIS
                contentHeight: 750,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },

                buttonText: {
                    today: 'Today'
                },

                events: @json($calendarBookings),

                select: function(info) {

                    // remove previous temporary event
                    if (selectedEvent) {
                        selectedEvent.remove();
                    }

                    selectedEvent = calendar.addEvent({
                        title: 'Your Booking',
                        start: info.start,
                        end: info.end,
                        editable: true,
                        backgroundColor: '#2563eb',
                        borderColor: '#2563eb'
                    });

                    updateInputs(info.start, info.end);

                    calendar.unselect();
                },

                eventResize: function(info) {

                    if (info.event.extendedProps.locked) {
                        info.revert();
                        return;
                    }

                    updateInputs(info.event.start, info.event.end);
                },

                eventDrop: function(info) {

                    if (info.event.extendedProps.locked) {
                        info.revert();
                        return;
                    }

                    updateInputs(info.event.start, info.event.end);
                },

                eventClick: function(info) {

                    // Cannot modify locked bookings
                    if (info.event.extendedProps.locked) {
                        return;
                    }
                }

            });

            calendar.render();

            // Date picker navigation
            document.getElementById('calendar_date')
                .addEventListener('change', function () {

                    if (this.value) {
                        calendar.gotoDate(this.value);
                    }
                });

            function updateInputs(start, end) {
                let date = start.toISOString().split('T')[0];
                let startTime = start.toTimeString().slice(0,5);
                let endTime = end.toTimeString().slice(0,5);

                document.getElementById('usage_date').value = date;
                document.getElementById('start_time').value = startTime;
                document.getElementById('end_time').value = endTime;

                updateEquipmentDropdown();
            }

        });

    </script>

    <script>

        let equipmentIndex = 1;

        document.getElementById('add-equipment')
            .addEventListener('click', function () {

                let container = document.getElementById('equipment-container');

                let row = document.createElement('div');

                row.className = 'equipment-row grid grid-cols-12 gap-3';

                row.innerHTML = `
                    <div class="col-span-10">
                        <select name="equipments[${equipmentIndex}][equipment_id]"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">

                            <option value="">
                                Select Equipment
                            </option>

                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}">
                                    {{ $equipment->name }}
                                    (Stock: {{ $equipment->stock }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-span-1">
                        <input type="number"
                            name="equipments[${equipmentIndex}][quantity]"
                            min="1"
                            placeholder="Qty"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    <div class="col-span-1 flex items-end justify-end">
                        <button type="button"
                            class="remove-equipment w-10 h-10 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold shadow">
                            x
                        </button>
                    </div>
                `;

                container.appendChild(row);

                equipmentIndex++;
            });

        // Remove equipment row
        document.addEventListener('click', function (e) {

            if (e.target.classList.contains('remove-equipment')) {

                let rows = document.querySelectorAll('.equipment-row');

                // Keep at least 1 row
                if (rows.length > 1) {
                    e.target.closest('.equipment-row').remove();
                }
            }
        });

    </script>

    <style>

        /* Remove white header background */
        .fc-theme-standard th,
        .fc-theme-standard td,
        .fc-scrollgrid,
        .fc-scrollgrid-section,
        .fc-col-header-cell {
            background: transparent !important;
        }

        /* Make day headings transparent */
        .fc-col-header-cell {
            background-color: transparent !important;
        }

        /* More spacing / taller rows */
        .fc-timegrid-slot {
            height: 40px !important;
        }

        /* Better spacing for time labels */
        .fc-timegrid-slot-label {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        /* Remove default white borders feeling */
        .fc-theme-standard .fc-scrollgrid {
            border-color: rgba(255,255,255,0.15);
        }

        /* Make header text cleaner */
        .fc-col-header-cell-cushion {
            padding: 12px 0;
            font-weight: 600;
        }

    </style>

</x-app-layout>