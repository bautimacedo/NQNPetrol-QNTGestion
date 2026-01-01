@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Editar Misión</h2>
        <p class="mt-2 text-gray-400">Modificar información de la misión</p>
    </div>

    <form action="{{ route('production.missions.update', $productionMission) }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $productionMission->name) }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">RPA</label>
                <select name="drone" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="">Seleccione un RPA</option>
                    @foreach($drones as $drone)
                        <option value="{{ $drone->name }}" {{ $productionMission->drone == $drone->name ? 'selected' : '' }}>
                            {{ $drone->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Duración (minutos)</label>
                <input type="number" name="duration" value="{{ old('duration', $productionMission->duration) }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">URL</label>
                <input type="url" name="url" value="{{ old('url', $productionMission->url) }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-400 mb-2">Payload JSON</label>
                <textarea name="payload" rows="6" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 font-mono text-sm">{{ old('payload', $productionMission->payload ? json_encode($productionMission->payload, JSON_PRETTY_PRINT) : '') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-gray-700 mt-6">
            <a href="{{ route('production.missions.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
            <button type="submit" class="px-4 py-2 text-white rounded-lg qnt-gradient">Actualizar</button>
        </div>
    </form>
</div>
@endsection

