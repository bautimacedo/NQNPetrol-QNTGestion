@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Editar Compra #{{ $purchase->id }}</h2>
        <p class="mt-2 text-gray-400">Modificar información de la compra</p>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <form action="{{ route('purchases.update', $purchase) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Proveedor *</label>
                    <select name="provider_id" required class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Seleccionar proveedor</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}" {{ old('provider_id', $purchase->provider_id) == $provider->id ? 'selected' : '' }}>
                                {{ $provider->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('provider_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Descripción *</label>
                    <textarea name="description" required rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('description', $purchase->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Monto Total *</label>
                        <input type="number" name="total_amount" step="0.01" min="0" required value="{{ old('total_amount', $purchase->total_amount) }}" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        @error('total_amount')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Moneda *</label>
                        <select name="currency" required class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="ARS" {{ old('currency', $purchase->currency) == 'ARS' ? 'selected' : '' }}>ARS</option>
                            <option value="USD" {{ old('currency', $purchase->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                        @error('currency')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Estado *</label>
                    <select name="status" required class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="pending" {{ old('status', $purchase->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="authorized" {{ old('status', $purchase->status) == 'authorized' ? 'selected' : '' }}>Autorizada</option>
                        <option value="paid" {{ old('status', $purchase->status) == 'paid' ? 'selected' : '' }}>Pagada</option>
                        <option value="canceled" {{ old('status', $purchase->status) == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('status')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('purchases.show', $purchase) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:text-white" style="border: 1px solid rgba(255, 255, 255, 0.2);">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                    Actualizar Compra
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

