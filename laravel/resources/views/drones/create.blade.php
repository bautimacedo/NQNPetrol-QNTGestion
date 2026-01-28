@extends('layouts.app')

@section('page-title', 'Registrar Nuevo Dron')
@section('page-subtitle', 'Agregar un nuevo dron a la flota operativa')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('drones.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: DJI Phantom 4 Pro #1" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Modelo *</label>
                <input type="text" name="model" value="{{ old('model') }}" required placeholder="Ej: DJI Phantom 4 Pro" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                @error('model')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Serie *</label>
                <input type="text" name="serial_number" value="{{ old('serial_number') }}" required placeholder="Ej: P4P-123456789" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                @error('serial_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado Inicial *</label>
                <select name="status" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors text-gray-900">
                    <option value="ready" {{ old('status') === 'ready' ? 'selected' : '' }}>Listo</option>
                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                    <option value="flying" {{ old('status') === 'flying' ? 'selected' : '' }}>En Vuelo</option>
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('drones.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Registrar Dron</button>
            </div>
        </div>
    </form>
</div>
@endsection
