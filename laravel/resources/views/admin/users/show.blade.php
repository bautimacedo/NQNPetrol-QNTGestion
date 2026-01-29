@extends('layouts.app')

@section('page-title', $user->name)
@section('page-subtitle', 'Detalles del usuario web')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Usuario</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nombre</p>
                        <p class="text-gray-900 font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">DNI</p>
                        <p class="text-gray-900 font-medium">{{ $user->dni ? '***' . substr($user->dni, -4) : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Fecha de Nacimiento</p>
                        <p class="text-gray-900 font-medium">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Estado</p>
                        @if($user->is_approved)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Aprobado</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Registrado</p>
                        <p class="text-gray-900 font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Roles</h3>
                <div class="space-y-2">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            @if($role->name === 'admin')
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">Admin</span>
                            @elseif($role->name === 'operator')
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">Operador</span>
                            @elseif($role->name === 'pilot')
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">Piloto</span>
                            @else
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($role->name) }}</span>
                            @endif
                        @endforeach
                    @else
                        <span class="text-sm text-gray-500">Sin roles asignados</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

