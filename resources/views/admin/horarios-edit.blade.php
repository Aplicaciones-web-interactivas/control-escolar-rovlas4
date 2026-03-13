@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Editar Horario</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Actualizar Horario</h2>

            <form action="{{ route('admin.horarios.update', $horario->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Materia -->
                    <div>
                        <label for="materia_id" class="block text-sm font-medium text-gray-700">Materia</label>
                        <select name="materia_id" id="materia_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">-- Selecciona una materia --</option>
                            @foreach ($materias as $materia)
                                <option value="{{ $materia->id }}" {{ old('materia_id', $horario->materia_id) == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->nombre }} ({{ $materia->clave }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Maestro -->
                    <div>
                        <label for="maestro_id" class="block text-sm font-medium text-gray-700">Maestro</label>
                        <select name="maestro_id" id="maestro_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">-- Selecciona un maestro --</option>
                            @foreach ($maestros as $maestro)
                                <option value="{{ $maestro->id }}" {{ old('maestro_id', $horario->maestro_id) == $maestro->id ? 'selected' : '' }}>
                                    {{ $maestro->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Hora Inicio -->
                    <div>
                        <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            value="{{ old('hora_inicio', $horario->hora_inicio) }}">
                    </div>

                    <!-- Hora Fin -->
                    <div>
                        <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                        <input type="time" name="hora_fin" id="hora_fin" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            value="{{ old('hora_fin', $horario->hora_fin) }}">
                    </div>
                </div>

                <!-- Días -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Días de la Semana</label>
                    <div class="space-y-2">
                        @php
                            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $diasSeleccionados = old('dias_arr') ? old('dias_arr') : explode(',', $horario->dias);
                        @endphp
                        @foreach ($dias as $dia)
                            <label class="flex items-center">
                                <input type="checkbox" name="dias_arr[]" value="{{ $dia }}"
                                    {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-offset-0 focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $dia }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Actualizar Horario
                    </button>
                    <a href="{{ route('admin.horarios') }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 px-4 rounded-md transition-colors text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
