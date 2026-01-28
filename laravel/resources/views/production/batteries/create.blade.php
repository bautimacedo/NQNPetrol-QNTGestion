@extends('layouts.app')

@section('page-title', 'Registrar Nueva Batería')
@section('page-subtitle', 'Agregar una nueva batería al inventario')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('production.batteries.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Serial * (UNIQUE)</label>
                <input type="text" name="serial" value="{{ old('serial') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('serial')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">RPA Asignado</label>
                <select name="drone_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccione un RPA</option>
                    @foreach($drones as $drone)
                        <option value="{{ $drone->name }}" {{ old('drone_name') == $drone->name ? 'selected' : '' }}>
                            {{ $drone->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cantidad de Vuelos</label>
                    <input type="number" name="flight_count" value="{{ old('flight_count', 0) }}" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Último Uso</label>
                    <input type="date" name="last_used" value="{{ old('last_used') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('production.batteries.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Registrar</button>
            </div>
        </div>
    </form>
</div>
@endsection
