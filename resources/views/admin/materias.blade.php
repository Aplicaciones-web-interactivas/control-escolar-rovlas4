@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="icon ion-document-text text-indigo-600"></i>
                        Gestionar Materias
                    </h1>
                    <p class="text-gray-500 mt-1">Crea, edita y administra todas las materias del sistema</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="card mb-8 hover-lift">
            <div class="card-header bg-gradient-to-r from-indigo-50 to-blue-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-plus-circled"></i>
                    Nueva Materia
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.materias.save') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="nombre" class="form-label">
                                Nombre de la Materia <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" required
                                class="form-input focus-ring @error('nombre') border-red-500 @enderror" 
                                value="{{ old('nombre') }}"
                                placeholder="Ej: Matemáticas">
                            @error('nombre')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="clave" class="form-label">
                                Clave de la Materia <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="clave" id="clave" required
                                class="form-input focus-ring @error('clave') border-red-500 @enderror" 
                                value="{{ old('clave') }}"
                                placeholder="Ej: MAT101">
                            @error('clave')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1 transition-colors">
                            <i class="icon ion-checkmark-circled"></i>
                            Crear Materia
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-1 justify-center transition-colors">
                            <i class="icon ion-close"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Section -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-list"></i>
                    Materias Registradas
                </h2>
                <div class="text-sm text-gray-500">
                    Total: <span class="font-bold text-indigo-600">{{ $materias->total() }}</span>
                </div>
            </div>

            @if ($materias->count() > 0)
                <div class="card-body">
                    @include('components.search-bar', ['search' => $search, 'placeholder' => 'Buscar por nombre o clave...'])
                    
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 15%">Clave</th>
                                    <th style="width: 50%">Nombre</th>
                                    <th style="width: 35%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materias as $materia)
                                    <tr class="transition-smooth hover:bg-indigo-50">
                                        <td>
                                            <span class="badge badge-primary">{{ strtoupper($materia->clave) }}</span>
                                        </td>
                                        <td class="font-medium">{{ $materia->nombre }}</td>
                                        <td>
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.materias.edit', $materia->id) }}" class="btn btn-primary btn-sm hover-lift">
                                                    <i class="icon ion-edit"></i>
                                                    Editar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $materias->links('components.pagination') }}
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="font-bold text-gray-900 mb-2">No hay materias registradas</h3>
                        <p class="text-gray-500 mb-6">Comienza creando una nueva materia usando el formulario anterior</p>
                        <a href="{{ route('admin.materias') }}" class="btn btn-primary hover-lift">
                            <i class="icon ion-plus"></i>
                            Crear Primera Materia
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

