<?php

namespace App\Http\Controllers;

use App\Models\Battery;
use App\Models\License;
use App\Models\AuthorizedUser;
use App\Models\ProductionDrone;
use App\Models\StatusLog;
use App\Models\Well;
use App\Models\WeatherLog;
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

        // 2. Alertas de licencias por vencer (desde license y authorized_users)
        $expiringLicenses = License::where('expiration_date', '>', now())
            ->where('expiration_date', '<=', now()->addDays(30))
            ->with('authorizedUser')
            ->get();

        // 3. Resumen de energía: Baterías con más de 100 vuelos
        $batteriesHighFlightCount = Battery::where('flight_count', '>', 100)
            ->with('drone')
            ->orderByDesc('flight_count')
            ->get();

        // 4. Operarios activos (pilotos)
        $totalPilots = AuthorizedUser::where('status', 1)
            ->whereNotNull('full_name')
            ->count();

        // 5. Pozos activos
        $activeWells = Well::where('status', 'activo')->count();

        // 6. Clima (desde weather_logs o fallback)
        $latestWeather = WeatherLog::orderByDesc('recorded_at')->first();
        $weather = $this->getWeatherData($latestWeather);

        return view('dashboard.index', compact(
            'totalDrones',
            'dronesWithStatus',
            'statusCounts',
            'expiringLicenses',
            'batteriesHighFlightCount',
            'totalPilots',
            'activeWells',
            'weather'
        ));
    }

    /**
     * Obtener datos del clima desde weather_logs o fallback
     */
    protected function getWeatherData($latestWeather): array
    {
        if ($latestWeather) {
            // Convertir velocidad del viento de m/s a km/h
            $windSpeedKmh = ($latestWeather->wind_speed_ms ?? 0) * 3.6;
            $windGustsKmh = ($latestWeather->wind_gust_ms ?? 0) * 3.6;
            
            return [
                'temperature' => $latestWeather->temp_celsius ?? 0,
                'wind_speed' => $windSpeedKmh,
                'wind_gusts' => $windGustsKmh,
                'description' => $latestWeather->condition_desc ?? $latestWeather->condition_main ?? 'Sin datos',
                'condition_main' => $latestWeather->condition_main ?? 'N/A',
                'visibility' => $latestWeather->visibility_meters ?? 0,
                'is_flyable' => $latestWeather->is_flyable ?? false,
                'last_update' => $latestWeather->recorded_at ? $latestWeather->recorded_at->format('d/m/Y H:i') : 'N/A',
                'city_name' => $latestWeather->city_name ?? 'N/A',
            ];
        }
        
        return $this->getFallbackWeather();
    }

    /**
     * Datos de respaldo por si no hay registros en weather_logs
     */
    protected function getFallbackWeather(): array
    {
        return [
            'temperature' => 22,
            'wind_speed' => 15,
            'wind_gusts' => 20,
            'description' => 'Datos no actualizados',
            'condition_main' => 'N/A',
            'visibility' => 0,
            'is_flyable' => true,
            'last_update' => 'N/A',
            'city_name' => 'N/A',
        ];
    }
}