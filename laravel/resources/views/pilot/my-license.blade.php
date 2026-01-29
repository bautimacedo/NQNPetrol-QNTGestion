@extends('layouts.app')

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

    <!-- Card Principal -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-3xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Información de Licencia</h3>
        
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

            @if($latestLicense)
                <!-- Información de Licencia -->
                <div class="pt-4 border-t border-gray-200">
                    <h4 class="text-md font-semibold text-gray-900 mb-4">Detalles de la Licencia</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Número de Licencia</p>
                            <p class="text-gray-900 font-medium">{{ $latestLicense->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Categoría</p>
                            <p class="text-gray-900 font-medium">{{ $latestLicense->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha de Vencimiento</p>
                            <p class="text-gray-900 font-medium">{{ $latestLicense->expiration_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estado</p>
                            @php
                                $isExpired = $latestLicense->expiration_date < now();
                                $expiresSoon = $latestLicense->expiration_date->isBefore(now()->addDays(30)) && !$isExpired;
                            @endphp
                            @if($isExpired)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 border border-red-200">Vencida</span>
                            @elseif($expiresSoon)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Por Vencer</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 border border-green-200">Vigente</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Documento de Licencia -->
                <div class="pt-4 border-t border-gray-200">
                    <h4 class="text-md font-semibold text-gray-900 mb-4">Documento Digital</h4>
                    
                    @if($latestLicense->document_path)
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

                    <form action="{{ route('pilot.my-license.update-document') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ $latestLicense->document_path ? 'Actualizar Documento' : 'Subir Documento' }} (PDF, JPG, PNG)
                            </label>
                            <input type="file" name="license_document" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            <p class="mt-1 text-xs text-gray-500">Tamaño máximo: 10MB. Formatos permitidos: PDF, JPG, PNG</p>
                            @error('license_document')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                                {{ $latestLicense->document_path ? 'Actualizar Documento' : 'Subir Documento' }}
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-gray-700">No tienes una licencia registrada. Contacta al administrador para que registre tu licencia.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

