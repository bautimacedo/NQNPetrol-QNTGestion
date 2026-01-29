<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::orderBy('name')->get();
        return view('sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sites,name',
            'location_details' => 'nullable|string',
        ]);

        Site::create($validated);

        return redirect()->route('sites.index')
            ->with('success', 'Ubicación registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        $site->load('drones');
        return view('sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sites,name,' . $site->id,
            'location_details' => 'nullable|string',
        ]);

        $site->update($validated);

        return redirect()->route('sites.index')
            ->with('success', 'Ubicación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        // Verificar si hay drones asociados
        if ($site->drones()->count() > 0) {
            return redirect()->route('sites.index')
                ->with('error', 'No se puede eliminar la ubicación porque tiene RPAs asociados.');
        }

        $site->delete();

        return redirect()->route('sites.index')
            ->with('success', 'Ubicación eliminada exitosamente.');
    }
}
