@extends('layouts.app')

@section('page-title', 'Seguros')
@section('page-subtitle', 'Gestión de seguros')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm fade-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('insurances.create') }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
            + Nuevo Seguro
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aseguradora</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Número de Póliza</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Vigencia</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Proveedor</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($insurances as $insurance)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $insurance->insurer_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $insurance->policy_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $insurance->validity_date->format('d/m/Y') }}</div>
                                @if($insurance->validity_date < now())
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Vencido</span>
                                @elseif($insurance->validity_date->isBefore(now()->addDays(30)))
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Por Vencer</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Vigente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $insurance->provider->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('insurances.show', $insurance) }}" class="text-sm font-medium mr-3" style="color: #6b7b39;" onmouseover="this.style.color='#5a6830'" onmouseout="this.style.color='#6b7b39'">Ver</a>
                                <a href="{{ route('insurances.edit', $insurance) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">No hay seguros registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

