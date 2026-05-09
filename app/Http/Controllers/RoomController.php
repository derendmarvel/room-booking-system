<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display all rooms
     */
    public function view()
    {
        // Get all rooms
        $rooms = Room::all();

        // Display all rooms
        return view('room-view', compact('rooms'));
    }

    /**
     * Show create room form
     */
    public function create()
    {
        // Display create room form
        return view('admin.rooms.create');
    }

    /**
     * Store new room
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'floor' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        // Create data in database
        Room::create($validated);

        // Display admin dashboard
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Room $room)
    {
        // Display edit room form
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update room
     */
    public function update(Request $request, Room $room)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'floor' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        // Update data into database
        $room->update($validated);

        // Display admin dashboard
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Delete room
     */
    public function destroy(Room $room)
    {
        // Delete room data from database
        $room->delete();

        // Display admin dashboard
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Room deleted successfully.');
    }
}