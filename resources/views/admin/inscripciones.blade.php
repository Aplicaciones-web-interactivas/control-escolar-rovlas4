@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="icon ion-clipboard text-indigo-600"></i>
                        Gestionar Inscripciones
                    </h1>
                    <p class="text-gray-500 mt-1">Inscribe estudiantes en grupos y materias</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card mb-8 hover-lift">
            <div class="card-header bg-gradient-to-r from-indigo-50 to-blue-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-plus-circled"></i>
                    Nueva Inscripción
                </h2>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.inscripciones.save') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="grupo_id" class="form-label">
                                Grupo <span class="text-red-500">*</span>
                            </label>
                            <select name="grupo_id" id="grupo_id" required
                                class="form-select focus-ring @error('grupo_id') border-red-500 @enderror">
                                <option value="">Seleccionar grupo</option>
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre }} - {{ $grupo->horario->materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grupo_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="usuario_id" class="form-label">
                                Estudiante <span class="text-red-500">*</span>
                            </label>
                            <select name="usuario_id" id="usuario_id" required
                                class="form-select focus-ring @error('usuario_id') border-red-500 @enderror">
                                <option value="">Seleccionar estudiante</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>{{ $usuario->nombre }}</option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1 transition-colors">
                            <i class="icon ion-checkmark-circled"></i>
                            Crear Inscripción
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-1 justify-center transition-colors">
                            <i class="icon ion-close"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inscripciones Lista -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-list"></i>
                    Inscripciones Registradas
                </h2>
                <div class="text-sm text-gray-500">
                    Total: <span class="font-bold text-indigo-600">{{ $inscripciones->total() }}</span>
                </div>
            </div>

            @if ($inscripciones->count() > 0)
                <div class="card-body">
                    @include('components.search-bar', ['search' => $search, 'placeholder' => 'Buscar estudiante o materia...'])
                    
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Grupo</th>
                                    <th>Materia</th>
                                    <th style="width: 20%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscripciones as $inscripcion)
                                    <tr class="transition-smooth hover:bg-indigo-50">
                                        <td class="font-medium">{{ $inscripcion->usuario->nombre }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $inscripcion->grupo->nombre }}</span>
                                        </td>
                                        <td>{{ $inscripcion->grupo->horario->materia->nombre }}</td>
                                        <td>
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.inscripciones.edit', $inscripcion->id) }}" class="btn btn-primary btn-sm hover-lift">
                                                    <i class="icon ion-edit"></i>
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.inscripciones.delete', $inscripcion->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm hover-lift">
                                                        <i class="icon ion-trash-a"></i>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $inscripciones->links('components.pagination') }}
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="font-bold text-gray-900 mb-2">No hay inscripciones registradas</h3>
                        <p class="text-gray-500 mb-6">Comienza creando una inscripción usando el formulario anterior</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
