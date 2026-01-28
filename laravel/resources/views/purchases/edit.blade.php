@extends('layouts.app')

@section('page-title', 'Editar Compra #' . $purchase->id)
@section('page-subtitle', 'Modificar información de la compra')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
    <form action="{{ route('purchases.update', $purchase) }}" method="POST">
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
                    <option value="canceled" {{ old('status', $purchase->status) == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

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
@endsection
