@extends('layouts.app')

@section('page-title', $pilot->full_name)
@section('page-subtitle', 'Ficha Técnica del Piloto')

@section('content')
<div class="space-y-6">
    <!-- Header con Alerta de Licencia -->
    @if($licenseExpiringSoon)
    <div class="p-4 rounded-lg bg-red-50 border border-red-200">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-semibold text-red-800">⚠ Licencia Próxima a Vencer</p>
                <p class="text-sm text-red-700">La licencia {{ $latestLicense->category }} vence el {{ $latestLicense->expiration_date->format('d/m/Y') }} ({{ $latestLicense->expiration_date->diffForHumans() }})</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Ficha Técnica del Piloto -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <!-- Header de la Ficha -->
        <div class="p-8 bg-gradient-to-r from-[#ecebbb] to-gray-50 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-2 text-gray-900">{{ $pilot->full_name }}</h1>
                    <p class="text-lg mb-4 text-gray-700">Ficha Técnica del Piloto</p>
                    
                    <!-- Información Básica -->
                    <div class="flex flex-wrap gap-6 mt-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide mb-1 text-gray-600">Telegram ID</p>
                            <p class="text-sm font-medium text-gray-900">{{ $pilot->user_telegram_id }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide mb-1 text-gray-600">Estado</p>
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ (int) $pilot->status === 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ (int) $pilot->status === 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Foto de Perfil -->
                <div class="ml-6 flex items-center">
                    @if($pilot->profile_photo_path)
                        <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0 border-4 border-[#6b7b39] shadow-lg">
                            <img src="{{ Storage::url($pilot->profile_photo_path) }}" 
                                 alt="{{ $pilot->full_name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-full flex items-center justify-center flex-shrink-0 bg-gray-200 border-4 border-[#6b7b39] shadow-lg">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Estadísticas Principales -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Estadísticas de Vuelo -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-6 pb-3 border-b border-gray-200 text-gray-900">Estadísticas de Vuelo</h3>
                        <div class="space-y-6">
                            <div class="text-center p-4 rounded-lg bg-gray-50 border border-gray-200">
                                <p class="text-sm uppercase tracking-wide mb-2 text-gray-600">Horas Totales</p>
                                <p class="text-4xl font-bold" style="color: #6b7b39;"><span class="text-2xl">{{ number_format($totalHours, 1) }}h</span></p>
                            </div>
                            <div class="text-center p-4 rounded-lg bg-gray-50 border border-gray-200">
                                <p class="text-sm uppercase tracking-wide mb-2 text-gray-600">Vuelos Completados</p>
                                <p class="text-4xl font-bold" style="color: #6b7b39;">{{ $totalFlights }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Licencia -->
                    @if($latestLicense)
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-6 pb-3 border-b border-gray-200 text-gray-900">Licencia Actual</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide mb-1 text-gray-600">Categoría</p>
                                <p class="text-base font-medium text-gray-900">{{ $latestLicense->category }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide mb-1 text-gray-600">Número</p>
                                <p class="text-base font-medium text-gray-900">{{ $latestLicense->license_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide mb-1 text-gray-600">Vencimiento</p>
                                <p class="text-base font-medium text-gray-900">{{ $latestLicense->expiration_date->format('d/m/Y') }}</p>
                                <p class="text-xs mt-1 text-gray-500">{{ $latestLicense->expiration_date->diffForHumans() }}</p>
                            </div>
                            <div>
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $latestLicense->isValid() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $latestLicense->isValid() ? '✓ Vigente' : '✗ Vencida' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Historial de Actividad -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-6 pb-3 border-b border-gray-200 text-gray-900">Historial de Actividad Reciente</h3>
                        @if($recentFlights->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentFlights as $flight)
                                    <div class="p-4 rounded-lg hover:bg-gray-50 transition-colors bg-gray-50 border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium mb-1 text-gray-900">
                                                    {{ $flight->timestamp ? $flight->timestamp->format('d/m/Y H:i') : 'Fecha no disponible' }}
                                                </p>
                                                @if($flight->droneRelation)
                                                    <p class="text-xs text-gray-600">Dron: {{ $flight->droneRelation->name ?? $flight->drone }}</p>
                                                @elseif($flight->drone)
                                                    <p class="text-xs text-gray-600">Dron: {{ $flight->drone }}</p>
                                                @endif
                                                @if($flight->flight_name)
                                                    <p class="text-xs text-gray-600">Misión: {{ $flight->flight_name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No hay actividad registrada para este piloto.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer de la Ficha -->
        <div class="px-8 py-4 border-t border-gray-200 flex items-center justify-between bg-gray-50">
            <a href="{{ route('pilots.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                ← Volver al Listado
            </a>
            <p class="text-xs text-gray-500">Quintana Energy Operations</p>
        </div>
    </div>
</div>
@endsection
