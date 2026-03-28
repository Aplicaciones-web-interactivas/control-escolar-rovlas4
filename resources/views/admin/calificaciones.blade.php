@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="icon ion-star text-indigo-600"></i>
                        Gestionar Calificaciones
                    </h1>
                    <p class="text-gray-500 mt-1">Registra y edita calificaciones de estudiantes</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card mb-8 hover-lift">
            <div class="card-header bg-gradient-to-r from-indigo-50 to-blue-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-plus-circled"></i>
                    Nueva Calificación
                </h2>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.calificaciones.save') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                            </select>
                            @error('usuario_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="calificacion" class="form-label">
                                Calificación (0-100) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="calificacion" id="calificacion" required min="0" max="100" step="1"
                                class="form-input focus-ring @error('calificacion') border-red-500 @enderror" 
                                value="{{ old('calificacion') }}"
                                placeholder="Ej: 95">
                            @error('calificacion')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1 transition-colors">
                            <i class="icon ion-checkmark-circled"></i>
                            Crear Calificación
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-1 justify-center transition-colors">
                            <i class="icon ion-close"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Calificaciones Lista -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-list"></i>
                    Calificaciones Registradas
                </h2>
                <div class="text-sm text-gray-500">
                    Total: <span class="font-bold text-indigo-600">{{ $calificaciones->total() }}</span>
                </div>
            </div>

            @if ($calificaciones->count() > 0)
                <div class="card-body">
                    @include('components.search-bar', ['search' => $search, 'placeholder' => 'Buscar estudiante, grupo o materia...'])
                    
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Grupo</th>
                                    <th>Materia</th>
                                    <th>Maestro</th>
                                    <th style="width: 12%">Calificación</th>
                                    <th style="width: 15%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($calificaciones as $calif)
                                    <tr class="transition-smooth hover:bg-indigo-50">
                                        <td class="font-medium">{{ $calif->usuario->nombre }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $calif->grupo->nombre }}</span>
                                        </td>
                                        <td>{{ $calif->grupo->horario->materia->nombre }}</td>
                                        <td>{{ $calif->grupo->horario->maestro->nombre }}</td>
                                        <td class="text-center">
                                            <span class="inline-block px-3 py-1 rounded-full text-white font-bold text-sm"
                                                style="background-color: {{ $calif->calificacion >= 80 ? '#10b981' : ($calif->calificacion >= 60 ? '#f59e0b' : '#ef4444') }}">
                                                {{ number_format($calif->calificacion) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.calificaciones.edit', $calif->id) }}" class="btn btn-primary btn-sm hover-lift">
                                                <i class="icon ion-edit"></i>
                                                Editar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $calificaciones->links('components.pagination') }}
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="font-bold text-gray-900 mb-2">No hay calificaciones registradas</h3>
                        <p class="text-gray-500 mb-6">Comienza registrando una calificación usando el formulario anterior</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Cargar estudiantes del grupo seleccionado
    document.getElementById('grupo_id').addEventListener('change', function() {
        const grupoId = this.value;
        const estudianteSelect = document.getElementById('usuario_id');

        if (!grupoId) {
            estudianteSelect.innerHTML = '<option value="">Seleccionar grupo primero</option>';
            return;
        }

        // Mostrar loading
        estudianteSelect.innerHTML = '<option value="">Cargando...</option>';
        estudianteSelect.disabled = true;

        fetch(`/admin/inscripciones/grupo/${grupoId}`)
            .then(response => response.json())
            .then(data => {
                estudianteSelect.innerHTML = '<option value="">Seleccionar estudiante</option>';
                data.forEach(estudiante => {
                    const option = document.createElement('option');
                    option.value = estudiante.id;
                    option.textContent = estudiante.nombre;
                    estudianteSelect.appendChild(option);
                });
                estudianteSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                estudianteSelect.innerHTML = '<option value="">Error al cargar</option>';
                Toast?.error('Error al cargar estudiantes');
            });
    });
</script>

@endsection
