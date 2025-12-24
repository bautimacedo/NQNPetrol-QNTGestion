@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Registrar Nuevo Dron (Producción)</h2>
        <p class="mt-2 text-gray-400">Agregar un nuevo dron a la base de datos de producción</p>
    </div>

    <form action="{{ route('production.drones.store') }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-2xl">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nombre * (UNIQUE)</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500">
                @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Dock</label>
                    <input type="text" name="dock" value="{{ old('dock') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Site</label>
                    <input type="text" name="site" value="{{ old('site') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Organización</label>
                <input type="text" name="organization" value="{{ old('organization') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Latitud</label>
                    <input type="number" step="0.00000001" name="Latitud" value="{{ old('Latitud') }}" placeholder="-39.01" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Longitud</label>
                    <input type="number" step="0.00000001" name="Longitud" value="{{ old('Longitud') }}" placeholder="-67.88" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('production.drones.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg">Registrar</button>
            </div>
        </div>
    </form>
</div>
@endsection

