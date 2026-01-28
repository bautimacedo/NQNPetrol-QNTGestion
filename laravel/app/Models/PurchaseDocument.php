<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDocument extends Model
{
    protected $fillable = [
        'purchase_id',
        'type',
        'file_path',
        'document_number',
    ];

    /**
     * Relación con compra
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Obtener el nombre legible del tipo de documento
     */
    public function getTypeLabel(): string
    {
        $labels = [
            'budget_request' => 'Solicitud de Presupuesto',
            'budget_pdf' => 'Presupuesto PDF',
            'purchase_order' => 'Orden de Compra',
            'invoice' => 'Factura',
            'payment_order' => 'Orden de Pago',
            'payment_proof' => 'Comprobante de Pago',
            'tax_retention' => 'Retención Impositiva',
        ];

        return $labels[$this->type] ?? $this->type;
    }
}
