<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insurance extends Model
{
    protected $fillable = [
        'insurer_name',
        'policy_number',
        'validity_date',
        'provider_id',
        'notes',
    ];

    protected $casts = [
        'validity_date' => 'date',
    ];

    /**
     * Relación con proveedor
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
