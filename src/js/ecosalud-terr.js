document.addEventListener('DOMContentLoaded', () => {
    // ============================
    // VARIABLES
    // ============================
    const API_URL = '../controllers/territoriolider.php'
    const modalTitle = document.getElementById("modalCrearTitle"); // Puedes mantenerlo si quieres cambiar título dinámicamente

    // Botones de modo
    const btnModoNuevo = document.getElementById("btnModoNuevo");
    const btnModoExistente = document.getElementById("btnModoExistente");

    // Formularios
    const formLider = document.getElementById("formLider");
    const formNuevo = document.getElementById("formNuevo");
    const formExistente = document.getElementById("formExistente");

    // Inputs formulario nuevo líder
    const inNombre = document.getElementById("inNombre");
    const inApellido = document.getElementById("inApellido");
    const inCorreo = document.getElementById("inCorreo");
    const inCelular = document.getElementById("inCelular");
    const inCedula = document.getElementById("inCedula");
    const inClase = document.getElementById("inClase");
    const inTerritorio = document.getElementById("inTerritorio");

    // Inputs formulario líder existente
    const inLiderExistente = document.getElementById("inLiderExistente");

    // Variable de control
    let modoRegistro = "nuevo"; // "nuevo" o "existente"

    // ============================
    // CONFIGURAR VALIDACIONES EN INPUTS
    // ============================
    function configurarValidacionesRegistro() {
        // Validación Cédula (solo números, máx 10)
        if (inCelular) {
            inCelular.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
        }

        // Validación al perder el foco
        inCelular.addEventListener('blur', function (e) {
            if (this.value.length > 0 && this.value.length < 10) {
                iziToast.warning({
                    title: '⚠️ Celular incompleto',
                    message: 'El celular debe tener exactamente 10 dígitos',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        });

        // Validación Nombre (solo letras y espacios)
        if (inNombre) {
            inNombre.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });
        }

        // Validación Apellido (solo letras y espacios)
        if (inApellido) {
            inApellido.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });
        }

        // Validación Clase Liderazgo (solo letras y espacios)
        if (inClase) {
            inClase.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });
        }
    }

    // ============================
    // CONFIGURAR EVENTOS DE LA SECCIÓN
    // ============================
    function configurarEventosSeccion() {
        // Cambiar modo de registro
        btnModoNuevo.addEventListener("click", () => cambiarModo("nuevo"));
        btnModoExistente.addEventListener("click", () => cambiarModo("existente"));

        // Enviar formulario
        formLider.addEventListener("submit", guardarLider);

        // Iniciar en modo "nuevo" por defecto (visual)
        cambiarModo("nuevo");

        console.log("✅ Eventos de sección configurados");
    }

    // ============================
    // CAMBIAR MODO DE REGISTRO
    // ============================
    function cambiarModo(modo) {
        modoRegistro = modo;

        if (modo === "nuevo") {
            formNuevo.classList.remove("hidden");
            formExistente.classList.add("hidden");

            // Campos requeridos
            inNombre.required = true;
            inApellido.required = true;
            inCorreo.required = true;
            inCelular.required = true;
            inCedula.required = true;
            inClase.required = true;
            inLiderExistente.required = false;

            // Estilos botones
            btnModoNuevo.className = "flex-1 px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg";
            btnModoExistente.className = "flex-1 px-6 py-3 glass-dark border-2 border-[#A0CED9] rounded-xl font-semibold hover:border-[#7DD3C0]";

        } else {
            formNuevo.classList.add("hidden");
            formExistente.classList.remove("hidden");

            // Campos requeridos
            inNombre.required = false;
            inApellido.required = false;
            inCorreo.required = false;
            inCelular.required = false;
            inCedula.required = false;
            inClase.required = false;
            inLiderExistente.required = true;

            // Estilos botones
            btnModoExistente.className = "flex-1 px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg";
            btnModoNuevo.className = "flex-1 px-6 py-3 glass-dark border-2 border-[#A0CED9] rounded-xl font-semibold hover:border-[#7DD3C0]";
        }
    }

    // ============================
    // LIMPIAR FORMULARIO
    // ============================
    function limpiarFormulario() {
        formLider.reset();
    }

    // ============================
    // VALIDAR FORMULARIO NUEVO LÍDER
    // ============================
    function validarFormularioNuevo() {
        let todosValidos = true;

        if (!inNombre.value.trim()) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'El nombre del líder es obligatorio', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        }

        if (!inApellido.value.trim()) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'El apellido del líder es obligatorio', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        }

        if (!inCorreo.value.trim()) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'El correo del líder es obligatorio', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        } else {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(inCorreo.value.trim())) {
                iziToast.error({ title: '❌ Correo inválido', message: 'El correo electrónico no es válido', position: 'topRight', timeout: 3000 });
                todosValidos = false;
            }
        }

        if (!inCelular.value.trim()) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'El celular del líder es obligatorio', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        } else if (inCelular.value.trim().length !== 10) {
            iziToast.error({ title: '❌ Celular inválido', message: 'El celular debe tener exactamente 10 dígitos', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        }

        if (!inCedula.value.trim()) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'La cédula del líder es obligatoria', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        } else if (inCedula.value.trim().length < 6 || inCedula.value.trim().length > 10) {
            iziToast.error({ title: '❌ Cédula inválida', message: 'La cédula debe tener entre 6 y 10 dígitos', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        }

        if (!inClase.value.trim()) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'La clase de liderazgo es obligatoria', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        }

        if (!inTerritorio.value) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'Debe seleccionar un sitio/territorio', position: 'topRight', timeout: 3000 });
            todosValidos = false;
        }

        return todosValidos;
    }

    // ============================
    // VALIDAR FORMULARIO LÍDER EXISTENTE
    // ============================
    function validarFormularioExistente() {
        if (!inLiderExistente.value) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'Por favor selecciona un líder', position: 'topRight', timeout: 3000 });
            return false;
        }
        if (!inTerritorio.value) {
            iziToast.warning({ title: '⚠ Campo requerido', message: 'Por favor selecciona un sitio/territorio', position: 'topRight', timeout: 3000 });
            return false;
        }
        return true;
    }

    // ============================
    // GUARDAR LÍDER (PRINCIPAL)
    // ============================
    function guardarLider(e) {
        e.preventDefault();

        if (modoRegistro === "nuevo") {
            if (!validarFormularioNuevo()) return;
            registrarNuevoLider();
        } else {
            if (!validarFormularioExistente()) return;
            asociarLiderExistente();
        }
    }

    // ============================
    // REGISTRAR NUEVO LÍDER y ASOCIAR EXISTENTE (sin cambios en lógica)
    // ============================
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

        console.log("📤 Enviando nuevo líder:", datos);

        fetch(`${API_URL}?accion=registrar_nuevo`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
            .then(res => res.json())
            .then(response => {
                // console.log("📥 Respuesta servidor:", response);

                if (response.success) {
                    iziToast.success({ title: '✅ Éxito', message: response.message || 'Líder registrado exitosamente', position: 'topRight', timeout: 3000 });
                    const codigo = response.cod_territorio
                    sessionStorage.setItem('territorioActivo', codigo);
                    document.getElementById('btnEncuesta1').href = `../../ENCUESTAS/front/Encuestasasti.php?cod_territorio=${codigo}`
                    document.getElementById('btnEncuesta2').href = `../../ENCUESTAS/front/sastifacionactividad.php?cod_territorio=${codigo}`
                    limpiarFormulario();
                    const evento = new CustomEvent("territorioRegistrado", {
                        detail: { cod_territorio: codigo }
                    })
                    window.dispatchEvent(evento)
                    //cargarTerritorios();
                    cargarLideres();
                } else if (response.existe) {
                    iziToast.warning({ title: '⚠ Advertencia', message: response.message || 'El líder ya existe', position: 'topRight', timeout: 4000 });
                } else {
                    iziToast.error({ title: '❌ Error', message: response.message || 'Error desconocido', position: 'topRight', timeout: 4000 });
                }
            })
            .catch(err => {
                console.error("❌ ERROR:", err);
                iziToast.error({ title: '❌ Error de conexión', message: 'No se pudo conectar con el servidor', position: 'topRight', timeout: 4000 });
            });
    }

    function asociarLiderExistente() {
        const datos = {
            id_lider: inLiderExistente.value,
            cod_sitioeco: inTerritorio.value
        };

        console.log("📤 Asociando líder existente:", datos);

        fetch(`${API_URL}?accion=asociar_existente`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
            .then(res => res.json())
            .then(response => {
                console.log("📥 Respuesta servidor:", response);

                if (response.success) {
                    iziToast.success({ title: '✅ Éxito', message: response.message || 'Líder asociado exitosamente', position: 'topRight', timeout: 3000 });
                    limpiarFormulario();
                    const codigo = response.cod_territorio
                    document.getElementById('btnEncuesta2').href = `../../ENCUESTAS/front/sastifacionactividad.php?cod_territorio=${codigo}`
                    document.getElementById('btnEncuesta1').href = `../../ENCUESTAS/front/Encuestasasti.php?cod_territorio=${codigo}`
                    sessionStorage.setItem('territorioActivo', codigo);

                    const evento = new CustomEvent("territorioRegistrado", {
                        detail: { cod_territorio: codigo }
                    })
                    window.dispatchEvent(evento)
                    //cargarTerritorios();
                } else {
                    iziToast.error({ title: '❌ Error', message: response.message || 'Error al asociar líder', position: 'topRight', timeout: 4000 });
                }
            })
            .catch(err => {
                console.error("❌ ERROR:", err);
                iziToast.error({ title: '❌ Error de conexión', message: 'No se pudo conectar con el servidor', position: 'topRight', timeout: 4000 });
            });
    }

    // ============================
    // CARGAR LÍDERES Y SITIOS (sin cambios)
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
            .catch(err => console.error("❌ Error al cargar líderes:", err));
    }

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
            .catch(err => console.error("❌ Error al cargar sitios:", err));
    }

    // ============================
    // INICIALIZAR AL CARGAR
    // ============================

    console.log("📄 DOM Cargado - Iniciando sección de registro...");

    configurarValidacionesRegistro();
    configurarEventosSeccion();
    cargarSitios();
    cargarLideres();

    console.log("✅ Sección de registro lista");

})