@extends('layouts.app')

@section('page-title', 'Nueva Ubicación')
@section('page-subtitle', 'Registrar una nueva ubicación o sitio')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('sites.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="Ej: Neuquén, Loma Campana, etc.">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Detalles de Ubicación</label>
                <textarea name="location_details" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="Información adicional sobre la ubicación...">{{ old('location_details') }}</textarea>
                @error('location_details')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('sites.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Registrar</button>
            </div>
        </div>
    </form>
</div>
@endsection

