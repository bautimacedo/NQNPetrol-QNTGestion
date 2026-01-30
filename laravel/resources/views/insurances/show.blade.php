@extends('layouts.app')

@section('page-title', 'Seguro: ' . $insurance->insurer_name)
@section('page-subtitle', 'Detalles del seguro')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="flex space-x-3">
            <a href="{{ route('insurances.edit', $insurance) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                Editar
            </a>
            <form action="{{ route('insurances.destroy', $insurance) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este seguro?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Eliminar
                </button>
            </form>
            <a href="{{ route('insurances.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Información del Seguro</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600">Aseguradora</p>
                <p class="text-lg font-medium text-gray-900">{{ $insurance->insurer_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Número de Póliza</p>
                <p class="text-lg font-medium text-gray-900">{{ $insurance->policy_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Fecha de Vigencia</p>
                <p class="text-lg font-medium text-gray-900">{{ $insurance->validity_date->format('d/m/Y') }}</p>
                @if($insurance->validity_date < now())
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Vencido</span>
                @elseif($insurance->validity_date->isBefore(now()->addDays(30)))
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Por Vencer</span>
                @else
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Vigente</span>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-600">Proveedor</p>
                <p class="text-lg font-medium text-gray-900">{{ $insurance->provider->name ?? '-' }}</p>
            </div>
            @if($insurance->notes)
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-600">Notas</p>
                    <p class="text-gray-900">{{ $insurance->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

