@extends('layouts.app')

@section('page-title', $authorizedUser->full_name ?? $authorizedUser->username ?? $authorizedUser->user_telegram_id)
@section('page-subtitle', 'Perfil del piloto')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('production.users.edit', ['user' => $authorizedUser->getRouteKey()]) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            @endhasrole
            <a href="{{ route('production.users.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Usuario</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Telegram ID</p>
                        <p class="text-gray-900 font-medium">{{ $authorizedUser->user_telegram_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Username</p>
                        <p class="text-gray-900 font-medium">{{ $authorizedUser->username ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Rol</p>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $authorizedUser->role === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $authorizedUser->role === 'operator' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $authorizedUser->role === 'viewer' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ ucfirst($authorizedUser->role) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Registrado</p>
                        <p class="text-gray-900 font-medium">{{ $authorizedUser->created_at ? $authorizedUser->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @if(isset($latestLicense) && $latestLicense)
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Licencia Actual</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Número de Licencia</p>
                            <p class="text-gray-900 font-medium">{{ $latestLicense->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Categoría</p>
                            <p class="text-gray-900 font-medium">{{ $latestLicense->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha de Vencimiento</p>
                            <p class="text-gray-900 font-medium">{{ $latestLicense->expiration_date->format('d/m/Y') }}</p>
                            @if($latestLicense->expiration_date < now())
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Vencida</span>
                            @elseif($latestLicense->expiration_date->isBefore(now()->addDays(30)))
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Por Vencer</span>
                            @else
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Vigente</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Logs Generados</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $authorizedUser->telemetryLogs->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Intenciones de Misión</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $authorizedUser->missionIntents->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
