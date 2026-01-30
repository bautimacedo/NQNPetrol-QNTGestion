@extends('layouts.app')

@section('page-title', 'Editar Seguro')
@section('page-subtitle', 'Modificar información del seguro')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
    <form action="{{ route('insurances.update', $insurance) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre de la Aseguradora *</label>
                <input type="text" name="insurer_name" required value="{{ old('insurer_name', $insurance->insurer_name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('insurer_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Póliza *</label>
                <input type="text" name="policy_number" required value="{{ old('policy_number', $insurance->policy_number) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('policy_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Vigencia *</label>
                <input type="date" name="validity_date" required value="{{ old('validity_date', $insurance->validity_date->format('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('validity_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Proveedor</label>
                <select name="provider_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccionar proveedor</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ old('provider_id', $insurance->provider_id) == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
                @error('provider_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Notas</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors resize-none">{{ old('notes', $insurance->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('insurances.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                Actualizar Seguro
            </button>
        </div>
    </form>
</div>
@endsection

