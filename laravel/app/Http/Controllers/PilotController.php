<?php

namespace App\Http\Controllers;

use App\Models\AuthorizedUser;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pilots = AuthorizedUser::with(['licenses' => function ($query) {
            $query->orderByDesc('expiration_date');
        }])
            ->whereNotNull('full_name') // Solo mostrar operarios que tienen datos de piloto
            ->orderBy('full_name')
            ->get();

        return view('pilots.index', compact('pilots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'dni' => 'required|string|max:20',
                'user_telegram_id' => 'required|string|max:255',
                'status' => 'required|integer|in:0,1',
                'license_number' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'expiration_date' => 'required|date',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'full_name.required' => 'El nombre completo es obligatorio.',
                'dni.required' => 'El DNI es obligatorio.',
                'user_telegram_id.required' => 'El Telegram ID es obligatorio.',
                'status.required' => 'El estado es obligatorio.',
                'status.integer' => 'El estado debe ser un número entero.',
                'license_number.required' => 'El número de licencia es obligatorio.',
                'category.required' => 'La categoría es obligatoria.',
                'expiration_date.required' => 'La fecha de vencimiento es obligatoria.',
                'expiration_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            ]);

            DB::beginTransaction();

            // Manejar la subida de la foto de perfil
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pilots', $filename, 'public');
                $profilePhotoPath = $path;
            }

            // Buscar o crear el authorized_user
            $authorizedUser = AuthorizedUser::firstOrNew([
                'user_telegram_id' => $validated['user_telegram_id']
            ]);

            // Si es nuevo, establecer valores por defecto
            if (!$authorizedUser->exists) {
                $authorizedUser->username = null;
                $authorizedUser->mission_password = '';
                $authorizedUser->role = 'operator';
                $authorizedUser->created_at = now();
            }

            // Actualizar o establecer los datos del piloto
            $authorizedUser->full_name = $validated['full_name'];
            $authorizedUser->dni = $validated['dni'];
            $authorizedUser->status = (int) $validated['status'];
            if ($profilePhotoPath) {
                $authorizedUser->profile_photo_path = $profilePhotoPath;
            }
            $authorizedUser->save();

            // Crear la licencia asociada
            License::create([
                'authorized_user_id' => $authorizedUser->id,
                'license_number' => $validated['license_number'],
                'category' => $validated['category'],
                'expiration_date' => $validated['expiration_date'],
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('pilots.index')
                ->with('success', 'Piloto y licencia registrados exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Errores de validación
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log del error para debugging
            \Log::error('Error al registrar piloto: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al registrar el piloto: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource (Perfil del Piloto).
     */
    public function show(AuthorizedUser $pilot)
    {
        $pilot->load(['licenses']);

        // Estadísticas del piloto (usando logs de telemetría como referencia de vuelos)
        $flights = $pilot->flights;
        $totalFlights = $flights->count();
        
        // Calcular horas basándose en los logs (si tienen duración)
        // Por ahora, si no hay datos de vuelos reales, usar 0
        $totalMinutes = 0;
        if ($flights->count() > 0) {
            // Intentar calcular desde los logs si tienen información de duración
            $totalMinutes = $flights->count() * 30; // Estimación: 30 min por vuelo si no hay datos
        }
        $totalHours = round($totalMinutes / 60, 2);
        
        // Licencia más reciente
        $latestLicense = $pilot->licenses()
            ->orderByDesc('expiration_date')
            ->first();

        // Vuelos recientes (últimos 10) - usando logs de telemetría
        $recentFlights = $pilot->flights()
            ->with('droneRelation')
            ->orderByDesc('timestamp')
            ->limit(10)
            ->get();

        // Verificar si la licencia vence pronto
        $licenseExpiringSoon = $latestLicense && $latestLicense->expiresSoon(30);

        return view('pilots.show', compact(
            'pilot',
            'totalFlights',
            'totalHours',
            'latestLicense',
            'recentFlights',
            'licenseExpiringSoon'
        ));
    }
}
