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
            'status' => 'required|in:pending,authorized,paid,canceled,delivered',
            'payment_method' => 'nullable|string|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque',
            'card_last_four' => 'nullable|string|size:4',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Manejar imagen de producto
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('purchase_products', $filename, 'public');
            $validated['product_image_path'] = $path;
        }

        // Validar card_last_four solo si payment_method es tarjeta
        if (in_array($validated['payment_method'] ?? null, ['tarjeta_credito', 'tarjeta_debito']) && empty($validated['card_last_four'])) {
            return redirect()->back()
                ->withErrors(['card_last_four' => 'Los últimos 4 dígitos de la tarjeta son requeridos cuando se selecciona pago con tarjeta.'])
                ->withInput();
        }

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
            'status' => 'required|in:pending,authorized,paid,canceled,delivered',
            'payment_method' => 'nullable|string|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque',
            'card_last_four' => 'nullable|string|size:4',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Manejar imagen de producto
        if ($request->hasFile('product_image')) {
            // Eliminar imagen anterior si existe
            if ($purchase->product_image_path && Storage::disk('public')->exists($purchase->product_image_path)) {
                Storage::disk('public')->delete($purchase->product_image_path);
            }
            $file = $request->file('product_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('purchase_products', $filename, 'public');
            $validated['product_image_path'] = $path;
        }

        // Validar card_last_four solo si payment_method es tarjeta
        if (in_array($validated['payment_method'] ?? null, ['tarjeta_credito', 'tarjeta_debito']) && empty($validated['card_last_four'])) {
            return redirect()->back()
                ->withErrors(['card_last_four' => 'Los últimos 4 dígitos de la tarjeta son requeridos cuando se selecciona pago con tarjeta.'])
                ->withInput();
        }

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

        // Eliminar imagen de producto si existe
        if ($purchase->product_image_path && Storage::disk('public')->exists($purchase->product_image_path)) {
            Storage::disk('public')->delete($purchase->product_image_path);
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
            'type' => 'required|in:budget_pdf,purchase_order,invoice,payment_order,payment_proof,tax_retention',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB máximo, permite PDF e imágenes
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

            // Si estaba marcado como completado manualmente, desmarcarlo
            if ($purchase->isManuallyCompleted($validated['type'])) {
                $purchase->unmarkAsManuallyCompleted($validated['type']);
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

    /**
     * Marcar/desmarcar un paso como completado manualmente
     */
    public function toggleManualCompletion(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'type' => 'required|in:budget_pdf,purchase_order,invoice,payment_order,payment_proof,tax_retention',
        ]);

        $type = $validated['type'];
        
        // Si ya tiene un documento físico, no se puede marcar como completado manualmente
        if ($purchase->getDocument($type)) {
            return redirect()->route('purchases.show', $purchase)
                ->with('error', 'Este paso ya tiene un documento subido. Elimine el documento primero si desea marcarlo como completado manualmente.');
        }

        // Toggle: si está marcado, desmarcarlo; si no, marcarlo
        if ($purchase->isManuallyCompleted($type)) {
            $purchase->unmarkAsManuallyCompleted($type);
            $message = 'Paso desmarcado como completado manualmente.';
        } else {
            $purchase->markAsManuallyCompleted($type);
            $message = 'Paso marcado como completado manualmente.';
        }

        return redirect()->route('purchases.show', $purchase)
            ->with('success', $message);
    }
}
