// Referencias a elementos
const page1 = document.getElementById('page1');
const page2 = document.getElementById('page2');
const btnSiguiente = document.getElementById('btnSiguiente');
const btnAnterior = document.getElementById('btnAnterior');
const btnAgregarTanque = document.getElementById('btnAgregarTanque');
const tanquesContainer = document.getElementById('tanquesContainer');
const pageCounter = document.getElementById('pageCounter');
const indicator1 = document.getElementById('page-indicator-1');
const indicator2 = document.getElementById('page-indicator-2');

// Modal de dirección
const modalDireccion = document.getElementById('modalDireccion');
const btnAbrirModal = document.getElementById('btnAbrirModal');
const btnCerrarModal = document.getElementById('btnCerrarModal');
const btnAplicarDireccion = document.getElementById('btnAplicarDireccion');
const btnBorrarModal = document.getElementById('btnBorrarModal');
const btnBorrarUltimoModal = document.getElementById('btnBorrarUltimoModal');
const vistaPrevia = document.getElementById('vistaPrevia');

// Inputs del formulario principal
const nombreZoo = document.getElementById('nombreZoo');
const barrio = document.getElementById('barrio');
const direccion = document.getElementById('direccion');

// Inputs del modal
const tipoVia = document.getElementById('tipoVia');
const numeroVia = document.getElementById('numeroVia');
const numeroSimbolo = document.getElementById('numeroSimbolo');
const sufijo = document.getElementById('sufijo');
const distancia = document.getElementById('distancia');

// ✅ VALIDAR FORMULARIO EN TIEMPO REAL (PÁGINA 1)
function validarFormulario() {
    const nombreValido = nombreZoo.value.trim() !== '';
    const barrioValido = barrio.value !== '';
    const direccionValida = direccion.value.trim() !== '';
    
    const todosCompletos = nombreValido && barrioValido && direccionValida;
    
    btnSiguiente.disabled = !todosCompletos;
}

// Event listeners para validación
nombreZoo.addEventListener('input', validarFormulario);
barrio.addEventListener('change', validarFormulario);
direccion.addEventListener('input', validarFormulario);

// Inicializar botón como deshabilitado
btnSiguiente.disabled = true;

// Abrir modal de dirección
btnAbrirModal.addEventListener('click', () => {
    modalDireccion.classList.remove('hidden');
    modalDireccion.classList.add('flex');
});

// Cerrar modal
function cerrarModal() {
    modalDireccion.classList.add('hidden');
    modalDireccion.classList.remove('flex');
}

btnCerrarModal.addEventListener('click', cerrarModal);

// Actualizar vista previa de dirección
function actualizarVistaPreviaModal() {
    const partes = [];
    
    if (tipoVia.value && tipoVia.value !== '-') partes.push(tipoVia.value);
    if (numeroVia.value.trim()) partes.push(numeroVia.value.trim());
    if (sufijo.value.trim()) partes.push(sufijo.value.trim());
    if (distancia.value.trim()) partes.push('#' + distancia.value.trim());
    
    const direccionCompleta = partes.length > 0 ? partes.join(' ') : '-';
    vistaPrevia.textContent = direccionCompleta;
}

// Event listeners para actualizar vista previa
tipoVia.addEventListener('change', actualizarVistaPreviaModal);
numeroVia.addEventListener('input', actualizarVistaPreviaModal);
sufijo.addEventListener('input', actualizarVistaPreviaModal);
distancia.addEventListener('input', actualizarVistaPreviaModal);

// Borrar todo
btnBorrarModal.addEventListener('click', () => {
    tipoVia.value = '';
    numeroVia.value = '';
    sufijo.value = '';
    distancia.value = '';
    actualizarVistaPreviaModal();
});

// Borrar último campo (de derecha a izquierda)
btnBorrarUltimoModal.addEventListener('click', () => {
    if (distancia.value) {
        distancia.value = '';
    } else if (sufijo.value) {
        sufijo.value = '';
    } else if (numeroVia.value) {
        numeroVia.value = '';
    } else if (tipoVia.value && tipoVia.value !== '') {
        tipoVia.value = '';
    }
    actualizarVistaPreviaModal();
});

