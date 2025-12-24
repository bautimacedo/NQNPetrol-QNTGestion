@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $drone->name }}</h2>
            <p class="mt-2 text-gray-400">{{ $drone->model }} - Serial: {{ $drone->serial_number }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('drones.edit', $drone) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Editar</a>
            <a href="{{ route('drones.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <!-- Estado y Estadísticas -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Estado</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Estado Actual</p>
                        <span class="px-3 py-1 text-sm font-medium rounded mt-2 inline-block
                            {{ $drone->status === 'ready' ? 'bg-green-500/20 text-green-400' : '' }}
                            {{ $drone->status === 'maintenance' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                            {{ $drone->status === 'flying' ? 'bg-orange-500/20 text-orange-400' : '' }}">
                            @if($drone->status === 'ready') Listo para Vuelo
                            @elseif($drone->status === 'maintenance') En Mantenimiento
                            @else En Vuelo
                            @endif
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Horas Totales</p>
                        <p class="text-3xl font-bold text-orange-400 mt-1">{{ number_format($drone->flight_hours_total, 1) }}h</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total de Vuelos</p>
                        <p class="text-xl font-semibold text-gray-100 mt-1">{{ $drone->flights->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <!-- Historial de Vuelos -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Historial de Vuelos</h3>
                @if($drone->flights->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Fecha</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Piloto</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Duración</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-400">Propósito</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach($drone->flights->take(10) as $flight)
                                    <tr class="hover:bg-gray-700/50">
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $flight->flight_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $flight->pilot->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ round($flight->total_minutes / 60, 1) }}h</td>
                                        <td class="px-4 py-3 text-sm text-gray-400">{{ $flight->purpose }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">No hay vuelos registrados para este dron.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

