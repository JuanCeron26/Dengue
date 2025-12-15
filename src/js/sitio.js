document.addEventListener("DOMContentLoaded", () => {

    // ============================================================
    // FUNCIONES AUXILIARES
    // ============================================================

    function mostrarExito(mensaje) {
        iziToast.success({
            title: 'Éxito',
            message: mensaje,
            position: 'topRight',
            timeout: 3000
        });
    }

    function mostrarError(mensaje) {
        iziToast.error({
            title: 'Error',
            message: mensaje,
            position: 'topRight',
            timeout: 4000
        });
    }

    function mostrarAdvertencia(mensaje) {
        iziToast.warning({
            title: 'Advertencia',
            message: mensaje,
            position: 'topRight',
            timeout: 3500
        });
    }

    function validarSoloNumeros(valor) {
        return /^\d+$/.test(valor);
    }

    function validarSinCaracteresEspeciales(valor) {
        return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(valor);
    }

    function qs(id) {
        return document.getElementById(id);
    }

    // ============================================================
    // VARIABLES GLOBALES PARA PAGINACIÓN
    // ============================================================
    let paginaActual = 1;
    const REGISTROS_POR_PAGINA = 6;
    let todosLosSitios = [];
    let modoRegistro = "nuevo";

    // ============================================================
    // REFERENCIAS A ELEMENTOS DEL DOM
    // ============================================================

    const modalRegisterBackdrop = qs('modalRegisterBackdrop');
    const openRegister = qs('openRegister');
    const closeRegister = qs('closeRegister');
    const formRegister = qs('formRegister');

    const btnModoNuevo = qs('btnModoNuevo');
    const btnModoExistente = qs('btnModoExistente');
    const tabsContainer = qs('tabsContainer');

    const formNuevo = qs('formNuevo');
    const formExistente = qs('formExistente');

    const modalAddressBackdrop = qs('modalAddressBackdrop');
    const openAddressBuilder = qs('openAddressBuilder');
    const closeAddress = qs('closeAddress');
    const btnSaveAddress = qs('btnSaveAddress');
    const btnClearAddress = qs('btnClearAddress');
    const btnDeleteLast = qs('btnDeleteLast');

    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    const rNombre = qs('nombre_responsable');
    const rApellido = qs('apellido_responsable');
    const rCedula = qs('cedula');
    const rCelular = qs('celular');
    const rCedulaExistente = qs('cedula_existente');

    const sDireccion = qs('direccion_sitio');

    const tipoVia = qs('tipoVia');
    const numeroVia = qs('numeroVia');
    const numero = qs('numero');
    const sufijo = qs('sufijo');
    const distancia = qs('distancia');
    const direccionGenerada = qs('direccionGenerada');
    const camposDireccion = [tipoVia, numeroVia, numero, sufijo, distancia];

    // ============================================================
    // FUNCIÓN: LISTAR SITIOS CON FILTROS Y PAGINACIÓN
    // ============================================================
    function listarSitiosConFiltros() {
        const params = new URLSearchParams({
            accion: "listar_filtros",
            f_sitio: document.querySelector("select[name='f_sitio']")?.value || '',
            f_barrio: document.querySelector("select[name='f_barrio']")?.value || '',
            f_nombre: document.querySelector("input[name='f_nombre']")?.value || ''
        });

        fetch(`../controller/sitio.php?${params}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return res.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if (data.success) {
                    todosLosSitios = data.data || [];
                    paginaActual = 1;
                    mostrarPagina(paginaActual);
                } else {
                    mostrarError(data.message || 'Error al cargar datos');
                    todosLosSitios = [];
                    actualizarTabla([]);
                }
            })
            .catch(err => {
                console.error('Error fetch:', err);
                mostrarError('Error al conectar con el servidor');
            });
    }

    // ============================================================
    // FUNCIÓN: MOSTRAR PÁGINA ESPECÍFICA
    // ============================================================
    function mostrarPagina(numeroPagina) {
        const inicio = (numeroPagina - 1) * REGISTROS_POR_PAGINA;
        const fin = inicio + REGISTROS_POR_PAGINA;
        const sitiosPagina = todosLosSitios.slice(inicio, fin);

        actualizarTabla(sitiosPagina);
        actualizarBotonesPaginacion();
    }

    // ============================================================
    // FUNCIÓN: ACTUALIZAR TABLA
    // ============================================================
    function actualizarTabla(sitios) {
        const tbody = document.querySelector('#tblRegistros tbody');

        if (!sitios || sitios.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="py-4 text-center text-gray-500">No hay registros disponibles</td></tr>';
            return;
        }

        tbody.innerHTML = sitios.map(s => `
                <tr class="border-b text-center hover:bg-[color:var(--verde-super-claro)] transition-colors">
                    <td class="py-2 px-4">${s.cod_sitiocontrolbiolo}</td>
                    <td class="py-2 px-4">${s.nombre_sitio}</td>
                    <td class="py-2 px-4">${s.direccion_sitio}</td>
                    <td class="py-2 px-4">${s.nombre_responsable || '-'} ${s.apellido_responsable || ''}</td>
                    <td class="py-2 px-4 space-x-2 flex justify-center">
                        <button type="button" class="btnEditar p-2 rounded-lg hover:bg-blue-50 hover:scale-110 transition-transform" data-id="${s.cod_sitiocontrolbiolo}&accion=editar">
                            <img src="../../../src/icons/icono_edit.png" class="w-5 h-5">
                        </button>
                        <button type="button" class="btnDetalle p-2 rounded-lg hover:bg-green-50 hover:scale-110 transition-transform" data-id="${s.cod_sitiocontrolbiolo}">
                            <img src="../../../src/icons/zoom.png" class="w-5 h-5">
                        </button>
                        <button type="button" class="btnEliminar p-2 rounded-lg hover:bg-red-50 hover:scale-110 transition-transform" data-id="${s.cod_sitiocontrolbiolo}">
                            <img src="../../../src/icons/trash-2.svg" class="w-5 h-5">
                        </button>
                        <a href="exportar.php?id=${s.cod_sitiocontrolbiolo}" class="p-2 rounded-lg hover:bg-yellow-50 hover:scale-110 transition-transform inline-block">
                            <img src="../../../src/icons/upload.svg" alt="Exportar" class="w-5 h-5">
                        </a>
                    </td>
                </tr>
            `).join('');

        // Reasignar eventos después de actualizar la tabla
        reasignarEventos();
    }

    // ============================================================
    // FUNCIÓN: ACTUALIZAR BOTONES DE PAGINACIÓN
    // ============================================================
    function actualizarBotonesPaginacion() {
        const totalPaginas = Math.ceil(todosLosSitios.length / REGISTROS_POR_PAGINA);

        let divPaginacion = document.getElementById('paginacion');
        if (!divPaginacion) {
            divPaginacion = document.createElement('div');
            divPaginacion.id = 'paginacion';
            divPaginacion.className = 'flex justify-center items-center gap-4 mt-6';
            document.querySelector('.col-span-8 .bg-white')?.appendChild(divPaginacion);
        }

        divPaginacion.innerHTML = `
                <button id="btnAnterior" 
                        class="px-6 py-2 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        ${paginaActual === 1 ? 'disabled' : ''}>
                    ← Anterior
                </button>
                <span class="font-bold text-[color:var(--texto-verde)] text-lg">
                    Página ${paginaActual} de ${totalPaginas || 1}
                </span>
                <button id="btnSiguiente" 
                        class="px-6 py-2 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        ${paginaActual >= totalPaginas ? 'disabled' : ''}>
                    Siguiente →
                </button>
            `;

        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (paginaActual > 1) {
                paginaActual--;
                mostrarPagina(paginaActual);
            }
        });

        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (paginaActual < totalPaginas) {
                paginaActual++;
                mostrarPagina(paginaActual);
            }
        });
    }

    // ============================================================
    // FUNCIÓN: CARGAR OPCIONES DE FILTROS
    // ============================================================
    function cargarOpcionesFiltros() {
        fetch('../controller/sitio.php?accion=listar_filtros&f_sitio=&f_barrio=&f_nombre=')
            .then(res => res.json())
            .then(data => {
                if (data.success && Array.isArray(data.data)) {
                    // Actualizar select de SITIOS
                    const selectSitio = document.querySelector("select[name='f_sitio']");
                    if (selectSitio) {
                        const valorActual = selectSitio.value;
                        selectSitio.innerHTML = '<option value="">-- Todos --</option>';

                        const sitiosUnicos = new Set();
                        data.data.forEach(s => {
                            if (s.nombre_sitio && !sitiosUnicos.has(s.nombre_sitio)) {
                                sitiosUnicos.add(s.nombre_sitio);
                                selectSitio.innerHTML += `<option value="${s.nombre_sitio}">${s.nombre_sitio}</option>`;
                            }
                        });
                        if (valorActual) selectSitio.value = valorActual;
                    }

                    // Actualizar select de BARRIOS
                    const selectBarrio = document.querySelector("select[name='f_barrio']");
                    if (selectBarrio) {
                        const valorActual = selectBarrio.value;
                        selectBarrio.innerHTML = '<option value="">-- Todos --</option>';

                        const barriosUnicos = new Set();
                        data.data.forEach(s => {
                            if (s.nombarrio && !barriosUnicos.has(s.nombarrio)) {
                                barriosUnicos.add(s.nombarrio);
                                selectBarrio.innerHTML += `<option value="${s.nombarrio}">${s.nombarrio}</option>`;
                            }
                        });
                        if (valorActual) selectBarrio.value = valorActual;
                    }
                }
            });
    }

    // ============================================================
    // EVENTOS: FILTROS
    // ============================================================
    const btnFilter = qs('btnFilter');
    if (btnFilter) {
        btnFilter.addEventListener('click', () => {
            listarSitiosConFiltros();
        });
    }

    const btnReset = qs('btnReset');
    if (btnReset) {
        btnReset.addEventListener('click', () => {
            document.querySelector("select[name='f_sitio']").value = '';
            document.querySelector("select[name='f_barrio']").value = '';
            document.querySelector("input[name='f_nombre']").value = '';
            listarSitiosConFiltros();
        });
    }

    // ============================================================
    // FUNCIÓN: CAMBIAR MODO
    // ============================================================
    function cambiarModo(modo) {
        modoRegistro = modo;

        if (modo === "nuevo") {
            formNuevo.classList.remove("hidden");
            formExistente.classList.add("hidden");
            tabsContainer.classList.remove("hidden");

            btnModoNuevo.className = "flex-1 px-6 py-3 rounded-xl bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg transition-all";
            btnModoExistente.className = "flex-1 px-6 py-3 rounded-xl bg-white border-2 border-[color:var(--verde-principal)] text-[color:var(--verde-principal)] font-semibold hover:bg-[color:var(--verde-super-claro)] transition-all";

            showTab("responsable");
        } else {
            formNuevo.classList.add("hidden");
            formExistente.classList.remove("hidden");
            tabsContainer.classList.remove("hidden");

            btnModoExistente.className = "flex-1 px-6 py-3 rounded-xl bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg transition-all";
            btnModoNuevo.className = "flex-1 px-6 py-3 rounded-xl bg-white border-2 border-[color:var(--verde-principal)] text-[color:var(--verde-principal)] font-semibold hover:bg-[color:var(--verde-super-claro)] transition-all";

            showTab("responsable");
        }
    }

    // ============================================================
    // EVENTOS: BOTONES DE MODO
    // ============================================================
    if (btnModoNuevo) {
        btnModoNuevo.addEventListener('click', () => cambiarModo('nuevo'));
    }

    if (btnModoExistente) {
        btnModoExistente.addEventListener('click', () => cambiarModo('existente'));
    }

    // ============================================================
    // FUNCIÓN: GENERAR DIRECCIÓN EN TIEMPO REAL
    // ============================================================
    function actualizarDireccion() {
        let partes = [];
        if (tipoVia.value.trim()) partes.push(tipoVia.value.trim());
        if (numeroVia.value.trim()) partes.push(numeroVia.value.trim());
        if (numero.value.trim()) partes.push("#" + numero.value.trim());
        if (sufijo.value.trim()) partes.push(sufijo.value.trim());
        if (distancia.value.trim()) partes.push("-" + distancia.value.trim());
        direccionGenerada.textContent = partes.length ? partes.join(" ") : "-";
    }

    camposDireccion.forEach(campo => campo.addEventListener("input", actualizarDireccion));

    // ============================================================
    // FUNCIÓN: ABRIR MODAL DE REGISTRO
    // ============================================================
    if (openRegister) {
        openRegister.addEventListener("click", () => {
            modalRegisterBackdrop.classList.remove("hidden");
            formRegister.reset();
            cambiarModo("nuevo");
        });
    }

    // ============================================================
    // FUNCIÓN: CERRAR MODAL DE REGISTRO
    // ============================================================
    if (closeRegister) {
        closeRegister.addEventListener("click", () => {
            modalRegisterBackdrop.classList.add("hidden");
        });
    }

    // ============================================================
    // FUNCIÓN: NAVEGACIÓN ENTRE TABS
    // ============================================================
    tabButtons.forEach(btn => {
        btn.addEventListener("click", (e) => {
            const tabDestino = btn.dataset.tab;

            if (tabDestino === "sitio") {
                e.preventDefault();
                validarYContinuarASitio();
            } else {
                showTab(tabDestino);
            }
        });
    });

    function showTab(tabName) {
        tabButtons.forEach(btn => {
            const active = btn.dataset.tab === tabName;
            btn.classList.toggle("bg-[color:var(--verde-tab)]", active);
            btn.classList.toggle("text-white", active);
            btn.classList.toggle("bg-gray-200", !active);
            btn.classList.toggle("text-gray-600", !active);
        });

        tabContents.forEach(tc => tc.classList.add("hidden"));
        qs("tab-" + tabName)?.classList.remove("hidden");
    }

    // ============================================================
    // VALIDACIÓN: RESPONSABLE
    // ============================================================
    function validarYContinuarASitio() {
        if (modoRegistro === "nuevo") {
            const nombre = rNombre.value.trim();
            const apellido = rApellido.value.trim();
            const cedula = rCedula.value.trim();
            const celular = rCelular.value.trim();

            if (!nombre || !apellido || !cedula || !celular) {
                mostrarError("Todos los campos son obligatorios");
                return;
            }

            if (!validarSinCaracteresEspeciales(nombre)) {
                mostrarError("El nombre no puede contener números ni caracteres especiales");
                return;
            }

            if (!validarSinCaracteresEspeciales(apellido)) {
                mostrarError("El apellido no puede contener números ni caracteres especiales");
                return;
            }

            if (!validarSoloNumeros(cedula)) {
                mostrarError("El documento solo recibe números");
                return;
            }

            if (cedula.length !== 10) {
                mostrarError("El documento debe tener exactamente 10 dígitos");
                return;
            }

            if (!validarSoloNumeros(celular)) {
                mostrarError("El teléfono solo recibe números");
                return;
            }

            if (celular.length !== 10) {
                mostrarError("El teléfono debe tener exactamente 10 dígitos");
                return;
            }
        } else {
            const cedula = rCedulaExistente.value.trim();

            if (!cedula) {
                mostrarError("Debe ingresar la cédula del responsable");
                return;
            }

            if (!validarSoloNumeros(cedula) || cedula.length !== 10) {
                mostrarError("La cédula debe tener 10 dígitos numéricos");
                return;
            }
        }

        mostrarExito("Datos validados correctamente");
        showTab("sitio");
    }

    if (qs("nextToSitio")) {
        qs("nextToSitio").addEventListener("click", validarYContinuarASitio);
    }

    if (qs("nextToSitioExistente")) {
        qs("nextToSitioExistente").addEventListener("click", validarYContinuarASitio);
    }

    if (qs("backToResponsable")) {
        qs("backToResponsable").addEventListener("click", () => showTab("responsable"));
    }

    // ============================================================
    // VALIDACIÓN: ANTES DE ENVIAR EL FORMULARIO
    // ============================================================
    // ============================================================
    // VALIDACIÓN: ANTES DE ENVIAR EL FORMULARIO
    // ============================================================
    // ============================================================
    // VALIDACIÓN: ANTES DE ENVIAR EL FORMULARIO
    // ============================================================
    if (formRegister) {
        formRegister.addEventListener("submit", async function (e) {
            e.preventDefault();

            const nombreSitio = qs('nombre_sitio').value.trim();
            const direccionSitio = sDireccion.value.trim();
            const codBarrio = qs('cod_barrio').value;

            if (!nombreSitio || !direccionSitio || !codBarrio) {
                mostrarError("Debe completar todos los datos del sitio");
                showTab("sitio");
                return false;
            }

            let datos = {
                nombre_sitio: nombreSitio,
                direccion_sitio: direccionSitio,
                cod_barrio: codBarrio
            };

            let url = "../controller/sitio.php?accion=";

            if (modoRegistro === "nuevo") {
                datos.nombre_responsable = rNombre.value.trim();
                datos.apellido_responsable = rApellido.value.trim();
                datos.cedula = rCedula.value.trim();
                datos.celular = rCelular.value.trim();
                url += "registrar_nuevo";
            } else {
                datos.cedula = rCedulaExistente.value.trim();
                url += "asociar_existente";
            }

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });

                const result = await response.json();

                if (result.success) {
                    mostrarExito(result.message);
                    cargarOpcionesFiltros();
                    listarSitiosConFiltros();
                    setTimeout(() => {
                        modalRegisterBackdrop.classList.add('hidden');
                        formRegister.reset();
                    }, 1500);
                }
                //  NUEVO: Manejo de sitios duplicados
                else if (result.existe_sitio) {
                    const tipoDup = result.tipo_duplicado === 'nombre' ? 'NOMBRE' : 'DIRECCIÓN';
                    iziToast.error({
                        title: `⚠️ Sitio Duplicado - ${tipoDup}`,
                        message: `
                            <div style="text-align: left; line-height: 1.6;">
                                <strong>${result.message}</strong><br><br>
                                📍 Sitio existente:<br>
                                • Código: ${result.sitio.cod_sitiocontrolbiolo}<br>
                                • Nombre: ${result.sitio.nombre_sitio}<br>
                                • Dirección: ${result.sitio.direccion_sitio}<br>
                            </div>
                        `,
                        position: 'center',
                        timeout: 8000,
                        backgroundColor: '#dc2626',
                        messageColor: '#fff',
                        titleColor: '#fff',
                        progressBarColor: '#fff',
                        close: true,
                        closeOnClick: false,
                        displayMode: 2,
                        layout: 2
                    });
                    showTab("sitio");
                }
                else if (result.existe) {
                    iziToast.warning({
                        title: '⚠️ Responsable Ya Registrado',
                        message: `
                            <div style="text-align: left; line-height: 1.6;">
                                <strong>Este responsable ya existe:</strong><br>
                                📝 Nombre: ${result.responsable.nombre_responsable} ${result.responsable.apellido_responsable}<br>
                                🆔 Cédula: ${result.responsable.cedula}<br><br>
                                <strong>👉 Por favor, use el botón "ASOCIAR RESPONSABLE EXISTENTE"</strong>
                            </div>
                        `,
                        position: 'center',
                        timeout: 8000,
                        backgroundColor: '#FFA500',
                        messageColor: '#fff',
                        titleColor: '#fff',
                        progressBarColor: '#fff',
                        close: true,
                        closeOnClick: false,
                        displayMode: 2,
                        layout: 2
                    });
                    showTab("responsable");
                }
                else {
                    mostrarError(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarError('Error al conectar con el servidor');
            }
        });
    }

    // ============================================================
    // MODAL DIRECCIÓN: ABRIR/CERRAR
    // ============================================================
    if (openAddressBuilder) {
        openAddressBuilder.addEventListener("click", () => {
            modalAddressBackdrop.classList.remove("hidden");
            actualizarDireccion();
        });
    }

    if (closeAddress) {
        closeAddress.addEventListener("click", () => {
            modalAddressBackdrop.classList.add("hidden");
        });
    }

    // ============================================================
    // MODAL DIRECCIÓN: LIMPIAR CAMPOS
    // ============================================================
    if (btnClearAddress) {
        btnClearAddress.addEventListener("click", () => {
            camposDireccion.forEach(c => c.value = "");
            actualizarDireccion();
            mostrarExito("Campos limpiados");
        });
    }

    // ============================================================
    // MODAL DIRECCIÓN: BORRAR ÚLTIMO CAMPO
    // ============================================================
    if (btnDeleteLast) {
        btnDeleteLast.addEventListener("click", () => {
            const orden = [distancia, sufijo, numero, numeroVia, tipoVia];
            for (let campo of orden) {
                if (campo.value.trim() !== "") {
                    campo.value = "";
                    actualizarDireccion();
                    mostrarExito("Último campo borrado");
                    return;
                }
            }
            mostrarAdvertencia("No hay nada para borrar");
        });
    }

    // ============================================================
    // MODAL DIRECCIÓN: GUARDAR DIRECCIÓN
    // ============================================================
    if (btnSaveAddress) {
        btnSaveAddress.addEventListener("click", () => {
            const dir = direccionGenerada.textContent.trim();
            if (dir === "-") {
                mostrarError("Debe construir una dirección antes de guardar");
                return;
            }
            sDireccion.value = dir;
            modalAddressBackdrop.classList.add("hidden");
            mostrarExito("Dirección guardada correctamente");
        });
    }

    // ============================================================
    // FUNCIÓN: REASIGNAR EVENTOS (después de actualizar tabla)
    // ============================================================
    function reasignarEventos() {
        // Ver detalle
        document.querySelectorAll('.btnDetalle').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                const id = this.dataset.id;

                try {
                    const res = await fetch(`../controller/sitio.php?id=${id}&accion=detalle`);
                    const data = await res.json();

                    if (data.error) {
                        mostrarError('No se encontró el sitio');
                        return;
                    }

                    const content = qs('detalleContent');
                    content.innerHTML = `
                            <p><strong>Nombre Sitio:</strong> ${data.nombre_sitio}</p>
                            <p><strong>Dirección:</strong> ${data.direccion_sitio}</p>
                            <p><strong>Barrio:</strong> ${data.nombarrio}</p>
                            <p><strong>Responsable:</strong> ${data.nombre_responsable} ${data.apellido_responsable}</p>
                            <p><strong>Cédula:</strong> ${data.cedula}</p>
                            <p><strong>Celular:</strong> ${data.celular}</p>
                        `;
                    qs('modalDetalle').classList.remove('hidden');
                } catch (error) {
                    mostrarError('Error al cargar el detalle del sitio');
                    console.error(error);
                }
            });
        });

        // Eliminar
        document.querySelectorAll('.btnEliminar').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                filaAEliminar = btn.closest('tr');
                idAEliminar = btn.dataset.id;
                progressBar.classList.add('scale-x-0');
                modalConfirm.classList.remove('hidden');
            });
        });

        // Editar
        document.querySelectorAll('.btnEditar').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const dataId = this.getAttribute('data-id');
                const codSitio = dataId.split('&')[0];

                fetch(`../controller/sitio.php?cod_sitiocontrolbiolo=${codSitio}&accion=obtener`)
                    .then(res => res.json())
                    .then(data => {
                        qs('edit_cod_sitio').value = data.cod_sitiocontrolbiolo;
                        qs('edit_nombre_responsable').value = data.nombre_responsable;
                        qs('edit_apellido_responsable').value = data.apellido_responsable;
                        qs('edit_cedula').value = data.cedula;
                        qs('edit_celular').value = data.celular;
                        qs('edit_nombre_sitio').value = data.nombre_sitio;
                        qs('edit_direccion_sitio').value = data.direccion_sitio;
                        qs('edit_cod_barrio').value = data.cod_barrio;

                        // 🔒 DESHABILITAR EL CAMPO DE CÉDULA
                        const inputCedula = qs('edit_cedula');
                        inputCedula.disabled = true;
                        inputCedula.classList.add('bg-gray-100', 'cursor-not-allowed', 'opacity-70');

                        qs('modalEditarBackdrop').classList.remove('hidden');
                        mostrarTabEdit('responsable');
                    })
                    .catch(err => {
                        console.error('Error cargando datos:', err);
                        mostrarError('Error al cargar los datos del sitio');
                    });
            });
        });
    }

    // ============================================================
    // FUNCIÓN: ELIMINAR SITIO
    // ============================================================
    const modalConfirm = qs('modalConfirm');
    const btnCancelar = qs('cancelarEliminar');
    const btnConfirmar = qs('confirmarEliminar');
    const progressBar = qs('progressBar');

    let filaAEliminar = null;
    let idAEliminar = null;

    if (btnCancelar) {
        btnCancelar.addEventListener('click', () => {
            modalConfirm.classList.add('hidden');
            filaAEliminar = null;
            idAEliminar = null;
        });
    }

    if (btnConfirmar) {
        btnConfirmar.addEventListener('click', async () => {
            if (!idAEliminar) return;
            progressBar.classList.remove('scale-x-0');

            try {
                const res = await fetch(`../controller/sitio.php?accion=eliminar&id=${idAEliminar}`);
                const data = await res.json();

                if (data.status) {
                    mostrarExito('Sitio eliminado correctamente');
                    cargarOpcionesFiltros();
                    listarSitiosConFiltros();
                } else {
                    mostrarError('No se pudo eliminar el registro');
                }
            } catch (err) {
                console.error(err);
                mostrarError('Error al conectar con el servidor');
            } finally {
                modalConfirm.classList.add('hidden');
            }
        });
    }

    // ============================================================
    // MODAL DETALLE: CERRAR
    // ============================================================
    if (qs('closeDetalle')) {
        qs('closeDetalle').addEventListener('click', () => qs('modalDetalle').classList.add('hidden'));
    }
    if (qs('closeDetalleFooter')) {
        qs('closeDetalleFooter').addEventListener('click', () => qs('modalDetalle').classList.add('hidden'));
    }

    // ============================================================
    // FUNCIÓN: EDITAR SITIO - CERRAR MODAL
    // ============================================================
    if (qs('closeEditar')) {
        qs('closeEditar').addEventListener('click', () => {
            qs('modalEditarBackdrop').classList.add('hidden');
        });
    }

    // ============================================================
    // FUNCIÓN: EDITAR SITIO - NAVEGACIÓN ENTRE TABS
    // ============================================================
    document.querySelectorAll('[data-tab-edit]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const tab = this.getAttribute('data-tab-edit');

            if (tab === 'sitio') {
                e.preventDefault();
                validarResponsableEdit();
            } else {
                mostrarTabEdit(tab);
            }
        });
    });

    function mostrarTabEdit(tab) {
        document.querySelectorAll('[data-tab-edit]').forEach(b => {
            b.classList.remove('bg-[color:var(--verde-tab)]');
            b.classList.add('bg-gray-200', 'text-gray-600');
        });
        document.querySelector(`[data-tab-edit="${tab}"]`).classList.add('bg-[color:var(--verde-tab)]');
        document.querySelector(`[data-tab-edit="${tab}"]`).classList.remove('text-gray-600');
        document.querySelector(`[data-tab-edit="${tab}"]`).classList.add('text-white');

        document.querySelectorAll('.tab-content-edit').forEach(content => content.classList.add('hidden'));
        qs(`tab-edit-${tab}`).classList.remove('hidden');
    }

    function validarResponsableEdit() {
        const nombre = qs('edit_nombre_responsable').value.trim();
        const apellido = qs('edit_apellido_responsable').value.trim();
        const cedula = qs('edit_cedula').value.trim();
        const celular = qs('edit_celular').value.trim();

        if (!nombre || !apellido || !cedula || !celular) {
            mostrarError("Todos los campos son obligatorios");
            return;
        }

        if (!validarSinCaracteresEspeciales(nombre)) {
            mostrarError("El nombre no puede contener números ni caracteres especiales");
            return;
        }

        if (!validarSinCaracteresEspeciales(apellido)) {
            mostrarError("El apellido no puede contener números ni caracteres especiales");
            return;
        }

        if (!validarSoloNumeros(cedula)) {
            mostrarError("El documento solo recibe números");
            return;
        }

        if (cedula.length !== 10) {
            mostrarError("El documento debe tener exactamente 10 dígitos");
            return;
        }

        if (!validarSoloNumeros(celular)) {
            mostrarError("El teléfono solo recibe números");
            return;
        }

        if (celular.length !== 10) {
            mostrarError("El teléfono debe tener exactamente 10 dígitos");
            return;
        }

        mostrarExito("Datos validados correctamente");
        mostrarTabEdit('sitio');
    }

    if (qs('nextToSitioEdit')) {
        qs('nextToSitioEdit').addEventListener('click', validarResponsableEdit);
    }

    if (qs('backToResponsableEdit')) {
        qs('backToResponsableEdit').addEventListener('click', () => {
            mostrarTabEdit('responsable');
        });
    }


    if (qs('formEditar')) {
        qs('formEditar').addEventListener('submit', async function (e) {
            e.preventDefault();

            //  OBTENER TODOS LOS DATOS DEL FORMULARIO
            const formData = new FormData();

            // Agregar campos manualmente para asegurar que todos se envíen
            formData.append('accion', 'editar');
            formData.append('cod_sitiocontrolbiolo', qs('edit_cod_sitio').value);
            formData.append('nombre_responsable', qs('edit_nombre_responsable').value);
            formData.append('apellido_responsable', qs('edit_apellido_responsable').value);
            formData.append('cedula', qs('edit_cedula').value); // ✅ Se envía pero NO se actualizará
            formData.append('celular', qs('edit_celular').value);
            formData.append('nombre_sitio', qs('edit_nombre_sitio').value);
            formData.append('direccion_sitio', qs('edit_direccion_sitio').value);
            formData.append('cod_barrio', qs('edit_cod_barrio').value);

            try {
                const response = await fetch('../controller/sitio.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    mostrarExito(result.message);
                    cargarOpcionesFiltros();
                    listarSitiosConFiltros();
                    setTimeout(() => {
                        qs('modalEditarBackdrop').classList.add('hidden');
                    }, 1500);
                } else {
                    mostrarError(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarError('Error al actualizar el sitio');
            }
        });
    }

    // ============================================================
    // FUNCIÓN: EDITAR - CONSTRUIR DIRECCIÓN
    // ============================================================
    if (qs('openAddressBuilderEdit')) {
        qs('openAddressBuilderEdit').addEventListener('click', () => {
            qs('btnEditarDireccion').classList.remove('hidden');
        });
    }

    if (qs('closeAddressEdit')) {
        qs('closeAddressEdit').addEventListener('click', () => {
            qs('btnEditarDireccion').classList.add('hidden');
        });
    }

    function generarDireccionEdit() {
        const tipo = qs('tipoViaEdit')?.value || '';
        const numVia = qs('numeroViaEdit')?.value || '';
        const num = qs('numeroEdit')?.value || '';
        const sufijo = qs('sufijoEdit')?.value || '';
        const dist = qs('distanciaEdit')?.value || '';

        let dir = [tipo, numVia, num, sufijo, dist].filter(Boolean).join(' ');
        if (qs('direccionGeneradaEdit')) {
            qs('direccionGeneradaEdit').textContent = dir || '-';
        }
    }

    ['tipoViaEdit', 'numeroViaEdit', 'numeroEdit', 'sufijoEdit', 'distanciaEdit'].forEach(id => {
        if (qs(id)) {
            qs(id).addEventListener('input', generarDireccionEdit);
        }
    });

    if (qs('btnSaveAddressEdit')) {
        qs('btnSaveAddressEdit').addEventListener('click', () => {
            const dir = qs('direccionGeneradaEdit')?.textContent || '';
            if (dir && dir !== '-') {
                qs('edit_direccion_sitio').value = dir;
                qs('btnEditarDireccion').classList.add('hidden');
                mostrarExito("Dirección actualizada correctamente");
            } else {
                mostrarError("Debe construir una dirección antes de guardar");
            }
        });
    }

    if (qs('btnClearAddressEdit')) {
        qs('btnClearAddressEdit').addEventListener('click', () => {
            ['tipoViaEdit', 'numeroViaEdit', 'numeroEdit', 'sufijoEdit', 'distanciaEdit'].forEach(id => {
                if (qs(id)) {
                    qs(id).value = '';
                }
            });
            generarDireccionEdit();
            mostrarExito("Campos limpiados");
        });
    }

    if (qs('btnDeleteLastEdit')) {
        qs('btnDeleteLastEdit').addEventListener('click', () => {
            const ids = ['distanciaEdit', 'sufijoEdit', 'numeroEdit', 'numeroViaEdit', 'tipoViaEdit'];
            for (let id of ids) {
                if (qs(id) && qs(id).value) {
                    qs(id).value = '';
                    generarDireccionEdit();
                    mostrarExito("Último campo borrado");
                    return;
                }
            }
            mostrarAdvertencia("No hay nada para borrar");
        });
    }


    // ============================================================
    // PASO 1: AGREGAR ESTE CÓDIGO DENTRO DE reasignarEventos()
    // Justo después del código de btnEditar (al final de la función)
    // ============================================================

    //  NUEVO: Manejar botones de exportar (dropdown)
    document.querySelectorAll('.btnExportar').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();

            // Cerrar otros menús abiertos
            document.querySelectorAll('.menuExportar').forEach(menu => {
                if (menu !== this.nextElementSibling) {
                    menu.classList.add('hidden');
                }
            });

            // Toggle del menú actual
            const menu = this.nextElementSibling;
            menu.classList.toggle('hidden');
        });
    });

    // ============================================================
    // PASO 2: AGREGAR ESTE CÓDIGO DESPUÉS DE reasignarEventos()
    // Al mismo nivel que los otros event listeners
    // (busca donde están los listeners de btnFilter, btnReset, etc.)
    // ============================================================

    //  NUEVO: Botón Exportar Todos
    if (qs('btnExportarTodos')) {
        qs('btnExportarTodos').addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = qs('menuExportarTodos');
            menu.classList.toggle('hidden');
        });
    }

    //  NUEVO: Cerrar menús al hacer clic fuera
    document.addEventListener('click', function (e) {
        // Cerrar menús de exportar individuales
        if (!e.target.closest('.btnExportar') && !e.target.closest('.menuExportar')) {
            document.querySelectorAll('.menuExportar').forEach(menu => {
                menu.classList.add('hidden');
            });
        }

        // Cerrar menú de exportar todos
        if (!e.target.closest('#btnExportarTodos') && !e.target.closest('#menuExportarTodos')) {
            const menuTodos = qs('menuExportarTodos');
            if (menuTodos) {
                menuTodos.classList.add('hidden');
            }
        }
    });

    // ============================================================
    // PASO 3: ACTUALIZAR LA FUNCIÓN actualizarTabla()
    // REEMPLAZA COMPLETAMENTE la función actualizarTabla con esta versión
    // ============================================================

    function actualizarTabla(sitios) {
        const tbody = document.querySelector('#tblRegistros tbody');

        if (!sitios || sitios.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="py-4 text-center text-gray-500">No hay registros disponibles</td></tr>';
            return;
        }

        tbody.innerHTML = sitios.map(s => `
            <tr class="border-b text-center hover:bg-[color:var(--verde-super-claro)] transition-colors">
                <td class="py-2 px-4">${s.cod_sitiocontrolbiolo}</td>
                <td class="py-2 px-4">${s.nombre_sitio}</td>
                <td class="py-2 px-4">${s.direccion_sitio}</td>
                <td class="py-2 px-4">${s.nombre_responsable || '-'} ${s.apellido_responsable || ''}</td>
                <td class="py-2 px-4 space-x-2 flex justify-center">
                    <!-- Editar -->
                    <button type="button" class="btnEditar p-2 rounded-lg hover:bg-blue-50 hover:scale-110 transition-transform" 
                            data-id="${s.cod_sitiocontrolbiolo}&accion=editar" title="Editar">
                        <img src="../../../src/icons/icono_edit.png" class="w-5 h-5">
                    </button>
                    
                    <!-- Ver detalle -->
                    <button type="button" class="btnDetalle p-2 rounded-lg hover:bg-green-50 hover:scale-110 transition-transform" 
                            data-id="${s.cod_sitiocontrolbiolo}" title="Ver detalle">
                        <img src="../../../src/icons/zoom.png" class="w-5 h-5">
                    </button>
                    
                    <!-- Eliminar -->
                    <button type="button" class="btnEliminar p-2 rounded-lg hover:bg-red-50 hover:scale-110 transition-transform" 
                            data-id="${s.cod_sitiocontrolbiolo}" title="Eliminar">
                        <img src="../../../src/icons/trash-2.svg" class="w-5 h-5">
                    </button>
                    
                    <!-- Dropdown de Exportar -->
                    <div class="relative inline-block">
                        <button type="button" class="btnExportar p-2 rounded-lg hover:bg-yellow-50 hover:scale-110 transition-transform" 
                                data-id="${s.cod_sitiocontrolbiolo}" title="Exportar">
                            <img src="../../../src/icons/upload.svg" alt="Exportar" class="w-5 h-5">
                        </button>
                        
                        <div class="menuExportar hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border-2 border-[color:var(--verde-principal)] z-50">
                            <a href="exportar.php?id=${s.cod_sitiocontrolbiolo}&formato=pdf" 
                            class="block px-4 py-3 hover:bg-[color:var(--verde-super-claro)] transition-colors rounded-t-lg text-gray-700">
                                <i class="fas fa-file-pdf text-red-600 mr-2"></i> Exportar a PDF
                            </a>
                            <a href="exportar.php?id=${s.cod_sitiocontrolbiolo}&formato=excel" 
                            class="block px-4 py-3 hover:bg-[color:var(--verde-super-claro)] transition-colors rounded-b-lg text-gray-700">
                                <i class="fas fa-file-excel text-green-600 mr-2"></i> Exportar a Excel
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        `).join('');

        // Reasignar eventos después de actualizar la tabla
        reasignarEventos();
    }

    // ============================================================
    // CARGAR AL INICIO
    // ============================================================
    listarSitiosConFiltros();
    cargarOpcionesFiltros();

}); // FIN DEL DOMContentLoaded