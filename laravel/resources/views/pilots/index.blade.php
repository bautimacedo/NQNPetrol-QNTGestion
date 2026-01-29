@extends('layouts.app')

@section('page-title', 'Pilotos')
@section('page-subtitle', 'Listado completo de pilotos registrados')

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

    @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-sm fade-in">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('production.users.create') }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
            Registrar Nuevo Piloto
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nombre del Piloto</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Telegram ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nro de Licencia</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha de Vencimiento</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pilots as $pilot)
                        @php
                            $latestLicense = $pilot->licenses->sortByDesc('expiration_date')->first();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $pilot->full_name ?? $pilot->username ?? 'N/A' }}</div>
                                @if($pilot->webUser)
                                    <div class="text-xs text-gray-500">{{ $pilot->webUser->email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $pilot->user_telegram_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($latestLicense)
                                    <div class="text-sm text-gray-900">{{ $latestLicense->license_number }}</div>
                                @else
                                    <span class="text-xs text-gray-500">Sin licencia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($latestLicense)
                                    <div class="text-sm text-gray-900">{{ $latestLicense->expiration_date->format('d/m/Y') }}</div>
                                    @php
                                        $isExpired = $latestLicense->expiration_date < now();
                                        $expiresSoon = $latestLicense->expiration_date->isBefore(now()->addDays(30)) && !$isExpired;
                                    @endphp
                                    @if($isExpired)
                                        <span class="text-xs text-red-600 font-medium">Vencida</span>
                                    @elseif($expiresSoon)
                                        <span class="text-xs text-yellow-600 font-medium">Por vencer</span>
                                    @else
                                        <span class="text-xs text-green-600 font-medium">Vigente</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('production.users.show', $pilot) }}" class="text-sm font-medium mr-3" style="color: #6b7b39;" onmouseover="this.style.color='#5a6830'" onmouseout="this.style.color='#6b7b39'">Ver</a>
                                @hasrole('admin')
                                    <a href="{{ route('production.users.edit', $pilot) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Editar</a>
                                @endhasrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">No hay pilotos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
