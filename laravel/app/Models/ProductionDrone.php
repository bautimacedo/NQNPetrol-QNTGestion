<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionDrone extends Model
{
    protected $table = 'Drone';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'dock',
        'site_id',
        'organization',
        'Latitud',
        'Longitud',
        'brand',
        'model',
        'registration',
    ];

    protected $casts = [
        'Latitud' => 'double',
        'Longitud' => 'double',
    ];

    /**
     * Relación con misiones (usando name como clave)
     */
    public function missions(): HasMany
    {
        return $this->hasMany(ProductionMission::class, 'drone', 'name');
    }

    /**
     * Relación con logs de telemetría
     */
    public function telemetryLogs(): HasMany
    {
        return $this->hasMany(TelemetryLog::class, 'drone', 'name');
    }

    /**
     * Relación con status logs
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(StatusLog::class, 'drone', 'name');
    }

    /**
     * Relación con baterías (usando name como clave)
     */
    public function batteries(): HasMany
    {
        return $this->hasMany(Battery::class, 'drone_name', 'name');
    }

    /**
     * Relación con el sitio
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    /**
     * Disponibilidad básica (la tabla no tiene campo de estado)
     */
    public function isAvailable(): bool
    {
        return true;
    }

    /**
     * Obtener el nombre de la clave para route model binding
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
