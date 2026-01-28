<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    protected $table = 'license';
    public $timestamps = false;

    protected $fillable = [
        'authorized_user_id',
        'license_number',
        'category',
        'expiration_date',
        'created_at',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Relación con el operario autorizado
     */
    public function authorizedUser(): BelongsTo
    {
        return $this->belongsTo(AuthorizedUser::class, 'authorized_user_id');
    }

    /**
     * Alias para mantener compatibilidad con código existente
     * @deprecated Usar authorizedUser() en su lugar
     */
    public function pilot(): BelongsTo
    {
        return $this->authorizedUser();
    }

    /**
     * Verificar si la licencia está vigente
     */
    public function isValid(): bool
    {
        return $this->expiration_date > now();
    }

    /**
     * Verificar si la licencia vence pronto (menos de 30 días)
     */
    public function expiresSoon(int $days = 30): bool
    {
        return $this->expiration_date->isBefore(now()->addDays($days)) 
            && $this->expiration_date->isAfter(now());
    }
}
