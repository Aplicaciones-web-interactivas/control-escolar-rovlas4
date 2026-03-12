<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Control Escolar</title>
</head>
<body class="bg-gray-100">
    <nav class="fixed top-0 left-0 w-full bg-red-800 shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-lg font-bold transition">Control Escolar</a>
                    @auth
                        <a href="{{ route('admin.materias') }}" class="text-blue-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">Materias</a>
                    @endauth
                </div>
                
                @auth
                    <div class="flex items-center space-x-4">
                        <span class="text-blue-100 text-sm">{{ Auth::user()->nombre }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium transition">Cerrar Sesión</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-blue-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="pt-16">
        @yield('content')
    </div>

    <script>
        // Para funciones JavaScript si se necesita
    </script>
</body>
</html>