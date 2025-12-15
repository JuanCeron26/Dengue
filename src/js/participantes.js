// ========================================
// VARIABLES GLOBALES
// ========================================
let participantes = [];

// Elementos del DOM
const listaDiv = document.getElementById('listaParticipantes');
const mensajeInicialDiv = document.getElementById('mensajeInicial');
const btnRegistrarTodos = document.getElementById('btnRegistrarTodos');
const formRegistrarTodos = document.getElementById('formRegistrarTodos');

// ========================================
// FUNCIONES DE VISUALIZACIÓN
// ========================================
function toggleDisplay() {
    if (participantes.length > 0) {
        listaDiv.classList.remove('hidden');
        mensajeInicialDiv.classList.add('hidden');
    } else {
        listaDiv.classList.add('hidden');
        if (window.innerWidth >= 1024) {
            mensajeInicialDiv.classList.remove('hidden');
        } else {
            mensajeInicialDiv.classList.add('hidden');
        }
    }
}

// ========================================
// VALIDACIONES
// ========================================
function validarSoloNumeros(e) { e.target.value = e.target.value.replace(/[^0-9]/g, ''); }
function validarSoloLetras(e) { e.target.value = e.target.value.replace(/[^a-záéíóúñüA-ZÁÉÍÓÚÑÜ ]/g, ''); }

// ========================================
// PARTICIPANTES
// ========================================
function agregarParticipante(event) {
    event.preventDefault();

    const f = event.target;
    const cedula = f.cedula.value.trim();
    const nombre = f.nombre.value.trim();
    const apellido = f.apellido.value.trim();
    const celular = f.celular.value.trim();

    if (!cedula || !nombre || !apellido || !celular) {
        iziToast.error({ title: 'Error', message: 'Todos los campos son obligatorios', position: 'topRight' });
        return;
    }
    if (celular.length !== 10) {
        iziToast.warning({ title: 'Atención', message: 'El celular debe tener 10 dígitos', position: 'topRight' });
        return;
    }
    if (cedula.length < 8 || cedula.length > 10) {
        iziToast.warning({ title: 'Atención', message: 'Cédula: 8 a 10 dígitos', position: 'topRight' });
        return;
    }
    if (participantes.some(p => p.cedula === cedula)) {
        iziToast.warning({ title: 'Duplicado', message: 'Esta cédula ya está en la lista', position: 'topRight' });
        return;
    }

    participantes.push({ id: Date.now(), cedula, nombre, apellido, celular });
    actualizarLista();
    f.reset();
    f.cedula.focus();

    iziToast.success({
        title: '¡Agregado!',
        message: `${nombre} ${apellido} añadido a la lista`,
        position: 'topRight'
    });
}

function eliminarParticipante(id) {
    participantes = participantes.filter(p => p.id !== id);
    actualizarLista();
    iziToast.info({ title: 'Eliminado', message: 'Participante removido', position: 'topRight', timeout: 2000 });
}

// ========================================
// ACTUALIZAR LISTA
// ========================================
function actualizarLista() {
    const contenedor = document.getElementById('contenedorParticipantes');
    const contador = document.getElementById('contador');
    const hidden = document.getElementById('participantesHidden');

    toggleDisplay();
    contador.textContent = participantes.length;

    // Habilitar botón
    btnRegistrarTodos.disabled = participantes.length === 0;
    btnRegistrarTodos.classList.toggle('opacity-50', participantes.length === 0);
    btnRegistrarTodos.classList.toggle('cursor-not-allowed', participantes.length === 0);

    if (participantes.length === 0) {
        contenedor.innerHTML = '';
        hidden.innerHTML = '';
        return;
    }

    // Campos hidden para enviar
    hidden.innerHTML = participantes.map((p, i) => `
        <input type="hidden" name="participantes[${i}][cedula]" value="${p.cedula}">
        <input type="hidden" name="participantes[${i}][nombre]" value="${p.nombre}">
        <input type="hidden" name="participantes[${i}][apellido]" value="${p.apellido}">
        <input type="hidden" name="participantes[${i}][celular]" value="${p.celular}">
    `).join('');

    // Tarjetas visuales
    contenedor.innerHTML = participantes.map((p, i) => `
        <div class="bg-gradient-to-r from-emerald-50 to-white p-5 rounded-xl border-2 border-emerald-200 hover:border-emerald-400 transition-all shadow-md hover:shadow-lg">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-emerald-600 text-white font-bold rounded-full w-10 h-10 flex items-center justify-center">
                            ${i + 1}
                        </div>
                        <h3 class="text-xl font-bold text-emerald-800">${p.nombre} ${p.apellido}</h3>
                    </div>
                    <div class="ml-14 text-sm space-y-1 text-gray-700">
                        <p><span class="font-semibold">Cédula:</span> ${p.cedula}</p>
                        <p><span class="font-semibold">Celular:</span> ${p.celular}</p>
                    </div>
                </div>
                <button onclick="eliminarParticipante(${p.id})" 
                        class="ml-4 bg-red-100 hover:bg-red-600 text-red-600 hover:text-white p-3 rounded-full transition-all hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    `).join('');
}

