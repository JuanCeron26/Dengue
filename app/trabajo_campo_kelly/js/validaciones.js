// ============================================
// VALIDACIONES PARA FORMULARIOS DE INSPECCIÓN
// ============================================

// Función para bloquear caracteres no permitidos en campos numéricos
function bloquearCaracteresInvalidos(event) {
    const caracteresInvalidos = ['e', 'E', '+', '-', '*', '/'];
    if (caracteresInvalidos.includes(event.key)) {
        event.preventDefault();
        return false;
    }
}

// Función para validar que solo se ingresen números positivos
function validarNumeroPositivo(input) {
    let valor = input.value;
    
    // Eliminar caracteres no permitidos
    valor = valor.replace(/[eE+\-*/]/g, '');
    
    // Convertir a número y validar
    const numero = parseFloat(valor);
    
    if (isNaN(numero) || numero < 0) {
        input.value = '';
        return false;
    }
    
    input.value = valor;
    return true;
}

// Inicializar validaciones para todos los campos numéricos
function inicializarValidacionesNumericas() {
    const camposNumericos = document.querySelectorAll('input[type="number"]');
    
    camposNumericos.forEach(campo => {
        // Bloquear teclas inválidas
        campo.addEventListener('keydown', bloquearCaracteresInvalidos);
        
        // Validar al perder el foco
        campo.addEventListener('blur', function() {
            validarNumeroPositivo(this);
        });
        
        // Validar mientras se escribe
        campo.addEventListener('input', function() {
            // Eliminar caracteres inválidos en tiempo real
            this.value = this.value.replace(/[eE+\-*/]/g, '');
        });
        
        // Prevenir pegar contenido inválido
        campo.addEventListener('paste', function(e) {
            setTimeout(() => {
                validarNumeroPositivo(this);
            }, 10);
        });
    });
}

// ============================================
// VALIDACIONES ESPECÍFICAS POR FORMULARIO
// ============================================

// Validar Formulario de Siembra
function validarFormularioSiembra() {
    const form = document.getElementById('form_siembra');
    
    // Fecha
    const fecha = form.querySelector('input[name="fecha"]');
    if (!fecha.value) {
        Toast.error('Debe seleccionar una fecha de siembra', 'Campo requerido');
        fecha.focus();
        return false;
    }
    
    // Usuario
    const usuario = form.querySelector('select[name="usuario"]');
    if (!usuario.value) {
        Toast.error('Debe seleccionar un usuario responsable', 'Campo requerido');
        usuario.focus();
        return false;
    }
    
    // Parámetros del agua
    const ph = form.querySelector('input[name="ph"]');
    if (!ph.value || parseFloat(ph.value) < 0 || parseFloat(ph.value) > 14) {
        Toast.error('El pH debe estar entre 0 y 14', 'Valor inválido');
        ph.focus();
        return false;
    }
    
    const temperatura = form.querySelector('input[name="temperatura"]');
    if (!temperatura.value || parseFloat(temperatura.value) < 0 || parseFloat(temperatura.value) > 50) {
        Toast.error('La temperatura debe estar entre 0°C y 50°C', 'Valor inválido');
        temperatura.focus();
        return false;
    }
    
    const cloro = form.querySelector('input[name="cloro"]');
    if (!cloro.value || parseFloat(cloro.value) < 0) {
        Toast.error('El cloro debe ser un valor positivo', 'Valor inválido');
        cloro.focus();
        return false;
    }
    
    // Cantidad de peces
    const alevines = form.querySelector('input[name="alevines"]');
    const adultos = form.querySelector('input[name="adultos"]');
    
    if (!alevines.value || parseInt(alevines.value) < 0) {
        Toast.error('La cantidad de alevines debe ser un número positivo', 'Valor inválido');
        alevines.focus();
        return false;
    }
    
    if (!adultos.value || parseInt(adultos.value) < 0) {
        Toast.error('La cantidad de adultos debe ser un número positivo', 'Valor inválido');
        adultos.focus();
        return false;
    }
    
    // Validar que al menos haya un pez
    if (parseInt(alevines.value) === 0 && parseInt(adultos.value) === 0) {
        Toast.warning('Debe sembrar al menos un pez (alevín o adulto)', '¡Atención!');
        alevines.focus();
        return false;
    }
    
    // Observaciones
    const observaciones = form.querySelector('textarea[name="observaciones"]');
    if (!observaciones.value.trim()) {
        Toast.error('Debe ingresar observaciones sobre la siembra', 'Campo requerido');
        observaciones.focus();
        return false;
    }
    
    if (observaciones.value.trim().length < 10) {
        Toast.warning('Las observaciones deben tener al menos 10 caracteres', 'Texto muy corto');
        observaciones.focus();
        return false;
    }
    
    return true;
}

