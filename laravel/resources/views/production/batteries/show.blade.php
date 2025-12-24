@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $battery->serial }}</h2>
            <p class="mt-2 text-gray-400">Información completa de la batería</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('production.batteries.edit', $battery) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Editar</a>
            <a href="{{ route('production.batteries.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Información de la Batería</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Serial</p>
                        <p class="text-gray-100 font-medium">{{ $battery->serial }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Dron Asignado</p>
                        <p class="text-gray-100 font-medium">{{ $battery->drone->name ?? 'Sin asignar' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Cantidad de Vuelos</p>
                        <p class="text-2xl font-bold {{ $battery->flight_count > 100 ? 'text-yellow-400' : 'text-gray-100' }}">
                            {{ $battery->flight_count }}
                        </p>
                        @if($battery->flight_count > 100)
                            <p class="text-xs text-yellow-400 mt-1">⚠️ Alto uso - Considerar reemplazo</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Último Uso</p>
                        <p class="text-gray-100 font-medium">
                            {{ $battery->last_used ? $battery->last_used->format('d/m/Y H:i') : 'Nunca' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Estado</h3>
                <div class="space-y-4">
                    @if($battery->flight_count > 100)
                        <div class="p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
                            <p class="text-sm font-medium text-yellow-400">⚠️ Batería con alto uso</p>
                            <p class="text-xs text-gray-400 mt-1">Más de 100 vuelos registrados</p>
                        </div>
                    @else
                        <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                            <p class="text-sm font-medium text-green-400">✓ Estado normal</p>
                            <p class="text-xs text-gray-400 mt-1">Uso dentro de parámetros</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

