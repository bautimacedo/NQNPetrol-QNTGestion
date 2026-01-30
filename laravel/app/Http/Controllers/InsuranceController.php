<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InsuranceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:admin'),
            'approved',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = Insurance::with('provider')
            ->orderBy('validity_date', 'desc')
            ->get();

        return view('insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('insurances.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'insurer_name' => 'required|string|max:255',
            'policy_number' => 'required|string|max:255',
            'validity_date' => 'required|date',
            'provider_id' => 'nullable|exists:providers,id',
            'notes' => 'nullable|string',
        ]);

        Insurance::create($validated);

        return redirect()->route('insurances.index')
            ->with('success', 'Seguro registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        $insurance->load('provider');
        return view('insurances.show', compact('insurance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        $providers = Provider::orderBy('name')->get();
        return view('insurances.edit', compact('insurance', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insurance $insurance)
    {
        $validated = $request->validate([
            'insurer_name' => 'required|string|max:255',
            'policy_number' => 'required|string|max:255',
            'validity_date' => 'required|date',
            'provider_id' => 'nullable|exists:providers,id',
            'notes' => 'nullable|string',
        ]);

        $insurance->update($validated);

        return redirect()->route('insurances.index')
            ->with('success', 'Seguro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        $insurance->delete();

        return redirect()->route('insurances.index')
            ->with('success', 'Seguro eliminado exitosamente.');
    }
}
