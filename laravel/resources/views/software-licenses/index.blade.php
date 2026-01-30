@extends('layouts.app')

@section('page-title', 'Licencias de Software')
@section('page-subtitle', 'Gestión de licencias de software')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm fade-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('software-licenses.create') }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
            + Nueva Licencia
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Software</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Proveedor</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Número de Licencia</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Asientos</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($licenses as $license)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $license->software_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $license->provider->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $license->license_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($license->expiration_date)
                                    <div class="text-sm text-gray-700">{{ $license->expiration_date->format('d/m/Y') }}</div>
                                    @if($license->expiration_date < now())
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Vencida</span>
                                    @elseif($license->expiration_date->isBefore(now()->addDays(30)))
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Por Vencer</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Vigente</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-500">Sin vencimiento</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $license->seats ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('software-licenses.show', $license) }}" class="text-sm font-medium mr-3" style="color: #6b7b39;" onmouseover="this.style.color='#5a6830'" onmouseout="this.style.color='#6b7b39'">Ver</a>
                                <a href="{{ route('software-licenses.edit', $license) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No hay licencias de software registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

