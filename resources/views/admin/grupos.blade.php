@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="icon ion-person-stalker text-indigo-600"></i>
                        Gestionar Grupos
                    </h1>
                    <p class="text-gray-500 mt-1">Organiza y administra los grupos de clases</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="card mb-8">
            <div class="card-header bg-gradient-to-r from-indigo-50 to-blue-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="icon ion-plus-circled"></i>
                    Nuevo Grupo
                </h2>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.grupos.save') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre Grupo -->
                        <div class="form-group">
                            <label for="nombre" class="form-label">
                                <i class="icon ion-android-people"></i>
                                Nombre del Grupo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" required
                                class="form-input @error('nombre') border-red-500 @enderror"
                                value="{{ old('nombre') }}"
                                placeholder="Ej: Grupo A1">
                            @error('nombre')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Horario -->
                        <div class="form-group">
                            <label for="horario_id" class="form-label">
                                <i class="icon ion-clock"></i>
                                Horario <span class="text-red-500">*</span>
                            </label>
                            <select name="horario_id" id="horario_id" required
                                class="form-select @error('horario_id') border-red-500 @enderror">
                                <option value="">-- Selecciona un horario --</option>
                                @foreach ($horarios as $horario)
                                    <option value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'selected' : '' }}>
                                        {{ $horario->materia->nombre }} - {{ substr($horario->hora_inicio, 0, 5) }} a {{ substr($horario->hora_fin, 0, 5) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('horario_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="icon ion-checkmark-circled"></i>
                            Crear Grupo
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-1 justify-center">
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
                    Grupos Registrados
                </h2>
                <div class="text-sm text-gray-500">
                    Total: <span class="font-bold text-indigo-600">{{ $grupos->count() }}</span>
                </div>
            </div>

            @if ($grupos->count() > 0)
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Materia</th>
                                    <th>Maestro</th>
                                    <th>Horario</th>
                                    <th style="width: 20%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupos as $grupo)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">{{ $grupo->nombre }}</span>
                                        </td>
                                        <td class="font-medium">{{ $grupo->horario->materia->nombre }}</td>
                                        <td>
                                            <span class="text-sm text-gray-700">
                                                {{ $grupo->horario->maestro->nombre ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-gray-700">
                                                {{ substr($grupo->horario->hora_inicio, 0, 5) }} - {{ substr($grupo->horario->hora_fin, 0, 5) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.grupos.edit', $grupo->id) }}" class="btn btn-primary btn-sm">
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
                </div>
            @else
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="font-bold text-gray-900 mb-2">No hay grupos registrados</h3>
                        <p class="text-gray-500 mb-6">Crea tu primer grupo usando el formulario anterior</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
