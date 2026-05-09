<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\EquipmentBooking;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RoomBookingController extends Controller
{
    public function index()
    {
        // Auto complete expired bookings
        RoomBooking::where('status', 'approved')
            ->where(function ($query) {

                $query->where('usage_date', '<', now()->toDateString())

                    ->orWhere(function ($q) {

                        $q->where('usage_date', now()->toDateString())
                        ->where('end_time', '<', now()->format('H:i:s'));
                    });
            })
            ->update([
                'status' => 'completed'
            ]);

        $bookings = RoomBooking::where('user_id', auth()->id())
            ->with(['room', 'equipmentBookings.equipment'])
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('bookings'));
    }

    public function adminDashboard()
    {
        // Auto complete expired bookings
        RoomBooking::where('status', 'approved')
            ->where(function ($query) {

                $query->where('usage_date', '<', now()->toDateString())

                    ->orWhere(function ($q) {

                        $q->where('usage_date', now()->toDateString())
                        ->where('end_time', '<', now()->format('H:i:s'));
                    });
            })
            ->update([
                'status' => 'completed'
            ]);

        $bookings = RoomBooking::with(['room', 'equipmentBookings.equipment', 'user'])
            ->orderBy('usage_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10, ['*'], 'bookings_page');

        $users = User::where('role', '!=', 'admin')
            ->paginate(10, ['*'], 'users_page');

        $rooms = Room::latest()
            ->paginate(10, ['*'], 'rooms_page');

        $equipment = Equipment::latest()
            ->paginate(10, ['*'], 'equipment_page');

        return view('admin.dashboard', compact(
            'bookings',
            'rooms',
            'equipment',
            'users'
        ));
    }

    public function create(Request $request)
    {
        $room = Room::findOrFail($request->room_id);

        // GET ALL EQUIPMENT
        $equipments = Equipment::all();
        $equipmentBookings = RoomBooking::with('equipmentBookings')
            ->whereIn('status', ['approved'])
            ->get();

        $bookings = RoomBooking::where('room_id', $room->id)
            ->whereIn('status', ['approved', 'completed'])
            ->get();

        $calendarBookings = [];

        foreach ($bookings as $booking) {

            $calendarBookings[] = [
                'title' => strtoupper($booking->status),

                'start' => $booking->usage_date . 'T' . $booking->start_time,

                'end' => $booking->usage_date . 'T' . $booking->end_time,

                'backgroundColor' => $booking->status === 'approved'
                    ? '#dc2626'
                    : '#6b7280',

                'borderColor' => $booking->status === 'approved'
                    ? '#dc2626'
                    : '#6b7280',

                'editable' => false,

                'locked' => true
            ];
        }

        return view('room-booking-form', compact(
            'room',
            'calendarBookings',
            'equipments',
            'equipmentBookings'
        ));
    }

    public function store(Request $request)
    {
        // Input data validation
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'usage_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'required|string',

            'equipments' => 'nullable|array',
            'equipments.*.equipment_id' => 'nullable|exists:equipment,id',
            'equipments.*.quantity' => 'nullable|integer|min:1',
        ]);

        // Room conflict check
        $conflict = RoomBooking::where('room_id', $request->room_id)
            ->where('usage_date', $request->usage_date)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'room_id' => 'Room is already booked during this time.'
            ])->withInput();
        }

        // Equipment Availability check
        foreach ($request->equipments ?? [] as $item) {
            if (empty($item['equipment_id'])) {
                continue; // skip empty rows
            }

            EquipmentBooking::create([
                'room_booking_id' => $roomBooking->id,
                'equipment_id' => $item['equipment_id'],
                'quantity' => $item['quantity'] ?? 1,
            ]);
        }

        // Save booking safely
        DB::transaction(function () use ($request) {

            $roomBooking = RoomBooking::create([
                'user_id' => auth()->id(),
                'room_id' => $request->room_id,
                'booking_date' => now(),
                'usage_date' => $request->usage_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'pending',
                'purpose' => $request->purpose,
            ]);

            foreach ($request->equipments as $item) {

                if (!empty($item['equipment_id'])) {

                    EquipmentBooking::updateOrCreate(
                        [
                            'room_booking_id' => $roomBooking->id,
                            'equipment_id' => $item['equipment_id'],
                        ],
                        [
                            'quantity' => $item['quantity'],
                        ]
                    );
                }
            }
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking request submitted successfully.');
    }

    public function approve($id)
    {
        $booking = RoomBooking::findOrFail($id);

        $booking->status = 'approved';
        $booking->save();

        return back()->with('success', 'Booking approved successfully.');
    }

    public function reject($id)
    {
        $booking = RoomBooking::findOrFail($id);

        $booking->status = 'rejected';
        $booking->save();

        return back()->with('success', 'Booking rejected successfully.');
    }

    public function exportPdf()
    {
        $bookings = RoomBooking::with(['room', 'equipmentBookings.equipment', 'user'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.exports.bookings-pdf', compact('bookings'));

        return $pdf->download('bookings-report.pdf');
    }
}