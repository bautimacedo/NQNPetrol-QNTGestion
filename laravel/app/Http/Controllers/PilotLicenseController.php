<?php

namespace App\Http\Controllers;

use App\Models\AuthorizedUser;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PilotLicenseController extends Controller
{
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
        
        // Usar la vista que permite editar la licencia completa
        return view('pilots.my-license', compact('authorizedUser', 'latestLicense'));
    }

    /**
     * Update the pilot's license information and document.
     */
    public function update(Request $request)
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
            'license_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);
        
        $latestLicense = $authorizedUser->licenses()->orderByDesc('expiration_date')->first();
        
        $licenseData = [
            'authorized_user_id' => $authorizedUser->id,
            'license_number' => $request->license_number,
            'category' => $request->category,
            'expiration_date' => $request->expiration_date,
            'created_at' => $latestLicense ? $latestLicense->created_at : now(),
        ];
        
        // Handle document upload
        if ($request->hasFile('document')) {
            // Delete old document if exists
            if ($latestLicense && $latestLicense->document_path) {
                Storage::disk('public')->delete($latestLicense->document_path);
            }
            $path = $request->file('document')->store('licenses_docs', 'public');
            $licenseData['document_path'] = $path;
        } elseif ($latestLicense && $latestLicense->document_path) {
            // Keep existing document if no new one is uploaded
            $licenseData['document_path'] = $latestLicense->document_path;
        }
        
        if ($latestLicense) {
            $latestLicense->update($licenseData);
        } else {
            $authorizedUser->licenses()->create($licenseData);
        }
        
        return redirect()->back()->with('success', 'Licencia actualizada exitosamente.');
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
