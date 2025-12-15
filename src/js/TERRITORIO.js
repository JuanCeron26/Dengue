// ============================
// CONSTANTES Y VARIABLES
// ============================
const API_URL = "../controller/territoriolider.php";
const cardsContainer = document.getElementById("cardsContainer");

// Modales
const modalCrear = document.getElementById("modalCrear");
const modalEditar = document.getElementById("modalEditar");
const modalDetalles = document.getElementById("modalDetalles");
const modalParticipantes = document.getElementById("modalParticipantes");
const modalTitle = document.getElementById("modalCrearTitle");

// Botones modales
const openModalBtn = document.getElementById("openModalBtn");
const closeCrear = document.getElementById("closeCrear");
const btnCancelarCrear = document.getElementById("btnCancelarCrear");
const closeEditar = document.getElementById("closeEditar");
const btnCancelarEditar = document.getElementById("btnCancelarEditar");
const closeDetalles = document.getElementById("closeDetalles");
const btnCerrarDetalles = document.getElementById("btnCerrarDetalles");
const closeParticipantes = document.getElementById("closeParticipantes");

// Botones de modo
const btnModoNuevo = document.getElementById("btnModoNuevo");
const btnModoExistente = document.getElementById("btnModoExistente");

// Formularios
const formLider = document.getElementById("formLider");
const formNuevo = document.getElementById("formNuevo");
const formExistente = document.getElementById("formExistente");
const formLiderEditar = document.getElementById("formLiderEditar");
const formParticipante = document.getElementById("formParticipante");

// Inputs formulario nuevo
const inNombre = document.getElementById("inNombre");
const inApellido = document.getElementById("inApellido");
const inCorreo = document.getElementById("inCorreo");
const inCelular = document.getElementById("inCelular");
const inCedula = document.getElementById("inCedula");
const inClase = document.getElementById("inClase");

// Inputs formulario editar
const inNombreEditar = document.getElementById("inNombreEditar");
const inApellidoEditar = document.getElementById("inApellidoEditar");
const inCorreoEditar = document.getElementById("inCorreoEditar");
const inCelularEditar = document.getElementById("inCelularEditar");
const inCedulaEditar = document.getElementById("inCedulaEditar");
const inClaseEditar = document.getElementById("inClaseEditar");

// Inputs participantes
const pNombre = document.getElementById("pNombre");
const pApellido = document.getElementById("pApellido");
const pCedula = document.getElementById("pCedula");
const pCelular = document.getElementById("pCelular");
const btnAgregarPart = document.getElementById("btnAgregarPart");
const btnGuardarParts = document.getElementById("btnGuardarParts");
const listaParticipantes = document.getElementById("listaParticipantes");

// Inputs comunes
const inTerritorio = document.getElementById("inTerritorio");
const inTerritorioEditar = document.getElementById("inTerritorioEditar");
const inLiderExistente = document.getElementById("inLiderExistente");

// Variables de control
let modoRegistro = "nuevo";
let codTerroritorioEditando = null;
let participantesAgregados = [];

console.log("✅ TERRITORIO.js cargado");

// ============================
// CARGAR AL INICIAR
// ============================
document.addEventListener("DOMContentLoaded", () => {
    console.log("📄 DOM Cargado - Iniciando...");
    cargarTerritorios();
    cargarSitios();
    cargarSitiosEditar();
    cargarLideres();
    configurarModal();
    configurarValidaciones();
});

