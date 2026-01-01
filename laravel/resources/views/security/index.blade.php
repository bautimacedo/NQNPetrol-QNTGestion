@extends('layouts.app')

@section('content')
<div class="space-y-6" style="background-color: #0F172A;">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold" style="color: #FFFFFF;">Panel de Seguridad</h2>
            <p class="mt-2" style="color: rgba(255, 255, 255, 0.6);">Gestión de intentos de login e IPs bloqueadas</p>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-lg border p-6" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <p class="text-sm font-medium mb-2" style="color: rgba(255, 255, 255, 0.6);">Total de Intentos</p>
            <p class="text-3xl font-bold" style="color: #FFFFFF;">{{ $stats['total_attempts'] }}</p>
        </div>
        <div class="rounded-lg border p-6" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <p class="text-sm font-medium mb-2" style="color: rgba(255, 255, 255, 0.6);">Logins Exitosos</p>
            <p class="text-3xl font-bold" style="color: #4ade80;">{{ $stats['successful_logins'] }}</p>
        </div>
        <div class="rounded-lg border p-6" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <p class="text-sm font-medium mb-2" style="color: rgba(255, 255, 255, 0.6);">Logins Fallidos</p>
            <p class="text-3xl font-bold" style="color: #f87171;">{{ $stats['failed_logins'] }}</p>
        </div>
        <div class="rounded-lg border p-6" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <p class="text-sm font-medium mb-2" style="color: rgba(255, 255, 255, 0.6);">IPs Bloqueadas</p>
            <p class="text-3xl font-bold" style="color: #fbbf24;">{{ $stats['blocked_ips_count'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Historial de Intentos de Login -->
        <div class="rounded-lg border overflow-hidden" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <div class="p-6 border-b" style="border-color: rgba(255, 255, 255, 0.1);">
                <h3 class="text-lg font-semibold" style="color: #FFFFFF;">Historial de Intentos de Login</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead style="background-color: rgba(255, 255, 255, 0.08);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">IP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(255, 255, 255, 0.1);">
                        @forelse($loginLogs as $log)
                            <tr class="hover:bg-opacity-10" style="background-color: rgba(255, 255, 255, 0.02);">
                                <td class="px-6 py-4 text-sm" style="color: #FFFFFF;">{{ $log->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-mono" style="color: rgba(255, 255, 255, 0.8);">{{ $log->ip_address }}</td>
                                <td class="px-6 py-4">
                                    @if($log->success)
                                        <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(34, 197, 94, 0.2); color: #4ade80;">Exitoso</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;">Fallido</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm" style="color: rgba(255, 255, 255, 0.7);">{{ $log->attempted_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center" style="color: rgba(255, 255, 255, 0.5);">No hay registros de login.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
                {{ $loginLogs->links() }}
            </div>
        </div>

        <!-- IPs Bloqueadas -->
        <div class="rounded-lg border overflow-hidden" style="background-color: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
            <div class="p-6 border-b" style="border-color: rgba(255, 255, 255, 0.1);">
                <h3 class="text-lg font-semibold" style="color: #FFFFFF;">IPs Bloqueadas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead style="background-color: rgba(255, 255, 255, 0.08);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">IP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Razón</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Bloqueada</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase" style="color: rgba(255, 255, 255, 0.6);">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(255, 255, 255, 0.1);">
                        @forelse($blockedIps as $blocked)
                            <tr class="hover:bg-opacity-10" style="background-color: rgba(255, 255, 255, 0.02);">
                                <td class="px-6 py-4 text-sm font-mono font-bold" style="color: #f87171;">{{ $blocked->ip_address }}</td>
                                <td class="px-6 py-4 text-sm" style="color: rgba(255, 255, 255, 0.8);">{{ $blocked->reason }}</td>
                                <td class="px-6 py-4 text-sm" style="color: rgba(255, 255, 255, 0.7);">{{ $blocked->blocked_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('security.unblock', $blocked->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="px-4 py-2 text-sm rounded-lg transition-colors" style="background-color: rgba(34, 197, 94, 0.2); color: #4ade80;" onmouseover="this.style.backgroundColor='rgba(34, 197, 94, 0.3)'" onmouseout="this.style.backgroundColor='rgba(34, 197, 94, 0.2)'">
                                            Desbloquear
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center" style="color: rgba(255, 255, 255, 0.5);">No hay IPs bloqueadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

