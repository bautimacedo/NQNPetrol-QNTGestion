<?php

namespace App\Http\Controllers;

use App\Models\SoftwareLicense;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SoftwareLicenseController extends Controller implements HasMiddleware
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
        $licenses = SoftwareLicense::with('provider')
            ->orderBy('software_name')
            ->get();

        return view('software-licenses.index', compact('licenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('software-licenses.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'software_name' => 'required|string|max:255',
            'provider_id' => 'nullable|exists:providers,id',
            'license_key' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:255',
            'expiration_date' => 'nullable|date',
            'seats' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        SoftwareLicense::create($validated);

        return redirect()->route('software-licenses.index')
            ->with('success', 'Licencia de software registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SoftwareLicense $softwareLicense)
    {
        $softwareLicense->load('provider');
        return view('software-licenses.show', compact('softwareLicense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SoftwareLicense $softwareLicense)
    {
        $providers = Provider::orderBy('name')->get();
        return view('software-licenses.edit', compact('softwareLicense', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SoftwareLicense $softwareLicense)
    {
        $validated = $request->validate([
            'software_name' => 'required|string|max:255',
            'provider_id' => 'nullable|exists:providers,id',
            'license_key' => 'nullable|string|max:255',
            'license_number' => 'required|string|max:255',
            'expiration_date' => 'nullable|date',
            'seats' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $softwareLicense->update($validated);

        return redirect()->route('software-licenses.index')
            ->with('success', 'Licencia de software actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SoftwareLicense $softwareLicense)
    {
        $softwareLicense->delete();

        return redirect()->route('software-licenses.index')
            ->with('success', 'Licencia de software eliminada exitosamente.');
    }
}