// Validar Formulario de Seguimiento
function validarFormularioSeguimiento() {
    const form = document.querySelector('#seguimiento-formulario form');
    
    // Fecha
    const fecha = form.querySelector('input[name="fecha_seguimiento"]');
    if (!fecha.value) {
        Toast.error('Debe seleccionar una fecha de seguimiento', 'Campo requerido');
        fecha.focus();
        return false;
    }
    
    // Usuario
    const usuario = form.querySelector('select[name="usuario"]');
    if (!usuario.value) {
        Toast.error('Debe seleccionar un usuario responsable', 'Campo requerido');
        usuario.focus();
        return false;
    }
    
    // Parámetros del agua
    const ph = form.querySelector('input[name="ph_actual"]');
    if (!ph.value || parseFloat(ph.value) < 0 || parseFloat(ph.value) > 14) {
        Toast.error('El pH debe estar entre 0 y 14', 'Valor inválido');
        ph.focus();
        return false;
    }
    
    const temperatura = form.querySelector('input[name="temperatura_actual"]');
    if (!temperatura.value || parseFloat(temperatura.value) < 0 || parseFloat(temperatura.value) > 50) {
        Toast.error('La temperatura debe estar entre 0°C y 50°C', 'Valor inválido');
        temperatura.focus();
        return false;
    }
    
    // Validar que al menos un campo de vectores esté seleccionado
    const larvasAedes = form.querySelector('input[name="larvas_aedes"]:checked');
    const pupas = form.querySelector('input[name="pupas"]:checked');
    const larvasCulex = form.querySelector('input[name="larvas_culex"]:checked');
    
    if (!larvasAedes || !pupas || !larvasCulex) {
        Toast.warning('Debe seleccionar todas las opciones de presencia de vectores', '¡Atención!');
        return false;
    }
    
    return true;
}

// Validar Formulario de Resiembra
function validarFormularioResiembra() {
    const form = document.querySelector('#resiembra-formulario form');
    
    // Fecha
    const fecha = form.querySelector('input[name="fecha"]');
    if (!fecha.value) {
        Toast.error('Debe seleccionar una fecha de resiembra', 'Campo requerido');
        fecha.focus();
        return false;
    }
    
    // Usuario
    const usuario = form.querySelector('select[name="usuario"]');
    if (!usuario.value) {
        Toast.error('Debe seleccionar un usuario responsable', 'Campo requerido');
        usuario.focus();
        return false;
    }
    
    // Parámetros del agua
    const ph = form.querySelector('input[name="ph"]');
    if (!ph.value || parseFloat(ph.value) < 0 || parseFloat(ph.value) > 14) {
        Toast.error('El pH debe estar entre 0 y 14', 'Valor inválido');
        ph.focus();
        return false;
    }
    
    const temperatura = form.querySelector('input[name="temperatura"]');
    if (!temperatura.value || parseFloat(temperatura.value) < 0 || parseFloat(temperatura.value) > 50) {
        Toast.error('La temperatura debe estar entre 0°C y 50°C', 'Valor inválido');
        temperatura.focus();
        return false;
    }
    
    const cloro = form.querySelector('input[name="cloro"]');
    if (!cloro.value || parseFloat(cloro.value) < 0) {
        Toast.error('El cloro debe ser un valor positivo', 'Valor inválido');
        cloro.focus();
        return false;
    }
    
    // Cantidad de peces
    const alevines = form.querySelector('input[name="alevines"]');
    const adultos = form.querySelector('input[name="adultos"]');
    
    if (!alevines.value || parseInt(alevines.value) < 0) {
        Toast.error('La cantidad de alevines debe ser un número positivo', 'Valor inválido');
        alevines.focus();
        return false;
    }
    
    if (!adultos.value || parseInt(adultos.value) < 0) {
        Toast.error('La cantidad de adultos debe ser un número positivo', 'Valor inválido');
        adultos.focus();
        return false;
    }
    
    // Validar que al menos haya un pez
    if (parseInt(alevines.value) === 0 && parseInt(adultos.value) === 0) {
        Toast.warning('Debe resembrar al menos un pez (alevín o adulto)', '¡Atención!');
        alevines.focus();
        return false;
    }
    
    // Observaciones
    const observaciones = form.querySelector('textarea[name="observaciones"]');
    if (!observaciones.value.trim()) {
        Toast.error('Debe ingresar observaciones sobre la resiembra', 'Campo requerido');
        observaciones.focus();
        return false;
    }
    
    return true;
}

