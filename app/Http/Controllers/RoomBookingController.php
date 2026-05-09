<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomBookingController extends Controller
{
    public function index()
    {
        $bookings = RoomBooking::where('user_id', auth()->id())
            ->with('room')
            ->latest()
            ->get();

        return view('dashboard', compact('bookings'));
    }

    public function adminDashboard()
    {
        $bookings = RoomBooking::with(['user', 'room'])->get();
        $rooms = Room::all();

        return view('admin.dashboard', compact('bookings', 'rooms'));
    }

    public function create(Request $request)
    {
        $room = Room::findOrFail($request->room_id);

        $bookedDates = RoomBooking::where('room_id', $room->id)
            ->where('status', 'approved')
            ->pluck('usage_date')
            ->toArray();

        return view('room-booking-form', compact('room', 'bookedDates'));
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
}