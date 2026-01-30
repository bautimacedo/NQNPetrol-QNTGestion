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
        'manually_completed_steps',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'manually_completed_steps' => 'array',
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
     * Verificar si tiene un documento específico o está marcado como completado manualmente
     */
    public function hasDocument(string $type): bool
    {
        // Verificar si tiene documento físico
        if ($this->documents()->where('type', $type)->exists()) {
            return true;
        }
        
        // Verificar si está marcado como completado manualmente
        $manuallyCompleted = $this->manually_completed_steps ?? [];
        return in_array($type, $manuallyCompleted);
    }
    
    /**
     * Verificar si un paso está marcado como completado manualmente
     */
    public function isManuallyCompleted(string $type): bool
    {
        $manuallyCompleted = $this->manually_completed_steps ?? [];
        return in_array($type, $manuallyCompleted);
    }
    
    /**
     * Marcar un paso como completado manualmente
     */
    public function markAsManuallyCompleted(string $type): void
    {
        $manuallyCompleted = $this->manually_completed_steps ?? [];
        if (!in_array($type, $manuallyCompleted)) {
            $manuallyCompleted[] = $type;
            $this->manually_completed_steps = $manuallyCompleted;
            $this->save();
        }
    }
    
    /**
     * Desmarcar un paso como completado manualmente
     */
    public function unmarkAsManuallyCompleted(string $type): void
    {
        $manuallyCompleted = $this->manually_completed_steps ?? [];
        $manuallyCompleted = array_values(array_filter($manuallyCompleted, fn($t) => $t !== $type));
        $this->manually_completed_steps = $manuallyCompleted;
        $this->save();
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
            $isManuallyCompleted = $this->isManuallyCompleted($type);
            if ($hasDocument || $isManuallyCompleted) {
                $completed++;
            }
            $status[$type] = $hasDocument || $isManuallyCompleted;
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
