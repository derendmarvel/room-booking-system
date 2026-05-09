<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.equipments.create');
    }

    /**
     * Store new equipment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:audio,video,accessory,computer,networking',
        ]);

        Equipment::create($validated);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Equipment created successfully.');
    }

    /**
     * Display single equipment.
     */
    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }

    /**
     * Show edit form.
     */
    public function edit(Equipment $equipment)
    {
        return view('admin.equipments.edit', compact('equipment'));
    }

    /**
     * Update equipment.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:audio,video,accessory,computer,networking',
        ]);

        $equipment->update($validated);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Equipment updated successfully.');
    }

    /**
     * Delete equipment.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Equipment deleted successfully.');
    }
}