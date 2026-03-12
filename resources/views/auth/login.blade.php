<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Tabs Header -->
            <div class="flex border-b border-gray-200">
                <button onclick="showTab('login')" id="login-tab" 
                    class="flex-1 py-4 px-4 text-center font-medium text-blue-600 border-b-2 border-blue-600 tab-btn active">
                    Iniciar Sesión
                </button>
                <button onclick="showTab('registro')" id="registro-tab"
                    class="flex-1 py-4 px-4 text-center font-medium text-gray-500 border-b-2 border-transparent tab-btn">
                    Registrarse
                </button>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- LOGIN TAB -->
                <div id="login" class="tab-content active">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Bienvenido</h2>

                    @if ($errors->has('login'))
                        <div class="rounded-md bg-red-50 p-4 mb-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        {{ $errors->first('login') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form class="space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <label for="clave_institucional_login" class="block text-sm font-medium text-gray-700">Clave Institucional</label>
                            <input id="clave_institucional_login" name="clave_institucional" type="text" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Tu clave institucional" value="{{ old('clave_institucional') }}">
                            @error('clave_institucional')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="contraseña_login" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input id="contraseña_login" name="contraseña" type="password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Tu contraseña">
                            @error('contraseña')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Entrar
                        </button>
                    </form>
                </div>

                <!-- REGISTRO TAB -->
                <div id="registro" class="tab-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Crear Cuenta</h2>

                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4 mb-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 mb-2">
                                        Por favor revisa los errores
                                    </h3>
                                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form class="space-y-4" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input id="nombre" name="nombre" type="text" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Tu nombre completo" value="{{ old('nombre') }}">
                            @error('nombre')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="clave_institucional" class="block text-sm font-medium text-gray-700">Clave Institucional</label>
                            <input id="clave_institucional" name="clave_institucional" type="text" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Tu clave institucional" value="{{ old('clave_institucional') }}">
                            @error('clave_institucional')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="contraseña" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input id="contraseña" name="contraseña" type="password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Contraseña (mínimo 6 caracteres)">
                            @error('contraseña')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="contraseña_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                            <input id="contraseña_confirmation" name="contraseña_confirmation" type="password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Confirmar contraseña">
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Registrarse
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-500', 'border-transparent');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked button
            const activeButton = document.getElementById(tabName + '-tab');
            activeButton.classList.remove('text-gray-500', 'border-transparent');
            activeButton.classList.add('text-blue-600', 'border-blue-600');
        }
    </script>
</body>
</html>
