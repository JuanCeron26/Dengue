// Función para obtener el color según la etapa
function obtenerColorEtapa(etapa) {
    const colores = {
        1: 'from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700',
        2: 'from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700',
        3: 'from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700',
        4: 'from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700'
    };
    return colores[etapa] || 'from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700';
}

// Función para agregar estilos CSS
function agregarEstilosCSS() {
    if (document.getElementById('estilos-dinamicos')) return;

    const style = document.createElement('style');
    style.id = 'estilos-dinamicos';
    style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .card-territorio {
            animation: slideIn 0.6s ease-out forwards;
            opacity: 0;
        }
        
        .boton-icono {
            position: relative;
            width: 64px;
            height: 64px;
            border-radius: 18px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            overflow: visible;
        }
        
        .boton-icono .icono-contenedor {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            border-radius: 18px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .grupo-emerald .icono-contenedor {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }
        
        .grupo-blue .icono-contenedor {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }
        
        .grupo-sky .icono-contenedor {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        }
        
        .boton-icono:hover {
            transform: translateY(-8px) scale(1.15) rotate(5deg);
        }
        
        .grupo-emerald:hover .icono-contenedor {
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #059669, #047857);
        }
        
        .grupo-blue:hover .icono-contenedor {
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.5);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }
        
        .grupo-sky:hover .icono-contenedor {
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.5);
            background: linear-gradient(135deg, #0284c7, #0369a1);
        }
        
        .boton-icono:active {
            transform: translateY(-4px) scale(1.05);
        }
        
        .boton-icono .icono-contenedor i {
            transition: transform 0.3s ease;
        }
        
        .boton-icono:hover .icono-contenedor i {
            transform: scale(1.2) rotate(-5deg);
        }
        
        .badge-numero {
            position: absolute;
            top: -10px;
            right: -10px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            border: 3px solid white;
            z-index: 2;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .tooltip {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%) scale(0.8);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .boton-icono:hover .tooltip {
            opacity: 1;
            transform: translateX(-50%) scale(1);
            bottom: -45px;
        }
        
        .tooltip::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid rgba(0, 0, 0, 0.9);
        }

        /* Scrollbar personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #059669, #047857);
        }

        /* Animación para tarjetas de participantes */
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
        
        .card-participante {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }
    `;
    document.head.appendChild(style);
}

function formatearFecha(fecha) {
    if (!fecha) return '---';
    const date = new Date(fecha);
    const opciones = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('es-ES', opciones);
}

async function traerTerritorios() {
    const contenedor = document.getElementById('listadoTerritorios');
    const mensajeVacio = document.getElementById('mensajeVacio');

    const solicito = await fetch('../backend/api.php?ajax=territorios');
    const territorios = await solicito.json();

    if (territorios.length === 0) {
        contenedor.classList.add('hidden');
        mensajeVacio.classList.remove('hidden');
        return;
    }

    contenedor.innerHTML = '';
    mensajeVacio.classList.add('hidden');

    territorios.forEach((territorio, index) => {
        const tarjeta = document.createElement('div');
        tarjeta.className = 'card-territorio rounded-3xl p-6 transform transition-all duration-500 hover:scale-[1.02] hover:-translate-y-2 cursor-pointer group';
        tarjeta.style.animationDelay = `${index * 100}ms`;

        tarjeta.innerHTML = `
            <div class="shimmer-effect absolute inset-0 rounded-3xl pointer-events-none"></div>
            
            <div class="relative flex items-center justify-between gap-6">
                <!-- Información del territorio -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-emerald-400 to-teal-400 animate-pulse"></div>
                        <h3 class="text-2xl font-bold text-slate-800 group-hover:text-emerald-600 transition-colors duration-300 truncate">
                            ${territorio.nombre_sitio}
                        </h3>
                    </div>
                    <div class="flex items-center gap-2 ml-7">
                        <i class="fas fa-map-marker-alt text-emerald-500 text-sm"></i>
                        <p class="text-slate-600 text-lg font-medium">${territorio.nombarrio}</p>
                    </div>
                </div>
                
                <!-- Iconos de acciones -->
                <div class="flex items-center gap-3">
                    <button 
                        class="boton-icono grupo-emerald" 
                        data-accion="territorio" 
                        data-id="${territorio.cod_territorio}"
                        data-nombre="${territorio.nombre_sitio}"
                        title="Territorio Priorizado">
                        <div class="icono-contenedor">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span class="tooltip">Territorio</span>
                    </button>
                    
                    <button 
                        class="boton-icono grupo-blue" 
                        data-accion="focos" 
                        data-id="${territorio.cod_territorio}"
                        data-nombre="${territorio.nombre_sitio}"
                        title="Focos Potenciales">
                        <div class="icono-contenedor">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <span class="tooltip">Focos</span>
                    </button>
                    
                    <button 
                        class="boton-icono grupo-sky" 
                        data-accion="participantes" 
                        data-id="${territorio.cod_territorio}"
                        data-nombre="${territorio.nombre_sitio}"
                        title="Participantes">
                        <div class="icono-contenedor">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="tooltip">Participantes</span>
                    </button>
                </div>
                
                <!-- Botón de etapa -->
                <div class="ml-4">
                    <button 
                        class="relative group/etapa overflow-hidden"
                        data-accion="etapa"
                        data-id="${territorio.cod_territorio}">
                        <div class="absolute inset-0 bg-gradient-to-r ${obtenerColorEtapa(2)} opacity-0 group-hover/etapa:opacity-20 transition-opacity duration-300"></div>
                        <div class="relative px-8 py-4 rounded-2xl bg-gradient-to-r ${obtenerColorEtapa(2)} text-white font-bold text-lg shadow-lg transform group-hover/etapa:scale-110 group-hover/etapa:shadow-2xl transition-all duration-300 cursor-pointer flex items-center gap-3 min-w-[140px] justify-center">
                            <i class="fas fa-flag-checkered group-hover/etapa:rotate-12 transition-transform duration-300"></i>
                            <span>Etapa ${2}</span>
                        </div>
                    </button>
                </div>
            </div>
        `;

        contenedor.appendChild(tarjeta);
    });

    agregarEstilosCSS();
    EventosBotones();
}

async function obtenerInformacionTerritorio(codTerritorio) {
    try {
        const response = await fetch(`../backend/api.php?ajax=detalle_territorio&id=${codTerritorio}`);

        if (!response.ok) {
            throw new Error('Error al obtener datos del territorio');
        }

        const datos = await response.json();
        return datos;
    } catch (error) {
        console.error('Error en la petición:', error);
        throw error;
    }
}

async function mostrarModalTerritorio(codTerritorio) {
    const modal = document.getElementById('modalTerritorio');
    const modalContainer = modal.querySelector('.modal-container');
    const loading = document.getElementById('modalLoading');
    const contenido = document.getElementById('modalContenido');
    const errorDiv = document.getElementById('modalError');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modalContainer.classList.remove('scale-95', 'opacity-0');
        modalContainer.classList.add('scale-100', 'opacity-100');
    }, 10);

    loading.classList.remove('hidden');
    contenido.classList.add('hidden');
    errorDiv.classList.add('hidden');

    try {
        const datos = await obtenerInformacionTerritorio(codTerritorio);
        await new Promise(resolve => setTimeout(resolve, 500));
        llenarDatosModal(datos);
        loading.classList.add('hidden');
        contenido.classList.remove('hidden');
    } catch (error) {
        loading.classList.add('hidden');
        errorDiv.classList.remove('hidden');
        console.error('Error al cargar territorio:', error);
    }
}

function llenarDatosModal(datos) {
    document.getElementById('nombreSitio').textContent = datos.nombre_sitio || '---';
    document.getElementById('codSitio').textContent = datos.cod_sitioeco || '---';
    document.getElementById('direccionSitio').querySelector('span').textContent = datos.direccion_sitio || '---';

    const estadoElement = document.getElementById('estadoSitio');
    const estadoTexto = datos.cod_estadositioeco === 1 ? 'Inactivo' : 'Activo';
    const estadoClasses = datos.cod_estadositioeco === 1
        ? 'bg-red-100 text-red-800'
        : 'bg-emerald-100 text-emerald-800';
    estadoElement.className = `inline-flex items-center gap-2 px-3 py-1 rounded-lg font-bold ${estadoClasses}`;
    estadoElement.querySelector('span:last-child').textContent = estadoTexto;

    document.getElementById('nombreBarrio').textContent = datos.nombarrio || '---';
    document.getElementById('codBarrio').textContent = datos.cod_barrio || '---';

    const nombreCompleto = `${datos.nombre_lider || ''} ${datos.apellido_lider || ''}`.trim() || '---';
    document.getElementById('nombreLider').querySelector('span').textContent = nombreCompleto;
    document.getElementById('correoLider').querySelector('span').textContent = datos.correo_lider || '---';
    document.getElementById('celularLider').querySelector('span').textContent = datos.celular_lider || '---';

    document.getElementById('codTerritorio').textContent = datos.cod_territorio || '---';
    document.getElementById('fechaRegistro').querySelector('span').textContent = formatearFecha(datos.fecha_registro);
}

function cerrarModal() {
    const modal = document.getElementById('modalTerritorio');
    const modalContainer = modal.querySelector('.modal-container');

    modalContainer.classList.remove('scale-100', 'opacity-100');
    modalContainer.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// ==================== FUNCIONES PARA MODAL DE PARTICIPANTES ====================

async function obtenerParticipantesTerritorio(codTerritorio) {
    try {
        const response = await fetch(`../backend/api.php?ajax=detalle_participantes&id=${codTerritorio}`);

        if (!response.ok) {
            throw new Error('Error al obtener participantes del territorio');
        }

        const datos = await response.json();
        return datos;
    } catch (error) {
        console.error('Error en la petición:', error);
        throw error;
    }
}

async function mostrarModalParticipantes(codTerritorio, nombreTerritorio) {
    const modal = document.getElementById('modalParticipantes');
    const modalContainer = modal.querySelector('.modal-container');
    const loading = document.getElementById('modalParticipantesLoading');
    const contenido = document.getElementById('modalParticipantesContenido');
    const errorDiv = document.getElementById('modalParticipantesError');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modalContainer.classList.remove('scale-95', 'opacity-0');
        modalContainer.classList.add('scale-100', 'opacity-100');
    }, 10);

    loading.classList.remove('hidden');
    contenido.classList.add('hidden');
    errorDiv.classList.add('hidden');

    try {
        const participantes = await obtenerParticipantesTerritorio(codTerritorio);
        await new Promise(resolve => setTimeout(resolve, 500));
        llenarDatosParticipantes(participantes, nombreTerritorio);
        loading.classList.add('hidden');
        contenido.classList.remove('hidden');
    } catch (error) {
        loading.classList.add('hidden');
        errorDiv.classList.remove('hidden');
        console.error('Error al cargar participantes:', error);
    }
}

function llenarDatosParticipantes(participantes, nombreTerritorio) {
    const listaContainer = document.getElementById('listaParticipantes');
    const sinParticipantes = document.getElementById('sinParticipantes');
    const totalElement = document.getElementById('totalParticipantes');
    const nombreTerritorioElement = document.getElementById('nombreTerritorioParticipantes');

    nombreTerritorioElement.textContent = nombreTerritorio || '---';
    totalElement.textContent = participantes.length;

    if (participantes.length === 0) {
        listaContainer.classList.add('hidden');
        sinParticipantes.classList.remove('hidden');
        return;
    }

    listaContainer.classList.remove('hidden');
    sinParticipantes.classList.add('hidden');
    listaContainer.innerHTML = '';

    participantes.forEach((participante, index) => {
        const card = document.createElement('div');
        card.className = 'card-participante bg-white rounded-2xl p-5 border-2 border-slate-200 hover:border-sky-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1';
        card.style.animationDelay = `${index * 50}ms`;

        const nombreCompleto = `${participante.nom_part} ${participante.ape_part}`;
        const iniciales = `${participante.nom_part.charAt(0)}${participante.ape_part.charAt(0)}`.toUpperCase();

        card.innerHTML = `
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                    <span class="text-white font-bold text-xl">${iniciales}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-lg font-bold text-slate-800 mb-2 truncate">${nombreCompleto}</h4>
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <i class="fas fa-id-card text-sky-600 w-4"></i>
                            <span class="font-semibold">CC:</span>
                            <span>${participante.id_cedula || 'No registrada'}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <i class="fas fa-phone text-sky-600 w-4"></i>
                            <span class="font-semibold">Cel:</span>
                            <span>${participante.celular || 'No registrado'}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        listaContainer.appendChild(card);
    });
}

