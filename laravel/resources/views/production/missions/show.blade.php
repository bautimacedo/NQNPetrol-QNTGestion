@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $productionMission->name }}</h2>
            <p class="mt-2 text-gray-400">Detalle completo de la misión</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('production.missions.edit', $productionMission->id) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Editar</a>
            <a href="{{ route('production.missions.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Información General -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Información de la Misión</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Dron</p>
                        <p class="text-gray-100 font-medium">{{ $productionMission->drone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Duración</p>
                        <p class="text-gray-100 font-medium">{{ $productionMission->duration ? $productionMission->duration . ' minutos' : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">URL</p>
                        @if($productionMission->url)
                            <a href="{{ $productionMission->url }}" target="_blank" class="text-blue-400 hover:text-blue-300">{{ $productionMission->url }}</a>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Link RTCP</p>
                        <p class="text-gray-100 font-medium">{{ $productionMission->link_rtcp ?? '-' }}</p>
                    </div>
                    @if($productionMission->descrpition)
                    <div class="col-span-2">
                        <p class="text-sm text-gray-400">Descripción</p>
                        <p class="text-gray-100">{{ $productionMission->descrpition }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payload JSON -->
            @if($productionMission->payload)
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Payload JSON</h3>
                <pre class="bg-gray-900 rounded-lg p-4 text-sm text-gray-300 overflow-x-auto">{{ json_encode($productionMission->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <!-- Estadísticas -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Logs de Telemetría</p>
                        <p class="text-2xl font-bold text-orange-400">{{ $productionMission->telemetryLogs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

