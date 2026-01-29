@extends('layouts.app')

@section('page-title', 'Editar RPA')
@section('page-subtitle', 'Modificar información del RPA')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-2xl">
    @php
        // #region agent log
        file_put_contents('/home/bauti/NQNPetrol/PilotosdeCero/.cursor/debug.log', json_encode([
            'sessionId' => 'debug-session',
            'runId' => 'run1',
            'hypothesisId' => 'B',
            'location' => 'edit.blade.php:8',
            'message' => 'Before route generation',
            'data' => [
                'productionDrone_exists' => isset($productionDrone),
                'productionDrone_id' => isset($productionDrone) ? ($productionDrone->id ?? 'NULL') : 'NOT_SET',
                'productionDrone_name' => isset($productionDrone) ? ($productionDrone->name ?? 'NULL') : 'NOT_SET',
                'route_key_name' => isset($productionDrone) ? $productionDrone->getRouteKeyName() : 'NOT_SET',
                'route_key_value' => isset($productionDrone) && method_exists($productionDrone, 'getRouteKey') ? $productionDrone->getRouteKey() : 'NOT_AVAILABLE',
            ],
            'timestamp' => time() * 1000
        ]) . "\n", FILE_APPEND);
        // #endregion
    @endphp
    <form action="{{ route('production.drones.update', $productionDrone->id ?? $productionDrone) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $productionDrone->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dock</label>
                    <input type="text" name="dock" value="{{ old('dock', $productionDrone->dock) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ubicación</label>
                    <select name="site_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        <option value="">Seleccione una ubicación</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ old('site_id', $productionDrone->site_id) == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('site_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Organización</label>
                <input type="text" name="organization" value="{{ old('organization', $productionDrone->organization) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Marca</label>
                    <input type="text" name="brand" value="{{ old('brand', $productionDrone->brand) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Modelo</label>
                    <input type="text" name="model" value="{{ old('model', $productionDrone->model) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Matrícula</label>
                <input type="text" name="registration" value="{{ old('registration', $productionDrone->registration) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Latitud</label>
                    <input type="number" step="0.00000001" name="Latitud" value="{{ old('Latitud', $productionDrone->Latitud) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Longitud</label>
                    <input type="number" step="0.00000001" name="Longitud" value="{{ old('Longitud', $productionDrone->Longitud) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('production.drones.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection
