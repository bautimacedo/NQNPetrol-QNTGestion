<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Provider;
use App\Models\PurchaseDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with(['provider', 'documents'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('purchases.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'description' => 'required|string|max:500',
            'total_amount' => 'required|numeric|min:0',
            'currency' => 'required|in:ARS,USD',
            'status' => 'required|in:pending,authorized,paid,canceled',
        ]);

        $purchase = Purchase::create($validated);

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Compra creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['provider', 'documents']);
        
        $documentTypes = [
            'budget_request' => 'Solicitud de Presupuesto',
            'budget_pdf' => 'Presupuesto PDF',
            'purchase_order' => 'Orden de Compra',
            'invoice' => 'Factura',
            'payment_order' => 'Orden de Pago',
            'payment_proof' => 'Comprobante de Pago',
            'tax_retention' => 'Retención Impositiva',
        ];

        $progress = $purchase->getDocumentationProgress();

        return view('purchases.show', compact('purchase', 'documentTypes', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $providers = Provider::orderBy('name')->get();
        return view('purchases.edit', compact('purchase', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'description' => 'required|string|max:500',
            'total_amount' => 'required|numeric|min:0',
            'currency' => 'required|in:ARS,USD',
            'status' => 'required|in:pending,authorized,paid,canceled',
        ]);

        $purchase->update($validated);

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Compra actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // Eliminar todos los documentos asociados
        foreach ($purchase->documents as $document) {
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();
        }

        $purchase->delete();

        return redirect()->route('purchases.index')
            ->with('success', 'Compra eliminada exitosamente.');
    }

    /**
     * Subir un documento para una compra
     */
    public function uploadDocument(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'type' => 'required|in:budget_request,budget_pdf,purchase_order,invoice,payment_order,payment_proof,tax_retention',
            'document' => 'required|file|mimes:pdf|max:10240', // 10MB máximo
            'document_number' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Eliminar documento anterior del mismo tipo si existe
            $existingDocument = $purchase->getDocument($validated['type']);
            if ($existingDocument) {
                if (Storage::disk('public')->exists($existingDocument->file_path)) {
                    Storage::disk('public')->delete($existingDocument->file_path);
                }
                $existingDocument->delete();
            }

            // Guardar el archivo
            $file = $request->file('document');
            $directory = "purchases/{$purchase->id}";
            $filename = $validated['type'] . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($directory, $filename, 'public');

            // Crear el registro del documento
            PurchaseDocument::create([
                'purchase_id' => $purchase->id,
                'type' => $validated['type'],
                'file_path' => $filePath,
                'document_number' => $validated['document_number'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Documento subido exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchases.show', $purchase)
                ->with('error', 'Error al subir el documento: ' . $e->getMessage());
        }
    }

    /**
     * Descargar/ver un documento
     */
    public function downloadDocument(Purchase $purchase, PurchaseDocument $purchaseDocument)
    {
        // Verificar que el documento pertenece a la compra
        if ($purchaseDocument->purchase_id !== $purchase->id) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($purchaseDocument->file_path)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::disk('public')->download($purchaseDocument->file_path);
    }

    /**
     * Eliminar un documento
     */
    public function deleteDocument(Purchase $purchase, PurchaseDocument $purchaseDocument)
    {
        // Verificar que el documento pertenece a la compra
        if ($purchaseDocument->purchase_id !== $purchase->id) {
            abort(404);
        }

        if (Storage::disk('public')->exists($purchaseDocument->file_path)) {
            Storage::disk('public')->delete($purchaseDocument->file_path);
        }

        $purchaseDocument->delete();

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Documento eliminado exitosamente.');
    }
}
