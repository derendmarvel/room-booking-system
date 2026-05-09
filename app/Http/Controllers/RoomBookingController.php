<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            ->with('room')
            ->latest()
            ->get();

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

        $bookings = RoomBooking::all();
        $rooms = Room::all();
        $equipment = Equipment::all();

        return view('admin.dashboard', compact(
            'bookings',
            'rooms',
            'equipment'
        ));
    }

    public function create(Request $request)
    {
        $room = Room::findOrFail($request->room_id);

        // GET ALL EQUIPMENT
        $equipments = Equipment::all();

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
            'equipments'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'usage_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'purpose' => 'required|string',
        ]);

        // Check room conflict
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

        RoomBooking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'booking_date' => now(),
            'usage_date' => $request->usage_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
            'purpose' => $request->purpose,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking request submitted successfully.');
    }

    public function approve($id)
    {
        $booking = RoomBooking::findOrFail($id);

        $booking->status = 'approved';

        $booking->save();

        return redirect()->back()
                        ->with('success', 'Booking approved successfully.');
    }

    public function reject($id)
    {
        $booking = RoomBooking::findOrFail($id);

        $booking->status = 'rejected';

        $booking->save();

        return redirect()->back()
                        ->with('success', 'Booking rejected successfully.');
    }
}