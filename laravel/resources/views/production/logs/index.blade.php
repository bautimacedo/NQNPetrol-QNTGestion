@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Monitor de Logs de Telemetría</h2>
        <p class="mt-2 text-gray-400">Visualización y filtrado de logs de telemetría en tiempo real</p>
    </div>

    <!-- Filtros -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
        <form method="GET" action="{{ route('production.logs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">RPA</label>
                <select name="drone" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="">Todos</option>
                    @foreach($drones as $drone)
                        <option value="{{ $drone->name }}" {{ request('drone') == $drone->name ? 'selected' : '' }}>
                            {{ $drone->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Severidad</label>
                <select name="severity" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="">Todas</option>
                    @foreach($severities as $severity)
                        <option value="{{ $severity }}" {{ request('severity') == $severity ? 'selected' : '' }}>
                            {{ ucfirst($severity) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Desde</label>
                <input type="datetime-local" name="date_from" value="{{ request('date_from') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Hasta</label>
                <input type="datetime-local" name="date_to" value="{{ request('date_to') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Filtrar</button>
                <a href="{{ route('production.logs.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg">Limpiar</a>
            </div>
        </form>
    </div>

    <!-- Tabla de Logs -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Timestamp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">RPA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Severidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Mensaje</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Batería</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-100">{{ $log->timestamp ? $log->timestamp->format('d/m/Y H:i:s') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-100">{{ $log->drone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    {{ $log->severity === 'error' || $log->severity === 'critical' ? 'bg-red-500/20 text-red-400' : '' }}
                                    {{ $log->severity === 'warning' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                    {{ $log->severity === 'info' ? 'bg-blue-500/20 text-blue-400' : '' }}">
                                    {{ $log->severity ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300 max-w-md truncate">{{ $log->message ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->latitude && $log->longitude)
                                    <div class="text-xs text-gray-400">{{ number_format($log->latitude, 4) }}, {{ number_format($log->longitude, 4) }}</div>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($log->battery_percentage)
                                    <div class="text-sm text-gray-100">{{ number_format($log->battery_percentage, 1) }}%</div>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">No se encontraron logs.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