// ========================================
// REGISTRO MASIVO CON AJAX (¡SIN RECARGAR NUNCA!)
// ========================================
formRegistrarTodos.addEventListener('submit', function (e) {
    e.preventDefault(); // ← ESTO ES LO QUE FALTABA

    const btn = btnRegistrarTodos;
    const textoOriginal = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Registrando grupo...
    `;

    const formData = new FormData(this);

    fetch('../controllers/controllerParticipante.php', {   // CAMBIA ESTO
        method: 'POST',
        body: formData
    })
        .then(response => response.text())  // ← CAMBIO CLAVE: .text() en vez de .json()
        .then(text => {
            console.log('Respuesta cruda del servidor:', text); // ← Abre F12 y mira aquí

            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                throw new Error('El servidor no devolvió JSON válido');
            }

            if (data.success) {
                iziToast.success({
                    title: '¡ÉXITO!',
                    message: `Se registraron <strong>${data.registrados}</strong> participantes`,
                    position: 'topRight',
                    timeout: 8000,
                    escapeHtml: false
                });
                participantes = [];
                actualizarLista();
            } else {
                let msg = data.message || 'Error desconocido';
                if (data.errores && data.errores.length > 0) {
                    msg += '<br><br><ul class="text-left list-disc pl-5 mt-2">';
                    data.errores.forEach(err => msg += `<li>${err}</li>`);
                    msg += '</ul>';
                }
                iziToast.error({
                    title: 'Error',
                    message: msg,
                    position: 'topRight',
                    timeout: 12000,
                    escapeHtml: false
                });
            }
        })
        .catch(err => {
            console.error('Error:', err);
            iziToast.error({
                title: 'Error',
                message: 'Hubo un problema al procesar la respuesta del servidor.',
                position: 'topRight'
            });
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = textoOriginal;
        });
});

function recuperarTerritorioActivo() {
    const codigo = sessionStorage.getItem('territorioActivo')
    const inputTerritorio = document.getElementById('asistencia_cod_territorio');

    if (inputTerritorio) {
        inputTerritorio.value = codigo
    }
}

// ========================================
// INICIALIZACIÓN
// ========================================
document.addEventListener('DOMContentLoaded', () => {
    toggleDisplay();
    recuperarTerritorioActivo();
    document.getElementById('cedula').addEventListener('input', validarSoloNumeros);
    document.getElementById('celular').addEventListener('input', validarSoloNumeros);
    document.getElementById('nombre').addEventListener('input', validarSoloLetras);
    document.getElementById('apellido').addEventListener('input', validarSoloLetras);


    function handleTerritorioRegistrado(e) {
        const codigo = e.detail.cod_territorio;
        const inputTerritorio = document.getElementById('participantes_cod_territorio');

        if (inputTerritorio) {
            inputTerritorio.value = codigo;
        }

        //TraerFocosActuales(codigo, 'ecosalud');
        //GetInvolucrados('participantes', codigo);
    }

    // Remover cualquier listener previo
    window.removeEventListener('territorioRegistrado', handleTerritorioRegistrado);

    // Agregar el listener
    window.addEventListener('territorioRegistrado', handleTerritorioRegistrado);
});