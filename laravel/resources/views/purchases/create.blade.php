@extends('layouts.app')

@section('page-title', 'Nueva Compra')
@section('page-subtitle', 'Crear una nueva compra en el sistema')

@section('content')
<div class="space-y-6">
    <!-- Timeline Horizontal Superior -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Progreso de Documentación</h3>
        
        <!-- Timeline Visual Horizontal -->
        <div class="relative">
            <!-- Línea del timeline -->
            <div class="absolute top-8 left-0 right-0 h-1 bg-gray-200"></div>
            
            @php
                $timelineSteps = [
                    ['label' => 'Presupuesto', 'order' => 1],
                    ['label' => 'OC', 'order' => 2],
                    ['label' => 'Factura', 'order' => 3],
                    ['label' => 'OP', 'order' => 4],
                    ['label' => 'Pago', 'order' => 5],
                ];
            @endphp
            
            <div class="flex items-center justify-between relative">
                @foreach($timelineSteps as $step)
                    <div class="flex flex-col items-center relative z-10 flex-1">
                        <!-- Círculo del paso -->
                        <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 bg-white border-gray-300">
                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                        </div>
                        <!-- Etiqueta -->
                        <p class="mt-3 text-xs font-medium text-center text-gray-500">
                            {{ $step['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <p class="text-sm text-gray-600 mt-4 text-center">Los documentos son opcionales y se podrán subir después de crear la compra</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Datos de la Compra</h3>
        <form action="{{ route('purchases.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Proveedor *</label>
                <select name="provider_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccionar proveedor</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
                @error('provider_id')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción *</label>
                <textarea name="description" required rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors resize-none" placeholder="Ej: Compra DJI Dock 2">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Monto Total *</label>
                    <input type="number" name="total_amount" step="0.01" min="0" required value="{{ old('total_amount') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="0.00">
                    @error('total_amount')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Moneda *</label>
                    <select name="currency" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        <option value="ARS" {{ old('currency') == 'ARS' ? 'selected' : '' }}>ARS</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                    @error('currency')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado *</label>
                <select name="status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="authorized" {{ old('status') == 'authorized' ? 'selected' : '' }}>Autorizada</option>
                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Pagada</option>
                    <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Entregada</option>
                    <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Método de Pago</label>
                <select name="payment_method" id="payment_method" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccionar método</option>
                    <option value="transferencia" {{ old('payment_method') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    <option value="efectivo" {{ old('payment_method') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta_credito" {{ old('payment_method') == 'tarjeta_credito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                    <option value="tarjeta_debito" {{ old('payment_method') == 'tarjeta_debito' ? 'selected' : '' }}>Tarjeta de Débito</option>
                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                    <option value="otro" {{ old('payment_method') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('payment_method')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="card_last_four_field" style="display: none;">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Últimos 4 dígitos de la tarjeta *</label>
                <input type="text" name="card_last_four" id="card_last_four" maxlength="4" pattern="[0-9]{4}" value="{{ old('card_last_four') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="1234">
                @error('card_last_four')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Imagen del Producto (Opcional)</label>
                <input type="file" name="product_image" accept="image/jpg,image/jpeg,image/png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 10MB</p>
                @error('product_image')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('purchases.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                Crear Compra
            </button>
        </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        const cardField = document.getElementById('card_last_four_field');
        const cardInput = document.getElementById('card_last_four');
        if (this.value === 'tarjeta_credito' || this.value === 'tarjeta_debito') {
            cardField.style.display = 'block';
            cardInput.required = true;
        } else {
            cardField.style.display = 'none';
            cardInput.required = false;
            cardInput.value = '';
        }
    });
</script>
@endsection
