<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Control Escolar</title>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <span class="logo-text">📚 Control Escolar</span>
            <span class="toggle-sidebar cursor-pointer" onclick="toggleSidebar()" id="toggleBtn">
                <i class="icon ion-navicon-round"></i>
            </span>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="icon ion-ios-home"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('admin.materias') }}" class="sidebar-item {{ request()->routeIs('admin.materias*') ? 'active' : '' }}">
            <i class="icon ion-document-text"></i>
            <span>Materias</span>
        </a>
        
        <a href="{{ route('admin.horarios') }}" class="sidebar-item {{ request()->routeIs('admin.horarios*') ? 'active' : '' }}">
            <i class="icon ion-clock"></i>
            <span>Horarios</span>
        </a>
        
        <a href="{{ route('admin.grupos') }}" class="sidebar-item {{ request()->routeIs('admin.grupos*') ? 'active' : '' }}">
            <i class="icon ion-person-stalker"></i>
            <span>Grupos</span>
        </a>
        
        <a href="{{ route('admin.inscripciones') }}" class="sidebar-item {{ request()->routeIs('admin.inscripciones*') ? 'active' : '' }}">
            <i class="icon ion-clipboard"></i>
            <span>Inscripciones</span>
        </a>
        
        <a href="{{ route('admin.calificaciones') }}" class="sidebar-item {{ request()->routeIs('admin.calificaciones*') ? 'active' : '' }}">
            <i class="icon ion-star"></i>
            <span>Calificaciones</span>
        </a>
        
        <div style="flex: 1;"></div>
        
        <div class="sidebar-footer">
            <div class="sidebar-user-name">{{ Auth::user()->nombre ?? 'Usuario' }}</div>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm w-full justify-center sidebar-logout-btn">
                    <i class="icon ion-log-out"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        @if ($errors->any())
            <div style="margin: 16px;">
                <div class="card border-l-4 border-red-500">
                    <div class="card-body">
                        <div style="font-weight: 600; color: #991b1b; margin-bottom: 8px;">Errores encontrados:</div>
                        <ul style="list-style: disc; margin-left: 20px; color: #7f1d1d;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        
        @yield('content')
    </div>
    
    <script>
        let sidebarCollapsed = false;
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebarCollapsed = !sidebarCollapsed;
            if (sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                sidebar.classList.remove('collapsed');
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        }
        
        // Restore sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
                sidebarCollapsed = true;
            }
        });
    </script>
</body>
</html>
