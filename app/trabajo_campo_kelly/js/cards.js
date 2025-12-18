// ================================
// SISTEMA DE CARDS MODERNO Y ELEGANTE
// ================================
// ================================
// OBJETO ALERTAS - SWEETALERT2
// ================================
const alertas = {
    eliminar: (mensaje = '¿Deseas anular esta actividad?') => {
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
    },

    exitoEspecial: (mensaje) => {
        return Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: mensaje,
            confirmButtonColor: '#10b981'
        });
    },

    error: (mensaje) => {
        return Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje,
            confirmButtonColor: '#dc2626'
        });
    },

    cargando: (mensaje = 'Procesando...') => {
        Swal.fire({
            title: mensaje,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    },

    cerrarCargando: () => {
        Swal.close();
    }
};

// ================================
// SISTEMA DE CARDS MODERNO Y ELEGANTE
// ================================
// ... resto de tu código ...
let todasLasActividades = [];
let actividadesFiltradas = [];
let paginaActual = 0;
const ITEMS_POR_PAGINA = 9;

// ======================================================
// PINTAR CARDS ORGANIZADAS POR TIPO
// ======================================================
function pintarCards(actividades) {
    todasLasActividades = actividades;
    actividadesFiltradas = actividades;

    // Organizar actividades por tipo
    const organizadas = organizarActividadesPorTipo(actividades);

    const contenedor = document.getElementById("contenedor_actividades");
    contenedor.innerHTML = "";

    // Crear secciones por tipo de actividad
    if (organizadas.inspecciones.length > 0) {
        contenedor.appendChild(crearSeccionActividades('Inspecciones', organizadas.inspecciones, 'emerald'));
    }

    if (organizadas.siembras.length > 0) {
        contenedor.appendChild(crearSeccionActividades('Siembras', organizadas.siembras, 'teal'));
    }

    if (organizadas.seguimientos.length > 0) {
        contenedor.appendChild(crearSeccionActividades('Seguimientos', organizadas.seguimientos, 'cyan'));
    }

    if (organizadas.resiembras.length > 0) {
        contenedor.appendChild(crearSeccionActividades('Resiembras', organizadas.resiembras, 'green'));
    }
}

// ======================================================
// ORGANIZAR ACTIVIDADES POR TIPO
// ======================================================
function organizarActividadesPorTipo(actividades) {
    // Obtener relaciones entre actividades
    const inspeccionesConSiembra = new Set(
        actividades.filter(a => a.cod_act_campo == 1)
            .map(a => a.cod_actividad_padre)
            .filter(Boolean)
    );

    const seguimientosConResiembra = new Set(
        actividades.filter(a => a.cod_act_campo == 2)
            .map(a => a.cod_actividad_padre)
            .filter(Boolean)
    );

    const siembrasConSeguimiento = new Set(
        actividades.filter(a => a.cod_act_campo == 3)
            .map(a => a.cod_actividad_padre)
            .filter(Boolean)
    );

    const resultado = {
        inspecciones: [],
        siembras: [],
        seguimientos: [],
        resiembras: []
    };

    actividades.forEach(ac => {
        const esInspeccion = ac.cod_act_campo == 4;
        const esSiembra = ac.cod_act_campo == 1;
        const esSeguimiento = ac.cod_act_campo == 3;
        const esResiembra = ac.cod_act_campo == 2;
        const idActividad = ac.cod_actividadtrabajocampo;

        // Filtrar actividades que ya tienen hijos
        if (esInspeccion && !inspeccionesConSiembra.has(idActividad)) {
            resultado.inspecciones.push(ac);
        } else if (esSiembra && !siembrasConSeguimiento.has(idActividad)) {
            resultado.siembras.push(ac);
        } else if (esSeguimiento && !seguimientosConResiembra.has(idActividad)) {
            resultado.seguimientos.push(ac);
        } else if (esResiembra) {
            resultado.resiembras.push(ac);
        }
    });

    // Ordenar por fecha (más recientes primero)
    Object.keys(resultado).forEach(tipo => {
        resultado[tipo].sort((a, b) => new Date(b.fecha_actividad) - new Date(a.fecha_actividad));
    });

    return resultado;
}

// ======================================================
// CREAR SECCIÓN DE ACTIVIDADES
// ======================================================
function crearSeccionActividades(titulo, actividades, color) {
    const seccion = document.createElement('div');
    seccion.className = 'mb-10 fade-in-section';

    const colores = {
        emerald: {
            bg: 'bg-emerald-50',
            border: 'border-emerald-500',
            text: 'text-emerald-700',
            icon: 'bg-gradient-to-br from-emerald-500 to-emerald-600'
        },
        teal: {
            bg: 'bg-teal-50',
            border: 'border-teal-500',
            text: 'text-teal-700',
            icon: 'bg-gradient-to-br from-teal-500 to-teal-600'
        },
        cyan: {
            bg: 'bg-cyan-50',
            border: 'border-cyan-500',
            text: 'text-cyan-700',
            icon: 'bg-gradient-to-br from-cyan-500 to-cyan-600'
        },
        green: {
            bg: 'bg-green-50',
            border: 'border-green-500',
            text: 'text-green-700',
            icon: 'bg-gradient-to-br from-green-500 to-green-600'
        }
    };

    const c = colores[color];

    // Mostrar solo las 3 más recientes inicialmente
    const actividadesVisibles = actividades.slice(0, 3);
    const hayMas = actividades.length > 3;

    seccion.innerHTML = `
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="${c.icon} w-10 h-10 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-${getIconoTipo(titulo)} text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold ${c.text}">${titulo}</h3>
                    <p class="text-sm text-gray-500">${actividades.length} ${actividades.length === 1 ? 'registro' : 'registros'}</p>
                </div>
            </div>
            ${hayMas ? `
                <button class="btn-ver-mas text-sm font-semibold ${c.text} hover:underline flex items-center gap-1" 
                        data-seccion="${titulo.toLowerCase()}" 
                        data-color="${color}">
                    Ver todas <i class="bi bi-chevron-down"></i>
                </button>
            ` : ''}
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 cards-container" 
             data-seccion="${titulo.toLowerCase()}">
            ${actividadesVisibles.map(ac => crearCard(ac, color)).join('')}
        </div>
        
        ${hayMas ? `
            <div class="text-center mt-4 hidden cargar-mas-container" data-seccion="${titulo.toLowerCase()}">
                <button class="btn-cargar-mas px-6 py-2 ${c.bg} ${c.text} rounded-lg font-semibold hover:shadow-md transition">
                    Cargar más <i class="bi bi-arrow-down-circle ml-1"></i>
                </button>
            </div>
        ` : ''}
    `;

    return seccion;
}

// ======================================================
// OBTENER ÍCONO SEGÚN TIPO
// ======================================================
function getIconoTipo(tipo) {
    const iconos = {
        'Inspecciones': 'search',
        'Siembras': 'droplet-fill',
        'Seguimientos': 'journal-check',
        'Resiembras': 'arrow-repeat'
    };
    return iconos[tipo] || 'file-text';
}

// ======================================================
// CREAR CARD INDIVIDUAL
// ======================================================
function crearCard(ac, color) {
    const esInspeccion = ac.cod_act_campo == 4;
    const esSiembra = ac.cod_act_campo == 1;
    const esSeguimiento = ac.cod_act_campo == 3;
    const esResiembra = ac.cod_act_campo == 2;
    const idActividad = ac.cod_actividadtrabajocampo;

    let tipoActividad = "Inspección";
    if (esSiembra) tipoActividad = "Siembra";
    else if (esSeguimiento) tipoActividad = "Seguimiento";
    else if (esResiembra) tipoActividad = "Resiembra";

    const colores = {
        emerald: {
            border: 'border-emerald-400',
            badge: 'bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800',
            hover: 'hover:border-emerald-600',
            shadow: 'hover:shadow-emerald-200'
        },
        teal: {
            border: 'border-teal-400',
            badge: 'bg-gradient-to-r from-teal-100 to-teal-200 text-teal-800',
            hover: 'hover:border-teal-600',
            shadow: 'hover:shadow-teal-200'
        },
        cyan: {
            border: 'border-cyan-400',
            badge: 'bg-gradient-to-r from-cyan-100 to-cyan-200 text-cyan-800',
            hover: 'hover:border-cyan-600',
            shadow: 'hover:shadow-cyan-200'
        },
        green: {
            border: 'border-green-400',
            badge: 'bg-gradient-to-r from-green-100 to-green-200 text-green-800',
            hover: 'hover:border-green-600',
            shadow: 'hover:shadow-green-200'
        }
    };

    const c = colores[color];

    // Formatear fecha
    const fecha = new Date(ac.fecha_actividad);
    const fechaFormateada = fecha.toLocaleDateString('es-CO', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });

    return `
        <div class="card-actividad bg-white rounded-2xl shadow-lg border-2 ${c.border} ${c.hover} ${c.shadow} transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl overflow-hidden"
             data-id="${idActividad}" 
             data-tipo="${tipoActividad}">
            
            <!-- Header de la Card -->
            <div class="p-5 bg-gradient-to-br from-white to-gray-50">
                <div class="flex items-start justify-between mb-3">
                    <span class="${c.badge} px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide shadow-sm">
                        ${tipoActividad}
                    </span>
                    <span class="text-gray-400 text-xs font-medium">#${idActividad}</span>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="bi bi-calendar-event text-lg text-emerald-600"></i>
                        <span class="font-semibold text-sm">${fechaFormateada}</span>
                    </div>
                    
                    <div class="flex items-start gap-2 text-gray-600">
                        <i class="bi bi-geo-alt-fill text-lg mt-0.5 text-teal-600"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium">${ac.nombre_sitio}</p>
                            <p class="text-xs text-gray-500">${ac.nombarrio || 'Sin barrio'}</p>
                        </div>
                    </div>
                    
                    ${ac.nombre_deposito ? `
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="bi bi-droplet text-lg text-cyan-600"></i>
                            <span class="text-xs">${ac.nombre_deposito}</span>
                        </div>
                    ` : ''}
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="px-5 py-3 bg-gradient-to-br from-gray-50 to-white border-t border-gray-100">
                <div class="grid grid-cols-3 gap-2 text-center">
                    ${esSiembra || esResiembra ? `
                        <div class="bg-white rounded-lg p-2 shadow-sm border border-blue-100">
                            <p class="text-xs text-gray-500">Alevines</p>
                            <p class="text-lg font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">${ac.alevines_guppies || 0}</p>
                        </div>
                        <div class="bg-white rounded-lg p-2 shadow-sm border border-emerald-100">
                            <p class="text-xs text-gray-500">Adultos</p>
                            <p class="text-lg font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent">${ac.adultos_guppies || 0}</p>
                        </div>
                        <div class="bg-white rounded-lg p-2 shadow-sm border border-teal-100">
                            <p class="text-xs text-gray-500">pH</p>
                            <p class="text-lg font-bold text-teal-600">${ac.ph || '-'}</p>
                        </div>
                    ` : esSeguimiento ? `
                        <div class="bg-white rounded-lg p-2 shadow-sm border ${ac.positivo_larvas_aedes == 1 ? 'border-red-100' : 'border-emerald-100'}">
                            <p class="text-xs text-gray-500">Larvas</p>
                            <p class="text-sm font-bold ${ac.positivo_larvas_aedes == 1 ? 'text-red-600' : 'text-emerald-600'}">
                                ${ac.positivo_larvas_aedes == 1 ? 'Sí' : 'No'}
                            </p>
                        </div>
                        <div class="bg-white rounded-lg p-2 shadow-sm border ${ac.positivo_pupas == 1 ? 'border-red-100' : 'border-emerald-100'}">
                            <p class="text-xs text-gray-500">Pupas</p>
                            <p class="text-sm font-bold ${ac.positivo_pupas == 1 ? 'text-red-600' : 'text-emerald-600'}">
                                ${ac.positivo_pupas == 1 ? 'Sí' : 'No'}
                            </p>
                        </div>
                        <div class="bg-white rounded-lg p-2 shadow-sm border border-cyan-100">
                            <p class="text-xs text-gray-500">Temp</p>
                            <p class="text-sm font-bold text-cyan-600">${ac.temperatura || '-'}°</p>
                        </div>
                    ` : `
                        <div class="bg-white rounded-lg p-2 shadow-sm col-span-3 border border-emerald-100">
                            <p class="text-xs text-gray-500 mb-1">Estado</p>
                            <div class="flex items-center justify-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                <span class="text-xs font-semibold text-emerald-700">Activa</span>
                            </div>
                        </div>
                    `}
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="p-4 bg-gradient-to-br from-white to-gray-50 border-t border-gray-100 flex items-center justify-between gap-2">
                <div class="flex gap-2">
                    <button class="btn-ver action-button bg-gradient-to-br from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 text-blue-600 p-2 rounded-lg transition shadow-sm border border-blue-200"
                            title="Ver detalles"
                            ${getDataAttributesVer(ac, tipoActividad)}>
                        <i class="bi bi-eye-fill"></i>
                    </button>
                    
                    <button class="btn-editar action-button bg-gradient-to-br from-teal-50 to-emerald-50 hover:from-teal-100 hover:to-emerald-100 text-teal-600 p-2 rounded-lg transition shadow-sm border border-teal-200"
                            title="Editar"
                            ${getDataAttributesEditar(ac, tipoActividad, esSiembra, esResiembra)}>
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    
                    ${!esInspeccion ? `
                        <button class="btn-informe action-button bg-gradient-to-br from-cyan-50 to-blue-50 hover:from-cyan-100 hover:to-blue-100 text-cyan-600 p-2 rounded-lg transition shadow-sm border border-cyan-200"
                                title="Generar Informe"
                                data-id="${idActividad}"
                                data-tipo="${tipoActividad}">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        </button>
                    ` : ''}
                </div>
                
                <div class="flex gap-2">
                    ${getBotonesAccion(ac, esInspeccion, esSiembra, esSeguimiento, esResiembra)}
                </div>
            </div>
        </div>
    `;
}

// ======================================================
// OBTENER DATA ATTRIBUTES PARA VER
// ======================================================
function getDataAttributesVer(ac, tipoActividad) {
    return `
        data-tipo="${tipoActividad}"
        data-fecha="${ac.fecha_actividad}"
        data-barrio="${ac.nombarrio || 'Sin barrio'}"
        data-sitio="${ac.nombre_sitio}"
        data-deposito="${ac.nombre_deposito || ''}"
        data-responsable="${ac.responsable || ''}"
        data-ph="${ac.ph || ''}"
        data-usuario="${ac.usuario || ''}"
        data-cloro="${ac.cloro || ''}"
        data-temperatura="${ac.temperatura || ''}"
        data-ancho="${ac.ancho_deposito || ''}"
        data-largo="${ac.largo_deposito || ''}"
        data-profundidad="${ac.profundidad_deposito || ''}"
        data-alevines="${ac.alevines_guppies || ''}"
        data-adultos="${ac.adultos_guppies || ''}"
        data-larvas="${ac.positivo_larvas_aedes || ''}"
        data-pupas="${ac.positivo_pupas || ''}"
        data-culex="${ac.positivo_culex || ''}"
        data-observaciones="${ac.observaciones || ''}"
    `;
}

// ======================================================
// OBTENER DATA ATTRIBUTES PARA EDITAR
// ======================================================
function getDataAttributesEditar(ac, tipoActividad, esSiembra, esResiembra) {
    return `
        data-tipo="${tipoActividad}"
        data-id="${ac.cod_actividadtrabajocampo}"
        data-cod_sitiodepo="${ac.cod_sitiodepo || 0}"
        data-fecha="${ac.fecha_actividad}"
        data-usuario="${ac.usuario || ''}"
        data-sitio="${ac.nombre_sitio}"
        data-deposito="${ac.nombre_deposito || ''}"
        data-responsable="${ac.responsable || ''}"
        data-ph="${ac.ph || ''}"
        data-cloro="${ac.cloro || ''}"
        data-temperatura="${ac.temperatura || ''}"
        data-cod_tipodepo="${ac.cod_tipodepo || 0}"
        data-cod_sitiocontrolbiolo="${ac.cod_sitiocontrolbiolo || 0}"
        data-ancho="${ac.ancho_deposito || ''}"
        data-largo="${ac.largo_deposito || ''}"
        data-profundidad="${ac.profundidad_deposito || ''}"
        data-alevines="${ac.alevines_guppies || '0'}"
        data-adultos="${ac.adultos_guppies || '0'}"
        data-larvas="${ac.positivo_larvas_aedes || '0'}"
        data-pupas="${ac.positivo_pupas || '0'}"
        data-culex="${ac.positivo_culex || '0'}"
        data-observaciones="${ac.observaciones || ''}"
        ${esSiembra ? `data-id-siembra="${ac.cod_actividadtrabajocampo}"` : ''}
        ${esResiembra ? `data-id-resiembra="${ac.cod_actividadtrabajocampo}"` : ''}
    `;
}

// ======================================================
// OBTENER BOTONES DE ACCIÓN ESPECÍFICOS
// ======================================================
function getBotonesAccion(ac, esInspeccion, esSiembra, esSeguimiento, esResiembra) {
    const idActividad = ac.cod_actividadtrabajocampo;

    if (esInspeccion) {
        return `
            <button class="btn-siembra action-button bg-gradient-to-br from-emerald-50 to-green-50 hover:from-emerald-100 hover:to-green-100 text-emerald-600 p-2 rounded-lg transition shadow-sm border border-emerald-200" 
                    title="Registrar Siembra"
                    data-id="${idActividad}"
                    data-cod_sitiodepo="${ac.cod_sitiodepo || 0}"
                    data-fecha="${ac.fecha_actividad}"
                    data-sitio="${ac.nombre_sitio}"
                    data-deposito="${ac.nombre_deposito || ''}">
                <i class="bi bi-arrow-right-circle-fill"></i>
            </button>
            <button class="btn-anular action-button bg-gradient-to-br from-red-50 to-pink-50 hover:from-red-100 hover:to-pink-100 text-red-600 p-2 rounded-lg transition shadow-sm border border-red-200" 
                    title="Anular Actividad"
                    data-id="${idActividad}">
                <i class="bi bi-trash-fill"></i>
            </button>
        `;
    }

    if (esSiembra) {
        return `
            <button class="btn-seguimiento action-button bg-gradient-to-br from-cyan-50 to-teal-50 hover:from-cyan-100 hover:to-teal-100 text-cyan-600 p-2 rounded-lg transition shadow-sm border border-cyan-200" 
                    title="Registrar Seguimiento"
                    data-id-siembra="${idActividad}"
                    data-sitio="${ac.nombre_sitio}"
                    data-cod_sitiodepo="${ac.cod_sitiodepo || 0}"
                    data-deposito="${ac.nombre_deposito || ''}"
                    data-responsable="${ac.responsable || ''}">
                <i class="bi bi-journal-check"></i>
            </button>
        `;
    }

    if (esResiembra) {
        return `
            <button class="btn-seguimiento-resiembra action-button bg-gradient-to-br from-cyan-50 to-blue-50 hover:from-cyan-100 hover:to-blue-100 text-cyan-600 p-2 rounded-lg transition shadow-sm border border-cyan-200" 
                    title="Registrar Seguimiento de Resiembra"
                    data-id="${idActividad}"
                    data-id-resiembra="${idActividad}"
                    data-cod_sitiodepo="${ac.cod_sitiodepo || 0}"
                    data-sitio="${ac.nombre_sitio}"
                    data-deposito="${ac.nombre_deposito || ''}">
                <i class="bi bi-arrow-right-circle"></i>
            </button>
        `;
    }

    if (esSeguimiento) {
        return `
            <button class="btn-resiembra action-button bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 text-green-600 p-2 rounded-lg transition shadow-sm border border-green-200"
                    title="Hacer Resiembra"
                    data-id="${idActividad}"
                    data-cod_sitiodepo="${ac.cod_sitiodepo || 0}"
                    data-sitio="${ac.nombre_sitio}"
                    data-deposito="${ac.nombre_deposito || ''}">
                <i class="bi bi-arrow-repeat"></i>
            </button>
            <button class="btn-seguimiento action-button bg-gradient-to-br from-teal-50 to-cyan-50 hover:from-teal-100 hover:to-cyan-100 text-teal-600 p-2 rounded-lg transition shadow-sm border border-teal-200"
                    title="Nuevo Seguimiento"
                    data-id="${idActividad}"
                    data-cod_sitiodepo="${ac.cod_sitiodepo || 0}"
                    data-sitio="${ac.nombre_sitio}"
                    data-deposito="${ac.nombre_deposito || ''}">
                <i class="bi bi-journal-plus"></i>
            </button>
        `;
    }

    return '';
}

