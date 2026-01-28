@extends('layouts.app')

@section('page-title', 'Editar Dron')
@section('page-subtitle', 'Modificar información del dron')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('drones.update', $drone) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $drone->name) }}" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Modelo *</label>
                <input type="text" name="model" value="{{ old('model', $drone->model) }}" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                @error('model')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Serie *</label>
                <input type="text" name="serial_number" value="{{ old('serial_number', $drone->serial_number) }}" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                @error('serial_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado *</label>
                <select name="status" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                    <option value="ready" {{ $drone->status === 'ready' ? 'selected' : '' }}>Listo</option>
                    <option value="maintenance" {{ $drone->status === 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                    <option value="flying" {{ $drone->status === 'flying' ? 'selected' : '' }}>En Vuelo</option>
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-sm text-gray-600 mb-1">Horas Totales de Vuelo</p>
                <p class="text-2xl font-bold text-[#6b7b39]">{{ number_format($drone->flight_hours_total, 1) }}h</p>
                <p class="text-xs text-gray-500 mt-1">Este valor se actualiza automáticamente con cada vuelo registrado.</p>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('drones.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection
