<?php

namespace App\Observers;

use App\Models\ProductionMission;

class MissionObserver
{
    /**
     * Handle the ProductionMission "updated" event.
     */
    public function updated(ProductionMission $mission): void
    {
        // Observer para misiones de producción si es necesario
        // Las misiones de producción no tienen flight_time_minutes ni status como en el modelo anterior
    }

    /**
     * Handle the ProductionMission "created" event.
     */
    public function created(ProductionMission $mission): void
    {
        // Observer para misiones de producción si es necesario
    }
}

