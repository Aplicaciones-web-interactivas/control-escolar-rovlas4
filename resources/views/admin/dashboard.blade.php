@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Panel de Control</h1>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Cantidad de Materias -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Materias Registradas</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $cantmaterias }}</p>
            </div>

            <!-- Cantidad de Horarios -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Horarios Registrados</h2>
                <p class="text-3xl font-bold text-green-600">{{ $canthorarios }}</p>
            </div>

            <!-- Cantidad de Grupos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Grupos Registrados</h2>
                <p class="text-3xl font-bold text-yellow-600">{{ $cantgrupos }}</p>
            </div>

            <!-- Cantidad de Calificaciones -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Calificaciones Registradas</h2>
                <p class="text-3xl font-bold text-black-600">{{ $cantcalificaciones }}</p>
            </div>
        </div>
    </div>
</div>
@endsection