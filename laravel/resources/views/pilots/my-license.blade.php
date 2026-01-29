@extends('layouts.app')
@inject('Storage', 'Illuminate\Support\Facades\Storage')

@section('page-title', 'Mi Licencia')
@section('page-subtitle', 'Gestiona tu información de licencia')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-sm fade-in">
            {{ session('error') }}
        </div>
    @endif

    @php
        $authorizedUser = \App\Models\AuthorizedUser::where('web_user_id', auth()->id())->first();
        $latestLicense = $authorizedUser ? $authorizedUser->licenses()->orderByDesc('expiration_date')->first() : null;
    @endphp

    @if(!$authorizedUser)
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-3xl mx-auto">
            <p class="text-gray-700">No se encontró tu perfil de piloto. Contacta al administrador.</p>
        </div>
    @else
        <!-- Card Principal -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-3xl mx-auto">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Información de Licencia</h3>
            
            <form action="{{ route('pilot.my-license.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Información del Piloto -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nombre</p>
                            <p class="text-gray-900 font-medium">{{ $authorizedUser->full_name ?? $authorizedUser->username ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Telegram ID</p>
                            <p class="text-gray-900 font-medium">{{ $authorizedUser->user_telegram_id }}</p>
                        </div>
                    </div>

                    <!-- Formulario de Licencia -->
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Datos de la Licencia</h4>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="license_number" class="block text-sm font-semibold text-gray-700 mb-2">Número de Licencia *</label>
                                <input type="text" name="license_number" id="license_number" value="{{ old('license_number', $latestLicense->license_number ?? '') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                                @error('license_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Categoría *</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $latestLicense->category ?? '') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                                @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="col-span-2">
                                <label for="expiration_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Vencimiento *</label>
                                <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date', $latestLicense ? $latestLicense->expiration_date->format('Y-m-d') : '') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                                @error('expiration_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Documento de Licencia -->
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Documento Digital</h4>
                        
                        @if($latestLicense && $latestLicense->document_path)
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-sm text-blue-800 font-medium mb-2">Documento Actual:</p>
                                <a href="{{ Storage::url($latestLicense->document_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="this.style.backgroundColor='#5a6830'" onmouseout="this.style.backgroundColor='#6b7b39'">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver Documento Actual
                                </a>
                            </div>
                        @endif

                        <div>
                            <label for="document" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ ($latestLicense && $latestLicense->document_path) ? 'Actualizar Documento' : 'Subir Documento' }} (PDF, JPG, PNG)
                            </label>
                            <input type="file" name="document" id="document" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            <p class="mt-1 text-xs text-gray-500">Tamaño máximo: 10MB. Formatos permitidos: PDF, JPG, PNG</p>
                            @error('document')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                            {{ $latestLicense ? 'Actualizar Licencia' : 'Guardar Licencia' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

