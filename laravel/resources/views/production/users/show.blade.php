@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">{{ $authorizedUser->username ?? $authorizedUser->user_telegram_id }}</h2>
            <p class="mt-2 text-gray-400">Perfil del usuario autorizado</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('production.users.edit', ['user' => $authorizedUser->user_telegram_id]) }}" class="px-4 py-2 text-white rounded-lg qnt-gradient">Editar</a>
            <a href="{{ route('production.users.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Información del Usuario</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Telegram ID</p>
                        <p class="text-gray-100 font-medium">{{ $authorizedUser->user_telegram_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Username</p>
                        <p class="text-gray-100 font-medium">{{ $authorizedUser->username ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Rol</p>
                        <span class="px-2 py-1 text-xs font-medium rounded
                            {{ $authorizedUser->role === 'admin' ? 'bg-red-500/20 text-red-400' : '' }}
                            {{ $authorizedUser->role === 'operator' ? 'bg-blue-500/20 text-blue-400' : '' }}
                            {{ $authorizedUser->role === 'viewer' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                            {{ ucfirst($authorizedUser->role) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Registrado</p>
                        <p class="text-gray-100 font-medium">{{ $authorizedUser->created_at ? $authorizedUser->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-400">Logs Generados</p>
                        <p class="text-2xl font-bold text-orange-400">{{ $authorizedUser->telemetryLogs->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Intenciones de Misión</p>
                        <p class="text-2xl font-bold text-blue-400">{{ $authorizedUser->missionIntents->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

