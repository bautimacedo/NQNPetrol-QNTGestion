@extends('layouts.app')

@section('content')
<div class="space-y-6" style="background-color: #0F172A;">
    @if(session('success'))
        <div class="p-4 rounded-lg" style="background-color: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3);">
            <p style="color: #4ade80;">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-lg" style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
            <ul class="list-disc list-inside text-sm" style="color: #f87171;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold" style="color: #FFFFFF;">Pilotos</h2>
            <p class="mt-2" style="color: rgba(255, 255, 255, 0.6);">Listado completo de pilotos registrados</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 text-white rounded-lg font-medium qnt-gradient">
            Registrar Piloto
        </button>
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Telegram ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Licencia</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($pilots as $pilot)
                            @php
                                $latestLicense = $pilot->licenses->sortByDesc('expiration_date')->first();
                            @endphp
                            <tr class="hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $pilot->full_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                <div class="text-sm text-gray-400">{{ $pilot->user_telegram_id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ (int) $pilot->status === 1 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ (int) $pilot->status === 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                                </td>
                                <td class="px-6 py-4">
                                @if($latestLicense)
                                    <div class="text-sm text-gray-100">{{ $latestLicense->category }}</div>
                                    <div class="text-xs text-gray-400">Vence: {{ $latestLicense->expiration_date->format('d/m/Y') }}</div>
                                    @if($latestLicense->expiresSoon(30))
                                        <span class="text-xs text-red-400 font-medium">⚠ Próxima a vencer</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-500">Sin licencia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pilots.show', $pilot) }}" class="text-orange-400 hover:text-orange-300">Ver Perfil</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay pilotos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Registrar Piloto -->
<div id="pilotModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-lg border border-gray-700 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-gray-100">Registrar Nuevo Piloto</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('pilots.store') }}" method="POST" id="pilotForm" enctype="multipart/form-data">
                @csrf
                
                <!-- Campos del Piloto -->
                <div class="space-y-6 mb-8">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-200 mb-4 pb-3 border-b border-gray-700">Datos del Piloto</h4>
                        
                        <div class="mb-5">
                            <label for="profile_photo" class="block text-sm font-medium text-gray-400 mb-2">Foto de Perfil</label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                            <p class="mt-1 text-xs text-gray-500">Formatos: JPEG, PNG, JPG, GIF. Máximo 2MB.</p>
                            @error('profile_photo')
                                <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-400 mb-2">Nombre Completo *</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                @error('full_name')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-400 mb-2">DNI *</label>
                                <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                @error('dni')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="user_telegram_id" class="block text-sm font-medium text-gray-400 mb-2">Telegram ID *</label>
                                <input type="text" name="user_telegram_id" id="user_telegram_id" value="{{ old('user_telegram_id') }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                @error('user_telegram_id')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-400 mb-2">Estado *</label>
                                <select name="status" id="status" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campos de la Licencia -->
                <div class="space-y-6 mb-8">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-200 mb-4 pb-3 border-b border-gray-700">Datos de la Licencia</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="license_number" class="block text-sm font-medium text-gray-400 mb-2">Número de Licencia *</label>
                                <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                @error('license_number')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-400 mb-2">Categoría *</label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                @error('category')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="expiration_date" class="block text-sm font-medium text-gray-400 mb-2">Fecha de Vencimiento *</label>
                                <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date') }}" required
                                    class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                                @error('expiration_date')
                                    <p class="mt-1 text-sm" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mensajes de Error -->
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-lg" style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                        <p class="text-sm font-semibold mb-2" style="color: #f87171;">Errores de validación:</p>
                        <ul class="list-disc list-inside text-sm" style="color: #f87171;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Botones -->
                <div class="flex gap-3 justify-end pt-4 border-t border-gray-700">
                    <button type="button" onclick="closeModal()" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                        Cancelar
                    </button>
                        <button type="submit" class="px-6 py-2 text-white rounded-lg font-medium transition-colors qnt-gradient">
                            Registrar
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('pilotModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('pilotModal').classList.add('hidden');
        // Limpiar el formulario
        document.getElementById('pilotForm').reset();
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('pilotModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection

