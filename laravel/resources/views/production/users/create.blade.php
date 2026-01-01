@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-100">Registrar Usuario Autorizado</h2>
        <p class="mt-2 text-gray-400">Agregar un nuevo operario de Telegram</p>
    </div>

    <form action="{{ route('production.users.store') }}" method="POST" class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-2xl">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Telegram ID * (Primary Key)</label>
                <input type="text" name="user_telegram_id" value="{{ old('user_telegram_id') }}" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                @error('user_telegram_id')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Contraseña de Misión</label>
                <input type="password" name="mission_password" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Rol *</label>
                <select name="role" required class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-3 py-2">
                    <option value="operator" {{ old('role') === 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('production.users.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 text-white rounded-lg qnt-gradient">Registrar</button>
            </div>
        </div>
    </form>
</div>
@endsection

