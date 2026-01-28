@extends('layouts.app')

@section('page-title', $productionMission->name)
@section('page-subtitle', 'Detalle completo de la misión')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('production.missions.edit', $productionMission->id) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            @endhasrole
            <a href="{{ route('production.missions.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Información General -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Misión</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">RPA</p>
                        <p class="text-gray-900 font-medium">{{ $productionMission->drone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Duración</p>
                        <p class="text-gray-900 font-medium">{{ $productionMission->duration ? $productionMission->duration . ' minutos' : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">URL</p>
                        @if($productionMission->url)
                            <a href="{{ $productionMission->url }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ $productionMission->url }}</a>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Link RTCP</p>
                        <p class="text-gray-900 font-medium">{{ $productionMission->link_rtcp ?? '-' }}</p>
                    </div>
                    @if($productionMission->descrpition)
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">Descripción</p>
                        <p class="text-gray-900">{{ $productionMission->descrpition }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payload JSON -->
            @if($productionMission->payload)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payload JSON</h3>
                <pre class="bg-gray-50 rounded-lg p-4 text-sm text-gray-900 overflow-x-auto border border-gray-200">{{ json_encode($productionMission->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Logs de Telemetría</p>
                        <p class="text-2xl font-bold" style="color: #6b7b39;">{{ $productionMission->telemetryLogs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
