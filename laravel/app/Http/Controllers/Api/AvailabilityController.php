<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DroneAvailabilityResource;
use App\Http\Resources\PilotAvailabilityResource;
use App\Models\ProductionDrone;
use App\Models\Pilot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Consultar disponibilidad de drones
     *
     * @return JsonResponse
     */
    public function drones(): JsonResponse
    {
        $drones = ProductionDrone::with('batteries')->get();

        return response()->json([
            'success' => true,
            'data' => DroneAvailabilityResource::collection($drones),
            'count' => $drones->count(),
        ]);
    }

    /**
     * Consultar disponibilidad de pilotos
     *
     * @return JsonResponse
     */
    public function pilots(): JsonResponse
    {
        $pilots = Pilot::with('licenses')
            ->where('status', 1)
            ->whereHas('licenses', function ($query) {
                $query->where('expiration_date', '>', now());
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => PilotAvailabilityResource::collection($pilots),
            'count' => $pilots->count(),
        ]);
    }

    /**
     * Consultar disponibilidad de un dron específico
     *
     * @param int $id
     * @return JsonResponse
     */
    public function drone(int $id): JsonResponse
    {
        $drone = ProductionDrone::with('batteries')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new DroneAvailabilityResource($drone),
            'available' => $drone->isAvailable(),
        ]);
    }

    /**
     * Consultar disponibilidad de un piloto específico
     *
     * @param int $id
     * @return JsonResponse
     */
    public function pilot(int $id): JsonResponse
    {
        $pilot = Pilot::with('licenses')->findOrFail($id);

        $available = (int) $pilot->status === 1 && $pilot->hasValidLicense();

        return response()->json([
            'success' => true,
            'data' => new PilotAvailabilityResource($pilot),
            'available' => $available,
        ]);
    }
}
