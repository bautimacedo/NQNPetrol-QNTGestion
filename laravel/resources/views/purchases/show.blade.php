@extends('layouts.app')

@section('page-title', 'Compra #' . $purchase->id)
@section('page-subtitle', $purchase->description)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="flex space-x-3">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('purchases.edit', $purchase) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                        Editar
                    </a>
                    <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta compra?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Eliminar
                        </button>
                    </form>
                @endif
            @endauth
            <a href="{{ route('purchases.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Volver
            </a>
        </div>
    </div>

    <!-- Información General -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Información General</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Proveedor</p>
                <p class="text-lg font-medium text-gray-900">{{ $purchase->provider->name }}</p>
                @if($purchase->provider->email)
                    <p class="text-sm text-gray-500 mt-1">{{ $purchase->provider->email }}</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-600">Monto Total</p>
                <p class="text-lg font-medium text-gray-900">{{ $purchase->currency }} {{ number_format($purchase->total_amount, 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Estado</p>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'authorized' => 'bg-blue-100 text-blue-800',
                        'paid' => 'bg-green-100 text-green-800',
                        'canceled' => 'bg-red-100 text-red-800',
                    ];
                    $statusLabels = [
                        'pending' => 'Pendiente',
                        'authorized' => 'Autorizada',
                        'paid' => 'Pagada',
                        'canceled' => 'Cancelada',
                    ];
                @endphp
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $statusColors[$purchase->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$purchase->status] ?? $purchase->status }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-600">Progreso de Documentación</p>
                <div class="flex items-center space-x-2 mt-1">
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div class="h-3 rounded-full transition-all" style="background-color: #6b7b39; width: {{ $progress['percentage'] }}%;"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">{{ $progress['percentage'] }}%</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $progress['completed'] }} de {{ $progress['total'] }} documentos</p>
            </div>
        </div>
    </div>

    <!-- Timeline Horizontal Superior -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Progreso de Documentación</h3>
        
        <!-- Timeline Visual Horizontal -->
        <div class="relative">
            <!-- Línea del timeline -->
            <div class="absolute top-8 left-0 right-0 h-1 bg-gray-200"></div>
            
            @php
                $timelineSteps = [
                    'budget_pdf' => ['label' => 'Presupuesto', 'order' => 1],
                    'purchase_order' => ['label' => 'OC', 'order' => 2],
                    'invoice' => ['label' => 'Factura', 'order' => 3],
                    'payment_order' => ['label' => 'OP', 'order' => 4],
                    'payment_proof' => ['label' => 'Pago', 'order' => 5],
                ];
                $sortedSteps = collect($timelineSteps)->sortBy('order');
            @endphp
            
            <div class="flex items-center justify-between relative">
                @foreach($sortedSteps as $type => $step)
                    @php
                        $document = $purchase->getDocument($type);
                        $hasDocument = $document !== null;
                        $isCompleted = $hasDocument;
                    @endphp
                    <div class="flex flex-col items-center relative z-10 flex-1">
                        <!-- Círculo del paso -->
                        <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 {{ $isCompleted ? 'bg-[#6b7b39] border-[#6b7b39]' : 'bg-white border-gray-300' }}">
                            @if($isCompleted)
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                            @endif
                        </div>
                        <!-- Etiqueta -->
                        <p class="mt-3 text-xs font-medium text-center {{ $isCompleted ? 'text-[#6b7b39] font-bold' : 'text-gray-500' }}">
                            {{ $step['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Timeline de Documentos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Documentación Detallada</h3>
        
        <!-- Lista Detallada de Documentos -->
        <div class="space-y-4">
            @foreach($documentTypes as $type => $label)
                @php
                    $document = $purchase->getDocument($type);
                    $hasDocument = $document !== null;
                @endphp
                <div class="flex items-center space-x-4 p-4 rounded-lg {{ $hasDocument ? 'bg-gray-50 border border-gray-200' : 'bg-white border border-gray-200' }}">
                    <!-- Indicador de estado -->
                    <div class="flex-shrink-0">
                        @if($hasDocument)
                            <div class="w-4 h-4 rounded-full" style="background-color: #6b7b39;"></div>
                        @else
                            <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                        @endif
                    </div>
                    
                    <!-- Nombre del documento -->
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900">{{ $label }}</h4>
                        @if($hasDocument && $document->document_number)
                            <p class="text-xs text-gray-600 mt-1">N° {{ $document->document_number }}</p>
                        @endif
                        @if($hasDocument)
                            <p class="text-xs text-gray-500 mt-1">Subido: {{ $document->created_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex-shrink-0">
                        @if($hasDocument)
                            <div class="flex space-x-2">
                                <a href="{{ route('purchases.download-document', [$purchase, $document]) }}" target="_blank" class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                                    Ver PDF
                                </a>
                                @auth
                                    @if(auth()->user()->hasRole('admin'))
                                        <form action="{{ route('purchases.delete-document', [$purchase, $document]) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este documento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @else
                            @auth
                                @if(auth()->user()->hasRole('admin'))
                                    <button onclick="openUploadModal('{{ $type }}', '{{ $label }}')" class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                                        Subir PDF
                                    </button>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal para subir documento -->
@auth
    @if(auth()->user()->hasRole('admin'))
        <div id="uploadModal" class="fixed inset-0 z-50 hidden">
            <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeUploadModal()"></div>
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 max-w-md w-full">
                    <h3 class="text-xl font-bold text-gray-900 mb-4" id="modalTitle">Subir Documento</h3>
                    <form id="uploadForm" action="{{ route('purchases.upload-document', $purchase) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" id="documentType">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Documento (Opcional)</label>
                            <input type="text" name="document_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Archivo PDF</label>
                            <input type="file" name="document" accept=".pdf" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6b7b39] focus:border-[#6b7b39] transition-colors">
                            <p class="text-xs text-gray-500 mt-1">Tamaño máximo: 10MB</p>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeUploadModal()" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">
                                Subir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openUploadModal(type, label) {
                document.getElementById('documentType').value = type;
                document.getElementById('modalTitle').textContent = 'Subir: ' + label;
                document.getElementById('uploadModal').classList.remove('hidden');
            }

            function closeUploadModal() {
                document.getElementById('uploadModal').classList.add('hidden');
                document.getElementById('uploadForm').reset();
            }
        </script>
    @endif
@endauth
@endsection