// Validar Formulario de Inspección
function validarFormularioInspeccion() {
    const form = document.getElementById('form_actividad');
    
    // Fecha
    const fecha = form.querySelector('input[name="fecha"]');
    if (!fecha.value) {
        Toast.error('Debe seleccionar una fecha de inspección', 'Campo requerido');
        fecha.focus();
        return false;
    }
    
    // Usuario
    const usuario = form.querySelector('select[name="usuario"]');
    if (!usuario.value) {
        Toast.error('Debe seleccionar un usuario responsable', 'Campo requerido');
        usuario.focus();
        return false;
    }
    
    // Sitio
    const sitio = form.querySelector('select[name="sitio"]');
    if (!sitio.value) {
        Toast.error('Debe seleccionar un sitio de inspección', 'Campo requerido');
        sitio.focus();
        return false;
    }
    
    // Tipo de depósito
    const deposito = form.querySelector('select[name="deposito"]');
    if (!deposito.value) {
        Toast.error('Debe seleccionar un tipo de depósito', 'Campo requerido');
        deposito.focus();
        return false;
    }
    
    // Validar parámetros del agua si están ingresados
    const ph = form.querySelector('input[name="ph"]');
    if (ph.value && (parseFloat(ph.value) < 0 || parseFloat(ph.value) > 14)) {
        Toast.error('El pH debe estar entre 0 y 14', 'Valor inválido');
        ph.focus();
        return false;
    }
    
    const temperatura = form.querySelector('input[name="temperatura"]');
    if (temperatura.value && (parseFloat(temperatura.value) < 0 || parseFloat(temperatura.value) > 50)) {
        Toast.error('La temperatura debe estar entre 0°C y 50°C', 'Valor inválido');
        temperatura.focus();
        return false;
    }
    
    const cloro = form.querySelector('input[name="cloro"]');
    if (cloro.value && parseFloat(cloro.value) < 0) {
        Toast.error('El cloro debe ser un valor positivo', 'Valor inválido');
        cloro.focus();
        return false;
    }
    
    // Validar medidas del depósito si están ingresadas
    const ancho = form.querySelector('input[name="ancho"]');
    const largo = form.querySelector('input[name="largo"]');
    const profundidad = form.querySelector('input[name="profundidad"]');
    
    if (ancho.value && parseFloat(ancho.value) < 0) {
        Toast.error('El ancho debe ser un valor positivo o cero', 'Valor inválido');
        ancho.focus();
        return false;
    }
    
    if (largo.value && parseFloat(largo.value) < 0) {
        Toast.error('El largo debe ser un valor positivo o cero', 'Valor inválido');
        largo.focus();
        return false;
    }
    
    if (profundidad.value && parseFloat(profundidad.value) < 0) {
        Toast.error('La profundidad debe ser un valor positivo o cero', 'Valor inválido');
        profundidad.focus();
        return false;
    }
    
    return true;
}

// ============================================
// FUNCIONES DE NOTIFICACIÓN CON SWEETALERT2
// (Para alertas modales importantes)
// ============================================

function mostrarAlertaExito(mensaje, opciones = {}) {
    return Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: mensaje,
        confirmButtonColor: '#16a34a',
        confirmButtonText: 'Entendido',
        timer: opciones.autoClose ? 3000 : undefined,
        ...opciones
    });
}

function mostrarAlertaError(mensaje, opciones = {}) {
    return Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: mensaje,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Entendido',
        ...opciones
    });
}

function mostrarAlertaConfirmacion(mensaje, opciones = {}) {
    return Swal.fire({
        title: '¿Estás seguro?',
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        ...opciones
    });
}

function mostrarAlertaEliminar(mensaje = '¿Deseas anular esta actividad?') {
    return Swal.fire({
        title: '¡Cuidado!',
        text: mensaje,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, anular',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        reverseButtons: true
    });
}

