@extends('layouts.app')

@section('page-title', 'Licencias de Pilotos')
@section('page-subtitle', 'Gestión y seguimiento de licencias de pilotos')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        @hasrole('admin')
            <button onclick="openLicenseModal()" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                Registrar Licencia
            </button>
        @endhasrole
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Piloto</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Número de Licencia</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha de Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($licenses as $license)
                        @php
                            $isExpired = $license->expiration_date < now();
                            $expiresSoon = $license->expiration_date->isBefore(now()->addDays(30)) && !$isExpired;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $license->authorizedUser->full_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $license->license_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $license->category }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">
                                    {{ $license->expiration_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($isExpired)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 border border-red-200">
                                        Vencida
                                    </span>
                                @elseif($expiresSoon)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Por Vencer
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Vigente
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">No hay licencias registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Registrar Licencia -->
<div id="licenseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-gray-900">Registrar Nueva Licencia</h3>
                <button onclick="closeLicenseModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('production.licenses.store') }}" method="POST" id="licenseForm">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="authorized_user_id" class="block text-sm font-semibold text-gray-700 mb-2">Operario *</label>
                        <select name="authorized_user_id" id="authorized_user_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            <option value="">Seleccione un operario</option>
                            @foreach(\App\Models\AuthorizedUser::whereNotNull('full_name')->orderBy('full_name')->get() as $user)
                                <option value="{{ $user->id }}" {{ old('authorized_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }} ({{ $user->dni }})
                                </option>
                            @endforeach
                        </select>
                        @error('authorized_user_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label for="license_number" class="block text-sm font-semibold text-gray-700 mb-2">Número de Licencia *</label>
                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        @error('license_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Categoría *</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label for="expiration_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Vencimiento *</label>
                        <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        @error('expiration_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Mensajes de Error -->
                    @if($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <ul class="list-disc list-inside text-sm text-red-800">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Botones -->
                    <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeLicenseModal()" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                            Registrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openLicenseModal() {
        document.getElementById('licenseModal').classList.remove('hidden');
    }

    function closeLicenseModal() {
        document.getElementById('licenseModal').classList.add('hidden');
        document.getElementById('licenseForm').reset();
    }

    document.getElementById('licenseModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLicenseModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLicenseModal();
        }
    });
</script>
@endsection
