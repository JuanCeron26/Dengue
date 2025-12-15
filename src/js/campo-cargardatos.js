// ================================
// ARCHIVO: cargardatos.js
// Propósito: Inicialización y carga de datos principales
// ================================

// Variable global para almacenar todas las actividades
window.actividadesGlobales = [];

// ================================
// CONFIGURACIÓN DE RUTAS
// ================================
const BASE_URL = '../controllers/actividadescontrol.php';

// ================================
// INICIALIZACIÓN AL CARGAR LA PÁGINA
// ================================
document.addEventListener("DOMContentLoaded", () => {


    // Cargar todos los datos
    cargarSitios();
    cargarDepositos();
    cargarUsuarios();
    cargarTiposActividad();
    cargarActividades();

    // Configurar event listeners para filtros
    configurarFiltros();



    // ================================
    // CARGAR SITIOS
    // ================================
    function cargarSitios() {

        // Cargar sitios para el formulario de inspección
        fetch(`${BASE_URL}?accion=sitios`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                

                const selectSitio = document.getElementById("select_sitio");
                if (selectSitio) {
                    selectSitio.innerHTML = '<option value="">Seleccione un sitio...</option>';
                    data.forEach(sitio => {
                        selectSitio.innerHTML += `<option value="${sitio.cod_sitiocontrolbiolo}">${sitio.nombre_sitio}</option>`;
                    });
                }
            })
            .catch(err => console.error("❌ Error cargando sitios:", err));

        // Cargar sitios para el filtro
        fetch(`${BASE_URL}?accion=sitios`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                const selectSitioFiltro = document.getElementById("select_sitio_filtro");
                if (selectSitioFiltro) {
                    selectSitioFiltro.innerHTML = '<option value="">Todos los sitios</option>';
                    data.forEach(sitio => {
                        selectSitioFiltro.innerHTML += `<option value="${sitio.cod_sitiocontrolbiolo}">${sitio.nombre_sitio}</option>`;
                    });
                }
            })
            .catch(err => console.error("❌ Error cargando sitios filtro:", err));
    }

    // ================================
    // CARGAR DEPÓSITOS
    // ================================
    function cargarDepositos() {
        

        fetch(`${BASE_URL}?accion=depositos`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log('✅ Depósitos cargados:', data.length);

                const selectDeposito = document.getElementById("select_deposito");
                if (selectDeposito) {
                    selectDeposito.innerHTML = '<option value="">Seleccione un depósito...</option>';
                    data.forEach(dep => {
                        selectDeposito.innerHTML += `<option value="${dep.cod_tipo_depo}">${dep.nombre_deposito}</option>`;
                    });
                }
            })
            .catch(err => console.error("❌ Error cargando depósitos:", err));
    }

    // ================================
    // CARGAR USUARIOS
    // ================================
    function cargarUsuarios() {
        

        fetch(`${BASE_URL}?accion=usuarios`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log('✅ Usuarios cargados:', data.length);

                document.querySelectorAll(".select_usuario").forEach(select => {
                    select.innerHTML = '<option value="" disabled selected>-- Seleccione --</option>';
                    data.forEach(usu => {
                        select.innerHTML += `<option value="${usu.id_usuarios}">${usu.nombre_usu} ${usu.apellido_usu}</option>`;
                    });
                });
            })
            .catch(err => console.error("❌ Error cargando usuarios:", err));
    }

    // ================================
    // CARGAR TIPOS DE ACTIVIDAD
    // ================================
    function cargarTiposActividad() {
        

        fetch(`${BASE_URL}?accion=tipo_actividad`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                

                const selectTipoActividad = document.getElementById("tipo_actividad_filtro");
                if (selectTipoActividad) {
                    selectTipoActividad.innerHTML = '<option value="">Todas las actividades</option>';
                    data.forEach(tipoact => {
                        selectTipoActividad.innerHTML += `<option value="${tipoact.cod_act_campo}">${tipoact.nombre_actividad}</option>`;
                    });
                }
            })
            .catch(err => console.error("❌ Error cargando tipos de actividad:", err));
    }

    // ================================
    // CARGAR ACTIVIDADES
    // ================================
    function cargarActividades() {
        

        fetch(`${BASE_URL}?accion=listar`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log('✅ Actividades cargadas:', data);

                const actividades = Array.isArray(data) ? data : [data];
                window.actividadesGlobales = actividades;

                prepararTipos(window.actividadesGlobales);
                pintarCards(window.actividadesGlobales);
            })
            .catch(err => {
                console.error("❌ Error cargando actividades:", err);
                mostrarMensajeError();
            });
    }

    // ================================
    // PREPARAR TIPOS DE ACTIVIDAD
    // ================================
    function prepararTipos(actividades) {
        actividades.forEach(ac => {
            switch (ac.cod_act_campo) {
                case 1:
                case "1":
                    ac.tipoActividad = "Siembra";
                    break;
                case 2:
                case "2":
                    ac.tipoActividad = "Resiembra";
                    break;
                case 3:
                case "3":
                    ac.tipoActividad = "Seguimiento";
                    break;
                case 4:
                case "4":
                    ac.tipoActividad = "Inspección";
                    break;
                default:
                    ac.tipoActividad = "Sin definir";
            }
        });
    }

    // ================================
    // CONFIGURAR FILTROS
    // ================================
    function configurarFiltros() {
        const filtroFecha = document.getElementById("filtro_fecha");
        const filtroSitio = document.getElementById("select_sitio_filtro");
        const filtroActividad = document.getElementById("tipo_actividad_filtro");
        const btnAplicar = document.getElementById("btn_aplicar_filtros");
        const btnLimpiar = document.getElementById("btn_limpiar_filtros");

        // Event listeners para cambios automáticos
        if (filtroFecha) {
            filtroFecha.addEventListener("change", aplicarFiltros);
        }
        if (filtroSitio) {
            filtroSitio.addEventListener("change", aplicarFiltros);
        }
        if (filtroActividad) {
            filtroActividad.addEventListener("change", aplicarFiltros);
        }

        // Event listeners para botones
        if (btnAplicar) {
            btnAplicar.addEventListener("click", aplicarFiltros);
        }
        if (btnLimpiar) {
            btnLimpiar.addEventListener("click", limpiarFiltros);
        }

        console.log('✅ Filtros configurados');
    }

    // ================================
    // APLICAR FILTROS
    // ================================
    function aplicarFiltros() {
        const fecha = document.getElementById("filtro_fecha")?.value || '';
        const sitio = document.getElementById("select_sitio_filtro")?.value || '';
        const actividad = document.getElementById("tipo_actividad_filtro")?.value || '';

        

        const url = `${BASE_URL}?accion=filtrar&fecha=${fecha}&sitio=${sitio}&actividad=${actividad}`;

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log('✅ Resultados filtrados:', data);

                const actividades = Array.isArray(data) ? data : [];
                prepararTipos(actividades);
                pintarCards(actividades);
            })
            .catch(err => {
                console.error("❌ Error filtrando:", err);
                mostrarMensajeError();
            });
    }

    // ================================
    // LIMPIAR FILTROS
    // ================================
    function limpiarFiltros() {
        

        const filtroFecha = document.getElementById("filtro_fecha");
        const filtroSitio = document.getElementById("select_sitio_filtro");
        const filtroActividad = document.getElementById("tipo_actividad_filtro");

        if (filtroFecha) filtroFecha.value = "";
        if (filtroSitio) filtroSitio.value = "";
        if (filtroActividad) filtroActividad.value = "";

        // Mostrar todas las actividades
        prepararTipos(window.actividadesGlobales);
        pintarCards(window.actividadesGlobales);

        
    }

    // ================================
    // MOSTRAR MENSAJE DE ERROR
    // ================================
    function mostrarMensajeError() {
        const contenedor = document.getElementById('contenedor_actividades');
        if (contenedor) {
            contenedor.innerHTML = `
            <div class="text-center py-12 bg-red-50 rounded-2xl shadow-lg border-2 border-red-200">
                <i class="bi bi-exclamation-triangle text-6xl text-red-400 mb-4"></i>
                <p class="text-red-600 text-lg font-semibold">Error al cargar los datos</p>
                <p class="text-red-500 text-sm mt-2">Por favor, verifica tu conexión e intenta nuevamente</p>
                <button onclick="location.reload()" class="mt-4 px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                    <i class="bi bi-arrow-clockwise mr-2"></i>Recargar página
                </button>
            </div>
        `;
        }
    }

    // ================================
    // FUNCIÓN DE RESPALDO PARA PINTAR CARDS
    // ================================
    if (typeof pintarCards === 'undefined') {
        window.pintarCards = function (actividades) {
            const contenedor = document.getElementById('contenedor_actividades');

            if (!contenedor) {
                console.error('❌ Contenedor de actividades no encontrado');
                return;
            }

            if (!actividades || actividades.length === 0) {
                contenedor.innerHTML = `
                <div class="text-center py-12 bg-white rounded-2xl shadow-lg">
                    <i class="bi bi-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">No hay actividades registradas</p>
                </div>
            `;
                return;
            }

            contenedor.innerHTML = '';

            actividades.forEach(actividad => {
                const card = document.createElement('div');
                card.className = 'bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300';

                // Determinar color según tipo de actividad
                let colorClass = 'bg-emerald-100 text-emerald-700';
                if (actividad.cod_act_campo == 1) colorClass = 'bg-blue-100 text-blue-700';
                if (actividad.cod_act_campo == 2) colorClass = 'bg-purple-100 text-purple-700';
                if (actividad.cod_act_campo == 3) colorClass = 'bg-orange-100 text-orange-700';
                if (actividad.cod_act_campo == 4) colorClass = 'bg-emerald-100 text-emerald-700';

                card.innerHTML = `
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            ${actividad.tipoActividad || 'Sin tipo'}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="bi bi-calendar-date mr-1"></i>
                            ${actividad.fecha || 'Sin fecha'}
                        </p>
                    </div>
                    <span class="px-3 py-1 ${colorClass} rounded-full text-xs font-bold">
                        ${actividad.tipoActividad || 'N/A'}
                    </span>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <p><i class="bi bi-geo-alt-fill mr-2 text-emerald-600"></i>${actividad.nombre_sitio || 'Sin sitio'}</p>
                    <p><i class="bi bi-person-circle mr-2 text-emerald-600"></i>${actividad.nombre_usu || 'Sin responsable'}</p>
                    ${actividad.observaciones ? `<p class="text-xs text-gray-500 mt-2"><i class="bi bi-chat-text mr-1"></i>${actividad.observaciones}</p>` : ''}
                </div>
                
                <div class="pt-4 border-t flex justify-end gap-2">
                    <button onclick="verDetalleActividad(${actividad.cod_actividadtrabajocampo})" 
                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition text-sm font-semibold">
                        <i class="bi bi-eye-fill mr-1"></i> Ver detalle
                    </button>
                </div>
            `;

                contenedor.appendChild(card);
            });

            
        };
    }

    // ================================
    // FUNCIÓN GLOBAL PARA VER DETALLE (PLACEHOLDER)
    // ================================
    if (typeof verDetalleActividad === 'undefined') {
        window.verDetalleActividad = function (id) {
            alert(`Función ver detalle para actividad ${id} - Implementar según necesidades`);
        };
    }

    
});