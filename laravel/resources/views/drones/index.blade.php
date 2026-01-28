@extends('layouts.app')

@section('page-title', 'Flota de Drones')
@section('page-subtitle', 'Gestión completa de la flota operativa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        @hasrole('admin')
            <a href="{{ route('drones.create') }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                + Nuevo Dron
            </a>
        @endhasrole
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($drones as $drone)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $drone->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $drone->model }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-medium rounded-full
                        {{ $drone->status === 'ready' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $drone->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $drone->status === 'flying' ? 'bg-orange-100 text-orange-800' : '' }}">
                        @if($drone->status === 'ready') Listo
                        @elseif($drone->status === 'maintenance') Mantenimiento
                        @else En Vuelo
                        @endif
                    </span>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Serial</p>
                        <p class="text-sm text-gray-900 font-medium">{{ $drone->serial_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Horas Totales</p>
                        <p class="text-lg font-semibold text-[#6b7b39]">{{ number_format($drone->flight_hours_total, 1) }}h</p>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600 pt-2 border-t border-gray-200">
                        <span>{{ $drone->flights_count }} vuelos</span>
                        <span>{{ $drone->maintenance_logs_count }} mantenimientos</span>
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('drones.show', $drone) }}" class="flex-1 px-3 py-2 text-sm font-medium text-white rounded-lg transition-colors text-center" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                        Ver
                    </a>
                    <a href="{{ route('drones.edit', $drone) }}" class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                        Editar
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <p class="text-gray-600">No hay drones registrados en la flota.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
