// ============================================
// SISTEMA DE TOAST NOTIFICATIONS
// ============================================

class ToastNotification {
    constructor() {
        this.container = null;
        this.toasts = [];
        this.init();
    }

    init() {
        // Crear contenedor si no existe
        if (!document.querySelector('.toast-container')) {
            this.container = document.createElement('div');
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.toast-container');
        }
    }

    show(options = {}) {
        const defaults = {
            type: 'info', // success, error, warning, info
            title: '',
            message: '',
            duration: 4000,
            position: 'top-right',
            showProgress: true,
            onClick: null,
            onClose: null
        };

        const config = { ...defaults, ...options };

        // Crear elemento toast
        const toast = this.createToast(config);
        
        // Agregar al contenedor
        this.container.appendChild(toast);
        this.toasts.push(toast);

        // Mostrar con animación
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto-cerrar si tiene duración
        if (config.duration > 0) {
            setTimeout(() => {
                this.hide(toast, config.onClose);
            }, config.duration);
        }

        return toast;
    }

    createToast(config) {
        const toast = document.createElement('div');
        toast.className = `toast ${config.type}`;

        // Icono
        const icon = document.createElement('div');
        icon.className = 'toast-icon';
        
        // Contenido
        const content = document.createElement('div');
        content.className = 'toast-content';

        if (config.title) {
            const title = document.createElement('div');
            title.className = 'toast-title';
            title.textContent = config.title;
            content.appendChild(title);
        }

        if (config.message) {
            const message = document.createElement('div');
            message.className = 'toast-message';
            message.textContent = config.message;
            content.appendChild(message);
        }

        // Botón cerrar
        const closeBtn = document.createElement('button');
        closeBtn.className = 'toast-close';
        closeBtn.innerHTML = '×';
        closeBtn.onclick = () => this.hide(toast, config.onClose);

        // Barra de progreso
        if (config.showProgress && config.duration > 0) {
            const progress = document.createElement('div');
            progress.className = 'toast-progress';
            progress.style.animationDuration = `${config.duration}ms`;
            toast.appendChild(progress);
        }

        // Ensamblar toast
        toast.appendChild(icon);
        toast.appendChild(content);
        toast.appendChild(closeBtn);

        // Click en el toast
        if (config.onClick) {
            toast.style.cursor = 'pointer';
            toast.onclick = (e) => {
                if (e.target !== closeBtn) {
                    config.onClick();
                }
            };
        }

        return toast;
    }

    hide(toast, callback) {
        toast.classList.remove('show');
        toast.classList.add('hide');

        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
            
            const index = this.toasts.indexOf(toast);
            if (index > -1) {
                this.toasts.splice(index, 1);
            }

            if (callback) {
                callback();
            }
        }, 400);
    }

    // Métodos de acceso rápido
    success(message, title = '¡Éxito!', duration = 4000) {
        return this.show({
            type: 'success',
            title: title,
            message: message,
            duration: duration
        });
    }

    error(message, title = '¡Error!', duration = 5000) {
        return this.show({
            type: 'error',
            title: title,
            message: message,
            duration: duration
        });
    }

    warning(message, title = '¡Atención!', duration = 4000) {
        return this.show({
            type: 'warning',
            title: title,
            message: message,
            duration: duration
        });
    }

    info(message, title = 'Información', duration = 4000) {
        return this.show({
            type: 'info',
            title: title,
            message: message,
            duration: duration
        });
    }

    // Limpiar todos los toasts
    clearAll() {
        this.toasts.forEach(toast => {
            this.hide(toast);
        });
    }
}

// ============================================
// INSTANCIA GLOBAL
// ============================================

const Toast = new ToastNotification();

// Exportar para uso en window
window.Toast = Toast;

// También crear funciones globales para facilidad de uso
window.showToast = (options) => Toast.show(options);
window.toastSuccess = (message, title, duration) => Toast.success(message, title, duration);
window.toastError = (message, title, duration) => Toast.error(message, title, duration);
window.toastWarning = (message, title, duration) => Toast.warning(message, title, duration);
window.toastInfo = (message, title, duration) => Toast.info(message, title, duration);

// ============================================
// INTEGRACIÓN CON VALIDACIONES.JS
// ============================================

// Reemplazar las funciones de SweetAlert2 toast por las personalizadas
function mostrarToastExito(mensaje) {
    Toast.success(mensaje, '¡Éxito!');
}

function mostrarToastError(mensaje) {
    Toast.error(mensaje, '¡Error!');
}

function mostrarToastWarning(mensaje) {
    Toast.warning(mensaje, '¡Atención!');
}

function mostrarToastInfo(mensaje) {
    Toast.info(mensaje, 'Información');
}

// ============================================
// EJEMPLOS DE USO
// ============================================

/*

// USO BÁSICO:
Toast.success('Operación completada correctamente');
Toast.error('Hubo un error al procesar la solicitud');
Toast.warning('Por favor revisa los campos');
Toast.info('Datos actualizados');

// USO CON OPCIONES:
Toast.show({
    type: 'success',
    title: '¡Guardado!',
    message: 'Los cambios se guardaron correctamente',
    duration: 5000,
    showProgress: true
});

// USO CON CALLBACK:
Toast.success('Registro exitoso', '¡Bien hecho!', 3000).onclick = () => {
    console.log('Toast clickeado');
};

// FUNCIONES GLOBALES:
toastSuccess('¡Archivo subido!');
toastError('No se pudo conectar al servidor');
toastWarning('Sesión a punto de expirar');
toastInfo('Hay 3 notificaciones nuevas');

// LIMPIAR TODOS:
Toast.clearAll();

*/

console.log('Sistema de Toast Notifications inicializado correctamente');