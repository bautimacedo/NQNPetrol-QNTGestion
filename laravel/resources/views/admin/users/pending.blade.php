@extends('layouts.app')

@section('page-title', 'Usuarios Pendientes de Aprobación')
@section('page-subtitle', 'Revisa y aprueba las solicitudes de acceso de nuevos usuarios')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if($pendingUsers->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="mx-auto h-12 w-12 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-lg font-semibold text-gray-900">No hay usuarios pendientes de aprobación</p>
            <p class="mt-2 text-sm text-gray-600">Todos los usuarios han sido revisados</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha de Nacimiento</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha de Registro</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingUsers as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="text-xs text-gray-600">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">
                                        {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Dropdown de Aprobación -->
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button 
                                                @click="open = !open" 
                                                type="button" 
                                                class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors" 
                                                style="background-color: #6b7b39;" 
                                                onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" 
                                                onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'"
                                            >
                                                Aprobar
                                                <svg class="inline-block ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            
                                            <div 
                                                x-show="open" 
                                                @click.away="open = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                                                style="display: none;"
                                            >
                                                <div class="py-1" role="menu">
                                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline w-full">
                                                        @csrf
                                                        <input type="hidden" name="role" value="pilot">
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                                            Aprobar como Piloto
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline w-full">
                                                        @csrf
                                                        <input type="hidden" name="role" value="operator">
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                                            Aprobar como Operador
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline w-full">
                                                        @csrf
                                                        <input type="hidden" name="role" value="admin">
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                                            Aprobar como Admin
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas rechazar y eliminar a este usuario? Esta acción no se puede deshacer.');">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection
