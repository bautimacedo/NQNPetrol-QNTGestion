<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\ProductionDrone;
use App\Models\TelemetryLog;
use Illuminate\Http\Request;

class TelemetryLogController extends Controller
{
    /**
     * Monitor de Logs de Telemetría
     */
    public function index(Request $request)
    {
        $query = TelemetryLog::with(['droneRelation', 'mission', 'authorizedUser'])
            ->orderByDesc('timestamp');

        // Filtros
        if ($request->filled('drone')) {
            $query->where('drone', $request->drone);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('date_from')) {
            $query->where('timestamp', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('timestamp', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);
        $drones = ProductionDrone::orderBy('name')->get();
        $severities = ['info', 'warning', 'error', 'critical'];

        return view('production.logs.index', compact('logs', 'drones', 'severities'));
    }
}
