@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Gestión de Drones (Producción)</h2>
            <p class="mt-2 text-gray-400">Flota de drones sincronizada con base de datos de producción</p>
        </div>
        <a href="{{ route('production.drones.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
            + Nuevo Dron
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Dock/Site</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Organización</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Ubicación</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($drones as $drone)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $drone->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $drone->dock ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $drone->site ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $drone->organization ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($drone->Latitud && $drone->Longitud)
                                    <div class="text-sm text-gray-300">{{ number_format($drone->Latitud, 6) }}, {{ number_format($drone->Longitud, 6) }}</div>
                                @else
                                    <span class="text-xs text-gray-500">Sin coordenadas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('production.drones.show', $drone) }}" class="text-orange-400 hover:text-orange-300 mr-3">Ver</a>
                                <a href="{{ route('production.drones.edit', $drone) }}" class="text-blue-400 hover:text-blue-300 mr-3">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay drones registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