// Aplicar dirección construida
btnAplicarDireccion.addEventListener('click', () => {
    const direccionGenerada = vistaPrevia.textContent;
    if (direccionGenerada && direccionGenerada !== '-') {
        direccion.value = direccionGenerada;
        validarFormulario();
        cerrarModal();
    } else {
        mostrarAlertaPersonalizada('Por favor completa al menos un campo de la dirección.', 'advertencia');
    }
});

// Navegación: Ir a página 2
btnSiguiente.addEventListener('click', () => {
    page1.classList.add('hidden');
    page2.classList.remove('hidden');
    pageCounter.textContent = '2/2';
    indicator1.classList.remove('bg-cyan-500');
    indicator1.classList.add('bg-gray-300');
    indicator2.classList.remove('bg-gray-300');
    indicator2.classList.add('bg-cyan-500');
});

// Navegación: Volver a página 1
btnAnterior.addEventListener('click', () => {
    page2.classList.add('hidden');
    page1.classList.remove('hidden');
    pageCounter.textContent = '1/2';
    indicator1.classList.remove('bg-gray-300');
    indicator1.classList.add('bg-cyan-500');
    indicator2.classList.remove('bg-cyan-500');
    indicator2.classList.add('bg-gray-300');
});

// Agregar nueva fila de tanque
btnAgregarTanque.addEventListener('click', () => {
    const nuevaFila = document.createElement('div');
    nuevaFila.className = 'grid grid-cols-2 gap-4 tanque-row';
    nuevaFila.innerHTML = `
        <select 
            name="tipoTanque[]" 
            class="px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50"
            required
        >
            <option value="">Seleccionar tipo</option>
            <option value="1">Acuícola</option>
            <option value="2">Reproductor</option>
            <option value="3">Cría</option>
        </select>
        <div class="flex gap-2">
            <input 
                type="text" 
                name="nombreTanque[]" 
                placeholder="Ingrese nombre"
                class="flex-1 px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50"
                required
            >
            <button 
                type="button" 
                class="btn-eliminar bg-red-400 text-white px-3 rounded-lg hover:bg-red-500 transition-all"
                title="Eliminar"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    tanquesContainer.appendChild(nuevaFila);

    // Agregar evento para eliminar
    const btnEliminar = nuevaFila.querySelector('.btn-eliminar');
    btnEliminar.addEventListener('click', () => {
        nuevaFila.remove();
    });
});

// ✅ FUNCIÓN PARA MOSTRAR ALERTA PERSONALIZADA
function mostrarAlertaPersonalizada(mensaje, tipo = 'exito') {
    // Crear el modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 alerta-modal';
    
    const colores = {
        exito: 'bg-green-500',
        error: 'bg-red-500',
        advertencia: 'bg-yellow-500'
    };
    
    const iconos = {
        exito: `<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>`,
        error: `<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>`,
        advertencia: `<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>`
    };
    
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
            <div class="flex flex-col items-center">
                <div class="${colores[tipo]} rounded-full p-4 mb-4">
                    ${iconos[tipo]}
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2 text-center">
                    ${tipo === 'exito' ? '¡Éxito!' : tipo === 'error' ? '¡Error!' : '¡Atención!'}
                </h3>
                <p class="text-gray-600 text-center mb-6">${mensaje}</p>
                <button 
                    onclick="this.closest('.alerta-modal').remove()"
                    class="${colores[tipo]} hover:opacity-90 text-white font-semibold px-8 py-3 rounded-lg transition-all">
                    Aceptar
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Auto-cerrar después de 3 segundos si es éxito
    if (tipo === 'exito') {
        setTimeout(() => {
            modal.remove();
        }, 3000);
    }
}

// ✅ ENVIAR FORMULARIO CON FETCH
document.getElementById('formCompleto').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('../controllers/controllerRegistrar.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            mostrarAlertaPersonalizada(data.message, 'exito');
            
            // Redirigir después de 2 segundos
            setTimeout(() => {
                window.location.href = 'listar.php';
            }, 2000);
        } else {
            mostrarAlertaPersonalizada(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarAlertaPersonalizada('Error al procesar la solicitud', 'error');
    }
});