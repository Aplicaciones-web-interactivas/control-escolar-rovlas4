@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header with Greeting -->
        <div class="mb-12">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Bienvenido, {{ Auth::user()->nombre }}</h1>
                    <p class="text-gray-500 text-lg">Aquí está el resumen de tu institución educativa</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-12">
            <!-- Materias -->
            <div class="stat-card">
                <div class="stat-icon stat-blue">
                    <i class="icon ion-document-text"></i>
                </div>
                <div class="flex-1">
                    <div class="stat-value">{{ $cantmaterias }}</div>
                    <div class="stat-label">Materias</div>
                </div>
            </div>

            <!-- Horarios -->
            <div class="stat-card">
                <div class="stat-icon stat-green">
                    <i class="icon ion-clock"></i>
                </div>
                <div class="flex-1">
                    <div class="stat-value">{{ $canthorarios }}</div>
                    <div class="stat-label">Horarios</div>
                </div>
            </div>

            <!-- Grupos -->
            <div class="stat-card">
                <div class="stat-icon stat-amber">
                    <i class="icon ion-person-stalker"></i>
                </div>
                <div class="flex-1">
                    <div class="stat-value">{{ $cantgrupos }}</div>
                    <div class="stat-label">Grupos</div>
                </div>
            </div>

            <!-- Estudiantes -->
            <div class="stat-card">
                <div class="stat-icon stat-purple">
                    <i class="icon ion-person"></i>
                </div>
                <div class="flex-1">
                    <div class="stat-value">{{ $cantusuarios }}</div>
                    <div class="stat-label">Usuarios</div>
                </div>
            </div>

            <!-- Calificaciones -->
            <div class="stat-card">
                <div class="stat-icon stat-red">
                    <i class="icon ion-star"></i>
                </div>
                <div class="flex-1">
                    <div class="stat-value">{{ $cantcalificaciones }}</div>
                    <div class="stat-label">Calificaciones</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Info Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="icon ion-information-circled" style="font-size: 20px;"></i>
                        Estado del Sistema
                    </h2>
                </div>
                <div class="card-body">
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="font-medium text-gray-900">Sistema:</span>
                            <span class="badge badge-primary">Control Escolar v1.0</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <span class="font-medium text-gray-900">Estado:</span>
                            <span class="badge badge-success">En línea ✓</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                            <span class="font-medium text-gray-900">Usuarios en línea:</span>
                            <span class="badge badge-purple">{{ $sesionesActivas }}</span>
                        </div>
                        <div class="mt-4 p-3 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-indigo-200">
                            <div class="text-xs text-indigo-700">
                                <!-- CONFIGURAR TIMEZONE-->
                                @php
                                    date_default_timezone_set('America/Mexico_City');
                                @endphp
                                <strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