function cerrarModalParticipantes() {
    const modal = document.getElementById('modalParticipantes');
    const modalContainer = modal.querySelector('.modal-container');

    modalContainer.classList.remove('scale-100', 'opacity-100');
    modalContainer.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// ==================== EVENT LISTENERS ====================

function EventosBotones() {
    const divTerritorios = document.getElementById('listadoTerritorios');

    divTerritorios.addEventListener('click', (e) => {
        const boton = e.target.closest('button');
        if (!boton) return;

        const accion = boton.dataset.accion;
        const cod_territorio = boton.dataset.id;
        const nombre_territorio = boton.dataset.nombre;

        if (accion === 'territorio') {
            mostrarModalTerritorio(cod_territorio);
        } else if (accion === 'participantes') {
            mostrarModalParticipantes(cod_territorio, nombre_territorio);
        } else if (accion === 'focos') {
            alert('Modal de focos próximamente...');
        } else if (accion === 'etapa') {
            alert('Modal de etapa próximamente...');
        }
    });

    // Cerrar modal territorio
    document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModal);

    // Cerrar modal participantes
    document.getElementById('btnCerrarModalParticipantes')?.addEventListener('click', cerrarModalParticipantes);

    // Cerrar modales con click fuera
    document.getElementById('modalTerritorio')?.addEventListener('click', function (e) {
        if (e.target === this) cerrarModal();
    });

    document.getElementById('modalParticipantes')?.addEventListener('click', function (e) {
        if (e.target === this) cerrarModalParticipantes();
    });

    // Cerrar con tecla ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('modalTerritorio').classList.contains('hidden')) {
                cerrarModal();
            }
            if (!document.getElementById('modalParticipantes').classList.contains('hidden')) {
                cerrarModalParticipantes();
            }
        }
    });
}

// Inicializar la aplicación
document.addEventListener('DOMContentLoaded', function () {
    traerTerritorios();
    const btnIniciarEvento = document.getElementById('btnIniciarEvento')
    btnIniciarEvento.addEventListener('click', () => {
        window.location.href = 'etapa1.php'
    }
    )
});