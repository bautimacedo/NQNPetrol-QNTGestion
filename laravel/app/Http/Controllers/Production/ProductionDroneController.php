<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\ProductionDrone;
use App\Models\Site;
use Illuminate\Http\Request;

class ProductionDroneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drones = ProductionDrone::with('site')->orderBy('name')->get();
        return view('production.drones.index', compact('drones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Site::orderBy('name')->get();
        return view('production.drones.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:Drone,name',
            'dock' => 'nullable|string',
            'site_id' => 'nullable|exists:sites,id',
            'organization' => 'nullable|string',
            'Latitud' => 'nullable|numeric',
            'Longitud' => 'nullable|numeric',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'registration' => 'nullable|string',
        ]);

        ProductionDrone::create($validated);

        return redirect()->route('production.drones.index')
            ->with('success', 'RPA registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionDrone $productionDrone)
    {
        $productionDrone->load(['site', 'missions', 'telemetryLogs', 'statusLogs']);
        return view('production.drones.show', compact('productionDrone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionDrone $productionDrone)
    {
        // #region agent log
        file_put_contents('/home/bauti/NQNPetrol/PilotosdeCero/.cursor/debug.log', json_encode([
            'sessionId' => 'debug-session',
            'runId' => 'run1',
            'hypothesisId' => 'A',
            'location' => 'ProductionDroneController@edit',
            'message' => 'Edit method called',
            'data' => [
                'drone_id' => $productionDrone->id ?? 'NULL',
                'drone_name' => $productionDrone->name ?? 'NULL',
                'route_key_name' => $productionDrone->getRouteKeyName(),
                'route_key_value' => method_exists($productionDrone, 'getRouteKey') ? $productionDrone->getRouteKey() : 'getRouteKey() not exists',
                'model_exists' => $productionDrone->exists ?? false,
            ],
            'timestamp' => time() * 1000
        ]) . "\n", FILE_APPEND);
        // #endregion
        
        $sites = Site::orderBy('name')->get();
        return view('production.drones.edit', compact('productionDrone', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionDrone $productionDrone)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:Drone,name,' . $productionDrone->id,
            'dock' => 'nullable|string',
            'site_id' => 'nullable|exists:sites,id',
            'organization' => 'nullable|string',
            'Latitud' => 'nullable|numeric',
            'Longitud' => 'nullable|numeric',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'registration' => 'nullable|string',
        ]);

        $productionDrone->update($validated);

        return redirect()->route('production.drones.index')
            ->with('success', 'RPA actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionDrone $productionDrone)
    {
        $productionDrone->delete();
        return redirect()->route('production.drones.index')
            ->with('success', 'RPA eliminado exitosamente.');
    }
}
