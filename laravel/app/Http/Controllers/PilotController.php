<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\License;
use App\Models\Pilot;
use Illuminate\Http\Request;

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
