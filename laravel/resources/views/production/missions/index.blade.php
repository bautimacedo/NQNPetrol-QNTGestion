@extends('layouts.app')

@section('page-title', 'Libro de Misiones')
@section('page-subtitle', 'Registro completo de misiones de producción')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        @hasrole('admin')
            <a href="{{ route('production.missions.create') }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                + Nueva Misión
            </a>
        @endhasrole
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RPA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payload</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($missions as $mission)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $mission->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $mission->drone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $mission->duration ? $mission->duration . ' min' : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($mission->payload)
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">JSON</span>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($mission->url)
                                    <a href="{{ $mission->url }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800">Ver</a>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('production.missions.show', $mission) }}" class="text-sm font-medium mr-3" style="color: #6b7b39;" onmouseover="this.style.color='#5a6830'" onmouseout="this.style.color='#6b7b39'">Ver</a>
                                @hasrole('admin')
                                    <a href="{{ route('production.missions.edit', $mission) }}" class="text-sm font-medium mr-3 text-blue-600 hover:text-blue-800">Editar</a>
                                @endhasrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No hay misiones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($missions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $missions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
