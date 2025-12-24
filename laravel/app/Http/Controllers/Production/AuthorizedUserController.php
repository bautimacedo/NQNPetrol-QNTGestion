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
        $users = AuthorizedUser::orderBy('username')->get();
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
            ->with('success', 'Usuario autorizado registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorizedUser $authorizedUser)
    {
        $authorizedUser->load(['telemetryLogs', 'missionIntents']);
        return view('production.users.show', compact('authorizedUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuthorizedUser $authorizedUser)
    {
        return view('production.users.edit', compact('authorizedUser'));
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
        ]);

        if ($request->has('mission_password') && $request->mission_password) {
            $validated['mission_password'] = Hash::make($request->mission_password);
        } else {
            unset($validated['mission_password']);
        }

        $authorizedUser->update($validated);

        return redirect()->route('production.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
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
