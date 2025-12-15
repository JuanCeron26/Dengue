// Variables globales
let participantesAsistencia = []; // 🔥 Cambié el nombre para que coincida
let territorioSeleccionado = null;
let actividadSeleccionada = null;

/**
 * Inicializar la página
 */
window.addEventListener('DOMContentLoaded', function () {
    // Establecer fecha actual
    const fecha = new Date();
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaActualEl = document.getElementById('fechaActual');
    if (fechaActualEl) {
        fechaActualEl.textContent = fecha.toLocaleDateString('es-ES', opciones);
    }

    // Cargar territorios
    // cargarTerritoriosAsistencia();

    //RECUPERAR TERRITORIO AL CARGAR LA PÁGINA
    recuperarTerritorioActivo();
    cargarActividadesAsistencia()

    function recuperarTerritorioActivo() {
        const territorioGuardado = sessionStorage.getItem('territorioActivo');

        if (territorioGuardado) {

            const inputTerritorio = document.getElementById('selectTerritorioAsistencia');
            if (inputTerritorio) {
                inputTerritorio.value = territorioGuardado;
            }
        }
    }
    function handleTerritorioRegistrado(e) {
        const codigo = e.detail.cod_territorio;
        const inputTerritorio = document.getElementById('selectTerritorioAsistencia');

        if (inputTerritorio) {
            inputTerritorio.value = codigo;
        }

        cargarActividadesAsistencia()
    }

    // Remover cualquier listener previo
    window.removeEventListener('territorioRegistrado', handleTerritorioRegistrado);

    // Agregar el listener
    window.addEventListener('territorioRegistrado', handleTerritorioRegistrado);
});

/**
 * Cargar territorios desde la BD
 */
/*
async function cargarTerritoriosAsistencia() {
    try {
        const response = await fetch('../controllers/controlasistencia.php?action=obtenerTerritorios');
        const data = await response.json();

        if (data.success) {
            const selectTerritorio = document.getElementById('selectTerritorioAsistencia');
            if (!selectTerritorio) return;

            selectTerritorio.innerHTML = '<option value="">Seleccione territorio</option>';

            data.territorios.forEach(t => {
                const option = document.createElement('option');
                option.value = t.cod_territorio;
                option.textContent = t.nombre_sitio;
                selectTerritorio.appendChild(option);
            });
        } else {
            alert('Error al cargar territorios: ' + data.message);
        }
    } catch (error) {
        console.error('Error al cargar territorios:', error);
        alert('Error de conexión al cargar territorios');
    }
}
    */

/**
 * Cargar actividades cuando se selecciona un territorio
 */
async function cargarActividadesAsistencia() {
    const inputTerritorio = document.getElementById('selectTerritorioAsistencia');
    if (!inputTerritorio) {
        console.error('No se encontró el input de territorio');
        return;
    }

    territorioSeleccionado = inputTerritorio.value;

    // Mostrar el código del territorio (o un mensaje genérico)
    const nombreTerritorioEl = document.getElementById('nombreTerritorioAsistencia');
    if (nombreTerritorioEl) {
        if (territorioSeleccionado) {
            nombreTerritorioEl.textContent = `Territorio #${territorioSeleccionado}`;
        } else {
            nombreTerritorioEl.textContent = 'Seleccione...';
        }
    }

    // Si no hay territorio seleccionado, limpiar select de actividades y lista
    if (!territorioSeleccionado) {
        const selectActividad = document.getElementById('selectActividadAsistencia');
        if (selectActividad) {
            selectActividad.innerHTML = '<option value="">Seleccione actividad</option>';
        }
        limpiarListaAsistencia();
        return;
    }

    try {
        const response = await fetch(
            `../controllers/controlasistencia.php?action=obtenerActividades&cod_territorio=${territorioSeleccionado}`
        );

        const text = await response.text();
        console.log('📥 Respuesta del servidor:', text);

        const data = JSON.parse(text);

        if (data.success) {
            const selectActividad = document.getElementById('selectActividadAsistencia');
            if (!selectActividad) {
                console.error('No se encontró el select de actividades');
                return;
            }

            selectActividad.innerHTML = '<option value="">Seleccione actividad</option>';

            if (data.actividades && data.actividades.length > 0) {
                data.actividades.forEach(a => {
                    const option = document.createElement('option');
                    option.value = a.cod_controlactividadeco;
                    option.textContent = `${a.nombre_actividad} - ${a.nom_etapa}`;
                    selectActividad.appendChild(option);
                });
                console.log(`✅ ${data.actividades.length} actividades cargadas`);
            } else {
                console.log('ℹ️ No hay actividades para este territorio');
                selectActividad.innerHTML = '<option value="">No hay actividades disponibles</option>';
            }
        } else {
            console.error('Error del servidor:', data.message);
            alert('Error al cargar actividades: ' + data.message);
        }
    } catch (error) {
        console.error('❌ Error al cargar actividades:', error);
        alert('Error de conexión al cargar actividades');
    }

    limpiarListaAsistencia();
}

/**
 * Cargar participantes cuando se selecciona una actividad
 */
async function cargarParticipantesAsistencia() {
    const selectActividad = document.getElementById('selectActividadAsistencia');
    if (!selectActividad) return;

    actividadSeleccionada = selectActividad.value;

    if (!actividadSeleccionada || !territorioSeleccionado) {
        limpiarListaAsistencia();
        return;
    }

    try {
        const response = await fetch(`../controllers/controlasistencia.php?action=obtenerParticipantes&cod_territorio=${territorioSeleccionado}&cod_controlactividadeco=${actividadSeleccionada}`);
        const data = await response.json();

        console.log('Participantes recibidos:', data); // 🔍 Debug

        if (data.success) {
            participantesAsistencia = data.participantes;
            console.log('participantesAsistencia cargados:', participantesAsistencia); // 🔍 Debug
            renderizarParticipantesAsistencia();
            actualizarEstadisticasAsistencia();

            const btnGuardarContainer = document.getElementById('btnGuardarContainerAsistencia');
            if (btnGuardarContainer) {
                btnGuardarContainer.classList.remove('hidden');
            }
        } else {
            alert('Error al cargar participantes: ' + data.message);
            limpiarListaAsistencia();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión al cargar participantes');
        limpiarListaAsistencia();
    }
}

/**
 * Renderizar lista de participantes
 */
function renderizarParticipantesAsistencia() {
    const listaParticipantesEl = document.getElementById('listaParticipantesAsistencia');
    const mensajeVacio = document.getElementById('mensajeVacioAsistencia');

    if (!listaParticipantesEl || !mensajeVacio) {
        console.error('No se encontraron los elementos del DOM');
        return;
    }

    if (participantesAsistencia.length === 0) {
        listaParticipantesEl.innerHTML = '';
        mensajeVacio.classList.remove('hidden');
        return;
    }

    console.log('Renderizando participantes:', participantesAsistencia); // 🔍 Debug

    mensajeVacio.classList.add('hidden');

    listaParticipantesEl.innerHTML = participantesAsistencia.map((p, index) => {
        // Normalizar el valor de asistio
        const asistioTrue = (p.asistio === true || p.asistio === 't' || p.asistio === 'T' ||
            p.asistio === '1' || p.asistio === 1 || p.asistio === 'true');
        const asistioFalse = (p.asistio === false || p.asistio === 'f' || p.asistio === 'F' ||
            p.asistio === '0' || p.asistio === 0 || p.asistio === 'false');

        const claseEstado = asistioTrue ? 'presente' : asistioFalse ? 'ausente' : '';
        const celular = p.celular || 'Sin teléfono';

        const presenteFill = asistioTrue ? '-fill' : '';
        const ausenteFill = asistioFalse ? '-fill' : '';

        return `
            <div class="participante-card ${claseEstado} bg-white rounded-2xl p-6 border-2 border-gray-100" style="animation-delay: ${index * 0.05}s">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="relative">
                            <div class=" w-16 h-16 border bg-linear-to-br from-emerald-100 to-green-100 rounded-2xl flex items-center justify-center">
                                <i class="bi bi-person-fill text-emerald-600 text-2xl"></i>
                            </div>
                            ${asistioTrue ? '<div class="checkmark-icon absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center"><i class="bi bi-check text-white text-xs font-bold"></i></div>' : ''}
                            ${asistioFalse ? '<div class="checkmark-icon absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center"><i class="bi bi-x text-white text-xs font-bold"></i></div>' : ''}
                        </div>
                        <div>
                            ${p.es_lider ? '<span class="inline-block bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-1">Líder del territorio</span>' : ''}
                            <h3 class="font-bold text-gray-800 text-lg">${p.nom_part} ${p.ape_part}</h3>
                            <p class="text-gray-500 text-sm flex items-center gap-2 mt-1">
                                <i class="bi bi-card-text"></i>
                                <span>CC: ${p.id_cedula}</span>
                            </p>
                            <p class="text-gray-500 text-sm flex items-center gap-2">
                                <i class="bi bi-phone"></i>
                                <span>${celular}</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button 
                            onclick="marcarAsistenciaParticipante(${index}, true)"
                            class="btn-check cursor-pointer px-6 py-4 rounded-xl font-bold text-sm transition-all ${asistioTrue ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-green-100'}"
                        >
                            <i class="bi bi-check-circle${presenteFill} text-xl"></i>
                            <div class="text-xs mt-1">Presente</div>
                        </button>
                        <button 
                            onclick="marcarAsistenciaParticipante(${index}, false)"
                            class="btn-check cursor-pointer px-6 py-4 rounded-xl font-bold text-sm transition-all ${asistioFalse ? 'bg-red-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-red-100'}"
                        >
                            <i class="bi bi-x-circle${ausenteFill} text-xl"></i>
                            <div class="text-xs mt-1">Ausente</div>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

/**
 * Marcar asistencia individual
 */
function marcarAsistenciaParticipante(index, asistio) {
    participantesAsistencia[index].asistio = asistio;
    renderizarParticipantesAsistencia();
    actualizarEstadisticasAsistencia();
}

/**
 * Marcar todos como presentes
 */
function marcarTodosAsistencia() {
    if (!confirm('¿Desea marcar a todos como presentes?')) return;

    participantesAsistencia.forEach(p => p.asistio = true);
    renderizarParticipantesAsistencia();
    actualizarEstadisticasAsistencia();
}

/**
 * Actualizar estadísticas y gráficos circulares
 */
function actualizarEstadisticasAsistencia() {
    const total = participantesAsistencia.length;
    const presentes = participantesAsistencia.filter(p => p.asistio === true).length;
    const ausentes = participantesAsistencia.filter(p => p.asistio === false).length;

    const totalEl = document.getElementById('totalParticipantesAsistencia');
    const presentesEl = document.getElementById('totalPresentesAsistencia');
    const ausentesEl = document.getElementById('totalAusentesAsistencia');

    if (totalEl) totalEl.textContent = total;
    if (presentesEl) presentesEl.textContent = presentes;
    if (ausentesEl) ausentesEl.textContent = ausentes;

    // Calcular porcentajes
    const pctPresentes = total > 0 ? ((presentes / total) * 100).toFixed(0) : 0;
    const pctAusentes = total > 0 ? ((ausentes / total) * 100).toFixed(0) : 0;

    const pctPresentesEl = document.getElementById('porcentajePresentesAsistencia');
    const pctAusentesEl = document.getElementById('porcentajeAusentesAsistencia');

    if (pctPresentesEl) pctPresentesEl.textContent = pctPresentes + '%';
    if (pctAusentesEl) pctAusentesEl.textContent = pctAusentes + '%';

    // Actualizar círculos de progreso
    const circunferencia = 226;
    const offsetPresentes = total > 0 ? circunferencia - (circunferencia * presentes / total) : circunferencia;
    const offsetAusentes = total > 0 ? circunferencia - (circunferencia * ausentes / total) : circunferencia;

    const circlePresentesEl = document.getElementById('circlePresentesAsistencia');
    const circleAusentesEl = document.getElementById('circleAusentesAsistencia');

    if (circlePresentesEl) circlePresentesEl.style.strokeDashoffset = offsetPresentes;
    if (circleAusentesEl) circleAusentesEl.style.strokeDashoffset = offsetAusentes;
}

/**
 * Guardar asistencia en la base de datos
 */
async function guardarAsistenciaTotal() {
    if (!actividadSeleccionada) {
        alert('Debe seleccionar una actividad');
        return;
    }

    const sinMarcar = participantesAsistencia.filter(p => p.asistio === null).length;

    if (sinMarcar > 0) {
        if (!confirm(`Hay ${sinMarcar} participante(s) sin marcar. ¿Desea continuar?`)) {
            return;
        }
    }

    const asistencias = participantesAsistencia.map(p => ({
        id_part: p.id_part,
        asistio: p.asistio === true ? true : false
    }));

    const formData = new URLSearchParams({
        action: 'guardarAsistencia',
        cod_controlactividadeco: actividadSeleccionada,
        asistencias: JSON.stringify(asistencias)
    });

    try {
        const response = await fetch('../controllers/controlasistencia.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert('✅ Asistencia guardada correctamente\n\nTotal presentes: ' + result.total_presentes + '\nTotal registrados: ' + result.total_registrados);
            cargarParticipantesAsistencia();
        } else {
            alert('❌ Error al guardar: ' + result.message);
            if (result.errores) {
                console.error('Errores:', result.errores);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error de conexión al guardar');
    }
}

/**
 * Limpiar lista de participantes
 */
function limpiarListaAsistencia() {
    participantesAsistencia = [];
    const listaEl = document.getElementById('listaParticipantesAsistencia');
    const mensajeEl = document.getElementById('mensajeVacioAsistencia');
    const btnGuardarEl = document.getElementById('btnGuardarContainerAsistencia');

    if (listaEl) listaEl.innerHTML = '';
    if (mensajeEl) mensajeEl.classList.remove('hidden');
    if (btnGuardarEl) btnGuardarEl.classList.add('hidden');

    actualizarEstadisticasAsistencia();
}