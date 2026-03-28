@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('tareas.alumno') }}" class="text-blue-600 hover:text-blue-800 mb-4">← Volver a mis tareas</a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $tarea->titulo }}</h1>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ $message }}
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ $message }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Descripción</h2>
            <p class="text-gray-700 mb-6">{{ $tarea->descripcion }}</p>
            
            <div class="grid md:grid-cols-3 gap-4 text-sm">
                <div class="bg-gray-50 p-4 rounded">
                    <span class="text-gray-600"><i class="icon ion-book"></i> Grupo</span>
                    <p class="text-lg font-semibold text-gray-900">{{ $tarea->grupo->nombre }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded">
                    <span class="text-gray-600"><i class="icon ion-person"></i> Maestro</span>
                    <p class="text-lg font-semibold text-gray-900">{{ $tarea->usuario->nombre }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded">
                    <span class="text-gray-600"><i class="icon ion-calendar"></i> Fecha de Entrega</span>
                    <p class="text-lg font-semibold text-gray-900">{{ $tarea->fecha_entrega->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Enviar Entrega</h2>
            
            @if ($entrega)
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-blue-900 font-semibold mb-2"><i class="icon ion-checkmark-round"></i> Archivo entregado</p>
                    <p class="text-blue-800 text-sm">Fecha de entrega: {{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</p>
                </div>
            @endif

            <form action="{{ route('entregas.store', $tarea->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Archivo PDF</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 cursor-pointer">
                        <input type="file" name="archivo" accept=".pdf" required 
                               class="hidden" id="archivo"
                               onchange="document.getElementById('nombreArchivo').innerText = this.files[0].name">
                        <label for="archivo" class="cursor-pointer">
                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v28a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="text-gray-600">Haz clic para seleccionar un PDF</p>
                            <p class="text-gray-500 text-sm">o arrastra un archivo aquí</p>
                        </label>
                    </div>
                    <p id="nombreArchivo" class="mt-2 text-sm text-gray-600"></p>
                    @error('archivo')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Enviar Entrega
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
