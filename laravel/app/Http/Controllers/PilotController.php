<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\License;
use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pilots = Pilot::with(['licenses' => function ($query) {
            $query->orderByDesc('expiration_date');
        }])
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

            // Crear el piloto (asegurar que status sea integer)
            $pilot = Pilot::create([
                'full_name' => $validated['full_name'],
                'dni' => $validated['dni'],
                'user_telegram_id' => $validated['user_telegram_id'],
                'status' => (int) $validated['status'],
                'timestamp' => now(),
            ]);

            // Crear la licencia asociada
            License::create([
                'pilot_id' => $pilot->id,
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
    public function show(Pilot $pilot)
    {
        $pilot->load(['licenses', 'flights.drone']);

        // Estadísticas del piloto
        $totalFlights = $pilot->flights->count();
        $totalMinutes = $pilot->flights->sum(fn($flight) => $flight->total_minutes);
        $totalHours = round($totalMinutes / 60, 2);
        
        // Licencia más reciente
        $latestLicense = $pilot->licenses()
            ->orderByDesc('expiration_date')
            ->first();

        // Vuelos recientes (últimos 10)
        $recentFlights = $pilot->flights()
            ->with('drone')
            ->orderByDesc('flight_date')
            ->orderByDesc('departure_time')
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
