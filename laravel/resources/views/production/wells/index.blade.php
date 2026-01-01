@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Pozos AIB</h2>
        <p class="mt-2 text-gray-400">Visualización y gestión de pozos en el mapa</p>
    </div>

    <!-- Mapa Leaflet -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>

    <!-- Tabla de Pozos -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">BPM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Sede</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">RPA Asignado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Última Actualización</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Coordenadas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($wells as $well)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $well->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ strtolower($well->status) === 'activo' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $well->status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-100">{{ $well->bpm ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $well->site ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $well->drone->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">
                                    {{ $well->last_update ? $well->last_update->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($well->latitude && $well->longitude)
                                    <div class="text-sm text-gray-300">{{ number_format($well->latitude, 6) }}, {{ number_format($well->longitude, 6) }}</div>
                                @else
                                    <span class="text-xs text-gray-500">Sin coordenadas</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">No hay pozos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
    // Inicializar el mapa
    var map = L.map('map').setView([-40.0, -70.0], 6);

    // Agregar capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Función para formatear fecha
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        var date = new Date(dateString);
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        return day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
    }

    // Datos de los pozos desde PHP
    var wells = @json($wells);

    // Agregar marcadores para cada pozo
    wells.forEach(function(well) {
        if (well.latitude && well.longitude) {
            // Color del marcador según el estado
            var markerColor = (well.status && well.status.toLowerCase() === 'activo') ? 'green' : 'red';
            
            // Crear icono personalizado
            var icon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background-color: ' + markerColor + '; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            // Crear marcador
            var marker = L.marker([well.latitude, well.longitude], { icon: icon }).addTo(map);

            // Tooltip con información del pozo
            var lastUpdate = well.last_update ? formatDate(well.last_update) : 'N/A';
            var tooltipContent = '<div class="text-sm">' +
                '<strong>' + (well.name || 'Sin nombre') + '</strong><br>' +
                '<span>Sede: ' + (well.site || 'N/A') + '</span><br>' +
                '<span>BPM: ' + (well.bpm || 'N/A') + '</span><br>' +
                '<span class="text-xs text-gray-400">Última act: ' + lastUpdate + '</span>' +
                '</div>';

            marker.bindTooltip(tooltipContent, {
                permanent: false,
                direction: 'top',
                className: 'custom-tooltip'
            });
        }
    });

    // Ajustar el zoom para mostrar todos los marcadores si hay pozos
    if (wells.length > 0 && wells.some(w => w.latitude && w.longitude)) {
        var bounds = wells
            .filter(w => w.latitude && w.longitude)
            .map(w => [w.latitude, w.longitude]);
        
        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }
    }
</script>

<style>
    .custom-tooltip {
        background-color: rgba(17, 24, 39, 0.95);
        color: #f3f4f6;
        border: 1px solid #4b5563;
        border-radius: 0.5rem;
        padding: 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection

