@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestionar Calificaciones</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Nueva Calificación</h2>

            <form action="{{ route('admin.calificaciones.save') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="grupo_id" class="block text-sm font-medium text-gray-700">Grupo</label>
                        <select name="grupo_id" id="grupo_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Seleccionar grupo</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }} - {{ $grupo->horario->materia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="usuario_id" class="block text-sm font-medium text-gray-700">Estudiante</label>
                        <select name="usuario_id" id="usuario_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Seleccionar grupo primero</option>
                        </select>
                    </div>

                    <div>
                        <label for="calificacion" class="block text-sm font-medium text-gray-700">Calificación (0-100)</label>
                        <input type="number" name="calificacion" id="calificacion" required min="0" max="100" step="1"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('calificacion') }}">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    Crear Calificación
                </button>
            </form>
        </div>

        <!-- Calificaciones Lista -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Calificaciones Registradas</h2>
            </div>

            @if ($calificaciones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">Estudiante</th>
                                <th class="px-6 py-3 text-left font-medium">Grupo</th>
                                <th class="px-6 py-3 text-left font-medium">Materia</th>
                                <th class="px-6 py-3 text-left font-medium">Maestro</th>
                                <th class="px-6 py-3 text-left font-medium">Calificación</th>
                                <th class="px-6 py-3 text-left font-medium">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($calificaciones as $calif)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $calif->usuario->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $calif->grupo->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $calif->grupo->horario->materia->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $calif->grupo->horario->maestro->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                            {{ number_format($calif->calificacion) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('admin.calificaciones.edit', $calif->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay calificaciones</h3>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('grupo_id').addEventListener('change', function() {
        const grupoId = this.value;
        const estudianteSelect = document.getElementById('usuario_id');

        if (!grupoId) {
            estudianteSelect.innerHTML = '<option value="">Seleccionar grupo primero</option>';
            return;
        }

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
            })
            .catch(error => console.error('Error:', error));
    });
</script>


                </div>
        </div>
    </div>
</div>

@endsection
