@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Dashboard Operativo</h2>
            <p class="mt-2 text-gray-400">Vista general de la flota y operaciones en tiempo real</p>
        </div>
        <div class="hidden md:block text-right">
            <p class="text-sm text-gray-400">Ubicación: <span class="text-gray-200">Neuquén, AR</span></p>
            <p class="text-xs text-gray-500">Coord: -39.01, -67.88</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-blue-500/50 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Flota Total</p>
                    <p class="mt-2 text-3xl font-bold text-gray-100">{{ $totalDrones }}</p>
                </div>
                <div class="p-3 bg-blue-500/10 rounded-lg">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-green-500/50 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Drones con Estado</p>
                    <p class="mt-2 text-3xl font-bold text-green-400">{{ $dronesWithStatus }}</p>
                </div>
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-yellow-500/50 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Baterías >100 Vuelos</p>
                    <p class="mt-2 text-3xl font-bold text-yellow-400">{{ $batteriesHighFlightCount->count() }}</p>
                </div>
                <div class="p-3 bg-yellow-500/10 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-orange-500/50 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Pilotos Activos</p>
                    <p class="mt-2 text-3xl font-bold text-orange-400">{{ $totalPilots }}</p>
                </div>
                <div class="p-3 bg-orange-500/10 rounded-lg">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-green-500/50 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Pozos Activos</p>
                    <p class="mt-2 text-3xl font-bold text-green-400">{{ $activeWells ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if($batteriesHighFlightCount->count() > 0)
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-100 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Resumen de Energía: Baterías con Alto Uso (>100 vuelos)
            </h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($batteriesHighFlightCount as $battery)
                <div class="bg-gray-700/30 rounded-lg border border-yellow-500/30 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold text-gray-100">{{ $battery->serial }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $battery->drone->name ?? 'Sin asignar' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-yellow-400">{{ $battery->flight_count }}</p>
                            <p class="text-xs text-gray-500">vuelos</p>
                        </div>
                    </div>
                    @if($battery->last_used)
                        <p class="text-xs text-gray-500 mt-2">Último uso: {{ $battery->last_used->format('d/m/Y') }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 bg-gray-800 rounded-lg border border-gray-700 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-100 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Licencias por Vencer (30 días)
                </h3>
                <span class="px-3 py-1 text-xs font-bold bg-red-500/20 text-red-400 rounded-full border border-red-500/30">
                    {{ $expiringLicenses->count() }} Alertas
                </span>
            </div>
            
            @if($expiringLicenses->count() > 0)
                <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($expiringLicenses as $license)
                        <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-lg border border-gray-600 hover:bg-gray-700/50 transition-all">
                            <div>
                                <p class="font-bold text-gray-100">{{ $license->pilot->name }}</p>
                                <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ $license->type }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-200">
                                    {{ $license->expiration_date->format('d/m/Y') }}
                                </p>
                                <p class="text-xs font-medium text-yellow-500 mt-1">
                                    {{ $license->expiration_date->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg class="w-12 h-12 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-400">Todo en regla. No hay licencias críticas.</p>
                </div>
            @endif
        </div>

        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-100">Condiciones Climáticas</h3>
                @if(isset($weather['last_update']))
                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Update: {{ $weather['last_update'] }}</span>
                @endif
            </div>
            
            <div class="space-y-5">
                <div class="flex items-center justify-between p-3 bg-gray-900/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-orange-500/10 rounded mr-3 text-orange-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="text-sm text-gray-400">Temperatura</span>
                    </div>
                    <span class="text-xl font-bold text-gray-100">{{ number_format($weather['temperature'] ?? 0, 1) }}°C</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-900/50 rounded-lg border-l-4 {{ ($weather['wind_speed'] ?? 0) >= 35 ? 'border-red-500' : 'border-green-500' }}">
                    <div class="flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-500/10 rounded mr-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <span class="text-sm text-gray-400">Viento Sostenido</span>
                    </div>
                    <span class="text-xl font-bold {{ ($weather['wind_speed'] ?? 0) >= 35 ? 'text-red-400' : 'text-green-400' }}">
                        {{ number_format($weather['wind_speed'] ?? 0, 0) }} <span class="text-xs">km/h</span>
                    </span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-900/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-500/10 rounded mr-3 text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-sm text-gray-400">Ráfagas</span>
                    </div>
                    <span class="text-xl font-bold {{ ($weather['wind_gusts'] ?? 0) >= 45 ? 'text-red-400' : 'text-purple-400' }}">
                        {{ number_format($weather['wind_gusts'] ?? 0, 0) }} <span class="text-xs">km/h</span>
                    </span>
                </div>
                
                <div class="pt-4 border-t border-gray-700">
                    <p class="text-xs text-gray-500 mb-1 uppercase tracking-tighter">Cielo y Visibilidad</p>
                    <div class="flex items-center">
                        <p class="text-base font-medium text-gray-100 capitalize">{{ $weather['description'] ?? 'Sin datos' }}</p>
                    </div>
                    @if(isset($weather['city_name']) && $weather['city_name'] !== 'N/A')
                        <p class="text-xs text-gray-500 mt-1">{{ $weather['city_name'] }}</p>
                    @endif
                </div>
                
                @if(isset($weather['last_update']) && $weather['last_update'] === 'N/A')
                    <div class="pt-2 px-2 py-1 bg-yellow-500/10 border border-yellow-500/20 rounded">
                        <p class="text-[10px] text-yellow-500 font-bold uppercase text-center">Datos no disponibles</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-100">Pilotos en Activo</h3>
                <p class="text-4xl font-black text-gray-100 mt-2">{{ $totalPilots }}</p>
            </div>
            <div class="text-gray-600">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-100 mb-4 tracking-tight">Estado Operativo del Sistema</h3>
            @php
                $isSafeToFly = ($weather['wind_speed'] ?? 0) < 35;
            @endphp
            <div class="flex items-center p-4 {{ $isSafeToFly ? 'bg-green-500/5' : 'bg-red-500/5' }} rounded-xl border {{ $isSafeToFly ? 'border-green-500/20' : 'border-red-500/20' }}">
                <div class="w-4 h-4 {{ $isSafeToFly ? 'bg-green-400' : 'bg-red-400' }} rounded-full animate-pulse mr-3"></div>
                <div>
                    <span class="text-lg font-bold {{ $isSafeToFly ? 'text-green-400' : 'text-red-400' }}">
                        {{ $isSafeToFly ? 'OPERACIONES HABILITADAS' : 'OPERACIONES SUSPENDIDAS' }}
                    </span>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $isSafeToFly ? 'Condiciones dentro de los parámetros de seguridad.' : 'Vientos excesivos detectados en la zona de Neuquén.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #1f2937;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 10px;
    }
</style>
@endsection