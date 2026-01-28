@extends('layouts.app')

@section('page-title', 'Editar Proveedor')
@section('page-subtitle', 'Modificar información del proveedor')

@section('content')
<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
    <form action="{{ route('providers.update', $provider) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre / Razón Social *</label>
                <input type="text" name="name" required value="{{ old('name', $provider->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="Ej: Rumco S.A.">
                @error('name')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">CUIT</label>
                    <input type="text" name="cuit" value="{{ old('cuit', $provider->cuit) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="20-12345678-9">
                    @error('cuit')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $provider->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="contacto@proveedor.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                <input type="text" name="phone" value="{{ old('phone', $provider->phone) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors" placeholder="+54 11 1234-5678">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                <textarea name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors resize-none" placeholder="Calle, número, ciudad, provincia">{{ old('address', $provider->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('providers.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                Actualizar Proveedor
            </button>
        </div>
    </form>
</div>
@endsection

