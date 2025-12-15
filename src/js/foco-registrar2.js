document.addEventListener('DOMContentLoaded', () => {

    const containerFocosActuales = document.getElementById('containerFocosActuales')
    const selectTipoFoco = document.getElementById('selectTipoFoco');
    const focoDescription = document.getElementById('focoDescription');
    const focoDescriptionText = document.getElementById('focoDescriptionText');
    const formRegistrarFoco = document.getElementById('formRegistrarFoco')


    let modoEdicion = false;
    let focoIdActual = null;

    GetFocosPotenciales();
    BotonEventos();

    //RECUPERAR TERRITORIO AL CARGAR LA PÁGINA
    recuperarTerritorioActivo();


    function recuperarTerritorioActivo() {
        const territorioGuardado = sessionStorage.getItem('territorioActivo');

        if (territorioGuardado) {

            const inputTerritorio = document.getElementById('foco_cod_territorio');
            if (inputTerritorio) {
                inputTerritorio.value = territorioGuardado;

                TraerFocosActuales(territorioGuardado, 'ecosalud');
                GetInvolucrados('participantes', territorioGuardado);
            }
        } else {
            console.log('ℹ️ No hay territorio activo guardado');


            containerFocosActuales.innerHTML = `
                <div class="text-center p-8">
                    <div class="text-6xl mb-4">📍</div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">
                        No hay territorio seleccionado
                    </h3>
                    <p class="text-slate-500">
                        Ve a la Sección 1 y registra o asocia un líder a un territorio
                    </p>
                </div>
            `;
        }
    }

    formRegistrarFoco.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const realizado = formData.get('realizo');
        const datos = {
            tipoVia: document.getElementById('tipoVia').value,
            numeroVia: document.getElementById('numeroVia').value,
            sufijo: document.getElementById('sufijo').value,
            distancia: document.getElementById('distancia').value,
            cod_tipo_foc: formData.get('cod_tipo_foc'),
            lugar: formData.get('lugar'),
            cod_territorio: formData.get('foco_cod_territorio')
        };

        const cod = formData.get('foco_cod_territorio')

        if (realizado) {
            datos.realizo = realizado
        }

        try {
            let url, mensaje;

            if (modoEdicion) {
                // MODO EDICIÓN
                datos.cod_focopotlugar = focoIdActual;
                url = '../backend/api-foco.php?accion=actualizar_foco';
                mensaje = 'Foco actualizado correctamente';
            } else {
                // MODO REGISTRO
                url = '../backend/api-foco.php?accion=registrar';
                mensaje = 'Foco registrado correctamente';
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            // console.log(resultado);

            if (resultado.success) {
                alert(mensaje);

                // Limpiar formulario
                e.target.reset();

                // Si estaba editando, cancelar modo edición
                if (modoEdicion) {
                    cancelarEdicion();
                }

                // Recargar lista de focos
                TraerFocosActuales(cod, 'ecosalud');

                formRegistrarFoco.scrollIntoView({ behavior: 'smooth', block: 'start' })

            } else {
                alert('Error: ' + (resultado.message || 'No se pudo completar la operación'));
            }


        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        }
    });

    selectTipoFoco.addEventListener('change', (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const descripcion = selectedOption.dataset.descripcion;

        if (descripcion && e.target.value) {
            focoDescriptionText.textContent = descripcion;
            focoDescription.classList.remove('hidden');
        } else {
            focoDescription.classList.add('hidden');
        }
    });

    async function TraerFocosActuales(cod_territorio, quien) {
        let url;
        if (quien == 'ecosalud') {
            url = `../backend/api-foco.php?ajax=traer_focosactuales&id=${cod_territorio}&ecosalud=true`
        } else {
            url = `../backend/api-foco.php?ajax=traer_focosactuales&id=${cod_territorio}&ecosalud=false`
        }
        const solicito = await fetch(url);
        const focos = await solicito.json()
        if (focos.length == 0) {
            containerFocosActuales.innerHTML = `
                <h1 class="text-2xl text-red-600 font-bold">No hay focos aún</h1>
            `
        }
        console.log(focos);
        containerFocosActuales.innerHTML = ''
        focos.forEach(foco => {
            const div = document.createElement('div')
            div.className = 'rounded-xl shadow-sm p-4 border border-slate-200 hover:border-purple-300 bg-white w-full hover:shadow-md transition-all duration-300 hover:-translate-y-0.5';
            div.innerHTML += `
                <div class="flex items-center justify-between gap-3">

                            <!-- Left Section: Icon + Info -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">

                                <!-- Icon -->
                                <div class="w-12 h-12 rounded-xl bg-linear-to-br from-purple-500 to-blue-500 
                                    flex items-center justify-center shadow-md shrink-0
                                    hover:scale-110 hover:rotate-3 transition-all duration-300">
                                    <img src="../../../src/icons/icono_ubicacion.png" class="w-6 h-6">
                                </div>

                                <!-- Text Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-slate-800 text-sm truncate">
                                        ${foco.nombre}
                                    </h3>
                                    <p class=" text-slate-500 truncate">
                                        ${foco.direccion}
                                    </p>
                                    <span class="inline-block mt-1 px-1 py-0.5 rounded-full text-xs font-medium
                                        bg-linear-to-r from-purple-100 to-blue-100 text-purple-700">
                                        ${foco.lugar}
                                    </span>
                                </div>
                            </div>

                            <!-- Right Section: Action Buttons -->
                            <div class="flex gap-2 shrink-0">

                                <!-- Edit Button -->
                                <button data-id-foco="${foco.id}" class="cursor-pointer btn-editar-foco 
                                    w-9 h-9 rounded-full bg-blue-200 hover:bg-blue-400 
                                    flex items-center justify-center shadow-sm
                                    hover:rotate-12 hover:scale-110 transition-all duration-300
                                    focus:outline-none focus:ring-2 focus:ring-blue-300 group">
                                    <img src="../../../src/icons/icono_edit2.png" alt="Editar"
                                        class="h-5 w-5 group-hover:brightness-0 group-hover:invert transition-all">
                                </button>

                                <!-- Delete Button -->
                                <button data-id-foco="${foco.id}" class="cursor-pointer btn-eliminar-foco 
                                    w-9 h-9 rounded-full bg-red-100 hover:bg-red-400 
                                    flex items-center justify-center shadow-sm
                                    hover:rotate-12 hover:scale-110 transition-all duration-300
                                    focus:outline-none focus:ring-2 focus:ring-red-300 group">
                                    <img src="../../../src/icons/icono_delete2.png" alt="Eliminar"
                                        class="h-5 w-5 group-hover:brightness-0 group-hover:invert transition-all">
                                </button>

                            </div>
                        </div>
            `

            containerFocosActuales.appendChild(div)

        })

    }

    async function cargarFocoParaEditar(idFoco) {
        try {
            const response = await fetch(`../backend/api-foco.php?ajax=obtener_foco&id=${idFoco}`);
            const foco = await response.json();

            // Activar modo edición
            modoEdicion = true;
            focoIdActual = parseInt(idFoco);
            document.getElementById('modoEdicion').value = '1';
            document.getElementById('focoIdEditar').value = idFoco;

            // Llenar el formulario con los datos
            const selectRealizo = document.getElementById('selectRealizo')
            if (selectRealizo) {
                selectRealizo.value = foco.realizo || '';
            }
            document.getElementById('tipoVia').value = foco.tipo_via || '';
            document.getElementById('numeroVia').value = foco.numero_via || '';
            document.getElementById('sufijo').value = foco.sufijo || '';
            document.getElementById('distancia').value = foco.distancia || '';
            document.getElementById('selectTipoFoco').value = foco.cod_tipo_foc || '';
            document.querySelector('input[name="lugar"]').value = foco.lugar || '';

            // Cambiar texto del botón
            document.getElementById('btnTexto').textContent = 'Editar foco potencial'


            // Mostrar botón cancelar
            document.getElementById('btnCancelarEdicion').classList.remove('hidden');

            // Scroll suave al formulario
            document.getElementById('formRegistrarFoco').scrollIntoView({ behavior: 'smooth', block: 'start' });

        } catch (error) {
            console.error('Error al cargar foco:', error);
            alert('Error al cargar los datos del foco');
        }
    }

    function GetFocosPotenciales() {
        fetch('../backend/api-foco.php?ajax=traer_tiposfocos')
            .then(respuesta => respuesta.json())
            .then(tiposfocos => {
                selectTipoFoco.innerHTML = '';
                tiposfocos.forEach((foco) => {
                    const option = document.createElement('option');
                    option.value = foco.cod_tipo_foc;
                    option.textContent = foco.nombre_foco;
                    option.dataset.descripcion = foco.descripcion_foco || 'Sin descripción disponible';
                    selectTipoFoco.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }


    function GetInvolucrados(quien, cod_territorio) {
        // quien = participantes
        // quien = usuarios_eco

        // Primero: validar si el select existe
        const selectRealizo = document.getElementById('selectRealizo');
        if (!selectRealizo) {
            // No existe → salir sin hacer nada
            return;
        }
        const form = new FormData();
        form.append('cod_territorio', cod_territorio);
        fetch(`../backend/api-foco.php?accion=traer_${quien}`, {
            method: 'POST',
            body: form
        })
            .then(respuesta => respuesta.json())
            .then(involucrados => {
                involucrados.forEach((inv) => {
                    const option = document.createElement('option');
                    option.value = inv.nombre; // aqui iba con id
                    option.textContent = inv.nombre;
                    selectRealizo.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function BotonEventos() {
        // currentTarget = es el elemento que está escuchando el evento. container.addEvent. Es el container
        // closes recorre desde el target hasta el currentTarget y encuentra el primer selector.

        containerFocosActuales.addEventListener('click', (e) => {
            const boton = e.target.closest('button')
            if (!boton) { return }

            const cod_focopotlugar = boton.dataset.idFoco

            if (boton.classList.contains('btn-eliminar-foco')) {
                eliminarFocoActual(cod_focopotlugar)
            }
            if (boton.classList.contains('btn-editar-foco')) {
                console.log(cod_focopotlugar);
                cargarFocoParaEditar(cod_focopotlugar)
            }
        })
    }

    function eliminarFocoActual(cod_focopotlugar) {
        fetch(`../backend/api-foco.php?ajax=eliminar_focoactual&id=${cod_focopotlugar}`)
            .then(respuesta => respuesta.text())
            .then(res => {
                if (res == 'exito') {
                    alert('Se elimino el foco actual')
                    const cod_territorio = document.getElementById('foco_cod_territorio').value
                    TraerFocosActuales(cod_territorio, 'ecosalud')
                }
            })
    }

    function cancelarEdicion() {
        modoEdicion = false;
        focoIdActual = null;

        // Resetear campos ocultos
        document.getElementById('modoEdicion').value = '0';
        document.getElementById('focoIdEditar').value = '';

        // Limpiar formulario
        document.getElementById('formRegistrarFoco').reset();

        // Restaurar texto del botón
        document.getElementById('btnTexto').textContent = 'Registrar Foco potencial';

        document.getElementById('btnCancelarEdicion').classList.add('hidden');
    }

    document.getElementById('btnCancelarEdicion').addEventListener('click', cancelarEdicion);

    // Definir la función fuera para poder removerla
    function handleTerritorioRegistrado(e) {
        const codigo = e.detail.cod_territorio;
        const inputTerritorio = document.getElementById('foco_cod_territorio');

        if (inputTerritorio) {
            inputTerritorio.value = codigo;
        }

        TraerFocosActuales(codigo, 'ecosalud');
        GetInvolucrados('participantes', codigo);
    }

    // Remover cualquier listener previo
    window.removeEventListener('territorioRegistrado', handleTerritorioRegistrado);

    // Agregar el listener
    window.addEventListener('territorioRegistrado', handleTerritorioRegistrado);



})