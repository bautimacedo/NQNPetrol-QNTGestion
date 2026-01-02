<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TelemetryLog;

class Pilot extends Model
{
    protected $table = 'pilots';
    
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'dni',
        'status',
        'timestamp',
        'user_telegram_id',
        'profile_photo',
    ];

    protected $casts = [
        'status' => 'integer',
        'timestamp' => 'datetime',
    ];

    /**
     * Relación con las licencias del piloto
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    /**
     * Relación con los vuelos del piloto
     * Nota: Por ahora retorna una colección vacía hasta que se implemente la tabla flights
     */
    public function flights(): HasMany
    {
        // Si existe un modelo Flight, usar: return $this->hasMany(Flight::class);
        // Por ahora, retornamos una relación vacía para evitar errores
        return $this->hasMany(TelemetryLog::class, 'flight_responsable', 'user_telegram_id');
    }

    /**
     * Verificar si el piloto tiene una licencia vigente
     */
    public function hasValidLicense(): bool
    {
        return $this->licenses()
            ->where('expiration_date', '>', now())
            ->exists();
    }
}
