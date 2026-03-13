@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Editar Grupo</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Actualizar Grupo</h2>

            <form action="{{ route('admin.grupos.update', $grupo->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre Grupo -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Grupo</label>
                        <input type="text" name="nombre" id="nombre" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('nombre', $grupo->nombre) }}">
                    </div>

                    <!-- Horario -->
                    <div>
                        <label for="horario_id" class="block text-sm font-medium text-gray-700">Horario</label>
                        <select name="horario_id" id="horario_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">-- Selecciona un horario --</option>
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->id }}" {{ old('horario_id', $grupo->horario_id) == $horario->id ? 'selected' : '' }}>
                                    {{ $horario->materia->nombre }} - {{ $horario->maestro->nombre }} ({{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_fin, 0, 5) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Actualizar Grupo
                    </button>
                    <a href="{{ route('admin.grupos') }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 px-4 rounded-md transition-colors text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
