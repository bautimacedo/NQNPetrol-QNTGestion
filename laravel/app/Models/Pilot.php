<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Verificar si el piloto tiene una licencia vigente
     */
    public function hasValidLicense(): bool
    {
        return $this->licenses()
            ->where('expiration_date', '>', now())
            ->exists();
    }
}
