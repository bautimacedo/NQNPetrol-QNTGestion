<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusLog extends Model
{
    protected $table = 'Status';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'drone',
        'event',
    ];

    /**
     * Relación con el dron (usando name como clave)
     */
    public function droneRelation(): BelongsTo
    {
        return $this->belongsTo(ProductionDrone::class, 'drone', 'name');
    }

    /**
     * Relación con el log de telemetría
     */
    public function telemetryLog(): BelongsTo
    {
        return $this->belongsTo(TelemetryLog::class, 'event', 'event_id');
    }
}
