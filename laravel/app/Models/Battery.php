<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Battery extends Model
{
    protected $table = 'batteries';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'serial_number',
        'flight_count',
        'last_used',
        'drone_name',
        'status',
    ];

    protected $casts = [
        'flight_count' => 'integer',
        'last_used' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Relación con el dron de producción usando drone_name como FK hacia Drone.name
     */
    public function drone(): BelongsTo
    {
        return $this->belongsTo(ProductionDrone::class, 'drone_name', 'name');
    }

    /**
     * Verificar si la batería tiene más de X vuelos
     */
    public function hasHighFlightCount(int $threshold = 100): bool
    {
        return $this->flight_count >= $threshold;
    }

    /**
     * Validar si la batería es utilizable para vuelo
     */
    public function isUsableForFlight(int $threshold = 200): bool
    {
        return ($this->status !== 'retired') && $this->flight_count <= $threshold;
    }
}
