@extends('layouts.app')

@section('page-title', $battery->serial)
@section('page-subtitle', 'Información completa de la batería')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('production.batteries.edit', $battery) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            @endhasrole
            <a href="{{ route('production.batteries.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Batería</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Serial</p>
                        <p class="text-gray-900 font-medium">{{ $battery->serial }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">RPA Asignado</p>
                        <p class="text-gray-900 font-medium">{{ $battery->drone->name ?? 'Sin asignar' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Cantidad de Vuelos</p>
                        <p class="text-2xl font-bold {{ $battery->flight_count > 100 ? 'text-amber-600' : 'text-gray-900' }}">
                            {{ $battery->flight_count }}
                        </p>
                        @if($battery->flight_count > 100)
                            <p class="text-xs text-amber-600 mt-1">⚠️ Alto uso - Considerar reemplazo</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Último Uso</p>
                        <p class="text-gray-900 font-medium">
                            {{ $battery->last_used ? $battery->last_used->format('d/m/Y H:i') : 'Nunca' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado</h3>
                <div class="space-y-4">
                    @if($battery->flight_count > 100)
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                            <p class="text-sm font-medium text-amber-800">⚠️ Batería con alto uso</p>
                            <p class="text-xs text-gray-600 mt-1">Más de 100 vuelos registrados</p>
                        </div>
                    @else
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm font-medium text-green-800">✓ Estado normal</p>
                            <p class="text-xs text-gray-600 mt-1">Uso dentro de parámetros</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
