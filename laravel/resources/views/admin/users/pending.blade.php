@extends('layouts.app')

@section('content')
<div class="space-y-6" style="background-color: #0F172A;">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold" style="color: #FFFFFF;">Usuarios Pendientes de Aprobación</h2>
            <p class="mt-2" style="color: rgba(255, 255, 255, 0.6);">Revisa y aprueba las solicitudes de acceso de nuevos usuarios</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg" style="background-color: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3);">
            <p style="color: #4ade80;">{{ session('success') }}</p>
        </div>
    @endif

    @if($pendingUsers->isEmpty())
        <div class="rounded-lg border p-12 text-center" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <svg class="mx-auto h-12 w-12 mb-4" style="color: rgba(255, 255, 255, 0.4);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-lg font-medium" style="color: rgba(255, 255, 255, 0.7);">No hay usuarios pendientes de aprobación</p>
            <p class="mt-2 text-sm" style="color: rgba(255, 255, 255, 0.5);">Todos los usuarios han sido revisados</p>
        </div>
    @else
        <div class="rounded-lg border overflow-hidden" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead style="background-color: rgba(255, 255, 255, 0.08);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Fecha de Nacimiento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Fecha de Registro</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(255, 255, 255, 0.1);">
                        @foreach($pendingUsers as $user)
                            <tr class="hover:bg-opacity-10" style="background-color: rgba(255, 255, 255, 0.02);">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium" style="color: #FFFFFF;">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="text-xs" style="color: rgba(255, 255, 255, 0.5);">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm" style="color: rgba(255, 255, 255, 0.8);">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm" style="color: rgba(255, 255, 255, 0.7);">
                                        {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm" style="color: rgba(255, 255, 255, 0.7);">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors qnt-gradient">
                                                Aprobar
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas rechazar y eliminar a este usuario? Esta acción no se puede deshacer.');">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.3)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

