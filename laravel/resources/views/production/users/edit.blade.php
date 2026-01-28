@extends('layouts.app')

@section('page-title', 'Editar Usuario Autorizado')
@section('page-subtitle', 'Modificar información del usuario')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('production.users.update', $authorizedUser->user_telegram_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-sm text-gray-600 mb-1">Telegram ID</p>
                <p class="text-lg font-semibold text-gray-900">{{ $authorizedUser->user_telegram_id }}</p>
                <p class="text-xs text-gray-500 mt-1">Este campo no se puede modificar (Primary Key)</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $authorizedUser->username) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nueva Contraseña de Misión</label>
                <input type="password" name="mission_password" placeholder="Dejar vacío para mantener la actual" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rol *</label>
                <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="operator" {{ $authorizedUser->role === 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="admin" {{ $authorizedUser->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="viewer" {{ $authorizedUser->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('production.users.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection
