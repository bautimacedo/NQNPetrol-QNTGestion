@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Editar Dron</h2>
        <p class="mt-2 text-gray-400">Modificar información del dron</p>
    </div>

    <form action="{{ route('drones.update', $drone) }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $drone->name) }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Modelo *</label>
                <input type="text" name="model" value="{{ old('model', $drone->model) }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                @error('model')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Número de Serie *</label>
                <input type="text" name="serial_number" value="{{ old('serial_number', $drone->serial_number) }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                @error('serial_number')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Estado *</label>
                <select name="status" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="ready" {{ $drone->status === 'ready' ? 'selected' : '' }}>Listo</option>
                    <option value="maintenance" {{ $drone->status === 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                    <option value="flying" {{ $drone->status === 'flying' ? 'selected' : '' }}>En Vuelo</option>
                </select>
                @error('status')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="bg-gray-900/50 rounded-lg p-4">
                <p class="text-sm text-gray-400 mb-1">Horas Totales de Vuelo</p>
                <p class="text-2xl font-bold text-orange-400">{{ number_format($drone->flight_hours_total, 1) }}h</p>
                <p class="text-xs text-gray-500 mt-1">Este valor se actualiza automáticamente con cada vuelo registrado.</p>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('drones.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection

