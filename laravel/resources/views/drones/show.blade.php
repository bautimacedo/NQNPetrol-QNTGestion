@extends('layouts.app')

@section('page-title', $drone->name)
@section('page-subtitle', $drone->model . ' - Serial: ' . $drone->serial_number)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('drones.edit', $drone) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            <a href="{{ route('drones.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <!-- Estado y Estadísticas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Estado</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Estado Actual</p>
                        <span class="px-3 py-1 text-sm font-medium rounded-full mt-2 inline-block
                            {{ $drone->status === 'ready' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $drone->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $drone->status === 'flying' ? 'bg-orange-100 text-orange-800' : '' }}">
                            @if($drone->status === 'ready') Listo para Vuelo
                            @elseif($drone->status === 'maintenance') En Mantenimiento
                            @else En Vuelo
                            @endif
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Horas Totales</p>
                        <p class="text-3xl font-extrabold text-[#6b7b39] mt-1">{{ number_format($drone->flight_hours_total, 1) }}h</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total de Vuelos</p>
                        <p class="text-xl font-semibold text-gray-900 mt-1">{{ $drone->flights->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <!-- Historial de Vuelos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Historial de Vuelos</h3>
                @if($drone->flights->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Piloto</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Duración</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Propósito</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($drone->flights->take(10) as $flight)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $flight->flight_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $flight->pilot->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ round($flight->total_minutes / 60, 1) }}h</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $flight->purpose }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-600 text-center py-8">No hay vuelos registrados para este dron.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
