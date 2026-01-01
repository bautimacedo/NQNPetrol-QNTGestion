@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $productionDrone->name }}</h2>
            <p class="mt-2 text-gray-400">Información completa del RPA</p>
        </div>
        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('production.drones.edit', $productionDrone) }}" class="px-4 py-2 text-white rounded-lg qnt-gradient">Editar</a>
            @endhasrole
            <a href="{{ route('production.drones.index') }}" class="px-4 py-2 text-white rounded-lg" style="background-color: rgba(255, 255, 255, 0.1);" onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.15)'" onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.1)'">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-lg border p-6" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #FFFFFF;">Información del RPA</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Marca</p>
                        <p class="text-gray-100 font-medium">{{ $productionDrone->brand ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Modelo</p>
                        <p class="text-gray-100 font-medium">{{ $productionDrone->model ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Matrícula</p>
                        <p class="text-gray-100 font-medium">{{ $productionDrone->registration ?? '-' }}</p>
                    </div>
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
            <div class="rounded-lg border p-6" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #FFFFFF;">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Misiones</p>
                        <p class="text-2xl font-bold" style="color: #1B998B;">{{ $productionDrone->missions->count() }}</p>
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

