@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Licencias de Pilotos</h2>
        <p class="mt-2 text-gray-400">Gestión y seguimiento de licencias de pilotos</p>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Piloto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Número de Licencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Fecha de Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($licenses as $license)
                        @php
                            $isExpired = $license->expiration_date < now();
                            $expiresSoon = $license->expiration_date->isBefore(now()->addDays(30)) && !$isExpired;
                        @endphp
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">
                                    {{ $license->pilot->full_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $license->license_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $license->category }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">
                                    {{ $license->expiration_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($isExpired)
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-red-500/20 text-red-400 border border-red-500/30">
                                        Vencida
                                    </span>
                                @elseif($expiresSoon)
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        Por Vencer
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/20 text-green-400 border border-green-500/30">
                                        Vigente
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay licencias registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

