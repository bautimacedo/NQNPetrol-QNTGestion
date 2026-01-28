@extends('layouts.app')

@section('page-title', 'Registrar Nueva Misión')
@section('page-subtitle', 'Crear una nueva misión en el sistema de producción')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
    <form action="{{ route('production.missions.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre * (UNIQUE)</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">RPA</label>
                <select name="drone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="">Seleccione un RPA</option>
                    @foreach($drones as $drone)
                        <option value="{{ $drone->name }}" {{ old('drone') == $drone->name ? 'selected' : '' }}>
                            {{ $drone->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Duración (minutos)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">URL</label>
                <input type="url" name="url" value="{{ old('url') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Link RTCP</label>
                <input type="text" name="link_rtcp" value="{{ old('link_rtcp') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Authentication</label>
                <input type="text" name="Authentication" value="{{ old('Authentication') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Send Password</label>
                <input type="text" name="send_passwd" value="{{ old('send_passwd') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción (descrpition)</label>
                <textarea name="descrpition" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors resize-none">{{ old('descrpition') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Payload JSON</label>
                <textarea name="payload" rows="6" placeholder='{"key": "value"}' class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors font-mono text-sm resize-none">{{ old('payload') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Ingrese un JSON válido</p>
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 mt-6">
            <a href="{{ route('production.missions.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Registrar Misión</button>
        </div>
    </form>
</div>
@endsection
