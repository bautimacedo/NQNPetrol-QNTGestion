@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Editar Usuario Autorizado</h2>
        <p class="mt-2 text-gray-400">Modificar información del usuario</p>
    </div>

    <form action="{{ route('production.users.update', $authorizedUser->user_telegram_id) }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="bg-gray-900/50 rounded-lg p-4">
                <p class="text-sm text-gray-400 mb-1">Telegram ID</p>
                <p class="text-lg font-semibold text-gray-100">{{ $authorizedUser->user_telegram_id }}</p>
                <p class="text-xs text-gray-500 mt-1">Este campo no se puede modificar (Primary Key)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $authorizedUser->username) }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nueva Contraseña de Misión</label>
                <input type="password" name="mission_password" placeholder="Dejar vacío para mantener la actual" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Rol *</label>
                <select name="role" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="operator" {{ $authorizedUser->role === 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="admin" {{ $authorizedUser->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="viewer" {{ $authorizedUser->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('production.users.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection

