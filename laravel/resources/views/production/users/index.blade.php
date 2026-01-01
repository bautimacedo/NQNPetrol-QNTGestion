@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Usuarios Autorizados</h2>
            <p class="mt-2 text-gray-400">Gestión de operarios de Telegram</p>
        </div>
        @hasrole('admin')
            <a href="{{ route('production.users.create') }}" class="px-4 py-2 text-white rounded-lg font-medium transition-colors qnt-gradient">
                + Nuevo Usuario
            </a>
        @endhasrole
    </div>

    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Telegram ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Registrado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">{{ $user->user_telegram_id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $user->username ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    {{ $user->role === 'admin' ? 'bg-red-500/20 text-red-400' : '' }}
                                    {{ $user->role === 'operator' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                    {{ $user->role === 'viewer' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('production.users.show', $user) }}" class="text-orange-400 hover:text-orange-300 mr-3">Ver</a>
                                @hasrole('admin')
                                    <a href="{{ route('production.users.edit', $user) }}" class="text-blue-400 hover:text-blue-300 mr-3">Editar</a>
                                @endhasrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

