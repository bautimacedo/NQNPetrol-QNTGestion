<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuthorizedUser extends Model
{
    protected $table = 'authorized_users';
    protected $primaryKey = 'user_telegram_id';
    public $incrementing = false;
    public $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_telegram_id',
        'username',
        'mission_password',
        'role',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
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
}
