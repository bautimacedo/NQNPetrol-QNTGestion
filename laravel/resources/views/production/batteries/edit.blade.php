@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Editar Batería</h2>
        <p class="mt-2 text-gray-400">Modificar información de la batería</p>
    </div>

    <form action="{{ route('production.batteries.update', $battery) }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Serial *</label>
                <input type="text" name="serial" value="{{ old('serial', $battery->serial) }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                @error('serial')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">RPA Asignado</label>
                <select name="drone_name" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="">Seleccione un RPA</option>
                    @foreach($drones as $drone)
                        <option value="{{ $drone->name }}" {{ $battery->drone_name == $drone->name ? 'selected' : '' }}>
                            {{ $drone->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Cantidad de Vuelos</label>
                    <input type="number" name="flight_count" value="{{ old('flight_count', $battery->flight_count) }}" min="0" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Último Uso</label>
                    <input type="date" name="last_used" value="{{ old('last_used', $battery->last_used ? $battery->last_used->format('Y-m-d') : '') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('production.batteries.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 text-white rounded-lg qnt-gradient">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection

