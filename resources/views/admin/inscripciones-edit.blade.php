@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Editar Inscripción</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form action="{{ route('admin.inscripciones.update', $inscripcion->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="grupo_id" class="block text-sm font-medium text-gray-700">Grupo</label>
                        <select name="grupo_id" id="grupo_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Seleccionar grupo</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ old('grupo_id', $inscripcion->grupo_id) == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }} - {{ $grupo->horario->materia->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('grupo_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="usuario_id" class="block text-sm font-medium text-gray-700">Estudiante</label>
                        <select name="usuario_id" id="usuario_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Seleccionar estudiante</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('usuario_id', $inscripcion->usuario_id) == $usuario->id ? 'selected' : '' }}>{{ $usuario->nombre }}</option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Actualizar Inscripción
                    </button>
                    <a href="{{ route('admin.inscripciones') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
