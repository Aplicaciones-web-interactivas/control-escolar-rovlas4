@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestionar Materias</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Nueva Materia</h2>

            <form action="{{ route('admin.materias.save') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Materia</label>
                    <input type="text" name="nombre" id="nombre" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('nombre') }}">
                </div>

                <div>
                    <label for="clave" class="block text-sm font-medium text-gray-700">Clave de la Materia</label>
                    <input type="text" name="clave" id="clave" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('clave') }}">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    Crear Materia
                </button>
            </form>
        </div>

        <!-- Materias Lista -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Materias Registradas</h2>
            </div>

            @if ($materias->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">Clave</th>
                                <th class="px-6 py-3 text-left font-medium">Nombre</th>
                                <th class="px-6 py-3 text-left font-medium">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($materias as $materia)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $materia->clave }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $materia->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('admin.materias.edit', $materia->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay materias</h3>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection