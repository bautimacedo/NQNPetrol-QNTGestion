@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Registrar Nuevo Dron</h2>
        <p class="mt-2 text-gray-400">Agregar un nuevo dron a la flota operativa</p>
    </div>

    <form action="{{ route('drones.store') }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-2xl">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: DJI Phantom 4 Pro #1" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Modelo *</label>
                <input type="text" name="model" value="{{ old('model') }}" required placeholder="Ej: DJI Phantom 4 Pro" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                @error('model')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Número de Serie *</label>
                <input type="text" name="serial_number" value="{{ old('serial_number') }}" required placeholder="Ej: P4P-123456789" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                @error('serial_number')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Estado Inicial *</label>
                <select name="status" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="ready" {{ old('status') === 'ready' ? 'selected' : '' }}>Listo</option>
                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                    <option value="flying" {{ old('status') === 'flying' ? 'selected' : '' }}>En Vuelo</option>
                </select>
                @error('status')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('drones.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg">Registrar Dron</button>
            </div>
        </div>
    </form>
</div>
@endsection

