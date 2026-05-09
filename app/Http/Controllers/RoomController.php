<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display room list.
     */
    public function view()
    {
        $rooms = Room::all();

        return view('room-view', compact('rooms'));
    }
}