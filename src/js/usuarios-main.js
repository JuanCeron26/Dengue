document.addEventListener('DOMContentLoaded', () => {

    const divUsuarios = document.getElementById('divUsuarios')
    const btnCreateUser = document.getElementById('btnRegistrarUsuario')
    const vistaRegistroUser = document.getElementById('ui-registrar-usuario')
    const vistaGeneral = document.getElementById('view')
    const selectTI = document.getElementById('selectTI')
    const selectRol = document.getElementById('selectRol')
    const selectSegmentos = document.getElementById('selectSegmento')
    const btnCancelarRegistro = document.getElementById('cancelarRegistro')
    const formEditarUsuario = document.getElementById('formEditarUsuario')
    const modalEditarUsuario = document.getElementById('modalEditarUsuario')
    const btnCerrarModal = document.getElementById('cerrarModal')
    const btnToggle = document.getElementById("togglePassword");

    btnCreateUser.addEventListener('click', () => {
        vistaGeneral.classList.add('-translate-x-full');

        setTimeout(() => {
            vistaGeneral.classList.add('hidden');
            vistaRegistroUser.classList.remove('hidden', 'opacity-0', 'translate-x-full');
        }, 700);
    });

    btnCancelarRegistro.addEventListener('click', () => {
        vistaRegistroUser.classList.add('translate-x-full');

        setTimeout(() => {
            vistaGeneral.classList.remove('hidden');
            vistaRegistroUser.classList.add('opacity-0', 'hidden');
            vistaGeneral.classList.remove('-translate-x-full');
        }, 500);
    });

    btnCerrarModal.addEventListener('click', () => {
        modalEditarUsuario.classList.add('hidden');
        modalEditarUsuario.classList.remove('flex');
    });

    document.getElementById("cerrarDetalle").addEventListener("click", () => {
        const modal = document.getElementById("modalDetalleUsuario");
        const card = document.getElementById("cardDetalle");

        card.classList.add("scale-90", "opacity-0");

        setTimeout(() => {
            modal.classList.add("hidden");
            modal.classList.remove('flex')
        }, 400);
    });

    pintarUsuarios();
    traerDocumentos(selectTI);
    traerRoles(selectRol);
    traerSegmentos(selectSegmentos);

    function pintarUsuarios() {
        fetch('../backend/api.php?ajax=pintar_usuarios')
            .then(res => res.json())
            .then(usuarios => {
                divUsuarios.innerHTML = "";
                const fragment = document.createDocumentFragment();

                usuarios.forEach(usuario => {
                    const divUsuario = document.createElement('div');
                    divUsuario.className =
                        'bg-white rounded-2xl p-6 shadow-xl border border-gray-200 hover:shadow-blue-300/50 ' +
                        'transition-all duration-300 transform hover:scale-[1.03] float-soft';

                    divUsuario.innerHTML = `
                    <div class="flex items-center space-x-4 border-b border-gray-200 pb-4 mb-4">
                        <div class="bg-blue-600 text-white font-bold rounded-full h-14 w-14 flex items-center justify-center text-xl ring-2 ring-blue-400 select-none pulse-glow">
                            ${usuario.nombre_usu.charAt(0)}${usuario.apellido_usu.charAt(0)}
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-800 select-none">
                                ${usuario.nombre_usu} ${usuario.apellido_usu}
                            </h3>
                            <p class="text-sm text-blue-600 font-semibold select-none">${usuario.rol}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-gray-600 flex items-center">
                            <span class="text-blue-500 mr-3">📧</span>
                            <span class="font-medium truncate">${usuario.correo_electronico}</span>
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <span class="text-blue-500 mr-3">🆔</span>
                            <span class="font-medium">${usuario.tipo_doc} ${usuario.id_cedula}</span>
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <span class="text-blue-500 mr-3">🏷️</span>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-green-300">${usuario.segmento}</span>
                        </p>
                    </div>

                    <div class="mt-6 flex justify-between space-x-3">
                        <button
                            class="btn-ver_detalle cursor-pointer flex-1 bg-blue-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition"
                            data-id="${usuario.id_usuarios}">
                            Ver Detalle
                        </button>

                        <button
                            class="btn-editar cursor-pointer bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition"
                            data-id="${usuario.id_usuarios}">
                            <img src="../../../src/icons/icono_edit.png" class="w-5 h-5 pointer-events-none" alt="">
                        </button>

                        <button
                            class="btn-eliminar cursor-pointer bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition"
                            data-id="${usuario.id_usuarios}">
                            <img src="../../../src/icons/icono_delete.png" class="w-5 h-5 pointer-events-none" alt="">
                        </button>
                    </div>
                `;

                    fragment.appendChild(divUsuario);
                });

                divUsuarios.appendChild(fragment);
                asignarEventosBotones();
            })
            .catch(error => {
                console.error('Error al cargar usuarios:', error);
            });
    }

    function asignarEventosBotones() {
        divUsuarios.addEventListener('click', (e) => {
            const boton = e.target.closest('button');
            if (!boton) return;

            const id_user = boton.dataset.id;

            if (boton.classList.contains('btn-editar')) {
                traerUsuario(id_user);
            } else if (boton.classList.contains('btn-eliminar')) {
                eliminarUsuario(id_user);
            } else if (boton.classList.contains('btn-ver_detalle')) {
                verDetalleUsuario(id_user);
            }
        });
    }

    function traerDocumentos(select) {
        return fetch('../backend/api.php?ajax=documentos')
            .then(respuesta => respuesta.json())
            .then(documentos => {
                select.innerHTML = '';
                documentos.forEach((doc) => {
                    const option = document.createElement('option');
                    option.value = doc.cod_tipodocum;
                    option.textContent = doc.nombre_tipodocum;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Error cargando documentos:", error);
            });
    }

    async function traerRoles(select) {
        try {
            const respuesta = await fetch('../backend/api.php?ajax=roles');
            const roles = await respuesta.json();
            select.innerHTML = '';
            roles.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol.cod_rol;
                option.textContent = rol.nombre_rol;
                select.appendChild(option);
            });
        } catch (error) {
            console.error("Error cargando roles:", error);
            throw error;
        }
    }

    async function traerSegmentos(select) {
        try {
            const respuesta = await fetch('../backend/api.php?ajax=segmentos');
            const segmentos = await respuesta.json();
            select.innerHTML = '';
            segmentos.forEach(segmento => {
                const option = document.createElement('option');
                option.value = segmento.cod_segmento;
                option.textContent = segmento.nomsegmento;
                select.appendChild(option);
            });
        } catch (error) {
            console.error("Error cargando segmentos:", error);
            throw error;
        }
    }

    async function traerUsuario(id_user) {
        const selectTipoDoc = document.getElementById('tipoDocUsuario');
        const selectRol = document.getElementById('rolUsuario');
        const selectSegmento = document.getElementById('segmentoUsuario');

        try {
            const respuesta = await fetch(`../backend/api.php?ajax=traer_usuario&id=${id_user}`);
            const usuario = await respuesta.json();

            console.log(usuario);

            // Llenar campos de texto primero
            document.getElementById('idUsuario').value = usuario.id_usuarios;
            document.getElementById('nombreUsuario').value = usuario.nombre_usu;
            document.getElementById('apellidoUsuario').value = usuario.apellido_usu;
            document.getElementById('correoUsuario').value = usuario.correo_electronico;
            document.getElementById('idCedulaUsuario').value = usuario.id_cedula;

            await traerDocumentos(selectTipoDoc);
            await traerRoles(selectRol);
            await traerSegmentos(selectSegmento);

            selectTipoDoc.value = usuario.cod_tipodocum;
            selectRol.value = usuario.cod_rol;
            selectSegmento.value = usuario.cod_segmento;

            modalEditarUsuario.classList.remove('hidden');
            modalEditarUsuario.classList.add('flex');

        } catch (error) {
            console.error('Error al cargar usuario:', error);
            alert('Error al cargar los datos del usuario');
        }
    }

    btnToggle.addEventListener("click", () => {
        if (document.getElementById('detallePassword').type === "password") {
            document.getElementById('detallePassword').type = "text"
        } else {
            document.getElementById('detallePassword').type = "password";
        }
    })

    //////////////// CRUD /////////////////

    formEditarUsuario.addEventListener('submit', (e) => {
        e.preventDefault();
        editarUsuario(e.target);
    });

    function editarUsuario(form) {
        const DataForm = new FormData(form);

        const tipoDoc = DataForm.get('tipoDocUsuario');
        const rol = DataForm.get('rolUsuario');
        const segmento = DataForm.get('segmentoUsuario');

        if (!tipoDoc || !rol || !segmento) {
            iziToast.warning({ title: 'Atención', message: 'Por favor complete todos los campos obligatorios', position: 'topRight' });
            return;
        }

        fetch('../backend/api.php?accion=editar', {
            method: 'POST',
            body: DataForm
        })
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                console.log('Respuesta del servidor:', respuesta);

                if (respuesta.includes('exito')) {
                    iziToast.success({ title: 'Éxito', message: 'Usuario editado correctamente', position: 'topRight' });
                    modalEditarUsuario.classList.add('hidden');
                    modalEditarUsuario.classList.remove('flex');
                    pintarUsuarios();
                } else {
                    iziToast.error({ title: 'Error', message: 'Error al editar usuario: ' + respuesta, position: 'topRight' });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión al editar usuario');
            });
    }

    async function eliminarUsuario(id_user) {

        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            title: 'Confirmar eliminación',
            message: '¿Estás seguro que deseas eliminar este usuario?',
            position: 'center',
            buttons: [
                ['<button class="bg-red-600 text-white px-4 py-2 rounded">Eliminar</button>', async function (instance, toast) {
                    // cerrar diálogo
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    // mostrar toast de proceso
                    iziToast.info({ title: 'Eliminando', message: 'Por favor espera...', position: 'topRight', timeout: 2000 });

                    try {
                        const form = new FormData();
                        form.append('id_user', id_user);

                        const resp = await fetch(`../backend/api.php?accion=eliminar`, {
                            method: 'POST',
                            body: form
                        });

                        const text = (await resp.text()).trim();

                        if (text === 'exito') {
                            iziToast.success({ title: 'Eliminado', message: 'Se eliminó correctamente', position: 'topRight' });
                            pintarUsuarios();
                        } else {
                            iziToast.error({ title: 'Error', message: 'No se pudo eliminar: ' + text, position: 'topRight' });
                            console.error('Fallo al eliminar:', text);
                        }
                    } catch (err) {
                        console.error('Error al eliminar:', err);
                    }
                }, true],
                ['<button class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }]
            ]
        });
    }

    function verDetalleUsuario(id_user) {
        fetch(`../backend/api.php?ajax=traer_usuario&id=${id_user}`)
            .then(res => res.json())
            .then(usuario => {

                console.log(usuario);

                // Llenar datos
                const iniciales = usuario.nombre_usu.charAt(0) + usuario.apellido_usu.charAt(0);
                document.getElementById("detalleIniciales").textContent = iniciales;
                document.getElementById("detalleNombre").textContent = `${usuario.nombre_usu} ${usuario.apellido_usu}`;
                document.getElementById("detalleRol").textContent = usuario.rol;
                document.getElementById("detalleCorreo").textContent = usuario.correo_electronico;
                document.getElementById("detalleCedula").textContent = `${usuario.tipo_doc} ${usuario.id_cedula}`;
                document.getElementById("detalleSegmento").textContent = usuario.segmento;
                document.getElementById("detallePassword").value = usuario.contraseña;

                // Mostrar modal con animaciones
                const modal = document.getElementById("modalDetalleUsuario");
                const card = document.getElementById("cardDetalle");

                modal.classList.remove("hidden");
                modal.classList.add("flex")

                // Tiempo para permitir animación
                setTimeout(() => {
                    card.classList.remove("scale-90", "opacity-0");
                    card.classList.add("scale-100", "opacity-100");
                }, 20);
            });
    }



});