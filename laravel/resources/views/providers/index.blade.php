@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Gestión de Proveedores</h2>
            <p class="mt-2 text-gray-400">Administración de proveedores y contactos</p>
        </div>
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('providers.create') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                    Nuevo Proveedor
                </a>
            @endif
        @endauth
    </div>

    <!-- Tabla de Proveedores -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nombre / Razón Social</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">CUIT</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Dirección</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Compras</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($providers as $provider)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $provider->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $provider->cuit ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $provider->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $provider->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ Str::limit($provider->address ?? '-', 40) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-500/20 text-blue-400">
                                    {{ $provider->purchases_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    @auth
                                        @if(auth()->user()->hasRole('admin'))
                                            <a href="{{ route('providers.edit', $provider) }}" class="px-3 py-1 text-sm font-medium rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                                                Editar
                                            </a>
                                            <form action="{{ route('providers.destroy', $provider) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-sm font-medium rounded-lg transition-colors" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.3)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">No hay proveedores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

