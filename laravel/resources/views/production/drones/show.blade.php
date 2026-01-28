@extends('layouts.app')

@section('page-title', $productionDrone->name)
@section('page-subtitle', 'Información completa del RPA')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('production.drones.edit', $productionDrone) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            @endhasrole
            <a href="{{ route('production.drones.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del RPA</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Marca</p>
                        <p class="text-gray-900 font-medium">{{ $productionDrone->brand ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Modelo</p>
                        <p class="text-gray-900 font-medium">{{ $productionDrone->model ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Matrícula</p>
                        <p class="text-gray-900 font-medium">{{ $productionDrone->registration ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dock</p>
                        <p class="text-gray-900 font-medium">{{ $productionDrone->dock ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Site</p>
                        <p class="text-gray-900 font-medium">{{ $productionDrone->site ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Organización</p>
                        <p class="text-gray-900 font-medium">{{ $productionDrone->organization ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Ubicación</p>
                        @if($productionDrone->Latitud && $productionDrone->Longitud)
                            <p class="text-gray-900 font-medium">{{ number_format($productionDrone->Latitud, 6) }}, {{ number_format($productionDrone->Longitud, 6) }}</p>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Misiones</p>
                        <p class="text-2xl font-bold" style="color: #6b7b39;">{{ $productionDrone->missions->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Logs de Telemetría</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $productionDrone->telemetryLogs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
