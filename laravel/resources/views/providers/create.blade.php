@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Nuevo Proveedor</h2>
        <p class="mt-2 text-gray-400">Registrar un nuevo proveedor en el sistema</p>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <form action="{{ route('providers.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nombre / Razón Social *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Ej: Rumco S.A.">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">CUIT</label>
                        <input type="text" name="cuit" value="{{ old('cuit') }}" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="20-12345678-9">
                        @error('cuit')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="contacto@proveedor.com">
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="+54 11 1234-5678">
                    @error('phone')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Dirección</label>
                    <textarea name="address" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Calle, número, ciudad, provincia">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('providers.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:text-white" style="border: 1px solid rgba(255, 255, 255, 0.2);">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                    Crear Proveedor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

