<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\ProductionDrone;
use App\Models\ProductionMission;
use Illuminate\Http\Request;

class ProductionMissionController extends Controller
{
    /**
     * Display a listing of the resource (Libro de Misiones).
     */
    public function index()
    {
        $missions = ProductionMission::with('droneRelation')
            ->orderByDesc('id')
            ->paginate(20);

        return view('production.missions.index', compact('missions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drones = ProductionDrone::orderBy('name')->get();
        return view('production.missions.create', compact('drones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:mission,name',
            'duration' => 'nullable|integer',
            'link_rtcp' => 'nullable|string',
            'url' => 'nullable|string',
            'descrpition' => 'nullable|string',
            'drone' => 'nullable|string|exists:Drone,name',
            'Authentication' => 'nullable|string',
            'payload' => 'nullable|json',
            'send_passwd' => 'nullable|string',
        ]);

        if ($request->has('payload') && is_string($request->payload)) {
            $validated['payload'] = json_decode($request->payload, true);
        }

        ProductionMission::create($validated);

        return redirect()->route('production.missions.index')
            ->with('success', 'Misión registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionMission $productionMission)
    {
        $productionMission->load(['droneRelation', 'telemetryLogs']);
        return view('production.missions.show', compact('productionMission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionMission $productionMission)
    {
        $drones = ProductionDrone::orderBy('name')->get();
        return view('production.missions.edit', compact('productionMission', 'drones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionMission $productionMission)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:mission,name,' . $productionMission->id,
            'duration' => 'nullable|integer',
            'link_rtcp' => 'nullable|string',
            'url' => 'nullable|string',
            'descrpition' => 'nullable|string',
            'drone' => 'nullable|string|exists:Drone,name',
            'Authentication' => 'nullable|string',
            'payload' => 'nullable|json',
            'send_passwd' => 'nullable|string',
        ]);

        if ($request->has('payload') && is_string($request->payload)) {
            $validated['payload'] = json_decode($request->payload, true);
        }

        $productionMission->update($validated);

        return redirect()->route('production.missions.index')
            ->with('success', 'Misión actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionMission $productionMission)
    {
        $productionMission->delete();
        return redirect()->route('production.missions.index')
            ->with('success', 'Misión eliminada exitosamente.');
    }
}
