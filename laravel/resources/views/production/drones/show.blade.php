@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $productionDrone->name }}</h2>
            <p class="mt-2 text-gray-400">Información completa del dron</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('production.drones.edit', $productionDrone) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Editar</a>
            <a href="{{ route('production.drones.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Información del Dron</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Dock</p>
                        <p class="text-gray-100 font-medium">{{ $productionDrone->dock ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Site</p>
                        <p class="text-gray-100 font-medium">{{ $productionDrone->site ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Organización</p>
                        <p class="text-gray-100 font-medium">{{ $productionDrone->organization ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Ubicación</p>
                        @if($productionDrone->Latitud && $productionDrone->Longitud)
                            <p class="text-gray-100 font-medium">{{ number_format($productionDrone->Latitud, 6) }}, {{ number_format($productionDrone->Longitud, 6) }}</p>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Misiones</p>
                        <p class="text-2xl font-bold text-orange-400">{{ $productionDrone->missions->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Logs de Telemetría</p>
                        <p class="text-2xl font-bold text-blue-400">{{ $productionDrone->telemetryLogs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

