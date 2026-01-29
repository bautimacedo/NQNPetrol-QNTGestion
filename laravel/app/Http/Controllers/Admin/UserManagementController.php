<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserManagementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:admin'),
            'approved',
        ];
    }

    public function index()
    {
        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.users.index', compact('users'));
    }

    public function pending()
    {
        $pendingUsers = User::where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.users.pending', compact('pendingUsers'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:admin,operator,pilot',
        ]);

        $user = User::findOrFail($id);
        $role = $request->input('role');
        
        $user->update([
            'is_approved' => true,
        ]);
        
        // Asignar el rol seleccionado (sincronizar para que solo tenga ese rol)
        $user->syncRoles([$role]);
        
        // Si el rol es pilot, crear/actualizar registro en authorized_users
        if ($role === 'pilot') {
            $authorizedUser = \App\Models\AuthorizedUser::where('web_user_id', $user->id)->first();
            
            if (!$authorizedUser) {
                // Generar un user_telegram_id único (usar un número alto para evitar conflictos)
                $maxTelegramId = \App\Models\AuthorizedUser::max('user_telegram_id') ?? 1000000;
                $newTelegramId = max($maxTelegramId + 1, 1000000 + $user->id);
                
                // Verificar que no exista
                while (\App\Models\AuthorizedUser::where('user_telegram_id', $newTelegramId)->exists()) {
                    $newTelegramId++;
                }
                
                // Crear nuevo registro en authorized_users
                \App\Models\AuthorizedUser::create([
                    'user_telegram_id' => $newTelegramId,
                    'username' => $user->name,
                    'full_name' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
                    'dni' => $user->dni ?? null,
                    'mission_password' => null, // Se configurará después por el piloto
                    'role' => 'operator', // Rol por defecto en authorized_users
                    'status' => 1,
                    'web_user_id' => $user->id,
                    'created_at' => now(),
                ]);
            } else {
                // Actualizar registro existente
                $authorizedUser->update([
                    'web_user_id' => $user->id,
                    'username' => $user->name,
                    'full_name' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
                    'dni' => $user->dni ?? $authorizedUser->dni,
                ]);
            }
        }
        
        $roleLabels = [
            'admin' => 'Administrador',
            'operator' => 'Operador',
            'pilot' => 'Piloto',
        ];
        
        return redirect()->back()
            ->with('success', "Usuario {$user->name} aprobado como {$roleLabels[$role]} exitosamente.");
    }

    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'is_approved' => true,
        ]);
        
        // Sincronizar roles para que solo tenga admin
        $user->syncRoles(['admin']);
        
        return redirect()->back()
            ->with('success', "Usuario {$user->name} ahora es Administrador.");
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        
        $user->delete();
        
        return redirect()->route('admin.users.pending')
            ->with('success', "Usuario {$userName} rechazado y eliminado.");
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load('roles');
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'nullable|string|in:admin,operator,pilot',
        ]);

        $user->update([
            'first_name' => $validated['first_name'] ?? $user->first_name,
            'last_name' => $validated['last_name'] ?? $user->last_name,
            'email' => $validated['email'],
        ]);

        if ($request->filled('role')) {
            $user->syncRoles([$validated['role']]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Usuario {$userName} eliminado exitosamente.");
    }
}
