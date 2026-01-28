@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Gestión de Compras</h2>
            <p class="mt-2 text-gray-400">Visualización y gestión de compras y documentación</p>
        </div>
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('purchases.create') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                    Nueva Compra
                </a>
            @endif
        @endauth
    </div>

    <!-- Tabla de Compras -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Proveedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Documentación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($purchases as $purchase)
                        @php
                            $progress = $purchase->getDocumentationProgress();
                            $isComplete = $purchase->isDocumentationComplete();
                        @endphp
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">#{{ $purchase->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-100">{{ $purchase->provider->name }}</div>
                                @if($purchase->provider->contact_email)
                                    <div class="text-xs text-gray-400">{{ $purchase->provider->contact_email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-100">{{ Str::limit($purchase->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-100">
                                    {{ $purchase->currency }} {{ number_format($purchase->total_amount, 2, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-500/20 text-yellow-400',
                                        'authorized' => 'bg-blue-500/20 text-blue-400',
                                        'paid' => 'bg-green-500/20 text-green-400',
                                        'canceled' => 'bg-red-500/20 text-red-400',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pendiente',
                                        'authorized' => 'Autorizada',
                                        'paid' => 'Pagada',
                                        'canceled' => 'Cancelada',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $statusColors[$purchase->status] ?? 'bg-gray-500/20 text-gray-400' }}">
                                    {{ $statusLabels[$purchase->status] ?? $purchase->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 bg-gray-700 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); width: {{ $progress['percentage'] }}%;"></div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $progress['completed'] }}/{{ $progress['total'] }}</span>
                                    @if($isComplete)
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-400">Completa</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-500/20 text-yellow-400">Incompleta</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('purchases.show', $purchase) }}" class="px-3 py-1 text-sm font-medium rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">No hay compras registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

