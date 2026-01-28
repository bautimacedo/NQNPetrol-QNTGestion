@extends('layouts.app')

@section('page-title', 'Registrar Usuario Autorizado')
@section('page-subtitle', 'Agregar un nuevo operario de Telegram')

@section('content')
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('production.users.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Telegram ID * (Primary Key)</label>
                <input type="text" name="user_telegram_id" value="{{ old('user_telegram_id') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                @error('user_telegram_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Contraseña de Misión</label>
                <input type="password" name="mission_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rol *</label>
                <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                    <option value="operator" {{ old('role') === 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('production.users.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Registrar</button>
            </div>
        </div>
    </form>
</div>
@endsection
