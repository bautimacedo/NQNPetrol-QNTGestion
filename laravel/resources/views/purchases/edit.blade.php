@extends('layouts.app')

@section('page-title', 'Editar Compra #' . $purchase->id)
@section('page-subtitle', 'Modificar información de la compra')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
    <form action="{{ route('purchases.update', $purchase) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Proveedor *</label>
                <select name="provider_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccionar proveedor</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ old('provider_id', $purchase->provider_id) == $provider->id ? 'selected' : '' }}>
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
                <textarea name="description" required rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors resize-none">{{ old('description', $purchase->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Monto Total *</label>
                    <input type="number" name="total_amount" step="0.01" min="0" required value="{{ old('total_amount', $purchase->total_amount) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    @error('total_amount')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Moneda *</label>
                    <select name="currency" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        <option value="ARS" {{ old('currency', $purchase->currency) == 'ARS' ? 'selected' : '' }}>ARS</option>
                        <option value="USD" {{ old('currency', $purchase->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                    @error('currency')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado *</label>
                <select name="status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="pending" {{ old('status', $purchase->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="authorized" {{ old('status', $purchase->status) == 'authorized' ? 'selected' : '' }}>Autorizada</option>
                    <option value="paid" {{ old('status', $purchase->status) == 'paid' ? 'selected' : '' }}>Pagada</option>
                    <option value="delivered" {{ old('status', $purchase->status) == 'delivered' ? 'selected' : '' }}>Entregada</option>
                    <option value="canceled" {{ old('status', $purchase->status) == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Método de Pago</label>
                <select name="payment_method" id="payment_method" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccionar método</option>
                    <option value="efectivo" {{ old('payment_method', $purchase->payment_method) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="transferencia" {{ old('payment_method', $purchase->payment_method) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    <option value="tarjeta_credito" {{ old('payment_method', $purchase->payment_method) == 'tarjeta_credito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                    <option value="tarjeta_debito" {{ old('payment_method', $purchase->payment_method) == 'tarjeta_debito' ? 'selected' : '' }}>Tarjeta de Débito</option>
                    <option value="cheque" {{ old('payment_method', $purchase->payment_method) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                </select>
                @error('payment_method')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="card_last_four_field" style="display: {{ in_array(old('payment_method', $purchase->payment_method), ['tarjeta_credito', 'tarjeta_debito']) ? 'block' : 'none' }};">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Últimos 4 dígitos de la tarjeta *</label>
                <input type="text" name="card_last_four" id="card_last_four" maxlength="4" pattern="[0-9]{4}" value="{{ old('card_last_four', $purchase->card_last_four) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="1234">
                @error('card_last_four')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Imagen del Producto (Opcional)</label>
                @if($purchase->product_image_path)
                    <div class="mb-2">
                        <img src="{{ Storage::url($purchase->product_image_path) }}" alt="Imagen del producto" class="h-32 w-auto rounded-lg border border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Imagen actual</p>
                    </div>
                @endif
                <input type="file" name="product_image" accept="image/jpeg,image/jpg,image/png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 10MB</p>
                @error('product_image')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
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

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('purchases.show', $purchase) }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                Actualizar Compra
            </button>
        </div>
    </form>
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