// ======================================================
// EVENT LISTENERS
// ======================================================
document.addEventListener('DOMContentLoaded', function () {
    // Event delegation para todos los botones
    document.addEventListener('click', function (e) {
        const target = e.target.closest('button');
        if (!target) return;

        // Siembra
        if (target.classList.contains('btn-siembra')) {
            abrirFormularioSiembra(target);
        }

        // Seguimiento
        if (target.classList.contains('btn-seguimiento')) {
            abrirSeguimiento(target);
        }

        // Seguimiento de Resiembra
        if (target.classList.contains('btn-seguimiento-resiembra')) {
            abrirSeguimientoResiembra(target);
        }

        // Resiembra
        if (target.classList.contains('btn-resiembra')) {
            abrirResiembra(target);
        }

        // Ver detalles
        if (target.classList.contains('btn-ver')) {
            mostrarDetalles(target);
        }

        // Ver más
        if (target.classList.contains('btn-ver-mas')) {
            const seccion = target.dataset.seccion;
            mostrarTodasLasCards(seccion, target.dataset.color);
            target.style.display = 'none';
        }

        // Cargar más
        if (target.classList.contains('btn-cargar-mas')) {
            // Implementar lógica de scroll infinito si se necesita
        }
    });
});

// ======================================================
// MOSTRAR TODAS LAS CARDS DE UNA SECCIÓN
// ======================================================
function mostrarTodasLasCards(seccion, color) {
    const organizadas = organizarActividadesPorTipo(todasLasActividades);
    let actividades = [];

    if (seccion === 'inspecciones') actividades = organizadas.inspecciones;
    else if (seccion === 'siembras') actividades = organizadas.siembras;
    else if (seccion === 'seguimientos') actividades = organizadas.seguimientos;
    else if (seccion === 'resiembras') actividades = organizadas.resiembras;

    const container = document.querySelector(`.cards-container[data-seccion="${seccion}"]`);
    if (!container) return;

    // Animar la expansión
    container.style.maxHeight = container.scrollHeight + 'px';
    container.style.transition = 'max-height 0.5s ease-out';

    // Renderizar todas las cards
    container.innerHTML = actividades.map(ac => crearCard(ac, color)).join('');

    // Animar la aparición de las nuevas cards
    setTimeout(() => {
        container.querySelectorAll('.card-actividad').forEach((card, index) => {
            setTimeout(() => {
                card.style.animation = 'fadeInUp 0.4s ease-out';
            }, index * 50);
        });
    }, 100);
}

