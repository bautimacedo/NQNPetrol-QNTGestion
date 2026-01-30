<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = [
        'provider_id',
        'description',
        'total_amount',
        'currency',
        'status',
        'payment_method',
        'card_last_four',
        'product_image_path',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Relación con proveedor
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Relación con documentos
     */
    public function documents(): HasMany
    {
        return $this->hasMany(PurchaseDocument::class);
    }

    /**
     * Verificar si tiene un documento específico
     */
    public function hasDocument(string $type): bool
    {
        return $this->documents()->where('type', $type)->exists();
    }

    /**
     * Obtener un documento específico
     */
    public function getDocument(string $type): ?PurchaseDocument
    {
        return $this->documents()->where('type', $type)->first();
    }

    /**
     * Calcular el progreso de documentación (etapas opcionales)
     */
    public function getDocumentationProgress(): array
    {
        // Etapas opcionales - no son obligatorias
        $optionalTypes = [
            'budget_pdf',
            'purchase_order',
            'invoice',
            'payment_order',
            'payment_proof',
            'tax_retention',
        ];

        $completed = 0;
        $total = count($optionalTypes);
        $status = [];

        foreach ($optionalTypes as $type) {
            $hasDocument = $this->hasDocument($type);
            if ($hasDocument) {
                $completed++;
            }
            $status[$type] = $hasDocument;
        }

        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
            'status' => $status,
        ];
    }

    /**
     * Verificar si la documentación está completa (ahora opcional, siempre retorna true)
     */
    public function isDocumentationComplete(): bool
    {
        // Las etapas son opcionales, así que siempre retornamos true
        return true;
    }
}
