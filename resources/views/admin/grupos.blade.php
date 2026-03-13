@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestionar Grupos</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Nuevo Grupo</h2>

            <form action="{{ route('admin.grupos.save') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre Grupo -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Grupo</label>
                        <input type="text" name="nombre" id="nombre" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('nombre') }}">
                    </div>

                    <!-- Horario -->
                    <div>
                        <label for="horario_id" class="block text-sm font-medium text-gray-700">Horario</label>
                        <select name="horario_id" id="horario_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">-- Selecciona un horario --</option>
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'selected' : '' }}>
                                    {{ $horario->materia->nombre }} - {{ $horario->maestro->nombre }} ({{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_fin, 0, 5) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    Crear Grupo
                </button>
            </form>
        </div>

        <!-- Grupos List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Grupos Registrados</h2>
            </div>

            @if ($grupos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maestro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($grupos as $grupo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $grupo->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $grupo->horario->materia->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $grupo->horario->maestro->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ substr($grupo->horario->hora_inicio, 0, 5) }} - {{ substr($grupo->horario->hora_fin, 0, 5) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('admin.grupos.edit', $grupo->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <h3 class="mt-2 text-sm text-gray-900">No hay grupos</h3>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