// ============================
// CONFIGURAR VALIDACIONES
// ============================
function configurarValidaciones() {
    // ========== FORMULARIO NUEVO ==========

    // CÉDULA NUEVO - Solo números, exactamente 10
    if (inCedula) {
        inCedula.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        inCedula.addEventListener('blur', function (e) {
            if (this.value.length > 0 && this.value.length !== 10) {
                iziToast.warning({
                    title: '⚠️ Cédula incompleta',
                    message: 'La cédula debe tener exactamente 10 dígitos',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        });
    }

    // CELULAR NUEVO - Solo números, exactamente 10
    if (inCelular) {
        inCelular.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        inCelular.addEventListener('blur', function (e) {
            if (this.value.length > 0 && this.value.length !== 10) {
                iziToast.warning({
                    title: '⚠️ Celular incompleto',
                    message: 'El celular debe tener exactamente 10 dígitos',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        });
    }

    // NOMBRE NUEVO - Solo letras
    if (inNombre) {
        inNombre.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    }

    // APELLIDO NUEVO - Solo letras
    if (inApellido) {
        inApellido.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    }

    // CLASE NUEVO - Solo letras
    if (inClase) {
        inClase.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    }

    // ========== FORMULARIO EDITAR ==========

    // CÉDULA EDITAR - Solo números, exactamente 10
    if (inCedulaEditar) {
        inCedulaEditar.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        inCedulaEditar.addEventListener('blur', function (e) {
            if (this.value.length > 0 && this.value.length !== 10) {
                iziToast.warning({
                    title: '⚠️ Cédula incompleta',
                    message: 'La cédula debe tener exactamente 10 dígitos',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        });
    }

    // CELULAR EDITAR - Solo números, exactamente 10
    if (inCelularEditar) {
        inCelularEditar.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        inCelularEditar.addEventListener('blur', function (e) {
            if (this.value.length > 0 && this.value.length !== 10) {
                iziToast.warning({
                    title: '⚠️ Celular incompleto',
                    message: 'El celular debe tener exactamente 10 dígitos',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        });
    }

    // NOMBRE EDITAR - Solo letras
    if (inNombreEditar) {
        inNombreEditar.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    }

    // APELLIDO EDITAR - Solo letras
    if (inApellidoEditar) {
        inApellidoEditar.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    }

    // CLASE EDITAR - Solo letras
    if (inClaseEditar) {
        inClaseEditar.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    }
}

// ============================
// CONFIGURAR MODAL
// ============================
function configurarModal() {
    openModalBtn.addEventListener("click", abrirModalNuevo);
    closeCrear.addEventListener("click", cerrarModalCrear);
    btnCancelarCrear.addEventListener("click", cerrarModalCrear);

    closeEditar.addEventListener("click", cerrarModalEditar);
    btnCancelarEditar.addEventListener("click", cerrarModalEditar);

    closeDetalles.addEventListener("click", cerrarModalDetalles);
    btnCerrarDetalles.addEventListener("click", cerrarModalDetalles);

    closeParticipantes.addEventListener("click", cerrarModalParticipantes);

    btnModoNuevo.addEventListener("click", () => cambiarModo("nuevo"));
    btnModoExistente.addEventListener("click", () => cambiarModo("existente"));

    btnAgregarPart.addEventListener("click", agregarParticipante);
    btnGuardarParts.addEventListener("click", guardarParticipantes);

    modalCrear.addEventListener("click", (e) => {
        if (e.target === modalCrear) cerrarModalCrear();
    });

    modalEditar.addEventListener("click", (e) => {
        if (e.target === modalEditar) cerrarModalEditar();
    });

    modalDetalles.addEventListener("click", (e) => {
        if (e.target === modalDetalles) cerrarModalDetalles();
    });

    modalParticipantes.addEventListener("click", (e) => {
        if (e.target === modalParticipantes) cerrarModalParticipantes();
    });

    formLider.addEventListener("submit", guardarLider);
    formLiderEditar.addEventListener("submit", guardarLiderEditar);

    console.log("✅ Eventos configurados");
}

function cambiarModo(modo) {
    modoRegistro = modo;

    if (modo === "nuevo") {
        formNuevo.classList.remove("hidden");
        formExistente.classList.add("hidden");

        inNombre.required = true;
        inApellido.required = true;
        inCorreo.required = true;
        inCelular.required = true;
        inCedula.required = true;
        inClase.required = true;

        inLiderExistente.required = false;

        btnModoNuevo.className = "flex-1 px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg";
        btnModoExistente.className = "flex-1 px-6 py-3 glass-dark border-2 border-[#A0CED9] rounded-xl font-semibold hover:border-[#7DD3C0]";
    } else {
        formNuevo.classList.add("hidden");
        formExistente.classList.remove("hidden");

        inNombre.required = false;
        inApellido.required = false;
        inCorreo.required = false;
        inCelular.required = false;
        inCedula.required = false;
        inClase.required = false;

        inLiderExistente.required = true;

        btnModoExistente.className = "flex-1 px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg";
        btnModoNuevo.className = "flex-1 px-6 py-3 glass-dark border-2 border-[#A0CED9] rounded-xl font-semibold hover:border-[#7DD3C0]";
    }
}

function abrirModalNuevo() {
    modoRegistro = "nuevo";
    modalTitle.innerHTML = '<i class="fas fa-user-plus"></i> Asociar Líder a Territorio';
    cambiarModo("nuevo");
    limpiarFormulario();

    modalCrear.classList.remove("hidden");
    modalCrear.classList.add("flex");
}

function cerrarModalCrear() {
    modalCrear.classList.add("hidden");
    modalCrear.classList.remove("flex");
    limpiarFormulario();
}

function cerrarModalEditar() {
    modalEditar.classList.add("hidden");
    modalEditar.classList.remove("flex");
    formLiderEditar.reset();
    codTerroritorioEditando = null;

    if (inCedulaEditar) {
        inCedulaEditar.disabled = false;
        inCedulaEditar.style.backgroundColor = '';
        inCedulaEditar.style.cursor = '';
        inCedulaEditar.style.opacity = '';
    }
}

function cerrarModalDetalles() {
    modalDetalles.classList.add("hidden");
    modalDetalles.classList.remove("flex");
}

function cerrarModalParticipantes() {
    modalParticipantes.classList.add("hidden");
    modalParticipantes.classList.remove("flex");
    formParticipante.reset();
    participantesAgregados = [];
    listaParticipantes.innerHTML = "";
}

function limpiarFormulario() {
    formLider.reset();
}

// ============================
// VALIDAR FORMULARIO NUEVO
// ============================
function validarFormularioNuevo() {
    let todosValidos = true;

    if (!inNombre.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El nombre del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inApellido.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El apellido del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inCorreo.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El correo del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    } else {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(inCorreo.value.trim())) {
            iziToast.error({
                title: '❌ Correo inválido',
                message: 'El correo electrónico no es válido',
                position: 'topRight',
                timeout: 3000
            });
            todosValidos = false;
        }
    }

    if (!inCelular.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El celular del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    } else if (inCelular.value.trim().length !== 10) {
        iziToast.error({
            title: '❌ Celular inválido',
            message: 'El celular debe tener exactamente 10 dígitos',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inCedula.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'La cédula del líder es obligatoria',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    } else if (inCedula.value.trim().length !== 10) {
        iziToast.error({
            title: '❌ Cédula inválida',
            message: 'La cédula debe tener exactamente 10 dígitos',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inClase.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'La clase de liderazgo es obligatoria',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inTerritorio.value) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'Debe seleccionar un sitio/territorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    return todosValidos;
}

// ============================
// VALIDAR FORMULARIO EDITAR
// ============================
function validarFormularioEditar() {
    let todosValidos = true;

    if (!inNombreEditar.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El nombre del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inApellidoEditar.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El apellido del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inCorreoEditar.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El correo del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    } else {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(inCorreoEditar.value.trim())) {
            iziToast.error({
                title: '❌ Correo inválido',
                message: 'El correo electrónico no es válido',
                position: 'topRight',
                timeout: 3000
            });
            todosValidos = false;
        }
    }

    if (!inCelularEditar.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'El celular del líder es obligatorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    } else if (inCelularEditar.value.trim().length !== 10) {
        iziToast.error({
            title: '❌ Celular inválido',
            message: 'El celular debe tener exactamente 10 dígitos',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inClaseEditar.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'La clase de liderazgo es obligatoria',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    if (!inTerritorioEditar.value) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'Debe seleccionar un sitio/territorio',
            position: 'topRight',
            timeout: 3000
        });
        todosValidos = false;
    }

    return todosValidos;
}

// ============================
// CARGAR SITIOS
// ============================
function cargarSitios() {
    fetch(`${API_URL}?accion=listar_sitios`)
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const sitios = response.data;
                inTerritorio.innerHTML = '<option value="">Selecciona sitio</option>';

                sitios.forEach(sitio => {
                    const option = document.createElement("option");
                    option.value = sitio.cod_sitioeco;
                    option.textContent = `${sitio.nombre_sitio} - ${sitio.nombarrio || 'Sin barrio'}`;
                    inTerritorio.appendChild(option);
                });
            }
        })
        .catch(err => console.error("ERROR AL CARGAR SITIOS:", err));
}

function cargarSitiosEditar() {
    fetch(`${API_URL}?accion=listar_sitios`)
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const sitios = response.data;
                inTerritorioEditar.innerHTML = '<option value="">Selecciona sitio</option>';

                sitios.forEach(sitio => {
                    const option = document.createElement("option");
                    option.value = sitio.cod_sitioeco;
                    option.textContent = `${sitio.nombre_sitio} - ${sitio.nombarrio || 'Sin barrio'}`;
                    inTerritorioEditar.appendChild(option);
                });
            }
        })
        .catch(err => console.error("ERROR AL CARGAR SITIOS EDITAR:", err));
}

// ============================
// CARGAR LÍDERES
// ============================
function cargarLideres() {
    fetch(`${API_URL}?accion=listar_lideres`)
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const lideres = response.data;
                inLiderExistente.innerHTML = '<option value="">Selecciona un líder</option>';

                lideres.forEach(lider => {
                    const option = document.createElement("option");
                    option.value = lider.id_lider;
                    option.textContent = `${lider.nombre_lider} ${lider.apellido_lider} - C.C: ${lider.id_cedula}`;
                    inLiderExistente.appendChild(option);
                });
            }
        })
        .catch(err => console.error("ERROR AL CARGAR LÍDERES:", err));
}

// ============================
// LISTAR TERRITORIOS
// ============================
function cargarTerritorios() {
    fetch(`../controller/territoriolider.php?accion=listar`)
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                pintarCards(response.data);
            } else {
                cardsContainer.innerHTML = `<p class="text-center text-red-600 col-span-3">Error al cargar datos</p>`;
            }
        })
        .catch(err => {
            console.error("ERROR AL CARGAR TERRITORIOS:", err);
            cardsContainer.innerHTML = `<p class="text-center text-red-600 col-span-3">Error de conexión</p>`;
        });
}

// ============================
// PINTAR CARDS
// ============================
function pintarCards(lista) {
    if (!cardsContainer) return;
    cardsContainer.innerHTML = "";

    if (!Array.isArray(lista) || lista.length === 0) {
        cardsContainer.innerHTML = `<p class="text-center text-gray-800 col-span-3">No hay registros disponibles.</p>`;
        return;
    }

    lista.forEach(item => {
        const card = document.createElement("div");
        card.className = "card-territorio";

        card.innerHTML = `
            <div class="card-header">
                <div class="card-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span>${item.fecha_registro || "2024-11-15"}</span>
                </div>
                <div class="card-actions">
                    <button onclick="verDetalles(${item.cod_territorio})" class="action-btn" title="Ver detalles">
                        <img src="../iconos/zoom.png" alt="Ver" class="w-5 h-5">
                    </button>
                    <button onclick="editarLider(${item.cod_territorio})" class="action-btn" title="Editar">
                        <img src="../iconos/edit.svg" alt="Editar" class="w-5 h-5">
                    </button>
                    <button onclick="eliminarLider(${item.cod_territorio})" class="action-btn" title="Eliminar">
                        <img src="../iconos/trash-2.svg" alt="Eliminar" class="w-5 h-5">
                    </button>
                </div>
            </div>

            <div class="card-body">
                <h2 class="card-leader-name">
                    ${item.nombre_lider || 'Sin nombre'}<br>
                    ${item.apellido_lider || ''}
                </h2>
                <div class="card-info-item">
                    <i class="fas fa-map-marker-alt card-info-icon"></i>
                    <span class="card-info-text">${item.nomcomun || 'N/A'}</span>
                </div>
                <div class="card-info-item">
                    <i class="fas fa-building card-info-icon"></i>
                    <span class="card-info-text"><b>Barrio:</b> ${item.nombarrio || 'Sin barrio'}</span>
                </div>
                <div class="card-info-item">
                    <i class="fas fa-home card-info-icon"></i>
                    <span class="card-info-highlight">${item.nombre_sitio || 'No asignado'}</span>
                </div>
                <div class="card-info-item">
                    <i class="fas fa-crown card-info-icon"></i>
                    <span class="card-info-text">${item.clase_liderazgo || 'N/A'}</span>
                </div>
            </div>
        `;

        cardsContainer.appendChild(card);
    });
}

// ============================
// GUARDAR LÍDER
// ============================
function guardarLider(e) {
    e.preventDefault();

    if (modoRegistro === "nuevo") {
        if (!validarFormularioNuevo()) {
            return;
        }
        registrarNuevoLider();
    } else {
        asociarLiderExistente();
    }
}

function registrarNuevoLider() {
    const datos = {
        nombre_lider: inNombre.value.trim(),
        apellido_lider: inApellido.value.trim(),
        correo_lider: inCorreo.value.trim(),
        celular: inCelular.value.trim(),
        id_cedula: inCedula.value.trim(),
        clase_liderazgo: inClase.value.trim(),
        cod_sitioeco: inTerritorio.value
    };

    fetch(`${API_URL}?accion=registrar_nuevo`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                iziToast.success({
                    title: '✅ Éxito',
                    message: response.message || 'Líder registrado exitosamente',
                    position: 'topRight',
                    timeout: 3000
                });
                cerrarModalCrear();
                cargarTerritorios();
                cargarLideres();
            } else if (response.existe) {
                iziToast.warning({
                    title: '⚠️ Advertencia',
                    message: response.message || 'El líder ya existe',
                    position: 'topRight',
                    timeout: 4000
                });
            } else {
                iziToast.error({
                    title: '❌ Error',
                    message: response.message || 'Error desconocido',
                    position: 'topRight',
                    timeout: 4000
                });
            }
        })
        .catch(err => {
            console.error("ERROR:", err);
            iziToast.error({
                title: '❌ Error de conexión',
                message: 'No se pudo conectar con el servidor',
                position: 'topRight',
                timeout: 4000
            });
        });
}

function asociarLiderExistente() {
    const id_lider = inLiderExistente.value;
    const cod_sitioeco = inTerritorio.value;

    if (!id_lider) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'Por favor selecciona un líder',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    if (!cod_sitioeco) {
        iziToast.warning({
            title: '⚠️ Campo requerido',
            message: 'Por favor selecciona un sitio/territorio',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    const datos = { id_lider, cod_sitioeco };

    fetch(`${API_URL}?accion=asociar_existente`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                iziToast.success({
                    title: '✅ Éxito',
                    message: response.message || 'Líder asociado exitosamente',
                    position: 'topRight',
                    timeout: 3000
                });
                cerrarModalCrear();
                cargarTerritorios();
            } else {
                iziToast.error({
                    title: '❌ Error',
                    message: response.message || 'Error desconocido',
                    position: 'topRight',
                    timeout: 4000
                });
            }
        })
        .catch(err => {
            console.error("ERROR:", err);
            iziToast.error({
                title: '❌ Error de conexión',
                message: 'No se pudo conectar con el servidor',
                position: 'topRight',
                timeout: 4000
            });
        });
}

// ============================
// VER DETALLES
// ============================
function verDetalles(cod_territorio) {
    console.log("🔍 Ver detalles:", cod_territorio);

    if (!cod_territorio) {
        iziToast.error({
            title: '❌ Error',
            message: 'Código de territorio inválido',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    const url = `${API_URL}?accion=obtener&cod_territorio=${cod_territorio}`;

    fetch(url)
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const data = response.data;

                document.getElementById("detallesContenido").innerHTML = `
                    <div class="glass-dark p-4 rounded-xl mb-4">
                        <h3 class="text-xl font-bold text-[#064E3B] mb-3">
                            <i class="fas fa-user"></i> Información del Líder
                        </h3>
                        <p class="mb-2"><strong>Fecha Registro:</strong> ${data.fecha_registro || 'N/A'}</p>
                        <p class="mb-2"><strong>Nombre:</strong> ${data.nombre_lider || 'N/A'} ${data.apellido_lider || ''}</p>
                        <p class="mb-2"><strong>Cédula:</strong> ${data.id_cedula || 'N/A'}</p>
                        <p class="mb-2"><strong>Correo:</strong> ${data.correo_lider || 'Sin correo'}</p>
                        <p class="mb-2"><strong>Celular:</strong> ${data.celular || 'Sin celular'}</p>
                        <p class="mb-2"><strong>Liderazgo:</strong> ${data.clase_liderazgo || 'N/A'}</p>
                    </div>
                    
                    <div class="glass-dark p-4 rounded-xl">
                        <h3 class="text-xl font-bold text-[#064E3B] mb-3">
                            <i class="fas fa-map-marker-alt"></i> Información del Territorio
                        </h3>
                        <p class="mb-2"><strong>Numero:</strong> ${data.cod_territorio || 'N/A'}</p>
                        <p class="mb-2"><strong>Sitio:</strong> ${data.nombre_sitio || 'N/A'}</p>
                        <p class="mb-2"><strong>Dirección:</strong> ${data.direccion_sitio || 'N/A'}</p>
                        <p class="mb-2"><strong>Barrio:</strong> ${data.nombarrio || 'N/A'}</p>
                        <p class="mb-2"><strong>Comuna:</strong> ${data.nomcomun || 'N/A'}</p>
                    </div>
                `;

                modalDetalles.classList.remove("hidden");
                modalDetalles.classList.add("flex");
            } else {
                iziToast.error({
                    title: '❌ Error',
                    message: response.message || 'No se encontró el territorio',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        })
        .catch(err => {
            console.error("❌ Error de red:", err);
            iziToast.error({
                title: '❌ Error de conexión',
                message: 'No se pudo conectar con el servidor',
                position: 'topRight',
                timeout: 4000
            });
        });
}

// ============================
// EDITAR LÍDER
// ============================
function editarLider(cod_territorio) {
    console.log("✏️ EDITAR LÍDER - ID:", cod_territorio);

    if (!cod_territorio) {
        iziToast.error({
            title: '❌ Error',
            message: 'Territorio no válido',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    const url = `${API_URL}?accion=obtener&cod_territorio=${cod_territorio}`;

    fetch(url)
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const data = response.data;

                codTerroritorioEditando = cod_territorio;

                inNombreEditar.value = data.nombre_lider || '';
                inApellidoEditar.value = data.apellido_lider || '';
                inCorreoEditar.value = data.correo_lider || '';
                inCelularEditar.value = data.celular || '';
                inCedulaEditar.value = data.id_cedula || '';
                inClaseEditar.value = data.clase_liderazgo || '';
                inTerritorioEditar.value = data.cod_sitioeco || '';

                inCedulaEditar.disabled = true;
                inCedulaEditar.style.backgroundColor = '#e9ecef';
                inCedulaEditar.style.cursor = 'not-allowed';
                inCedulaEditar.style.opacity = '0.7';

                modalEditar.classList.remove("hidden");
                modalEditar.classList.add("flex");
            } else {
                iziToast.error({
                    title: '❌ Error',
                    message: 'Error al cargar datos',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        })
        .catch(err => {
            console.error("ERROR:", err);
            iziToast.error({
                title: '❌ Error de conexión',
                message: 'No se pudo conectar con el servidor',
                position: 'topRight',
                timeout: 4000
            });
        });
}

// ============================
// GUARDAR CAMBIOS EDITAR
// ============================
function guardarLiderEditar(e) {
    e.preventDefault();

    console.log("🔥 GUARDAR EDITAR - Iniciando...");

    if (!codTerroritorioEditando) {
        iziToast.error({
            title: '❌ Error',
            message: 'No hay territorio para editar',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    if (!validarFormularioEditar()) {
        return;
    }

    const datos = {
        cod_territorio: codTerroritorioEditando,
        nombre_lider: inNombreEditar.value.trim(),
        apellido_lider: inApellidoEditar.value.trim(),
        correo_lider: inCorreoEditar.value.trim(),
        celular: inCelularEditar.value.trim(),
        id_cedula: inCedulaEditar.value.trim(),
        clase_liderazgo: inClaseEditar.value.trim(),
        cod_sitioeco: inTerritorioEditar.value
    };

    console.log("📤 Datos a enviar:", datos);

    fetch(`${API_URL}?accion=actualizar`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
        .then(res => res.json())
        .then(response => {
            console.log("📥 Respuesta del servidor:", response);

            if (response.success) {
                iziToast.success({
                    title: '✅ Éxito',
                    message: response.message || 'Actualizado exitosamente',
                    position: 'topRight',
                    timeout: 3000
                });
                cerrarModalEditar();
                cargarTerritorios();
            } else {
                iziToast.error({
                    title: '❌ Error',
                    message: response.message || 'Error al actualizar',
                    position: 'topRight',
                    timeout: 4000
                });
            }
        })
        .catch(err => {
            console.error("❌ ERROR:", err);
            iziToast.error({
                title: '❌ Error de conexión',
                message: 'No se pudo conectar con el servidor',
                position: 'topRight',
                timeout: 4000
            });
        });
}

// ============================
// ELIMINAR LÍDER
// ============================
function eliminarLider(cod_territorio) {
    if (!confirm("¿Estás segura de eliminar este territorio?")) {
        return;
    }

    fetch(`${API_URL}?accion=eliminar&cod_territorio=${cod_territorio}`)
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                iziToast.success({
                    title: '✅ Éxito',
                    message: response.message || 'Territorio eliminado exitosamente',
                    position: 'topRight',
                    timeout: 3000
                });
                cargarTerritorios();
            } else {
                iziToast.error({
                    title: '❌ Error',
                    message: response.message || 'Error al eliminar',
                    position: 'topRight',
                    timeout: 4000
                });
            }
        })
        .catch(err => {
            console.error("ERROR AL ELIMINAR:", err);
            iziToast.error({
                title: '❌ Error de conexión',
                message: 'No se pudo conectar con el servidor',
                position: 'topRight',
                timeout: 4000
            });
        });
}

// ============================
// PARTICIPANTES
// ============================
function abrirModalParticipantes() {
    participantesAgregados = [];
    listaParticipantes.innerHTML = "";
    formParticipante.reset();

    modalParticipantes.classList.remove("hidden");
    modalParticipantes.classList.add("flex");
}

function agregarParticipante() {
    if (!pNombre.value.trim() || !pApellido.value.trim()) {
        iziToast.warning({
            title: '⚠️ Campos requeridos',
            message: 'Por favor ingresa nombre y apellido del participante',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    const participante = {
        nombre: pNombre.value.trim(),
        apellido: pApellido.value.trim(),
        cedula: pCedula.value.trim() || 'N/A',
        celular: pCelular.value.trim() || 'N/A'
    };

    participantesAgregados.push(participante);
    mostrarParticipantes();
    formParticipante.reset();
}

function mostrarParticipantes() {
    listaParticipantes.innerHTML = "";
    participantesAgregados.forEach((p, index) => {
        const li = document.createElement("li");
        li.className = "bg-blue-50 p-3 rounded-lg flex justify-between items-center";
        li.innerHTML = `
            <span><strong>${p.nombre} ${p.apellido}</strong> - ${p.cedula}</span>
            <button type="button" onclick="eliminarParticipante(${index})" class="text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i>
            </button>
        `;
        listaParticipantes.appendChild(li);
    });
}

function eliminarParticipante(index) {
    participantesAgregados.splice(index, 1);
    mostrarParticipantes();
}

function guardarParticipantes() {
    if (participantesAgregados.length === 0) {
        iziToast.warning({
            title: '⚠️ Sin participantes',
            message: 'Por favor agrega al menos un participante',
            position: 'topRight',
            timeout: 3000
        });
        return;
    }

    iziToast.success({
        title: '✅ Éxito',
        message: 'Participantes guardados correctamente',
        position: 'topRight',
        timeout: 3000
    });
    cerrarModalParticipantes();
}