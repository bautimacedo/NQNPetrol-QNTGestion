@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Libro de Misiones</h2>
            <p class="mt-2 text-gray-400">Registro completo de misiones de producción</p>
        </div>
        <a href="{{ route('production.missions.create') }}" class="px-4 py-2 text-white rounded-lg font-medium transition-colors qnt-gradient">
            + Nueva Misión
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">RPA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Payload</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">URL</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($missions as $mission)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $mission->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $mission->drone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $mission->duration ? $mission->duration . ' min' : '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($mission->payload)
                                    <span class="px-2 py-1 text-xs bg-blue-500/20 text-blue-400 rounded">JSON</span>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($mission->url)
                                    <a href="{{ $mission->url }}" target="_blank" class="text-blue-400 hover:text-blue-300 text-sm">Ver</a>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('production.missions.show', $mission) }}" class="text-orange-400 hover:text-orange-300 mr-3">Ver</a>
                                <a href="{{ route('production.missions.edit', $mission) }}" class="text-blue-400 hover:text-blue-300 mr-3">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">No hay misiones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($missions->hasPages())
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $missions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

