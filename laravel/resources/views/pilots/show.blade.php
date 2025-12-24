@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header con Alerta de Licencia -->
    @if($licenseExpiringSoon)
    <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-semibold text-red-400">⚠ Licencia Próxima a Vencer</p>
                <p class="text-sm text-gray-300">La licencia {{ $latestLicense->type }} vence el {{ $latestLicense->expiration_date->format('d/m/Y') }} ({{ $latestLicense->expiration_date->diffForHumans() }})</p>
            </div>
        </div>
    </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $pilot->full_name }}</h2>
            <p class="mt-2 text-gray-400">Perfil completo del piloto</p>
        </div>
        <a href="{{ route('pilots.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Volver</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Estadísticas -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Horas de Vuelo Totales</p>
                        <p class="text-3xl font-bold text-orange-400">{{ number_format($totalHours, 1) }}h</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Vuelos Completados</p>
                        <p class="text-2xl font-semibold text-gray-100">{{ $totalFlights }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Estado</p>
                        <span class="px-3 py-1 text-sm font-medium rounded {{ (int) $pilot->status === 1 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ (int) $pilot->status === 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Información de Licencia -->
            @if($latestLicense)
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Licencia Actual</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-400">Tipo</p>
                        <p class="text-gray-100 font-medium">{{ $latestLicense->category }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Vencimiento</p>
                        <p class="text-gray-100 font-medium">{{ $latestLicense->expiration_date->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $latestLicense->expiration_date->diffForHumans() }}</p>
                    </div>
                    <div>
                        <span class="px-2 py-1 text-xs font-medium rounded {{ $latestLicense->isValid() ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ $latestLicense->isValid() ? 'Vigente' : 'Vencida' }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Historial de Vuelos -->
        <div class="lg:col-span-2">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Historial de Vuelos Recientes</h3>
                @if($recentFlights->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Fecha</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Dron</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Duración</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Propósito</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach($recentFlights as $flight)
                                    <tr class="hover:bg-gray-700/50">
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $flight->flight_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $flight->drone->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ round($flight->total_minutes / 60, 1) }}h</td>
                                        <td class="px-4 py-3 text-sm text-gray-400">{{ $flight->purpose }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">No hay vuelos registrados para este piloto.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

