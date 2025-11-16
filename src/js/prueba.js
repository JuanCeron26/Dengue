window.addEventListener('load', () => {

    const divUsuarios = document.getElementById('divUsuarios')
    const btnCreateUser = document.getElementById('btnRegistrarUsuario')
    const vistaRegistroUser = document.getElementById('ui-registrar-usuario')
    const vistaGeneral = document.getElementById('view')
    const selectTI = document.getElementById('selectTI')
    const selectRol = document.getElementById('selectRol')
    const selectSegmentos = document.getElementById('selectSegmento')
    const btnCancelarRegistro = document.getElementById('cancelarRegistro')
    const formEditarUsuario = document.getElementById('formEditarUsuario')

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
            vistaRegistroUser.classList.add('opacity-0');
            vistaRegistroUser.classList.add('hidden');

            vistaGeneral.classList.remove('-translate-x-full');
        }, 500);
    });

    document.getElementById('cerrarModal').addEventListener('click', () => {
        document.getElementById('modalEditarUsuario').classList.add('hidden');
        document.getElementById('modalEditarUsuario').classList.remove('flex');
    });

    pintarUsuarios();
    traerDocumentos(selectTI);
    traerRoles(selectRol);
    traerSegmentos(selectSegmentos);

    /*
    fetch('../backend/api.php?ajax=documentos')
        .then(res => res.text())
        .then(texto => {
            console.log("RESPUESTA DEL SERVIDOR:");
            console.log(texto);
        });
    */




    function pintarUsuarios() {
        fetch('../backend/api.php?ajax=pintar_usuarios')
            .then(res => res.json())
            .then(usuarios => {

                // LIMPIAR contenedor primero
                divUsuarios.innerHTML = "";

                // Crear fragmento para insertar TODO al final
                const fragment = document.createDocumentFragment();

                usuarios.forEach(usuario => {

                    const divUsuario = document.createElement('div');
                    divUsuario.className =
                        'bg-white rounded-2xl p-6 shadow-xl border border-gray-200 hover:shadow-blue-300/50 ' +
                        'transition-all duration-300 transform hover:scale-[1.03] float-soft';

                    divUsuario.innerHTML = `
                    <div class="flex items-center space-x-4 border-b border-gray-200 pb-4 mb-4">
                        <div class="bg-blue-600 text-white font-bold rounded-full h-14 w-14 flex items-center justify-center text-xl ring-2 ring-blue-400 select-none pulse-glow">
                            JC
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

                // Inserta TODO de una sola vez
                divUsuarios.appendChild(fragment);
                asignarEventosBotones();
            });
    }


    function asignarEventosBotones() {
        divUsuarios.addEventListener('click', (e) => {
            // Buscar el botón más cercano (esto soluciona el problema de clicks en elementos hijos)
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
        fetch('../backend/api.php?ajax=documentos')
            .then(respuesta => respuesta.json())
            .then(documentos => {
                select.innerHTML = ''; // Limpiar opciones previas
                documentos.forEach((doc) => {
                    const option = document.createElement('option');
                    option.value = doc.cod_tipodocum;
                    option.textContent = doc.nombre_tipodocum;
                    select.appendChild(option);
                });
            });
    }

    async function traerRoles(select) {
        try {
            const respuesta = await fetch('../backend/api.php?ajax=roles');
            const roles = await respuesta.json();
            select.innerHTML = ''; // Limpiar opciones previas
            roles.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol.cod_rol;
                option.textContent = rol.nombre_rol;
                select.appendChild(option);
            });
        } catch (error) {
            console.error("Error cargando roles:", error);
        }
    }

    async function traerSegmentos(select) {
        try {
            const respuesta = await fetch('../backend/api.php?ajax=segmentos');
            const segmentos = await respuesta.json();
            select.innerHTML = ''; // Limpiar opciones previas
            segmentos.forEach(segmento => {
                const option = document.createElement('option');
                option.value = segmento.cod_segmento;
                option.textContent = segmento.nomsegmento;
                select.appendChild(option);
            });
        } catch (error) {
            console.error("Error cargando segmentos:", error);
        }
    }

    async function traerUsuario(id_user) {
        const selectTipoDoc = formEditarUsuario.querySelector('#tipoDocUsuario');
        const selectRol = formEditarUsuario.querySelector('#rolUsuario');
        const selectSegmento = formEditarUsuario.querySelector('#segmentoUsuario');

        try {
            // Primero traemos los datos del usuario
            const respuesta = await fetch(`../backend/api.php?ajax=traer_usuario&id=${id_user}`);
            const usuario = await respuesta.json();

            // Llenar campos de texto primero
            document.getElementById('idUsuario').value = usuario.id_usuarios;
            document.getElementById('nombreUsuario').value = usuario.nombre_usu;
            document.getElementById('apellidoUsuario').value = usuario.apellido_usu;
            document.getElementById('correoUsuario').value = usuario.correo_electronico;
            document.getElementById('idCedulaUsuario').value = usuario.id_cedula;

            // Cargar los selects y ESPERAR a que terminen
            await traerDocumentos(selectTipoDoc);
            await traerRoles(selectRol);
            await traerSegmentos(selectSegmento);

            // AHORA SÍ asignar los valores (después de que los selects estén llenos)
            selectTipoDoc.value = usuario.tipo_doc;
            selectRol.value = usuario.rol;
            selectSegmento.value = usuario.segmento;

            // Mostrar modal
            document.getElementById('modalEditarUsuario').classList.remove('hidden');

        } catch (error) {
            console.error('Error al cargar usuario:', error);
            alert('Error al cargar los datos del usuario');
        }
    }

    //////////////// CRUD /////////////////

    formEditarUsuario.addEventListener('submit', (e) => {
        e.preventDefault()
        editarUsuario(e.target)

    })

    function editarUsuario(form) {
        const DataForm = new FormData(form)

        fetch('../backend/api.php?accion=editar', {
            method: 'POST',
            body: DataForm
        })
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                if (respuesta == 'exito') {
                    alert('usuario editado')
                    document.getElementById('modalEditarUsuario').classList.add('hidden');
                    pintarUsuarios()
                }
            })
    }

    function eliminarUsuario() {
        
    }




})