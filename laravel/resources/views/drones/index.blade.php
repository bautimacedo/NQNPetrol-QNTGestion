@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Flota de Drones</h2>
            <p class="mt-2 text-gray-400">Gestión completa de la flota operativa</p>
        </div>
        <a href="{{ route('drones.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
            + Nuevo Dron
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($drones as $drone)
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 hover:border-orange-500/50 transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-100">{{ $drone->name }}</h3>
                        <p class="text-sm text-gray-400">{{ $drone->model }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded
                        {{ $drone->status === 'ready' ? 'bg-green-500/20 text-green-400' : '' }}
                        {{ $drone->status === 'maintenance' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                        {{ $drone->status === 'flying' ? 'bg-orange-500/20 text-orange-400' : '' }}">
                        @if($drone->status === 'ready') Listo
                        @elseif($drone->status === 'maintenance') Mantenimiento
                        @else En Vuelo
                        @endif
                    </span>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Serial</p>
                        <p class="text-sm text-gray-300">{{ $drone->serial_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Horas Totales</p>
                        <p class="text-lg font-semibold text-orange-400">{{ number_format($drone->flight_hours_total, 1) }}h</p>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-700">
                        <span>{{ $drone->flights_count }} vuelos</span>
                        <span>{{ $drone->maintenance_logs_count }} mantenimientos</span>
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-gray-700">
                    <a href="{{ route('drones.show', $drone) }}" class="flex-1 px-3 py-2 bg-gray-700 hover:bg-gray-600 text-white text-center rounded text-sm transition-colors">
                        Ver
                    </a>
                    <a href="{{ route('drones.edit', $drone) }}" class="flex-1 px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-center rounded text-sm transition-colors">
                        Editar
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-800 rounded-lg border border-gray-700 p-12 text-center">
                <p class="text-gray-400">No hay drones registrados en la flota.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

