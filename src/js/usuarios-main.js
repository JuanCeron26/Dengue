window.addEventListener('load', () => {

    const divUsuarios = document.getElementById('divUsuarios')
    const btnCreateUser = document.getElementById('btnRegistrarUsuario')
    const vistaRegistroUser = document.getElementById('ui-registrar-usuario')
    const vistaGeneral = document.getElementById('view')
    const selectTI = document.getElementById('selectTI')
    const selectRol = document.getElementById('selectRol')
    const selectSegmentos = document.getElementById('selectSegmento')
    const btnCancelarRegistro = document.getElementById('cancelarRegistro')

    btnCreateUser.addEventListener('click', () => {
        // Deslizar la vista general hacia la izquierda
        vistaGeneral.classList.add('-translate-x-full');

        // DESPUÉS de que termine la animación, se oculta
        setTimeout(() => {
            vistaGeneral.classList.add('hidden');

            vistaRegistroUser.classList.remove('hidden', 'opacity-0', 'translate-x-full');
        }, 700); // debe coincidir con duration-500
    });

    btnCancelarRegistro.addEventListener('click', () => {

        vistaRegistroUser.classList.add('translate-x-full');

        setTimeout(() => {
            vistaGeneral.classList.remove('hidden');
            vistaRegistroUser.classList.add('opacity-0');
            vistaRegistroUser.classList.add('hidden');

            vistaGeneral.classList.remove('-translate-x-full');


        }, 500);
    })

    pintarUsuarios();
    traerDocumentos();
    traerRoles();
    traerSegmentos();

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
            .then(respuesta => respuesta.json())
            .then(usuarios => {
                usuarios.forEach(usuario => {
                    const divUsuario = document.createElement('div')
                    divUsuario.className = 'bg-white rounded-2xl p-6 shadow-xl border border-gray-200 hover:shadow-blue-300/50 transition-all duration-300 transform hover:scale-[1.03] float-soft';
                    divUsuario.innerHTML +=
                        `
                    <div class="flex items-center space-x-4 border-b border-gray-200 pb-4 mb-4">
                        <div class="bg-blue-600 text-white font-bold rounded-full h-14 w-14 flex items-center justify-center text-xl ring-2 ring-blue-400 select-none pulse-glow">
                            JC
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-800 select-none">${usuario.nombre_usu + ' ' + usuario.apellido_usu}</h3>
                            <p class="text-sm text-blue-600 font-semibold select-none">${usuario.rol}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-gray-600 flex items-center">
                            <span class="text-blue-500 mr-3">📧</span>
                            <span class="font-medium truncate" title="juan.ceron@email.com">${usuario.correo_electronico}</span>
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
                            class="cursor-pointer flex-1 bg-blue-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition duration-200 transform hover:scale-[1.05] shadow-md hover:shadow-blue-500/50"
                            title="Ver detalles completos">
                            Ver Detalle
                        </button>
                        <button
                            class="cursor-pointer bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition duration-200 transform hover:rotate-6"
                            title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z" />
                            </svg>
                        </button>
                        <button
                            class="cursor-pointer bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition duration-200 transform hover:-rotate-6"
                            title="Eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    `

                    divUsuarios.appendChild(divUsuario);
                });
            })
    }

    function traerDocumentos() {
        fetch('../backend/api.php?ajax=documentos')
            .then(respuesta => respuesta.json())
            .then(documentos => {
                documentos.forEach((doc) => {
                    const option = document.createElement('option');
                    option.value = doc.cod_tipodocum
                    option.textContent = doc.nombre_tipodocum

                    selectTI.appendChild(option)
                })
            })
    }

    async function traerRoles() {
        try {
            const respuesta = await fetch('../backend/api.php?ajax=roles');
            const roles = await respuesta.json();

            roles.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol.cod_rol;
                option.textContent = rol.nombre_rol;
                selectRol.appendChild(option);
            });

        } catch (error) {
            console.error("Error cargando documentos:", error);
        }
    }

    async function traerSegmentos() {
        try {
            const respuesta = await fetch('../backend/api.php?ajax=segmentos');
            const segmentos = await respuesta.json();

            segmentos.forEach(segmento => {
                const option = document.createElement('option');
                option.value = segmento.cod_segmento;
                option.textContent = segmento.nomsegmento;
                selectSegmentos.appendChild(option);
            });

        } catch (error) {
            console.error("Error cargando documentos:", error);
        }
    }


})