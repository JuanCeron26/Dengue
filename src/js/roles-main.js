document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tab-button');
    const contentSections = document.querySelectorAll('.content-section');
    const mainContent = document.querySelector('main > div.relative');


    const listaRoles = document.getElementById('listaRoles')
    const formCrearRol = document.getElementById('formCrearRol')

    formCrearRol.addEventListener('submit', (e) => {
        e.preventDefault();
        CrearRol();
    });

    pintarRoles();



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
            console.log('creado');
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

    const modalPermisos = document.getElementById('modalPermisos');
    const modalContent = document.getElementById('modalContent');
    const btnCancelarModal = document.getElementById('btnCancelarModal');

    // Modal Crear Rol/Segmento
    const modalCrearRol = document.getElementById('modalCrearRol');
    const crearRolContent = document.getElementById('crearRolContent');
    const btnCrearRol = document.getElementById('btnCrearRol');
    const cerrarCrearRol = document.getElementById('cerrarCrearRol');
    const btnCrearSegmento = document.getElementById('btnCrearSegmento'); // Añadido para Segmento

    // --- Funciones de Modal de Permisos ---

    window.abrirModalPermisos = (rol, segmento) => {
        document.getElementById('modalInfo').textContent = `Perfil: ${rol} + ${segmento}`;
        modalPermisos.classList.remove('hidden');
        modalPermisos.classList.add('flex');

        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
        }, 10);
    };

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
    btnCrearSegmento.addEventListener('click', () => abrirModalCrear('Segmento'));

    cerrarCrearRol.addEventListener('click', cerrarModalCrear);
    modalCrearRol.addEventListener('click', (e) => {
        if (e.target === modalCrearRol) {
            cerrarModalCrear();
        }
    });

    // Inicializar la altura mínima del contenedor
    setMinHeight();
});
