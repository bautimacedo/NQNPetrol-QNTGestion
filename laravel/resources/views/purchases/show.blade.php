@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-100">Compra #{{ $purchase->id }}</h2>
            <p class="mt-2 text-gray-400">{{ $purchase->description }}</p>
        </div>
        <div class="flex space-x-3">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('purchases.edit', $purchase) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                        Editar
                    </a>
                    <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta compra?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.3)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'">
                            Eliminar
                        </button>
                    </form>
                @endif
            @endauth
            <a href="{{ route('purchases.index') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors text-gray-300 hover:text-white" style="border: 1px solid rgba(255, 255, 255, 0.2);">
                Volver
            </a>
        </div>
    </div>

    <!-- Información General -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <h3 class="text-xl font-bold text-gray-100 mb-4">Información General</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-400">Proveedor</p>
                <p class="text-lg font-medium text-gray-100">{{ $purchase->provider->name }}</p>
                @if($purchase->provider->contact_email)
                    <p class="text-sm text-gray-400 mt-1">{{ $purchase->provider->contact_email }}</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-400">Monto Total</p>
                <p class="text-lg font-medium text-gray-100">{{ $purchase->currency }} {{ number_format($purchase->total_amount, 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-400">Estado</p>
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
                <span class="px-3 py-1 text-sm font-medium rounded {{ $statusColors[$purchase->status] ?? 'bg-gray-500/20 text-gray-400' }}">
                    {{ $statusLabels[$purchase->status] ?? $purchase->status }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-400">Progreso de Documentación</p>
                <div class="flex items-center space-x-2 mt-1">
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="h-3 rounded-full transition-all" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); width: {{ $progress['percentage'] }}%;"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-100">{{ $progress['percentage'] }}%</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ $progress['completed'] }} de {{ $progress['total'] }} documentos</p>
            </div>
        </div>
    </div>

    <!-- Timeline de Documentos -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <h3 class="text-xl font-bold text-gray-100 mb-6">Documentación</h3>
        
        <div class="space-y-4">
            @foreach($documentTypes as $type => $label)
                @php
                    $document = $purchase->getDocument($type);
                    $hasDocument = $document !== null;
                @endphp
                <div class="flex items-center space-x-4 p-4 rounded-lg {{ $hasDocument ? 'bg-gray-700/50' : 'bg-gray-900/50' }} border border-gray-700">
                    <!-- Indicador de estado -->
                    <div class="flex-shrink-0">
                        @if($hasDocument)
                            <div class="w-3 h-3 rounded-full" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%);"></div>
                        @else
                            <div class="w-3 h-3 rounded-full bg-gray-600"></div>
                        @endif
                    </div>
                    
                    <!-- Nombre del documento -->
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-100">{{ $label }}</h4>
                        @if($hasDocument && $document->document_number)
                            <p class="text-xs text-gray-400 mt-1">N° {{ $document->document_number }}</p>
                        @endif
                        @if($hasDocument)
                            <p class="text-xs text-gray-400 mt-1">Subido: {{ $document->created_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex-shrink-0">
                        @if($hasDocument)
                            <div class="flex space-x-2">
                                <a href="{{ route('purchases.download-document', [$purchase, $document]) }}" target="_blank" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
                                    Ver PDF
                                </a>
                                @auth
                                    @if(auth()->user()->hasRole('admin'))
                                        <form action="{{ route('purchases.delete-document', [$purchase, $document]) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este documento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors" style="background-color: rgba(239, 68, 68, 0.2); color: #f87171;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.3)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @else
                            @auth
                                @if(auth()->user()->hasRole('admin'))
                                    <button onclick="openUploadModal('{{ $type }}', '{{ $label }}')" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
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
                <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 max-w-md w-full" style="background-color: #1F2937;">
                    <h3 class="text-xl font-bold text-gray-100 mb-4" id="modalTitle">Subir Documento</h3>
                    <form id="uploadForm" action="{{ route('purchases.upload-document', $purchase) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" id="documentType">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Número de Documento (Opcional)</label>
                            <input type="text" name="document_number" class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Archivo PDF</label>
                            <input type="file" name="document" accept=".pdf" required class="w-full px-3 py-2 rounded-lg border border-gray-600 bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <p class="text-xs text-gray-400 mt-1">Tamaño máximo: 10MB</p>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeUploadModal()" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:text-white" style="border: 1px solid rgba(255, 255, 255, 0.2);">
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors" style="background: linear-gradient(135deg, #082032 0%, #1B998B 100%); color: #FFFFFF;">
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

