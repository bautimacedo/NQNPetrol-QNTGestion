@extends('layouts.app')

@section('page-title', $site->name)
@section('page-subtitle', 'Detalles de la ubicación')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('sites.edit', $site) }}" class="px-6 py-2 text-sm font-medium text-white rounded-lg transition-colors" style="background-color: #6b7b39;" onmouseover="if(!this.disabled) this.style.backgroundColor='#5a6830'" onmouseout="if(!this.disabled) this.style.backgroundColor='#6b7b39'">Editar</a>
            @endhasrole
            <a href="{{ route('sites.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Volver</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Ubicación</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Nombre</p>
                        <p class="text-gray-900 font-medium">{{ $site->name }}</p>
                    </div>
                    @if($site->location_details)
                        <div>
                            <p class="text-sm text-gray-600">Detalles</p>
                            <p class="text-gray-900">{{ $site->location_details }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Creado</p>
                        <p class="text-gray-900 font-medium">{{ $site->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">RPAs Asociados</h3>
                <div class="space-y-4">
                    @if($site->drones->count() > 0)
                        @foreach($site->drones as $drone)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $drone->name }}</p>
                                    @if($drone->dock)
                                        <p class="text-xs text-gray-600">Dock: {{ $drone->dock }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('production.drones.show', $drone) }}" class="text-sm" style="color: #6b7b39;">Ver</a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No hay RPAs asociados a esta ubicación.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

