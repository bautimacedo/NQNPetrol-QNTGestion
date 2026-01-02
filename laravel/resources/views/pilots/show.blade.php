@extends('layouts.app')

@section('content')
<div class="space-y-6" style="background-color: #0F172A;">
    <!-- Header con Alerta de Licencia -->
    @if($licenseExpiringSoon)
    <div class="p-4 rounded-lg" style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" style="color: #f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-semibold" style="color: #f87171;">⚠ Licencia Próxima a Vencer</p>
                <p class="text-sm" style="color: rgba(255, 255, 255, 0.7);">La licencia {{ $latestLicense->category }} vence el {{ $latestLicense->expiration_date->format('d/m/Y') }} ({{ $latestLicense->expiration_date->diffForHumans() }})</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Ficha Técnica del Piloto -->
    <div class="rounded-lg overflow-hidden" style="background-color: rgba(31, 41, 55, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);">
        <!-- Header de la Ficha -->
        <div class="p-8" style="background: linear-gradient(135deg, rgba(8, 32, 50, 0.8) 0%, rgba(27, 153, 139, 0.3) 100%); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-2" style="color: #FFFFFF;">{{ $pilot->full_name }}</h1>
                    <p class="text-lg mb-4" style="color: rgba(255, 255, 255, 0.7);">Ficha Técnica del Piloto</p>
                    
                    <!-- Información Básica -->
                    <div class="flex flex-wrap gap-6 mt-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide mb-1" style="color: rgba(255, 255, 255, 0.5);">Telegram ID</p>
                            <p class="text-sm font-medium" style="color: #FFFFFF;">{{ $pilot->user_telegram_id }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide mb-1" style="color: rgba(255, 255, 255, 0.5);">Estado</p>
                            <span class="px-3 py-1 text-xs font-medium rounded {{ (int) $pilot->status === 1 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ (int) $pilot->status === 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Foto de Perfil -->
                <div class="ml-6 flex items-center">
                    @if($pilot->profile_photo)
                        <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0" style="border: 3px solid #1B998B; box-shadow: 0 0 20px rgba(27, 153, 139, 0.3);">
                            <img src="{{ Storage::url($pilot->profile_photo) }}" 
                                 alt="{{ $pilot->full_name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: rgba(31, 41, 55, 0.8); border: 3px solid #1B998B; box-shadow: 0 0 20px rgba(27, 153, 139, 0.3);">
                            <svg class="w-12 h-12" style="color: rgba(255, 255, 255, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="rounded-lg p-6" style="background-color: rgba(31, 41, 55, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h3 class="text-lg font-semibold mb-6 pb-3 border-b" style="color: #FFFFFF; border-color: rgba(255, 255, 255, 0.1);">Estadísticas de Vuelo</h3>
                        <div class="space-y-6">
                            <div class="text-center p-4 rounded-lg" style="background: linear-gradient(135deg, rgba(8, 32, 50, 0.5) 0%, rgba(27, 153, 139, 0.2) 100%);">
                                <p class="text-sm uppercase tracking-wide mb-2" style="color: rgba(255, 255, 255, 0.6);">Horas Totales</p>
                                <p class="text-4xl font-bold" style="color: #1B998B;">{{ number_format($totalHours, 1) }}<span class="text-2xl">h</span></p>
                            </div>
                            <div class="text-center p-4 rounded-lg" style="background: linear-gradient(135deg, rgba(8, 32, 50, 0.5) 0%, rgba(27, 153, 139, 0.2) 100%);">
                                <p class="text-sm uppercase tracking-wide mb-2" style="color: rgba(255, 255, 255, 0.6);">Vuelos Completados</p>
                                <p class="text-4xl font-bold" style="color: #1B998B;">{{ $totalFlights }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Licencia -->
                    @if($latestLicense)
                    <div class="rounded-lg p-6" style="background-color: rgba(31, 41, 55, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h3 class="text-lg font-semibold mb-6 pb-3 border-b" style="color: #FFFFFF; border-color: rgba(255, 255, 255, 0.1);">Licencia Actual</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide mb-1" style="color: rgba(255, 255, 255, 0.5);">Categoría</p>
                                <p class="text-base font-medium" style="color: #FFFFFF;">{{ $latestLicense->category }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide mb-1" style="color: rgba(255, 255, 255, 0.5);">Número</p>
                                <p class="text-base font-medium" style="color: #FFFFFF;">{{ $latestLicense->license_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide mb-1" style="color: rgba(255, 255, 255, 0.5);">Vencimiento</p>
                                <p class="text-base font-medium" style="color: #FFFFFF;">{{ $latestLicense->expiration_date->format('d/m/Y') }}</p>
                                <p class="text-xs mt-1" style="color: rgba(255, 255, 255, 0.5);">{{ $latestLicense->expiration_date->diffForHumans() }}</p>
                            </div>
                            <div>
                                <span class="px-3 py-1 text-xs font-medium rounded {{ $latestLicense->isValid() ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $latestLicense->isValid() ? '✓ Vigente' : '✗ Vencida' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Historial de Actividad -->
                <div class="lg:col-span-2">
                    <div class="rounded-lg p-6" style="background-color: rgba(31, 41, 55, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h3 class="text-lg font-semibold mb-6 pb-3 border-b" style="color: #FFFFFF; border-color: rgba(255, 255, 255, 0.1);">Historial de Actividad Reciente</h3>
                        @if($recentFlights->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentFlights as $flight)
                                    <div class="p-4 rounded-lg hover:bg-gray-700/30 transition-colors" style="background-color: rgba(31, 41, 55, 0.3); border: 1px solid rgba(255, 255, 255, 0.05);">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium mb-1" style="color: #FFFFFF;">
                                                    {{ $flight->timestamp ? $flight->timestamp->format('d/m/Y H:i') : 'Fecha no disponible' }}
                                                </p>
                                                @if($flight->droneRelation)
                                                    <p class="text-xs" style="color: rgba(255, 255, 255, 0.6);">Dron: {{ $flight->droneRelation->name ?? $flight->drone }}</p>
                                                @elseif($flight->drone)
                                                    <p class="text-xs" style="color: rgba(255, 255, 255, 0.6);">Dron: {{ $flight->drone }}</p>
                                                @endif
                                                @if($flight->flight_name)
                                                    <p class="text-xs" style="color: rgba(255, 255, 255, 0.6);">Misión: {{ $flight->flight_name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 mb-4" style="color: rgba(255, 255, 255, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm" style="color: rgba(255, 255, 255, 0.5);">No hay actividad registrada para este piloto.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer de la Ficha -->
        <div class="px-8 py-4 border-t flex items-center justify-between" style="border-color: rgba(255, 255, 255, 0.1); background-color: rgba(15, 23, 42, 0.5);">
            <a href="{{ route('pilots.index') }}" class="px-4 py-2 rounded-lg transition-colors" style="background-color: rgba(55, 65, 81, 0.8); color: #FFFFFF;" onmouseover="this.style.backgroundColor='rgba(75, 85, 99, 0.9)'" onmouseout="this.style.backgroundColor='rgba(55, 65, 81, 0.8)'">
                ← Volver al Listado
            </a>
            <p class="text-xs" style="color: rgba(255, 255, 255, 0.4);">Quintana Energy Operations</p>
        </div>
    </div>
</div>
@endsection
