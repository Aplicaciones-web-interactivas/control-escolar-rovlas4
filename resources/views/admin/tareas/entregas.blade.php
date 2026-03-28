@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('tareas.maestro') }}" class="text-blue-600 hover:text-blue-800 mb-4">← Volver a mis tareas</a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $tarea->titulo }}</h1>
            <p class="text-gray-600 mt-2">Entregas para la tarea</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Descripción</h2>
            <p class="text-gray-700 mb-4">{{ $tarea->descripcion }}</p>
            <div class="flex items-center gap-6 text-sm text-gray-600">
                <span><i class="icon ion-calendar"></i> Fecha de entrega: {{ $tarea->fecha_entrega->format('d/m/Y H:i') }}</span>
                <span><i class="icon ion-book"></i> Grupo: {{ $tarea->grupo->nombre }}</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Entregas de los Alumnos</h2>
            
            @if ($entregas->isEmpty())
                <p class="text-gray-500 text-center py-6">Aún no hay entregas</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Alumno</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Fecha Entrega</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entregas as $entrega)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 text-gray-800">{{ $entrega->usuario->nombre }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('entregas.download', $entrega->id) }}" 
                                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Descargar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
