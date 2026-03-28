@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materias') }}" class="text-indigo-600 hover:text-indigo-700">
                    <i class="icon ion-chevron-left text-2xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Materia</h1>
                    <p class="text-gray-500 mt-1">Modifica la información de la materia</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-header bg-gradient-to-r from-indigo-50 to-blue-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-edit"></i>
                    Actualizar Información
                </h2>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.materias.update', $materia->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nombre" class="form-label">
                            <i class="icon ion-ios-book"></i>
                            Nombre de la Materia <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" required
                            class="form-input @error('nombre') border-red-500 @enderror"
                            value="{{ old('nombre', $materia->nombre) }}"
                            placeholder="Ej: Matemáticas Avanzadas">
                        @error('nombre')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="clave" class="form-label">
                            <i class="icon ion-qr-scanner"></i>
                            Clave de la Materia <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="clave" id="clave" required
                            class="form-input @error('clave') border-red-500 @enderror"
                            value="{{ old('clave', $materia->clave) }}"
                            placeholder="Ej: MAT101">
                        @error('clave')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="text-sm text-blue-800">
                            <i class="icon ion-information"></i>
                            <strong>Información:</strong> Los cambios realizados se reflejarán inmediatamente en todo el sistema.
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="icon ion-checkmark-circled"></i>
                            Guardar Cambios
                        </button>
                        <a href="{{ route('admin.materias') }}" class="btn btn-secondary flex-1 justify-center">
                            <i class="icon ion-close"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card mt-8">
            <div class="card-header">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-information-circled"></i>
                    Detalles Actuales
                </h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">ID de Materia:</span>
                        <span class="font-medium text-gray-900">#{{ $materia->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">Nombre Actual:</span>
                        <span class="font-medium text-gray-900">{{ $materia->nombre }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Clave Actual:</span>
                        <span class="font-medium text-gray-900">{{ strtoupper($materia->clave) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
