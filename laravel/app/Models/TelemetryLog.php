<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelemetryLog extends Model
{
    protected $table = 'Logs';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'event_type',
        'message',
        'severity',
        'dock',
        'drone',
        'latitude',
        'longitude',
        'altitude',
        'site',
        'organization',
        'drone_battery',
        'timestamp',
        'flight_type',
        'flight_name',
        'flight_responsable',
        'telegram_sender',
        'telegram',
    ];

    protected $casts = [
        'telegram' => 'boolean',
        'timestamp' => 'datetime',
    ];

    /**
     * Relación con el dron (usando name como clave)
     */
    public function droneRelation(): BelongsTo
    {
        return $this->belongsTo(ProductionDrone::class, 'drone', 'name');
    }

    /**
     * Relación con la misión (usando name como clave)
     */
    public function mission(): BelongsTo
    {
        return $this->belongsTo(ProductionMission::class, 'flight_name', 'name');
    }

    /**
     * Relación con el usuario autorizado
     */
    public function authorizedUser(): BelongsTo
    {
        return $this->belongsTo(AuthorizedUser::class, 'telegram_sender', 'user_telegram_id');
    }
}
