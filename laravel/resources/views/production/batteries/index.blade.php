@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Gestión de Baterías</h2>
            <p class="mt-2 text-gray-400">Inventario de baterías de la flota</p>
        </div>
        <a href="{{ route('production.batteries.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
            + Nueva Batería
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Serial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">RPA Asignado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Vuelos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Último Uso</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($batteries as $battery)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $battery->serial }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $battery->drone->name ?? 'Sin asignar' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-100 {{ $battery->flight_count > 100 ? 'text-yellow-400' : '' }}">
                                        {{ $battery->flight_count }}
                                    </span>
                                    @if($battery->flight_count > 100)
                                        <span class="ml-2 px-2 py-1 text-xs bg-yellow-500/20 text-yellow-400 rounded">Alto uso</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">
                                    {{ $battery->last_used ? $battery->last_used->format('d/m/Y') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('production.batteries.show', $battery) }}" class="text-orange-400 hover:text-orange-300 mr-3">Ver</a>
                                <a href="{{ route('production.batteries.edit', $battery) }}" class="text-blue-400 hover:text-blue-300 mr-3">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay baterías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($batteries->hasPages())
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $batteries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

