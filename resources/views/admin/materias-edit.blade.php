@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Editar Materia</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Actualizar Materia</h2>

            <form action="{{ route('admin.materias.update', $materia->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Materia</label>
                    <input type="text" name="nombre" id="nombre" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('nombre', $materia->nombre) }}">
                </div>

                <div>
                    <label for="clave" class="block text-sm font-medium text-gray-700">Clave de la Materia</label>
                    <input type="text" name="clave" id="clave" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('clave', $materia->clave) }}">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        Actualizar Materia
                    </button>
                    <a href="{{ route('admin.materias') }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 px-4 rounded-md transition-colors text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
