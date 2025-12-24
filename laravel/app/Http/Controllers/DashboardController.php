<?php

namespace App\Http\Controllers;

use App\Models\Battery;
use App\Models\License;
use App\Models\Pilot;
use App\Models\ProductionDrone;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Estado de la flota (desde Drone y Status)
        $totalDrones = ProductionDrone::count();
        $dronesWithStatus = StatusLog::select('drone')
            ->distinct()
            ->get()
            ->pluck('drone')
            ->unique()
            ->count();
        
        // Obtener estados desde StatusLog uniendo con Logs para obtener event_type como status
        // Usamos comillas dobles "" para los nombres de tablas con mayúsculas
        $statusCounts = StatusLog::join('Logs', 'Status.event', '=', 'Logs.event_id')
        ->selectRaw('COALESCE("Logs".event_type, \'unknown\') as status') // Agregamos "" a "Logs"
        ->selectRaw('COUNT(DISTINCT "Status".drone) as drone_count')      // Agregamos "" a "Status"
        ->groupByRaw('COALESCE("Logs".event_type, \'unknown\')')         // Agregamos "" a "Logs"
        ->get()
        ->pluck('drone_count', 'status');

        // 2. Alertas de licencias por vencer (desde license y pilots)
        $expiringLicenses = License::where('expiration_date', '>', now())
            ->where('expiration_date', '<=', now()->addDays(30))
            ->with('pilot')
            ->get();

        // 3. Resumen de energía: Baterías con más de 100 vuelos
        $batteriesHighFlightCount = Battery::where('flight_count', '>', 100)
            ->with('drone')
            ->orderByDesc('flight_count')
            ->get();

        // 4. Pilotos activos
        $totalPilots = Pilot::where('status', 1)->count();

        // 5. Clima (desde cache o fallback)
        $weather = Cache::get('weather_data') ?? $this->getFallbackWeather();

        return view('dashboard.index', compact(
            'totalDrones',
            'dronesWithStatus',
            'statusCounts',
            'expiringLicenses',
            'batteriesHighFlightCount',
            'totalPilots',
            'weather'
        ));
    }

    /**
     * Datos de respaldo por si la API falla o la cache está vacía
     */
    protected function getFallbackWeather(): array
    {
        return [
            'temp' => 22,
            'wind' => 15,
            'condition' => 'Datos no actualizados',
            'last_update' => 'N/A'
        ];
    }
}