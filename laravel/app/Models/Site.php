<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    protected $fillable = [
        'name',
        'location_details',
    ];

    /**
     * Relación con drones
     */
    public function drones(): HasMany
    {
        return $this->hasMany(ProductionDrone::class, 'site_id');
    }
}