// ======================================================
// ANULAR ACTIVIDAD
// ======================================================
document.addEventListener("click", async function (e) {
    if (e.target.closest(".btn-anular")) {
        const btn = e.target.closest(".btn-anular");
        const idActividad = btn.dataset.id;

        console.log('🎯 CLICK EN ANULAR');
        console.log('ID de actividad:', idActividad);

        if (!idActividad) {
            alertas.error('No se encontró el ID de la actividad');
            return;
        }

        const resultado = await alertas.eliminar('¿Deseas anular esta inspección?');
        console.log('Resultado de confirmación:', resultado);

        if (resultado.isConfirmed) {
            alertas.cargando('Anulando inspección...');

            try {
                const url = "../controller/actividadescontrol.php?accion=anular";
                const body = `id_actividad=${idActividad}`;

                console.log('🚀 ENVIANDO REQUEST:');
                console.log('URL:', url);
                console.log('Body:', body);

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: body
                });

                console.log('📡 RESPONSE RECIBIDO:');
                console.log('Status:', response.status);
                console.log('OK:', response.ok);

                const text = await response.text();
                console.log('📄 TEXTO CRUDO:', text);

                let data;
                try {
                    data = JSON.parse(text);
                    console.log('✅ JSON PARSEADO:', data);
                } catch (parseError) {
                    console.error('❌ ERROR AL PARSEAR JSON:', parseError);
                    console.error('Texto recibido:', text);
                    alertas.cerrarCargando();
                    alertas.error('El servidor devolvió una respuesta inválida');
                    return;
                }

                alertas.cerrarCargando();

                if (data.success) {
                    console.log('✅ ÉXITO');
                    await alertas.exitoEspecial(data.mensaje || 'La inspección ha sido anulada');

                    // Animar y eliminar la card
                    const card = btn.closest('.card-actividad');
                    if (card) {
                        card.style.animation = 'fadeOut 0.3s ease-out';
                        setTimeout(() => {
                            card.remove();
                        }, 300);
                    }
                } else {
                    console.error('❌ ERROR DEL SERVIDOR:', data);
                    alertas.error(data.mensaje || data.error || 'No se pudo anular');
                }
            } catch (err) {
                alertas.cerrarCargando();
                console.error('❌ ERROR EN FETCH:', err);
                console.error('Tipo de error:', err.name);
                console.error('Mensaje:', err.message);
                console.error('Stack:', err.stack);
                alertas.error('No se pudo completar la operación: ' + err.message);
            }
        }
    }
});
// ======================================================
// ANIMACIONES CSS
// ======================================================
const estilosAnimaciones = document.createElement('style');
estilosAnimaciones.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.9);
        }
    }
    
    .fade-in-section {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .card-actividad {
        animation: fadeInUp 0.4s ease-out;
    }
    
    .action-button {
        transition: all 0.2s ease;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .action-button:active {
        transform: translateY(0);
    }
`;
document.head.appendChild(estilosAnimaciones);
// ============================================
// CONTROL DEL MENÚ LATERAL
// ============================================

document.addEventListener('DOMContentLoaded', function () {

    // Elementos del DOM
    const btnAside = document.getElementById('btn-aside');
    const aside = document.getElementById('aside');
    const body = document.body;
    const menuLinks = aside ? aside.querySelectorAll('a') : [];

    // Verificar que los elementos existan
    if (!btnAside || !aside) {
        console.warn('No se encontraron los elementos del menú lateral');
        return;
    }

    // Estado del menú
    let isMenuOpen = false;

    // ============================================
    // FUNCIÓN PARA TOGGLE DEL MENÚ
    // ============================================
    function toggleMenu() {
        isMenuOpen = !isMenuOpen;

        if (isMenuOpen) {
            // Abrir menú
            aside.classList.remove('-translate-x-full');
            aside.classList.add('translate-x-0');
            btnAside.classList.add('opacity-0');
        } else {
            // Cerrar menú
            aside.classList.add('-translate-x-full');
            aside.classList.remove('translate-x-0');
            btnAside.classList.remove('opacity-0');
        }
    }

    // ============================================
    // EVENTOS DEL MENÚ
    // ============================================

    // Click en la barra lateral izquierda para abrir
    btnAside.addEventListener('click', function (e) {
        e.stopPropagation();
        if (!isMenuOpen) {
            toggleMenu();
        }
    });

    // Click fuera del menú para cerrar
    document.addEventListener('click', function (e) {
        if (isMenuOpen &&
            !aside.contains(e.target) &&
            !btnAside.contains(e.target)) {
            toggleMenu();
        }
    });

    // Prevenir que clicks dentro del aside lo cierren
    aside.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Cerrar menú al hacer click en enlaces
    menuLinks.forEach(link => {
        link.addEventListener('click', function () {
            setTimeout(() => {
                if (isMenuOpen) {
                    toggleMenu();
                }
            }, 200);
        });
    });

    // ============================================
    // CERRAR MENÚ CON TECLA ESC
    // ============================================
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isMenuOpen) {
            toggleMenu();
        }
    });

    // ============================================
    // DETECTAR PÁGINA ACTUAL Y MARCARLA
    // ============================================
    function markActiveLink() {
        const currentPage = window.location.pathname.split('/').pop();

        menuLinks.forEach(link => {
            const linkHref = link.getAttribute('href');
            if (!linkHref) return;

            const linkPage = linkHref.split('/').pop();

            if (linkPage === currentPage ||
                (currentPage === '' && linkPage === 'inicio.php')) {

                // Agregar borde izquierdo destacado
                link.style.borderLeft = '3px solid var(--verde-principal, #10b981)';
                link.style.paddingLeft = '5px';

                // Hacer el icono más visible
                const img = link.querySelector('img');
                const icon = link.querySelector('i');

                if (img) {
                    img.style.filter = 'brightness(1.2) drop-shadow(0 0 8px rgba(16, 185, 129, 0.5))';
                }
                if (icon) {
                    icon.style.color = 'var(--verde-principal, #10b981)';
                    icon.style.filter = 'drop-shadow(0 0 8px rgba(16, 185, 129, 0.5))';
                }
            }
        });
    }

    markActiveLink();

    // ============================================
    // HOVER EFFECT EN LA BARRA DE ACTIVACIÓN
    // ============================================
    btnAside.addEventListener('mouseenter', function () {
        if (!isMenuOpen) {
            this.style.backgroundColor = 'rgba(100, 116, 139, 0.6)';
        }
    });

    btnAside.addEventListener('mouseleave', function () {
        if (!isMenuOpen) {
            this.style.backgroundColor = 'rgba(100, 116, 139, 0.4)';
        }
    });

    // ============================================
    // MANEJO DE IMÁGENES FALTANTES
    // ============================================
    const images = aside.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function () {
            // Si la imagen no carga, usar un ícono de Font Awesome como fallback
            const parent = this.parentElement;
            this.style.display = 'none';

            // Crear ícono de respaldo
            const fallbackIcon = document.createElement('i');
            fallbackIcon.className = 'fas fa-image text-2xl text-gray-400';
            parent.appendChild(fallbackIcon);

            console.warn(`⚠️ Imagen no encontrada: ${this.src}`);
        });
    });

    // ============================================
    // LOG PARA DEBUGGING
    // ============================================
    console.log('✅ Menú lateral inicializado correctamente');
});

// ============================================
// FUNCIÓN GLOBAL PARA ABRIR/CERRAR DESDE OTROS SCRIPTS
// ============================================
window.toggleSidebar = function () {
    const aside = document.getElementById('aside');
    const btnAside = document.getElementById('btn-aside');
    if (aside && btnAside) {
        const event = new Event('click');
        btnAside.dispatchEvent(event);
    }
};