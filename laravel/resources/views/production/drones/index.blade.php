@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Gestión de RPAs (Producción)</h2>
            <p class="mt-2 text-gray-400">Flota de RPAs sincronizada con base de datos de producción</p>
        </div>
        <a href="{{ route('production.drones.create') }}" class="px-4 py-2 text-white rounded-lg font-medium transition-colors qnt-gradient">
            + Nuevo RPA
        </a>
    </div>

    <div class="rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead style="background-color: rgba(255, 255, 255, 0.08);">
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
                                <a href="{{ route('production.drones.show', $drone) }}" class="mr-3 transition-colors" style="color: #1B998B;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#1B998B'">Ver</a>
                                <a href="{{ route('production.drones.edit', $drone) }}" class="mr-3 transition-colors" style="color: #60a5fa;" onmouseover="this.style.color='#93c5fd'" onmouseout="this.style.color='#60a5fa'">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay RPAs registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

