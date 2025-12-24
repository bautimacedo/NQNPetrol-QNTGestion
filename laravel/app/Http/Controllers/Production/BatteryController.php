<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use App\Models\ProductionDrone;
use Illuminate\Http\Request;

class BatteryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batteries = Battery::with('drone')
            ->orderByDesc('flight_count')
            ->paginate(20);

        return view('production.batteries.index', compact('batteries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drones = ProductionDrone::orderBy('name')->get();
        return view('production.batteries.create', compact('drones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial' => 'required|string|unique:batteries,serial',
            'flight_count' => 'nullable|integer|min:0',
            'last_used' => 'nullable|date',
            'drone_name' => 'nullable|string|exists:Drone,name',
        ]);

        Battery::create($validated);

        return redirect()->route('production.batteries.index')
            ->with('success', 'Batería registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Battery $battery)
    {
        $battery->load('drone');
        return view('production.batteries.show', compact('battery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Battery $battery)
    {
        $drones = ProductionDrone::orderBy('name')->get();
        return view('production.batteries.edit', compact('battery', 'drones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Battery $battery)
    {
        $validated = $request->validate([
            'serial' => 'required|string|unique:batteries,serial,' . $battery->id,
            'flight_count' => 'nullable|integer|min:0',
            'last_used' => 'nullable|date',
            'drone_name' => 'nullable|string|exists:Drone,name',
        ]);

        $battery->update($validated);

        return redirect()->route('production.batteries.index')
            ->with('success', 'Batería actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Battery $battery)
    {
        $battery->delete();
        return redirect()->route('production.batteries.index')
            ->with('success', 'Batería eliminada exitosamente.');
    }
}
