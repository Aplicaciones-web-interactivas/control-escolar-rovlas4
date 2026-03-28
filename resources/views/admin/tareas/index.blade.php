@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Mis Tareas</h1>
            <a href="{{ route('tareas.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Nueva Tarea
            </a>
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

        <div class="grid gap-4">
            @forelse ($tareas as $tarea)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $tarea->titulo }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($tarea->descripcion, 100) }}</p>
                            <div class="flex items-center gap-6 text-sm text-gray-600">
                                <span><i class="icon ion-book"></i> Grupo: {{ $tarea->grupo->nombre }}</span>
                                <span><i class="icon ion-calendar"></i> Entrega: {{ $tarea->fecha_entrega->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('tareas.entregas', $tarea->id) }}" 
                           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                            Ver Entregas
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">No tienes tareas creadas aún.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
