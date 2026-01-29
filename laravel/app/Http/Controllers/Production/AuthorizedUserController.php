<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorizedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = AuthorizedUser::with('licenses')->orderBy('username')->get();
        return view('production.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('production.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_telegram_id' => 'required|integer|unique:authorized_users,user_telegram_id',
            'username' => 'nullable|string',
            'mission_password' => 'required|string',
            'role' => 'required|string|in:operator,admin,viewer',
        ]);

        if ($request->has('mission_password')) {
            $validated['mission_password'] = Hash::make($request->mission_password);
        }

        AuthorizedUser::create($validated);

        return redirect()->route('production.users.index')
            ->with('success', 'Piloto registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorizedUser $authorizedUser)
    {
        $authorizedUser->load(['telemetryLogs', 'missionIntents', 'licenses']);
        $latestLicense = $authorizedUser->licenses()->orderByDesc('expiration_date')->first();
        return view('production.users.show', compact('authorizedUser', 'latestLicense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuthorizedUser $authorizedUser)
    {
        $authorizedUser->load('licenses');
        $latestLicense = $authorizedUser->licenses()->orderByDesc('expiration_date')->first();
        return view('production.users.edit', compact('authorizedUser', 'latestLicense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AuthorizedUser $authorizedUser)
    {
        $validated = $request->validate([
            'username' => 'nullable|string',
            'mission_password' => 'nullable|string',
            'role' => 'required|string|in:operator,admin,viewer',
            'license_number' => 'nullable|string|max:255',
            'license_category' => 'nullable|string|max:255',
            'license_expiration_date' => 'nullable|date',
        ]);

        if ($request->has('mission_password') && $request->mission_password) {
            $validated['mission_password'] = Hash::make($request->mission_password);
        } else {
            unset($validated['mission_password']);
        }

        $authorizedUser->update([
            'username' => $validated['username'] ?? $authorizedUser->username,
            'role' => $validated['role'],
            'mission_password' => $validated['mission_password'] ?? $authorizedUser->mission_password,
        ]);

        // Actualizar o crear licencia
        if ($request->filled('license_number') && $request->filled('license_category') && $request->filled('license_expiration_date')) {
            $license = $authorizedUser->licenses()->orderByDesc('expiration_date')->first();
            
            if ($license) {
                $license->update([
                    'license_number' => $validated['license_number'],
                    'category' => $validated['license_category'],
                    'expiration_date' => $validated['license_expiration_date'],
                ]);
            } else {
                \App\Models\License::create([
                    'authorized_user_id' => $authorizedUser->id,
                    'license_number' => $validated['license_number'],
                    'category' => $validated['license_category'],
                    'expiration_date' => $validated['license_expiration_date'],
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('production.users.index')
            ->with('success', 'Piloto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthorizedUser $authorizedUser)
    {
        $authorizedUser->delete();
        return redirect()->route('production.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
