<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorizedUser extends Model
{
    protected $table = 'authorized_users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_telegram_id',
        'username',
        'mission_password',
        'role',
        'created_at',
        'dni',
        'full_name',
        'status',
        'profile_photo_path',
        'web_user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'status' => 'integer',
    ];

    /**
     * Relación con logs de telemetría
     */
    public function telemetryLogs(): HasMany
    {
        return $this->hasMany(TelemetryLog::class, 'telegram_sender', 'user_telegram_id');
    }

    /**
     * Relación con intenciones de misión
     */
    public function missionIntents(): HasMany
    {
        return $this->hasMany(SendMissionIntent::class, 'sender', 'user_telegram_id');
    }

    /**
     * Relación con las licencias del operario
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class, 'authorized_user_id');
    }

    /**
     * Relación con los vuelos del operario (usando TelemetryLog como referencia)
     */
    public function flights(): HasMany
    {
        return $this->hasMany(TelemetryLog::class, 'flight_responsable', 'user_telegram_id');
    }

    /**
     * Relación con el usuario web (si está vinculado)
     */
    public function webUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'web_user_id');
    }

    /**
     * Verificar si el operario tiene una licencia vigente
     */
    public function hasValidLicense(): bool
    {
        return $this->licenses()
            ->where('expiration_date', '>', now())
            ->exists();
    }

    /**
     * Obtener el nombre de la clave para route model binding
     */
    public function getRouteKeyName()
    {
        return 'user_telegram_id';
    }
}
