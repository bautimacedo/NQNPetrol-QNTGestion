<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SendMissionIntent extends Model
{
    protected $table = 'send_mission_intent';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'mision_name',
        'stage',
        'sender',
    ];

    protected $casts = [
        'stage' => 'integer',
    ];

    /**
     * Relación con la misión (usando name como clave)
     */
    public function mission(): BelongsTo
    {
        return $this->belongsTo(ProductionMission::class, 'mision_name', 'name');
    }

    /**
     * Relación con el usuario autorizado
     */
    public function authorizedUser(): BelongsTo
    {
        return $this->belongsTo(AuthorizedUser::class, 'sender', 'user_telegram_id');
    }
}
