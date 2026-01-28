<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\AuthorizedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $licenses = License::with('authorizedUser')
            ->orderByDesc('expiration_date')
            ->get();

        return view('production.licenses.index', compact('licenses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'authorized_user_id' => 'required|integer|exists:authorized_users,id',
            'license_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'expiration_date' => 'required|date',
        ]);

        try {
            License::create([
                'authorized_user_id' => $validated['authorized_user_id'],
                'license_number' => $validated['license_number'],
                'category' => $validated['category'],
                'expiration_date' => $validated['expiration_date'],
                'created_at' => now(),
            ]);

            return redirect()->route('production.licenses.index')
                ->with('success', 'Licencia registrada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('production.licenses.index')
                ->withErrors(['error' => 'Error al registrar la licencia: ' . $e->getMessage()])
                ->withInput();
        }
    }
}

