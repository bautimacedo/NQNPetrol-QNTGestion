@extends('layouts.app')

@section('page-title', 'Pozos AIB')
@section('page-subtitle', 'Visualización y gestión de pozos en el mapa')

@section('content')
<div class="space-y-6">
    <!-- Mapa Leaflet -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>

    <!-- Tabla de Pozos -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BPM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sede</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RPA Asignado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Actualización</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordenadas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($wells as $well)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $well->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ strtolower($well->status) === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $well->status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $well->bpm ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $well->site ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $well->drone->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">
                                    {{ $well->last_update ? $well->last_update->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($well->latitude && $well->longitude)
                                    <div class="text-sm text-gray-700">{{ number_format($well->latitude, 6) }}, {{ number_format($well->longitude, 6) }}</div>
                                @else
                                    <span class="text-xs text-gray-500">Sin coordenadas</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">No hay pozos registrados.</td>
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
    var map = L.map('map').setView([-40.0, -70.0], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

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

    var wells = @json($wells);

    wells.forEach(function(well) {
        if (well.latitude && well.longitude) {
            var markerColor = (well.status && well.status.toLowerCase() === 'activo') ? 'green' : 'red';
            
            var icon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background-color: ' + markerColor + '; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            var marker = L.marker([well.latitude, well.longitude], { icon: icon }).addTo(map);

            var lastUpdate = well.last_update ? formatDate(well.last_update) : 'N/A';
            var tooltipContent = '<div class="text-sm">' +
                '<strong>' + (well.name || 'Sin nombre') + '</strong><br>' +
                '<span>Sede: ' + (well.site || 'N/A') + '</span><br>' +
                '<span>BPM: ' + (well.bpm || 'N/A') + '</span><br>' +
                '<span class="text-xs text-gray-600">Última act: ' + lastUpdate + '</span>' +
                '</div>';

            marker.bindTooltip(tooltipContent, {
                permanent: false,
                direction: 'top',
                className: 'custom-tooltip'
            });
        }
    });

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
        background-color: white;
        color: #1f2937;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem;
        font-size: 0.875rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
