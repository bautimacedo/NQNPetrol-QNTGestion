@extends('layouts.app')

@section('page-title', 'Editar Piloto')
@section('page-subtitle', 'Modificar información del piloto y licencia')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-3xl">
        <form action="{{ route('production.users.update', $authorizedUser->user_telegram_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Piloto</h3>
                
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Telegram ID</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $authorizedUser->user_telegram_id }}</p>
                    <p class="text-xs text-gray-500 mt-1">Este campo no se puede modificar (Primary Key)</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', $authorizedUser->username) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nueva Contraseña de Misión</label>
                    <input type="password" name="mission_password" placeholder="Dejar vacío para mantener la actual" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rol *</label>
                    <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        <option value="operator" {{ $authorizedUser->role === 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="admin" {{ $authorizedUser->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="viewer" {{ $authorizedUser->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                    </select>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Licencia</h3>
                    
                    @if($latestLicense)
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 mb-4">
                            <p class="text-sm text-blue-800 font-medium mb-2">Licencia Actual:</p>
                            <p class="text-sm text-blue-900"><strong>Categoría:</strong> {{ $latestLicense->category }}</p>
                            <p class="text-sm text-blue-900"><strong>Número:</strong> {{ $latestLicense->license_number }}</p>
                            <p class="text-sm text-blue-900"><strong>Vencimiento:</strong> {{ $latestLicense->expiration_date->format('d/m/Y') }}</p>
                            @if($latestLicense->expiration_date < now())
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Vencida</span>
                            @elseif($latestLicense->expiration_date->isBefore(now()->addDays(30)))
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Por Vencer</span>
                            @else
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Vigente</span>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Licencia</label>
                            <input type="text" name="license_number" value="{{ old('license_number', $latestLicense->license_number ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Categoría</label>
                            <input type="text" name="license_category" value="{{ old('license_category', $latestLicense->category ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Vencimiento</label>
                        <input type="date" name="license_expiration_date" value="{{ old('license_expiration_date', $latestLicense ? $latestLicense->expiration_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    </div>

                    @if($latestLicense && $latestLicense->document_path)
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800 font-medium mb-2">Documento Actual:</p>
                            <a href="{{ Storage::url($latestLicense->document_path) }}" target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Documento Actual
                            </a>
                        </div>
                    @endif

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subir/Actualizar Documento (PDF, JPG, PNG)</label>
                        <input type="file" name="license_document" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        <p class="mt-1 text-xs text-gray-500">Tamaño máximo: 10MB. Formatos permitidos: PDF, JPG, PNG</p>
                        @error('license_document')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('production.users.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
