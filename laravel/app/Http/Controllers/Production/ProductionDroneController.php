<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\ProductionDrone;
use Illuminate\Http\Request;

class ProductionDroneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drones = ProductionDrone::orderBy('name')->get();
        return view('production.drones.index', compact('drones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('production.drones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:Drone,name',
            'dock' => 'nullable|string',
            'site' => 'nullable|string',
            'organization' => 'nullable|string',
            'Latitud' => 'nullable|numeric',
            'Longitud' => 'nullable|numeric',
        ]);

        ProductionDrone::create($validated);

        return redirect()->route('production.drones.index')
            ->with('success', 'Dron registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionDrone $productionDrone)
    {
        $productionDrone->load(['missions', 'telemetryLogs', 'statusLogs']);
        return view('production.drones.show', compact('productionDrone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionDrone $productionDrone)
    {
        return view('production.drones.edit', compact('productionDrone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionDrone $productionDrone)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:Drone,name,' . $productionDrone->id,
            'dock' => 'nullable|string',
            'site' => 'nullable|string',
            'organization' => 'nullable|string',
            'Latitud' => 'nullable|numeric',
            'Longitud' => 'nullable|numeric',
        ]);

        $productionDrone->update($validated);

        return redirect()->route('production.drones.index')
            ->with('success', 'Dron actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionDrone $productionDrone)
    {
        $productionDrone->delete();
        return redirect()->route('production.drones.index')
            ->with('success', 'Dron eliminado exitosamente.');
    }
}
