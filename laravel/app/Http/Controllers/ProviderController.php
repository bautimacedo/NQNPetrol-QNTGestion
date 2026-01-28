<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::withCount('purchases')
            ->orderBy('name')
            ->get();

        return view('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cuit' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'El nombre o razón social es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
        ]);

        Provider::create($validated);

        return redirect()->route('providers.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        $provider->load('purchases');
        return view('providers.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cuit' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'El nombre o razón social es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
        ]);

        $provider->update($validated);

        return redirect()->route('providers.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        // Verificar si tiene compras asociadas
        if ($provider->purchases()->count() > 0) {
            return redirect()->route('providers.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene compras asociadas.');
        }

        $provider->delete();

        return redirect()->route('providers.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}
