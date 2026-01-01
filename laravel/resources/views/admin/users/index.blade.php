@extends('layouts.app')

@section('content')
<div class="space-y-6" style="background-color: #0F172A;">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold" style="color: #FFFFFF;">Gestión de Usuarios</h2>
            <p class="mt-2" style="color: rgba(255, 255, 255, 0.6);">Administra usuarios, roles y aprobaciones del sistema</p>
        </div>
        <a href="{{ route('admin.users.pending') }}" class="px-4 py-2 text-white rounded-lg font-medium transition-colors qnt-gradient">
            Ver Pendientes
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg" style="background-color: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3);">
            <p style="color: #4ade80;">{{ session('success') }}</p>
        </div>
    @endif

    <div class="rounded-lg border overflow-hidden" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead style="background-color: rgba(255, 255, 255, 0.08);">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">DNI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Rol Actual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: rgba(255, 255, 255, 0.1);">
                    @forelse($users as $user)
                        <tr class="hover:bg-opacity-10" style="background-color: rgba(255, 255, 255, 0.02);">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium" style="color: #FFFFFF;">{{ $user->first_name }} {{ $user->last_name }}</div>
                                <div class="text-xs" style="color: rgba(255, 255, 255, 0.5);">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm" style="color: rgba(255, 255, 255, 0.8);">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-mono" style="color: rgba(255, 255, 255, 0.7);">
                                    {{ $user->dni ? '***' . substr($user->dni, -4) : 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        @if($role->name === 'admin')
                                            <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;">Admin</span>
                                        @elseif($role->name === 'operator')
                                            <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(34, 197, 94, 0.2); color: #4ade80;">Operador</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(255, 255, 255, 0.1); color: rgba(255, 255, 255, 0.7);">{{ $role->name }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(251, 191, 36, 0.2); color: #fbbf24;">Sin rol</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_approved)
                                    <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(34, 197, 94, 0.2); color: #4ade80;">Aprobado</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(251, 191, 36, 0.2); color: #fbbf24;">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @if(!$user->is_approved)
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-xs rounded-lg font-medium transition-colors qnt-gradient">
                                                Aprobar como Operador
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(!$user->hasRole('admin'))
                                        <form action="{{ route('admin.users.makeAdmin', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-xs rounded-lg font-medium transition-colors" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.3)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'">
                                                Hacer Administrador
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center" style="color: rgba(255, 255, 255, 0.5);">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

