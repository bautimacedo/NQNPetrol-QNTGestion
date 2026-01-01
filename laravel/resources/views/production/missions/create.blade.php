@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Registrar Nueva Misión</h2>
        <p class="mt-2 text-gray-400">Crear una nueva misión en el sistema de producción</p>
    </div>

    <form action="{{ route('production.missions.store') }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nombre * (UNIQUE)</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">RPA</label>
                <select name="drone" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="">Seleccione un RPA</option>
                    @foreach($drones as $drone)
                        <option value="{{ $drone->name }}" {{ old('drone') == $drone->name ? 'selected' : '' }}>
                            {{ $drone->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Duración (minutos)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">URL</label>
                <input type="url" name="url" value="{{ old('url') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Link RTCP</label>
                <input type="text" name="link_rtcp" value="{{ old('link_rtcp') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Authentication</label>
                <input type="text" name="Authentication" value="{{ old('Authentication') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Send Password</label>
                <input type="text" name="send_passwd" value="{{ old('send_passwd') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-400 mb-2">Descripción (descrpition)</label>
                <textarea name="descrpition" rows="3" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">{{ old('descrpition') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-400 mb-2">Payload JSON</label>
                <textarea name="payload" rows="6" placeholder='{"key": "value"}' class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2 font-mono text-sm">{{ old('payload') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Ingrese un JSON válido</p>
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-gray-700 mt-6">
            <a href="{{ route('production.missions.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
            <button type="submit" class="px-4 py-2 text-white rounded-lg qnt-gradient">Registrar Misión</button>
        </div>
    </form>
</div>
@endsection

