<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
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

    public function approve($id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'is_approved' => true,
        ]);
        
        // Asegurar que tenga el rol operator
        if (!$user->hasRole('operator')) {
            $user->assignRole('operator');
        }
        
        return redirect()->back()
            ->with('success', "Usuario {$user->name} aprobado como Operador exitosamente.");
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
}
