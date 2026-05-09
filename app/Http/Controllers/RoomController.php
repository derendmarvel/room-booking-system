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
        $rooms = Room::all();

        return view('room-view', compact('rooms'));
    }

    /**
     * Show create room form
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store new room
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'floor' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        Room::create($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update room
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'floor' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Delete room
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Room deleted successfully.');
    }
}