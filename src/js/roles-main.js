document.addEventListener('DOMContentLoaded', () => {

    const tabButtons = document.querySelectorAll('.tab-button');
    const contentSections = document.querySelectorAll('.content-section');
    const mainContent = document.querySelector('main > div.relative');
    const modalPermisos = document.getElementById('modalPermisos');
    const modalContent = document.getElementById('modalContent'); // el contenido de los checkbox de los permisos

    const listaRoles = document.getElementById('listaRoles')
    const formCrearRol = document.getElementById('formCrearRol')

    const filtroRoles = document.getElementById('filtroRol');
    const filtroSegmentos = document.getElementById('filtroSegmento')

    const listaPermisosPerfiles = document.getElementById('listaPermisosPerfiles')
    const listaAccionesModulos = document.getElementById('listaAcciones')

    let permisoActualEditando = null; // guarda el permiso que se va a editar

    document.getElementById('btnGuardarPermisos')?.addEventListener('click', () => {
        guardarPermisos();
    });


    formCrearRol.addEventListener('submit', (e) => {
        e.preventDefault();
        CrearRol();
    });

    pintarRoles();
    pintarRolesFiltro();
    pintarSegmentos();
    pintarPerfilesPermisos();
    pintarModulosAcciones()



    function pintarRoles() {
        fetch('../backend/ajax.php?api=traer_roles')
            .then(respuesta => respuesta.json())
            .then(roles => {
                listaRoles.innerHTML = ''
                roles.forEach((rol) => {
                    const div = document.createElement('div')
                    div.className = 'flex justify-between items-center p-3 bg-white border border-gray-200 rounded-xl hover:bg-indigo-50 transition duration-300 ease-in-out'
                    div.innerHTML = `
                        <div class="flex justify-between items-center w-full p-3 bg-white border border-gray-200 rounded-xl hover:bg-indigo-50 transition duration-300 ease-in-out">

        <input readonly 
            type="text" 
            id="input_rol-${rol.cod_rol}" 
            value="${rol.nombre_rol}" 
            class="font-semibold text-gray-800 text-base w-full pr-4 bg-transparent focus:outline-none">

        <div class="flex items-center space-x-3 min-w-[90px] justify-end">

            <button
                class="btn-editar-rol p-2 text-indigo-500 hover:text-indigo-700 bg-transparent rounded-full hover:bg-indigo-100 transition duration-200 cursor-pointer transform hover:scale-110"
                title="Editar Rol" data-id="${rol.cod_rol}">
                <img src="../../../src/icons/icono_edit2.png" alt="" class="w-5 h-5">
            </button>

            <button
                class="btn-eliminar-rol p-2 text-red-500 hover:text-red-700 bg-transparent rounded-full hover:bg-red-100 transition duration-200 cursor-pointer transform hover:scale-110"
                title="Eliminar Rol" data-id="${rol.cod_rol}">
                <img src="../../../src/icons/icono_delete2.png" alt="" class="w-5 h-5 text-red-700">
            </button>

        </div>

    </div>
                    `
                    listaRoles.appendChild(div)
                })

                EventosBotonesRol()
            })
    }

    function pintarRolesFiltro() {
        fetch('../backend/ajax.php?api=traer_roles')
            .then(respuesta => respuesta.json())
            .then(roles => {
                filtroRoles.innerHTML = ''
                roles.forEach((rol) => {
                    const option = document.createElement('option')
                    option.value = rol.cod_rol
                    option.textContent = rol.nombre_rol
                    filtroRoles.appendChild(option)
                })

                EventosBotonesRol()
            })
    }

    function EventosBotonesRol() {
        // Botones de roles
        listaRoles.addEventListener('click', (e) => {
            const boton = e.target.closest('button') // el elemento <button>
            if (!boton) return; // para cuando haga click en el div de listaRoles
            const id_rol = boton.dataset.id;

            if (boton.classList.contains('btn-editar-rol')) {
                habilitarEdicion(id_rol)
            } else if (boton.classList.contains('btn-eliminar-rol')) {
                AnularRol(id_rol)
            }
        })
    }

    function pintarSegmentos() {
        fetch('../backend/ajax.php?api=traer_segmentos')
            .then(respuesta => respuesta.json())
            .then(segmentos => {
                filtroSegmentos.innerHTML = ''
                segmentos.forEach((seg) => {
                    const option = document.createElement('option')
                    option.value = seg.cod_segmento
                    option.textContent = seg.nomsegmento

                    filtroSegmentos.appendChild(option)
                })
            })

    }

    async function pintarPerfilesPermisos() {
        const solicito = await fetch('../backend/ajax.php?api=traer_perfiles')
        const perfiles = await solicito.json()

        // console.log(perfiles);

        perfiles.forEach((perfil) => {
            const div = document.createElement('div')
            div.className = "bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-lg transition duration-200 hover:bg-emerald-50 flex justify-between items-center"
            div.innerHTML = `
            <div class="space-y-2">
                <!-- ROL -->
                <p class="font-bold text-2xl text-gray-900">${perfil.nombre_rol}</p>

                <!-- Segmento y submodulo -->
                <div class="flex flex-wrap gap-2">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-lg text-sm font-semibold">
                        ${perfil.nomsegmento}
                    </span>

                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-lg text-sm font-semibold">
                        ${perfil.nombre_modseg}
                    </span>
                </div>

                <!-- Acciones permitidas 
                <p class="text-sm text-gray-700 bg-white px-3 py-1 rounded-lg shadow-inner border inline-block mt-2">
                    Acciones permitidas: <span class="font-semibold">15</span> / 20
                </p>
                -->
            </div>

            <!--Botones-->
            <div class="flex space-x-3">

                <button data-id="${perfil.cod_permiso}" type="button" class="btn-editar-permisos px-4 py-2 rounded-xl bg-emerald-600 text-white font-semibold 
                hover:bg-emerald-700 cursor-pointer transition transform 
                hover:scale-105 shadow-md">
                        Editar Permisos
                </button>
            </div>
        `

            listaPermisosPerfiles.appendChild(div)
        })

        EventosBotonesPermisos()
    }

    async function pintarModulosAcciones() {
        const respuesta = await fetch('../backend/ajax.php?api=traer_modulos_acciones');
        const modulos = await respuesta.json();

        // console.log(modulos);

        const arrayModulos = Object.values(modulos);

        arrayModulos.forEach((mod) => {
            const div = document.createElement('div')
            div.className = 'bg-white shadow rounded-xl p-4 border border-gray-200 hover:shadow-md transition'
            div.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-sky-700">Módulo: ${mod.nom_mod}</h3>
                <input type="checkbox" 
                    data-id-modulo="${mod.cod_mod}"
                    class="check-modulo h-6 w-6 text-sky-600 rounded border-gray-300 focus:ring-sky-500 cursor-pointer">
            </div>

            <!-- Acciones CRUD -->
            <div class="space-y-2 pl-2" data-modulo="${mod.cod_mod}">
        `;

            mod.acciones.forEach((acc) => {
                div.innerHTML += `
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <label class="font-medium text-gray-700">${acc.nom_accion}</label>
                    <input type="checkbox"
                        data-accion="${acc.cod_accionesmod}" 
                        data-modulo="${mod.cod_mod}"
                        class="check-accion h-5 w-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500 cursor-pointer">
                </div>
            `
            });

            div.innerHTML += `</div>`;

            listaAccionesModulos.appendChild(div);
        });

        // Agregar eventos después de pintar
        agregarEventosCheckboxes();
    }

    function EventosBotonesPermisos() {
        // Botones de Permisos
        listaPermisosPerfiles.addEventListener('click', (e) => {
            const boton = e.target.closest('button') // el elemento <button>
            if (!boton) return; // para cuando haga click en el div de listaRoles
            const cod_permiso = boton.dataset.id;

            if (boton.classList.contains('btn-editar-permisos')) {
                habilitarEdicionPermisos(cod_permiso)
            } else if (boton.classList.contains('btn-ver-permisos')) {

            }
        })
    }

    function agregarEventosCheckboxes() {
        // Evento para los checkboxes de MÓDULOS (seleccionar/deseleccionar todas las acciones)
        const checkModulos = document.querySelectorAll('.check-modulo');

        checkModulos.forEach(checkModulo => {
            checkModulo.addEventListener('change', (e) => {
                const codModulo = e.target.dataset.idModulo;
                const isChecked = e.target.checked;

                // Seleccionar/deseleccionar todas las acciones de ese módulo
                const accionesModulo = document.querySelectorAll(`.check-accion[data-modulo="${codModulo}"]`);
                accionesModulo.forEach(accion => {
                    accion.checked = isChecked;
                });
            });
        });

        // Evento para los checkboxes de ACCIONES (verificar si todas están marcadas para marcar el módulo)
        const checkAcciones = document.querySelectorAll('.check-accion');

        checkAcciones.forEach(checkAccion => {
            checkAccion.addEventListener('change', (e) => {
                const codModulo = e.target.dataset.modulo;
                verificarEstadoModulo(codModulo);
            });
        });
    }

    function verificarEstadoModulo(codModulo) {
        // Obtener todas las acciones del módulo
        const accionesModulo = document.querySelectorAll(`.check-accion[data-modulo="${codModulo}"]`);
        const checkModulo = document.querySelector(`.check-modulo[data-id-modulo="${codModulo}"]`);

        // Verificar si todas están marcadas
        const todasMarcadas = Array.from(accionesModulo).every(accion => accion.checked);
        const algunaMarcada = Array.from(accionesModulo).some(accion => accion.checked);

        if (todasMarcadas) {
            checkModulo.checked = true;
            checkModulo.indeterminate = false;
        } else if (algunaMarcada) {
            checkModulo.checked = false;
            checkModulo.indeterminate = true; // Estado intermedio
        } else {
            checkModulo.checked = false;
            checkModulo.indeterminate = false;
        }
    }

    async function habilitarEdicionPermisos(cod_permiso) {

        permisoActualEditando = cod_permiso;

        modalPermisos.classList.remove('hidden');
        modalPermisos.classList.add('flex');

        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
        }, 10);

        // Limpiar checkboxes antes de cargar los nuevos
        limpiarCheckboxes();

        try {
            // Traer las acciones que tiene este permiso actualmente
            const respuesta = await fetch(`../backend/ajax.php?api=traer_acciones&permiso=${cod_permiso}`);
            const accionesActivas = await respuesta.json();

            // Marcar los checkboxes de las acciones que tiene
            accionesActivas.forEach((accion) => {
                const checkbox = document.querySelector(`.check-accion[data-accion="${accion.cod_accionesmod}"][data-modulo="${accion.cod_mod}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                } else {
                    console.log('Checkbox NO encontrado');
                }
            });

            // Verificar el estado de cada módulo (si todas sus acciones están marcadas)
            const modulos = document.querySelectorAll('.check-modulo');
            modulos.forEach(checkModulo => {
                const codModulo = checkModulo.dataset.idModulo;
                verificarEstadoModulo(codModulo);
            });

        } catch (error) {
            console.error('Error al cargar acciones:', error);
        }
    }

    function limpiarCheckboxes() {
        // Desmarcar todos los checkboxes
        const todosLosChecks = document.querySelectorAll('.check-modulo, .check-accion');
        todosLosChecks.forEach(check => {
            check.checked = false;
            check.indeterminate = false;
        });
    }

    async function guardarPermisos() {
        if (!permisoActualEditando) {
            iziToast.error({
                title: 'Error',
                message: 'No hay permiso seleccionado',
                position: 'topRight',
                timeout: 2500
            });
            return;
        }

        // Obtener todos los checkboxes marcados
        const checkboxesMarcados = document.querySelectorAll('.check-accion:checked');

        // Crear array con los permisos seleccionados
        const permisosSeleccionados = [];
        checkboxesMarcados.forEach(checkbox => {
            permisosSeleccionados.push({
                cod_accionesmod: checkbox.dataset.accion,
                cod_mod: checkbox.dataset.modulo
            });
        });

        // console.log('💾 Guardando permisos:', permisosSeleccionados);
        // console.log('📋 Para el permiso:', permisoActualEditando);

        // Validar que haya al menos un permiso seleccionado
        if (permisosSeleccionados.length === 0) {
            iziToast.warning({
                title: 'Advertencia',
                message: 'Debe seleccionar al menos un permiso',
                position: 'topRight',
                timeout: 2500
            });
            return;
        }

        try {
            const respuesta = await fetch('../backend/ajax.php?modulo=permisos&accion=actualizar_permisos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    cod_permiso: permisoActualEditando,
                    permisos: permisosSeleccionados
                })
            });


            const resultado = await respuesta.json(); // ✅ Cambiar a JSON

            if (resultado.status === 'exito') {
                iziToast.success({
                    title: 'Éxito',
                    message: 'Los permisos se han actualizado correctamente',
                    position: 'topRight',
                    timeout: 2500
                });

                cerrarModalPermisos();

                // Limpiar la lista antes de repintar
                listaPermisosPerfiles.innerHTML = '';
                await pintarPerfilesPermisos();

            } else {
                iziToast.error({
                    title: 'Error',
                    message: resultado.message || 'No se pudieron actualizar los permisos',
                    position: 'topRight',
                    timeout: 3000
                });
                console.error('❌ Error del servidor:', resultado);
            }

        } catch (error) {
            console.error('❌ Error al guardar:', error);
            iziToast.error({
                title: 'Error',
                message: 'Error de conexión al guardar permisos',
                position: 'topRight',
                timeout: 3000
            });
        }
    }


    // --- Funciones de Modal de Permisos ---

    const cerrarModalPermisos = () => {
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modalPermisos.classList.add('hidden');
            modalPermisos.classList.remove('flex');
        }, 300);
    };

    // Eventos de cierre para el modal de permisos
    btnCancelarModal.addEventListener('click', cerrarModalPermisos);
    modalPermisos.addEventListener('click', (e) => {
        if (e.target === modalPermisos) {
            cerrarModalPermisos();
        }
    });

    function habilitarEdicion(id_rol) {

        const input = document.getElementById(`input_rol-${id_rol}`);

        if (!input.readOnly) return;

        const valorOriginal = input.value.trim(); // ⬅️ Guardar el valor inicial

        input.readOnly = false;
        input.classList.add("border-b", "border-indigo-500");

        input.focus();
        input.select();

        // GUARDADO AUTOMÁTICO
        const guardar = () => {

            input.readOnly = true;
            input.classList.remove("border-b", "border-indigo-500");

            const nuevoValor = input.value.trim();

            // ⛔ Si NO cambió, no hacer nada
            if (nuevoValor === valorOriginal) {
                return;
            }

            // ✅ Si cambió, guardar
            EditarRol(id_rol, nuevoValor);
        };

        input.addEventListener("blur", guardar, { once: true });

        input.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                input.blur(); // dispara el blur → guarda
            }
        });
    }


    async function EditarRol(id_rol, valor) {

        const form = new FormData();
        form.append("id_rol", id_rol)
        form.append("nombre_rol", valor)

        const solicito = await fetch('../backend/ajax.php?modulo=rol&accion=editar', {
            method: 'POST',
            body: form
        })
        const respuesta = await solicito.text();

        if (respuesta == 'exito') {
            //alert('Se editó')
            iziToast.success({
                title: 'Éxito',
                message: 'El rol se ha editado correctamente',
                position: 'topRight',   // puedes cambiarlo si quieres
                timeout: 2500
            });
            pintarRoles()
        } else {

        }
    }

    async function CrearRol() {
        const form = new FormData(formCrearRol);
        const solicito = await fetch('../backend/ajax.php?modulo=rol&accion=crear', {
            method: 'POST',
            body: form
        })

        const respuesta = await solicito.text()
        if (respuesta == 'exito') {
            // console.log('creado');
            iziToast.success({
                title: 'Guardado',
                message: 'Se ha guardado con éxito',
                position: 'topRight',
                timeout: 2500
            });

            pintarRoles()
            cerrarModalCrear()
        }
    }

    async function AnularRol(id_rol) {
        iziToast.question({
            timeout: false,
            close: false,
            overlay: true,
            displayMode: 'once',
            title: 'Confirmar',
            message: '¿Estás seguro de que quieres eliminar este rol?',
            position: 'center',
            buttons: [

                // Botón SI
                ['<button><b>SI</b></button>', async (instance, toast) => {
                    instance.hide({ transitionOut: 'fadeOut' }, toast);

                    const form = new FormData();
                    form.append("id_rol", id_rol);

                    const solicito = await fetch(
                        '../backend/ajax.php?modulo=rol&accion=eliminar',
                        {
                            method: 'POST',
                            body: form
                        }
                    );

                    const respuesta = await solicito.text();

                    if (respuesta == 'exito') {
                        iziToast.success({
                            title: 'Eliminado',
                            message: 'Se ha eliminado con éxito',
                            position: 'topRight',
                            timeout: 2500
                        });

                        pintarRoles();
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'No se pudo eliminar el rol',
                            position: 'topRight'
                        });
                    }
                }, true],

                // Botón NO
                ['<button>NO</button>', (instance, toast) => {
                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                }]
            ]
        });
    }



    //==============================================================================================================

    // Función para establecer la altura mínima del contenedor principal
    const setMinHeight = () => {
        const activeSection = document.querySelector('.content-section.active');
        if (activeSection) {
            // Se ajusta la altura mínima para evitar saltos al cambiar entre secciones de diferente tamaño
            mainContent.style.minHeight = activeSection.offsetHeight + 'px';
        }
    };

    window.addEventListener('resize', setMinHeight);

    // Función para cambiar de sección con transición
    const changeSection = (newTargetId) => {
        const currentActive = document.querySelector('.content-section.active');
        const newActive = document.getElementById(newTargetId);

        if (currentActive === newActive) return;

        // Determinar la dirección de la transición
        const isForward = (newTargetId === 'asignacion-permisos');

        // 1. Transición de salida de la sección actual
        currentActive.classList.remove('active');
        currentActive.classList.add(isForward ? 'hidden-left' : 'hidden-right');

        // 2. Transición de entrada de la nueva sección
        setTimeout(() => {
            newActive.classList.remove('hidden-left', 'hidden-right');
            newActive.classList.add('active');
            // Ajustamos la altura al final de la transición
            setTimeout(setMinHeight, 500);
        }, 50);

        // 3. Actualizar botones (tabs)
        tabButtons.forEach(btn => btn.classList.remove('active'));
        document.querySelector(`.tab-button[data-target="${newTargetId}"]`).classList.add('active');
    };

    // Asignar eventos a los botones de pestaña
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            changeSection(targetId);
        });
    });

    // GESTIÓN DE MODALES (ANIMACIONES)


    // Modal Crear Rol/Segmento
    const modalCrearRol = document.getElementById('modalCrearRol');
    const crearRolContent = document.getElementById('crearRolContent');
    const btnCrearRol = document.getElementById('btnCrearRol');
    const cerrarCrearRol = document.getElementById('cerrarCrearRol');
    const btnCrearSegmento = document.getElementById('btnCrearSegmento'); // Añadido para Segmento




    // --- Funciones de Modal Crear Rol/Segmento ---

    const abrirModalCrear = (title) => {
        // Actualizar título dinámicamente
        document.querySelector('#modalCrearRol h2').textContent = `Crear Nuevo ${title}`;
        document.querySelector('#modalCrearRol button[type="submit"]').textContent = `Guardar ${title}`;

        modalCrearRol.classList.remove('hidden');
        modalCrearRol.classList.add('flex');
        setTimeout(() => {
            crearRolContent.classList.remove('scale-95', 'opacity-0');
        }, 10);
    };

    const cerrarModalCrear = () => {
        crearRolContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modalCrearRol.classList.add('hidden');
            modalCrearRol.classList.remove('flex');
        }, 300);
    };

    btnCrearRol.addEventListener('click', () => abrirModalCrear('Rol'));
    // Evento para el botón de crear Segmento
    // btnCrearSegmento.addEventListener('click', () => abrirModalCrear('Segmento'));

    cerrarCrearRol.addEventListener('click', cerrarModalCrear);
    modalCrearRol.addEventListener('click', (e) => {
        if (e.target === modalCrearRol) {
            cerrarModalCrear();
        }
    });

    // Inicializar la altura mínima del contenedor
    setMinHeight();
});
