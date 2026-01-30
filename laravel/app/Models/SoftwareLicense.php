<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoftwareLicense extends Model
{
    protected $fillable = [
        'software_name',
        'provider_id',
        'license_key',
        'license_number',
        'expiration_date',
        'seats',
        'notes',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'seats' => 'integer',
    ];

    /**
     * Relación con proveedor
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
