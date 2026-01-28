<?php

namespace App\Services;

use App\Models\Battery;
use App\Models\Drone;
use App\Models\License;
use App\Models\AuthorizedUser;
use Illuminate\Support\Collection;

class FlightSafetyService
{
    /**
     * Validar todas las condiciones de seguridad antes de aprobar un vuelo
     *
     * @param AuthorizedUser $pilot
     * @param Drone $drone
     * @param Battery|null $battery
     * @param float|null $windSpeedSustained Viento sostenido en km/h
     * @param float|null $windSpeedGusts Ráfagas de viento en km/h
     * @return Collection Errores encontrados (vacío si todo está OK)
     */
    public function validateFlightSafety(
        AuthorizedUser $pilot,
        Drone $drone,
        ?Battery $battery = null,
        ?float $windSpeedSustained = null,
        ?float $windSpeedGusts = null
    ): Collection {
        $errors = collect();

        // Validaciones de clima
        $weatherErrors = $this->validateWeather($windSpeedSustained, $windSpeedGusts);
        $errors = $errors->merge($weatherErrors);

        // Validaciones legales
        $legalErrors = $this->validateLegalCompliance($pilot);
        $errors = $errors->merge($legalErrors);

        // Validaciones de estado del equipo
        $equipmentErrors = $this->validateEquipmentStatus($drone, $battery);
        $errors = $errors->merge($equipmentErrors);

        return $errors;
    }

    /**
     * Validar condiciones climáticas
     *
     * @param float|null $windSpeedSustained
     * @param float|null $windSpeedGusts
     * @return Collection
     */
    protected function validateWeather(?float $windSpeedSustained, ?float $windSpeedGusts): Collection
    {
        $errors = collect();

        // Viento sostenido debe ser < 40 km/h
        if ($windSpeedSustained !== null && $windSpeedSustained >= 40) {
            $errors->push([
                'type' => 'weather',
                'field' => 'wind_speed_sustained',
                'message' => "El viento sostenido ({$windSpeedSustained} km/h) excede el límite permitido de 40 km/h",
            ]);
        }

        // Ráfagas de viento < 50 km/h
        if ($windSpeedGusts !== null && $windSpeedGusts >= 50) {
            $errors->push([
                'type' => 'weather',
                'field' => 'wind_speed_gusts',
                'message' => "Las ráfagas de viento ({$windSpeedGusts} km/h) exceden el límite permitido de 50 km/h",
            ]);
        }

        return $errors;
    }

    /**
     * Validar cumplimiento legal
     *
     * @param AuthorizedUser $pilot
     * @return Collection
     */
    protected function validateLegalCompliance(AuthorizedUser $pilot): Collection
    {
        $errors = collect();

        // La licencia del piloto debe estar vigente
        if (!$pilot->hasValidLicense()) {
            $errors->push([
                'type' => 'legal',
                'field' => 'pilot_license',
                'message' => "El piloto {$pilot->full_name} no tiene una licencia vigente",
            ]);
        }

        return $errors;
    }

    /**
     * Validar estado del equipo
     *
     * @param Drone $drone
     * @param Battery|null $battery
     * @return Collection
     */
    protected function validateEquipmentStatus(Drone $drone, ?Battery $battery = null): Collection
    {
        $errors = collect();

        // El dron no puede estar en "maintenance"
        if ($drone->status === 'maintenance') {
            $errors->push([
                'type' => 'equipment',
                'field' => 'drone_status',
                'message' => "El dron {$drone->name} está en mantenimiento y no puede volar",
            ]);
        }

        // El dron no puede estar volando
        if ($drone->status === 'flying') {
            $errors->push([
                'type' => 'equipment',
                'field' => 'drone_status',
                'message' => "El dron {$drone->name} ya está en vuelo",
            ]);
        }

        // La batería asignada debe tener menos de 200 ciclos
        if ($battery !== null) {
            if (!$battery->isUsableForFlight(200)) {
                $errors->push([
                    'type' => 'equipment',
                    'field' => 'battery_cycles',
                    'message' => "La batería {$battery->serial} tiene {$battery->cycle_count} ciclos (máximo permitido: 200) o salud baja ({$battery->health_percentage}%)",
                ]);
            }
        }

        return $errors;
    }

    /**
     * Verificar si un vuelo puede ser aprobado
     *
     * @param AuthorizedUser $pilot
     * @param Drone $drone
     * @param Battery|null $battery
     * @param float|null $windSpeedSustained
     * @param float|null $windSpeedGusts
     * @return bool
     */
    public function canApproveFlight(
        AuthorizedUser $pilot,
        Drone $drone,
        ?Battery $battery = null,
        ?float $windSpeedSustained = null,
        ?float $windSpeedGusts = null
    ): bool {
        $errors = $this->validateFlightSafety(
            $pilot,
            $drone,
            $battery,
            $windSpeedSustained,
            $windSpeedGusts
        );

        return $errors->isEmpty();
    }
}

