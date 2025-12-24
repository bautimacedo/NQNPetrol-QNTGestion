<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionMission extends Model
{
    protected $table = 'mission';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'duration',
        'link_rtcp',
        'url',
        'descrpition',
        'drone',
        'Authentication',
        'payload',
        'send_passwd',
    ];

    protected $casts = [
        'payload' => 'array',
        'duration' => 'integer',
    ];

    /**
     * Relación con el dron (usando name como clave)
     */
    public function droneRelation(): BelongsTo
    {
        return $this->belongsTo(ProductionDrone::class, 'drone', 'name');
    }

    /**
     * Relación con logs de telemetría
     */
    public function telemetryLogs(): HasMany
    {
        return $this->hasMany(TelemetryLog::class, 'flight_name', 'name');
    }

    /**
     * Relación con intenciones de misión
     */
    public function missionIntents(): HasMany
    {
        return $this->hasMany(SendMissionIntent::class, 'mision_name', 'name');
    }
}
