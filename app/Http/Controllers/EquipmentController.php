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
        // Display create equipment form
        return view('admin.equipments.create');
    }

    /**
     * Store new equipment.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:audio,video,accessory,computer,networking',
        ]);

        // Create data on database
        Equipment::create($validated);

        // Display admin dashboard
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Equipment created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Equipment $equipment)
    {
        // Display edit equipment form
        return view('admin.equipments.edit', compact('equipment'));
    }

    /**
     * Update equipment.
     */
    public function update(Request $request, Equipment $equipment)
    {
        // Validate input data
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:audio,video,accessory,computer,networking',
        ]);

        // Update data
        $equipment->update($validated);

        // Display admin dashboard
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Equipment updated successfully.');
    }

    /**
     * Delete equipment.
     */
    public function destroy(Equipment $equipment)
    {
        // Delete data
        $equipment->delete();

        // Display admin dashboard
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Equipment deleted successfully.');
    }
}