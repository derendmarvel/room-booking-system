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
    /**
     * Display user dashboard
     */
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

        // Get user's bookings from database
        $bookings = RoomBooking::where('user_id', auth()->id())
            ->with(['room', 'equipmentBookings.equipment'])
            ->latest()
            ->paginate(10);

        // Display user dashboard
        return view('dashboard', compact('bookings'));
    }

    /**
     * Display admin dashboard
     */
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

        // Get all room bookings, ordered by date and time (descending)
        $bookings = RoomBooking::with(['room', 'equipmentBookings.equipment', 'user'])
            ->orderBy('usage_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10, ['*'], 'bookings_page');

        // Get all users
        $users = User::where('role', '!=', 'admin')
            ->paginate(10, ['*'], 'users_page');

        // Get all rooms
        $rooms = Room::latest()
            ->paginate(10, ['*'], 'rooms_page');

        // Get all equipments
        $equipment = Equipment::latest()
            ->paginate(10, ['*'], 'equipment_page');

        // Display admin dashboard
        return view('admin.dashboard', compact(
            'bookings',
            'rooms',
            'equipment',
            'users'
        ));
    }

    /**
     * Show booking request form
     */
    public function create(Request $request)
    {
        // Get designated room
        $room = Room::findOrFail($request->room_id);

        // Get all equipments
        $equipments = Equipment::all();

        // Get all equipment bookings
        $equipmentBookings = RoomBooking::with('equipmentBookings')
            ->whereIn('status', ['approved'])
            ->get();

        // Get bookings that have been approved or completed to block out unavailable dates
        $bookings = RoomBooking::where('room_id', $room->id)
            ->whereIn('status', ['approved', 'completed'])
            ->get();

        $calendarBookings = [];

        // Turn all bookings into blocks on a calendar
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

        // Display room booking form
        return view('room-booking-form', compact(
            'room',
            'calendarBookings',
            'equipments',
            'equipmentBookings'
        ));
    }

    /**
     * Store booking request
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
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
        $conflict = RoomBooking::where('room_id', $validated['room_id'])
            ->where('usage_date', $validated['usage_date'])
            ->where('status', 'approved')
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'room_id' => 'Room is already booked during this time.'
            ]);
        }

        // Equipment Stock Validation Check
        foreach ($validated['equipments'] ?? [] as $index => $item) {
            if (!empty($item['equipment_id'])) {
                $equipment = Equipment::find($item['equipment_id']);
                
                if ($item['quantity'] > $equipment->stock) {
                    return back()->withErrors([
                        "equipments.{$index}.quantity" => "The requested quantity for {$equipment->name} exceeds available stock ({$equipment->stock})."
                    ])->withInput();
                }
            }
        }

        // Database Transaction
        DB::transaction(function () use ($validated) {
            $roomBooking = RoomBooking::create([
                'user_id' => auth()->id(),
                'room_id' => $validated['room_id'],
                'booking_date' => now(),
                'usage_date' => $validated['usage_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => 'pending',
                'purpose' => $validated['purpose'],
            ]);

            foreach ($validated['equipments'] ?? [] as $item) {
                if (!empty($item['equipment_id'])) {
                    EquipmentBooking::create([
                        'room_booking_id' => $roomBooking->id,
                        'equipment_id' => $item['equipment_id'],
                        'quantity' => $item['quantity'] ?? 1,
                    ]);
                }
            }
        });

        // Display user dashboard
        return redirect()->route('dashboard')
            ->with('success', 'Booking request submitted successfully.');
    }

    /**
     * Approve booking request
     */
    public function approve($id)
    {
        // Get designated booking
        $booking = RoomBooking::findOrFail($id);

        // Change status to approved
        $booking->status = 'approved';
        $booking->save();

        // Display previous view
        return back()->with('success', 'Booking approved successfully.');
    }

    /**
     * Reject booking request
     */
    public function reject($id)
    {
        // Get designated booking
        $booking = RoomBooking::findOrFail($id);

        // Change status to rejected
        $booking->status = 'rejected';
        $booking->save();

        // Display previous view
        return back()->with('success', 'Booking rejected successfully.');
    }

    /**
     * Export to PDF
     */
    public function exportPdf()
    {
        // Get all bookings
        $bookings = RoomBooking::with(['room', 'equipmentBookings.equipment', 'user'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.exports.bookings-pdf', compact('bookings'));

        // Download pdf
        return $pdf->download('bookings-report.pdf');
    }
}