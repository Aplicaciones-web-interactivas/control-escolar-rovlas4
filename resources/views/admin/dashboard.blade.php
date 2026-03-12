@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Panel de Control</h1>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Manage Materias -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Gestionar Materias</h2>
                <a href="{{ route('admin.materias') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                    Ir a Materias
                </a>
            </div>

            <!-- Manage Horarios -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Gestionar Horarios</h2>
                <a href="{{ route('admin.horarios') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">
                    Ir a Horarios
                </a>
            </div>
        </div>
    </div>
</div>
@endsection