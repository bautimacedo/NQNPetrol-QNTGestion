@extends('layouts.app')

@section('page-title', 'Pilotos')
@section('page-subtitle', 'Gestión de pilotos y operarios de Telegram')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        @hasrole('admin')
            <a href="{{ route('production.users.create') }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                + Nuevo Piloto
            </a>
        @endhasrole
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#ecebbb] to-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Telegram ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Licencia</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Registrado</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->user_telegram_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $user->username ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $user->role === 'operator' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $user->role === 'viewer' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $latestLicense = $user->licenses->sortByDesc('expiration_date')->first();
                                @endphp
                                @if($latestLicense)
                                    @if($latestLicense->expiration_date < now())
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Vencida</span>
                                    @elseif($latestLicense->expiration_date->isBefore(now()->addDays(30)))
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Por Vencer</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Vigente</span>
                                    @endif
                                    <div class="text-xs text-gray-600 mt-1">{{ $latestLicense->category }} - Vence: {{ $latestLicense->expiration_date->format('d/m/Y') }}</div>
                                @else
                                    <span class="text-xs text-gray-500">Sin licencia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('production.users.show', $user) }}" class="text-sm font-medium mr-3" style="color: #6b7b39;" onmouseover="this.style.color='#5a6830'" onmouseout="this.style.color='#6b7b39'">Ver</a>
                                @hasrole('admin')
                                    <a href="{{ route('production.users.edit', $user) }}" class="text-sm font-medium mr-3 text-blue-600 hover:text-blue-800">Editar</a>
                                @endhasrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
