<div id="toast-container" class="fixed bottom-4 right-4 z-50 p-4"></div>

<script>
class ToastNotification {
    constructor() {
        this.container = document.getElementById('toast-container');
    }

    show(message, type = 'success', duration = 4000) {
        // Icono basado en tipo
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ⓘ'
        };

        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        const toast = document.createElement('div');
        toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg mb-3 flex items-center gap-3 animate-slideInRight text-sm font-medium`;
        toast.innerHTML = `
            <span class="text-lg">${icons[type]}</span>
            <span>${message}</span>
        `;

        this.container.appendChild(toast);

        // Auto-remove después de duration
        setTimeout(() => {
            toast.classList.add('animate-fadeOut');
            setTimeout(() => toast.remove(), 300);
        }, duration);

        // Click para cerrar
        toast.addEventListener('click', () => {
            toast.classList.add('animate-fadeOut');
            setTimeout(() => toast.remove(), 300);
        });
    }

    success(message) {
        this.show(message, 'success');
    }

    error(message) {
        this.show(message, 'error');
    }

    warning(message) {
        this.show(message, 'warning');
    }

    info(message) {
        this.show(message, 'info');
    }
}

// Hacer disponible globalmente
window.Toast = new ToastNotification();

// Mostrar notificaciones de Laravel automáticamente
@if (session('success'))
    Toast.success('{{ session('success') }}');
@endif

@if (session('error'))
    Toast.error('{{ session('error') }}');
@endif

@if (session('warning'))
    Toast.warning('{{ session('warning') }}');
@endif

@if (session('info'))
    Toast.info('{{ session('info') }}');
@endif

// Mostrar errores de validación
@if ($errors->any())
    @foreach ($errors->all() as $error)
        Toast.error('{{ $error }}');
    @endforeach
@endif
</script>
