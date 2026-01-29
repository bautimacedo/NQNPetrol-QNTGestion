<?php

namespace App\Http\Controllers;

use App\Models\AuthorizedUser;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PilotController extends Controller
{
    /**
     * Display a listing of pilots (authorized_users with pilot role).
     */
    public function index()
    {
        // Obtener todos los usuarios web con rol 'pilot'
        $pilotUserIds = \App\Models\User::role('pilot')->pluck('id');
        
        // Obtener authorized_users vinculados a esos usuarios web
        $pilots = AuthorizedUser::whereIn('web_user_id', $pilotUserIds)
            ->with(['webUser', 'licenses' => function($query) {
                $query->orderByDesc('expiration_date');
            }])
            ->orderBy('full_name')
            ->orderBy('username')
            ->get();
        
        return view('pilots.index', compact('pilots'));
    }

    /**
     * Display the pilot's license management page.
     */
    public function myLicense()
    {
        $user = auth()->user();
        
        if (!$user->hasRole('pilot')) {
            abort(403, 'Acceso denegado. Solo para pilotos.');
        }
        
        $authorizedUser = AuthorizedUser::where('web_user_id', $user->id)
            ->with('licenses')
            ->first();
        
        if (!$authorizedUser) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró tu perfil de piloto. Contacta al administrador.');
        }
        
        $latestLicense = $authorizedUser->licenses()->orderByDesc('expiration_date')->first();
        
        return view('pilot.my-license', compact('authorizedUser', 'latestLicense'));
    }

    /**
     * Update the pilot's license document.
     */
    public function updateLicenseDocument(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->hasRole('pilot')) {
            abort(403, 'Acceso denegado.');
        }
        
        $authorizedUser = AuthorizedUser::where('web_user_id', $user->id)->first();
        
        if (!$authorizedUser) {
            return redirect()->back()->with('error', 'No se encontró tu perfil de piloto.');
        }
        
        $request->validate([
            'license_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
        ]);
        
        $latestLicense = $authorizedUser->licenses()->orderByDesc('expiration_date')->first();
        
        if (!$latestLicense) {
            return redirect()->back()->with('error', 'No tienes una licencia registrada. Contacta al administrador.');
        }
        
        // Eliminar documento anterior si existe
        if ($latestLicense->document_path && Storage::disk('public')->exists($latestLicense->document_path)) {
            Storage::disk('public')->delete($latestLicense->document_path);
        }
        
        // Subir nuevo documento
        $file = $request->file('license_document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('licenses_docs', $filename, 'public');
        
        $latestLicense->update([
            'document_path' => $path,
        ]);
        
        return redirect()->back()->with('success', 'Documento de licencia actualizado exitosamente.');
    }
}
