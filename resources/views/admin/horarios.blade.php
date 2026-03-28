@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="icon ion-clock text-indigo-600"></i>
                        Gestionar Horarios
                    </h1>
                    <p class="text-gray-500 mt-1">Asigna horarios a materias y maestros</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="card mb-8 hover-lift">
            <div class="card-header bg-gradient-to-r from-indigo-50 to-blue-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-plus-circled"></i>
                    Nuevo Horario
                </h2>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.horarios.save') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Materia -->
                        <div class="form-group">
                            <label for="materia_id" class="form-label">
                                Materia <span class="text-red-500">*</span>
                            </label>
                            <select name="materia_id" id="materia_id" required
                                class="form-select focus-ring @error('materia_id') border-red-500 @enderror">
                                <option value="">-- Selecciona una materia --</option>
                                @foreach ($materias as $materia)
                                    <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->nombre }} ({{ strtoupper($materia->clave) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('materia_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Maestro -->
                        <div class="form-group">
                            <label for="maestro_id" class="form-label">
                                Maestro <span class="text-red-500">*</span>
                            </label>
                            <select name="maestro_id" id="maestro_id" required
                                class="form-select focus-ring @error('maestro_id') border-red-500 @enderror">
                                <option value="">-- Selecciona un maestro --</option>
                                @foreach ($maestros as $maestro)
                                    <option value="{{ $maestro->id }}" {{ old('maestro_id') == $maestro->id ? 'selected' : '' }}>
                                        {{ $maestro->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('maestro_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Hora Inicio -->
                        <div class="form-group">
                            <label for="hora_inicio" class="form-label">
                                Hora de Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="hora_inicio" id="hora_inicio" required
                                class="form-input focus-ring @error('hora_inicio') border-red-500 @enderror"
                                value="{{ old('hora_inicio') }}">
                            @error('hora_inicio')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Hora Fin -->
                        <div class="form-group">
                            <label for="hora_fin" class="form-label">
                                Hora de Fin <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="hora_fin" id="hora_fin" required
                                class="form-input focus-ring @error('hora_fin') border-red-500 @enderror"
                                value="{{ old('hora_fin') }}">
                            @error('hora_fin')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Días -->
                    <div>
                        <label class="form-label">
                            Días de la Semana <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                            @php
                                $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                $diasSeleccionados = old('dias') ? explode(',', old('dias')) : [];
                            @endphp
                            @foreach ($dias as $dia)
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition-smooth">
                                    <input type="checkbox" name="dias_arr[]" value="{{ $dia }}"
                                        {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}
                                        class="rounded">
                                    <span class="ml-2 text-sm text-gray-700 font-medium">{{ $dia }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1 transition-colors">
                            <i class="icon ion-checkmark-circled"></i>
                            Crear Horario
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-1 justify-center transition-colors">
                            <i class="icon ion-close"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Horarios List -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-list"></i>
                    Horarios Registrados
                </h2>
                <div class="text-sm text-gray-500">
                    Total: <span class="font-bold text-indigo-600">{{ $horarios->total() }}</span>
                </div>
            </div>

            @if ($horarios->count() > 0)
                <div class="card-body">
                    @include('components.search-bar', ['search' => $search, 'placeholder' => 'Buscar por materia o maestro...'])
                    
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Maestro</th>
                                    <th>Horario</th>
                                    <th>Días</th>
                                    <th style="width: 15%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($horarios as $horario)
                                    <tr class="transition-smooth hover:bg-indigo-50">
                                        <td class="font-medium">{{ $horario->materia->nombre }}</td>
                                        <td>{{ $horario->maestro->nombre }}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_fin, 0, 5) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach (explode(',', $horario->dias) as $dia)
                                                    <span class="badge badge-secondary">{{ substr($dia, 0, 2) }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.horarios.edit', $horario->id) }}" class="btn btn-primary btn-sm hover-lift">
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
                        {{ $horarios->links('components.pagination') }}
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="font-bold text-gray-900 mb-2">No hay horarios registrados</h3>
                        <p class="text-gray-500 mb-6">Crea horarios para materias y maestros usando el formulario anterior</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
