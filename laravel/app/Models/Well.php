<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Well extends Model
{
    protected $table = 'well';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'status',
        'bpm',
        'last_update',
        'drone_asignated',
        'site',
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'bpm' => 'integer',
        'last_update' => 'datetime',
    ];

    /**
     * Relación con el dron asignado
     */
    public function drone(): BelongsTo
    {
        return $this->belongsTo(ProductionDrone::class, 'drone_asignated', 'name');
    }
}