function mostrarAlertaCargando(mensaje = 'Procesando...') {
    Swal.fire({
        title: mensaje,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function cerrarAlertaCargando() {
    Swal.close();
}

// ============================================
// ASIGNAR VALIDACIONES A FORMULARIOS
// ============================================

function asignarValidaciones() {
    // Formulario de Siembra
    const formSiembra = document.getElementById('form_siembra');
    if (formSiembra) {
        formSiembra.addEventListener('submit', function(e) {
            if (!validarFormularioSiembra()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Formulario de Seguimiento
    const formSeguimiento = document.querySelector('#seguimiento-formulario form');
    if (formSeguimiento) {
        formSeguimiento.addEventListener('submit', function(e) {
            if (!validarFormularioSeguimiento()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Formulario de Resiembra
    const formResiembra = document.querySelector('#resiembra-formulario form');
    if (formResiembra) {
        formResiembra.addEventListener('submit', function(e) {
            if (!validarFormularioResiembra()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Formulario de Inspección
    const formInspeccion = document.getElementById('form_actividad');
    if (formInspeccion) {
        formInspeccion.addEventListener('submit', function(e) {
            if (!validarFormularioInspeccion()) {
                e.preventDefault();
                return false;
            }
        });
    }
}

// ============================================
// VALIDACIÓN DE ARCHIVOS
// ============================================

function validarArchivosImagen(input) {
    const archivos = input.files;
    const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    const tamañoMaximo = 5 * 1024 * 1024; // 5MB
    
    for (let i = 0; i < archivos.length; i++) {
        const archivo = archivos[i];
        
        // Validar tipo
        if (!tiposPermitidos.includes(archivo.type)) {
            Toast.error(`El archivo "${archivo.name}" no es válido. Solo JPG, PNG y GIF`, 'Tipo no permitido');
            input.value = '';
            return false;
        }
        
        // Validar tamaño
        if (archivo.size > tamañoMaximo) {
            Toast.error(`El archivo "${archivo.name}" supera el tamaño máximo de 5MB`, 'Archivo muy grande');
            input.value = '';
            return false;
        }
    }
    
    Toast.success('Archivo(s) cargado(s) correctamente');
    return true;
}

// Asignar validación a inputs de archivos
function asignarValidacionArchivos() {
    const inputsArchivos = document.querySelectorAll('input[type="file"]');
    inputsArchivos.forEach(input => {
        input.addEventListener('change', function() {
            validarArchivosImagen(this);
        });
    });
}

// ============================================
// VALIDACIONES ADICIONALES ÚTILES
// ============================================

// Validar fecha no sea futura
function validarFechaNoFutura(inputFecha) {
    const fechaSeleccionada = new Date(inputFecha.value);
    const fechaActual = new Date();
    fechaActual.setHours(0, 0, 0, 0);
    
    if (fechaSeleccionada > fechaActual) {
        Toast.warning('La fecha seleccionada no puede ser futura', '¡Atención!');
        inputFecha.value = '';
        return false;
    }
    return true;
}

// ============================================
// MANEJO DE RESPUESTAS DE FORMULARIOS
// ============================================

async function manejarRespuestaFormulario(response, mensajeExito, mensajeError) {
    try {
        let data;
        
        if (typeof response === 'string') {
            try {
                data = JSON.parse(response);
            } catch (e) {
                if (response.includes('éxito') || response.includes('correctamente')) {
                    Toast.success(mensajeExito, '¡Éxito!', 4000);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                    return;
                } else {
                    Toast.error(mensajeError || 'Ocurrió un error inesperado', 'Error');
                    return;
                }
            }
        } else {
            data = response;
        }

        if (data.success) {
            Toast.success(data.mensaje || mensajeExito, '¡Éxito!', 4000);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            Toast.error(data.error || mensajeError || 'Error al procesar', 'Error');
        }
    } catch (error) {
        console.error('Error al manejar respuesta:', error);
        Toast.error('Error al procesar la respuesta del servidor', 'Error');
    }
}

// Configurar formularios con alertas
function configurarFormulariosConAlertas() {
    // Formulario de Siembra
    const formSiembra = document.getElementById('form_siembra');
    if (formSiembra) {
        formSiembra.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validarFormularioSiembra()) {
                return false;
            }

            mostrarAlertaCargando('Registrando siembra...');

            const formData = new FormData(this);

            try {
                const response = await fetch('../controller/actividadescontrol.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();
                cerrarAlertaCargando();

                if (text.includes('<!DOCTYPE html>')) {
                    const exitoMatch = text.match(/class='alert-text'>\s*([^<]+)/);
                    if (exitoMatch) {
                        Toast.success(exitoMatch[1].trim(), '¡Éxito!', 4000);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    await manejarRespuestaFormulario(
                        text,
                        'Siembra registrada correctamente',
                        'Error al registrar la siembra'
                    );
                }
            } catch (error) {
                cerrarAlertaCargando();
                console.error('Error:', error);
                Toast.error('Error de conexión con el servidor', 'Error de red');
            }
        });
    }

    // Formulario de Seguimiento
    const formSeguimiento = document.querySelector('#seguimiento-formulario form');
    if (formSeguimiento) {
        formSeguimiento.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validarFormularioSeguimiento()) {
                return false;
            }

            mostrarAlertaCargando('Registrando seguimiento...');

            const formData = new FormData(this);

            try {
                const response = await fetch('../controller/actividadescontrol.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();
                cerrarAlertaCargando();

                if (text.includes('<!DOCTYPE html>')) {
                    const exitoMatch = text.match(/class='alert-text'>\s*([^<]+)/);
                    if (exitoMatch) {
                        Toast.success(exitoMatch[1].trim(), '¡Éxito!', 4000);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    await manejarRespuestaFormulario(
                        text,
                        'Seguimiento registrado correctamente',
                        'Error al registrar el seguimiento'
                    );
                }
            } catch (error) {
                cerrarAlertaCargando();
                console.error('Error:', error);
                Toast.error('Error de conexión con el servidor', 'Error de red');
            }
        });
    }

    // Formulario de Resiembra
    const formResiembra = document.querySelector('#resiembra-formulario form');
    if (formResiembra) {
        formResiembra.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validarFormularioResiembra()) {
                return false;
            }

            mostrarAlertaCargando('Registrando resiembra...');

            const formData = new FormData(this);

            try {
                const response = await fetch('../controller/actividadescontrol.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();
                cerrarAlertaCargando();

                if (text.includes('<!DOCTYPE html>')) {
                    const exitoMatch = text.match(/class='alert-text'>\s*([^<]+)/);
                    if (exitoMatch) {
                        Toast.success(exitoMatch[1].trim(), '¡Éxito!', 4000);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    await manejarRespuestaFormulario(
                        text,
                        'Resiembra registrada correctamente',
                        'Error al registrar la resiembra'
                    );
                }
            } catch (error) {
                cerrarAlertaCargando();
                console.error('Error:', error);
                Toast.error('Error de conexión con el servidor', 'Error de red');
            }
        });
    }

    // Formulario de Inspección
    const formInspeccion = document.getElementById('form_actividad');
    if (formInspeccion) {
        formInspeccion.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validarFormularioInspeccion()) {
                return false;
            }

            mostrarAlertaCargando('Registrando inspección...');

            const formData = new FormData(this);

            try {
                const response = await fetch('../controller/actividadescontrol.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();
                cerrarAlertaCargando();

                if (text.includes('<!DOCTYPE html>')) {
                    const exitoMatch = text.match(/class='alert-text'>\s*([^<]+)/);
                    if (exitoMatch) {
                        Toast.success(exitoMatch[1].trim(), '¡Éxito!', 4000);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    await manejarRespuestaFormulario(
                        text,
                        'Inspección registrada correctamente',
                        'Error al registrar la inspección'
                    );
                }
            } catch (error) {
                cerrarAlertaCargando();
                console.error('Error:', error);
                Toast.error('Error de conexión con el servidor', 'Error de red');
            }
        });
    }
}

// ============================================
// INICIALIZACIÓN
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando sistema de validaciones...');
    
    // Inicializar validaciones numéricas
    inicializarValidacionesNumericas();
    
    // Asignar validaciones a formularios
    asignarValidaciones();
    
    // Asignar validaciones a archivos
    asignarValidacionArchivos();
    
    // Configurar formularios con alertas
    configurarFormulariosConAlertas();
    
    // Validar fechas
    const camposFecha = document.querySelectorAll('input[type="date"]');
    camposFecha.forEach(campo => {
        campo.addEventListener('change', function() {
            validarFechaNoFutura(this);
        });
    });
    
    console.log('Sistema de validaciones inicializado correctamente');
});

// Exportar funciones globales
window.validaciones = {
    validarSiembra: validarFormularioSiembra,
    validarSeguimiento: validarFormularioSeguimiento,
    validarResiembra: validarFormularioResiembra,
    validarInspeccion: validarFormularioInspeccion
};
