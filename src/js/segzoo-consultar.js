document.addEventListener('DOMContentLoaded', () => {

    const divSeguimientos = document.getElementById('divSeguimientos')
    const selectZoocriadero = document.getElementById('cod_zoocriadero')
    const selectTanque = document.getElementById('cod_tanque')
    const contenedorAcciones = document.getElementById('maintenanceActivities')
    const selectOperario = document.getElementById('selectOperario')
    const filtroZoocriaderos = document.getElementById('filtroZoocriaderos')
    const formEditarSeguimiento = document.getElementById('formEditarSeguimiento')

    pintarSeguimientos()
    pintarZoocriaderos(selectZoocriadero)
    pintarZoocriaderos(filtroZoocriaderos)
    pintarActividades()

    formEditarSeguimiento.addEventListener('submit', (e) => {
        e.preventDefault()
        const form = new FormData(formEditarSeguimiento)
        EditarSeguimiento(form)
    })

    function pintarSeguimientos() {
        fetch('../backend/api.php?ajax=traer_seguimientos')
            .then(respuesta => respuesta.json())
            .then(seguimientos => {
                divSeguimientos.innerHTML = ''
                seguimientos.forEach(seg => {
                    const article = document.createElement('article');
                    article.className = 'card-elegant p-5 bg-white border-2 border-sky-500 rounded-2xl';

                    // Formatear fecha
                    const fecha = new Date(seg.fecha_actividad + 'T00:00:00');
                    const fechaFormateada = fecha.toLocaleDateString('es-ES', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    article.innerHTML = `
                            <div class="text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">
                                ${seg.actividades || 'Sin actividades'}
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Fecha:</span>
                                    <span class="text-sky-800 font-bold">${fechaFormateada}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Zoocriadero:</span>
                                    <span class="text-sky-800 font-semibold">${seg.nombre_zoo}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Tanque:</span>
                                    <span class="text-sky-800 font-semibold">${seg.tipo_tanque} (${seg.nombre_tanque})</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-slate-500 font-medium">Realizó:</span>
                                    <span class="text-sky-800 font-semibold">${seg.nombre_usu} ${seg.apellido_usu}</span>
                                </div>
                            </div>

                            <hr class="my-3 border-sky-200">

                            <!-- Valores -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl bg-blue-100 p-3 text-center border border-blue-300 shadow-inner">
                                    <div class="text-xs uppercase font-bold text-blue-800">pH</div>
                                    <div class="text-xl font-black text-blue-900">${seg.ph || 'N/A'}</div>
                                </div>
                                <div class="rounded-xl bg-orange-100 p-3 text-center border border-orange-300 shadow-inner">
                                    <div class="text-xs uppercase font-bold text-orange-800">Temp</div>
                                    <div class="text-xl font-black text-orange-900">${seg.temperatura ? seg.temperatura + '°C' : 'N/A'}</div>
                                </div>
                                <div class="rounded-xl bg-teal-100 p-3 text-center border border-teal-300 shadow-inner">
                                    <div class="text-xs uppercase font-bold text-teal-800">Cloro</div>
                                    <div class="text-xl font-black text-teal-900">${seg.cloro || 'N/A'}</div>
                                </div>
                            </div>

                            <hr class="my-3 border-sky-200">

                            <!-- BOTONES DE ACCIÓN -->
                            <div class="flex justify-center gap-2">
                                <button data-id="${seg.cod_segzooact}" title="Ver Detalle" class="btn-ver-detalle cursor-pointer action-button p-2 rounded-xl bg-gray-200 hover:bg-gray-300 hover:-translate-y-0.5 transition shadow-sm">
                                    <img src="../../../src/icons/icono_eye.png" alt="" class="h-6 w-6">
                                </button>

                                <button data-id="${seg.cod_segzooact}" title="Editar" class="btn-editar cursor-pointer action-button p-2 rounded-xl bg-purple-200 hover:bg-purple-300 hover:-translate-y-0.5 transition shadow-sm"">
                                    <img src="../../../src/icons/icono_edit2.png" alt="" class="h-6 w-6">
                                </button>

                                <button data-id="${seg.cod_segzooact}" title="Eliminar" class="btn-eliminar cursor-pointer p-2 rounded-xl bg-red-100 text-red-600 hover:bg-red-200 hover:-translate-y-0.5 transition shadow-sm">
                                    <img src="../../../src/icons/icono_delete2.png" alt="" class="h-6 w-6">
                                </button>
                            </div>
                        `;

                    divSeguimientos.appendChild(article);
                });

                EventosBotones()
            })
            .catch(error => { console.log(error); })
    }

    function pintarZoocriaderos(selectZoocriadero) {
        fetch('../backend/api.php?ajax=traer_zoocriaderos')
            .then(respuesta => respuesta.json())
            .then(zoocriaderos => {
                selectZoocriadero.innerHTML = ''

                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "Seleccione el zoocriadero";
                selectZoocriadero.appendChild(defaultOption);

                zoocriaderos.forEach((zoo) => {
                    const option = document.createElement('option')
                    option.value = zoo.cod_zoo
                    option.textContent = zoo.nombre_zoo

                    selectZoocriadero.appendChild(option)
                })
            })
    }

    function pintarOperarios(cod_zoo) {
        fetch(`../backend/api.php?ajax=traer_operarios&id=${cod_zoo}`)
            .then(respuesta => respuesta.json())
            .then(operarios => {
                console.log(operarios);
                selectOperario.innerHTML = '';

                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "Seleccione el operario";
                selectOperario.appendChild(defaultOption);

                operarios.forEach((ope) => {
                    const option = document.createElement('option')
                    option.value = ope.id_zooadmin
                    option.textContent = `${ope.nombre_usu} ${ope.apellido_usu}`

                    selectOperario.appendChild(option)
                })
            })

    }

    function pintarActividades() {
        fetch('../backend/api.php?ajax=traer_actividades')
            .then(respuesta => respuesta.json())
            .then(actividades => {
                actividades.forEach((actividad) => {

                    const label = document.createElement('label');
                    label.className = 'flex items-center space-x-3 p-3 rounded-xl cursor-pointer bg-blue-50 hover:bg-sky-100 transition-all duration-200';

                    const input = document.createElement('input');
                    input.type = 'checkbox';
                    input.name = 'actividades[]';
                    input.value = actividad.cod_tipoactividadzoo;
                    input.dataset.activityKey = actividad.nombre_actividad;
                    input.className = 'h-5 w-5 text-sky-600 rounded border-gray-300 focus:ring-sky-500';

                    const span = document.createElement('span');
                    span.className = 'text-gray-700 font-semibold';
                    span.textContent = actividad.nombre_actividad;

                    label.appendChild(input);
                    label.appendChild(span);
                    contenedorAcciones.appendChild(label);

                    // Identificar el checkbox "No requirió" (ajusta el texto según tu BD)
                    if (actividad.nombre_actividad.toLowerCase().includes('no se requirió') ||
                        actividad.nombre_actividad.toLowerCase().includes('no se requirió ninguna actividad')) {
                        checkboxNinguna = input;
                    }

                });


                configurarEventListeners();
            });
    }

    function configurarEventListeners() {
        const maintenanceActivities = document.querySelectorAll('#maintenanceActivities input[type="checkbox"]');

        // Event listener para el checkbox "No requirió"
        if (checkboxNinguna) {
            checkboxNinguna.addEventListener('change', handleNingunaAccion);
        }

        // Event listeners para los demás checkboxes
        maintenanceActivities.forEach(checkbox => {
            if (checkbox !== checkboxNinguna) {
                checkbox.addEventListener('change', (event) => {
                    // Si se selecciona otra actividad, deseleccionar "Ninguna"
                    if (event.target.checked && checkboxNinguna && checkboxNinguna.checked) {
                        checkboxNinguna.checked = false;
                        // Habilitar todos los checkboxes
                        maintenanceActivities.forEach(cb => {
                            if (cb !== checkboxNinguna) {
                                cb.disabled = false;
                            }
                        });
                    }
                });
            }
        });
    }

    async function EditarSeguimiento(form) {

        const solicito = await fetch('../backend/api.php?accion=editar', {
            method: 'POST',
            body: form
        })
        const respuesta = await solicito.text()
        if (respuesta === 'exito') {

            iziToast.success({
                title: '¡Actualizado!',
                message: 'El seguimiento se editó correctamente.',
                position: 'topRight',
                timeout: 2000
            });

            setTimeout(() => {
                window.location.href = 'consulta3.php';
            }, 2000);

        } else {

            iziToast.error({
                title: 'Error',
                message: 'No se pudo editar el seguimiento.',
                position: 'topRight'
            });

            console.log(respuesta);
        }
    }

    async function AnularSeguimiento(cod_segzooact) {

        iziToast.question({
            timeout: false,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999999,
            title: 'Confirmación',
            message: '¿Estás seguro de que deseas anular este seguimiento?',
            position: 'center',
            buttons: [
                // BOTÓN ACEPTAR
                ['<button><b>SI, ANULAR</b></button>', async (instance, toast) => {

                    instance.hide({ transitionOut: 'fadeOut' }, toast);

                    // --- LÓGICA ORIGINAL ---
                    const form = new FormData();
                    form.append("cod_estado", 2);
                    form.append("cod_segzooact", cod_segzooact);

                    const solicito = await fetch('../backend/api.php?accion=eliminar', {
                        method: 'POST',
                        body: form
                    });

                    const respuesta = await solicito.text();

                    if (respuesta == 'exito') {
                        iziToast.success({
                            title: 'Excelente',
                            message: 'Se anuló correctamente',
                            position: 'topRight'
                        });

                        setTimeout(() => {
                            pintarSeguimientos()
                        }, 1500);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'No se pudo anular',
                            position: 'topRight'
                        });
                    }

                }, true],

                // BOTÓN CANCELAR
                ['<button>CANCELAR</button>', (instance, toast) => {
                    instance.hide({ transitionOut: 'fadeOut' }, toast);
                }]
            ]
        });
    }

    async function VerDetalleSeguimiento(cod_segzooact) {
        const form = new FormData()
        form.append("cod_segzooact", cod_segzooact)
        const solicito = await fetch('../backend/api.php?accion=ver_detalle', {
            method: 'POST',
            body: form
        })

        const seguimiento = await solicito.json()
        abrirModalDetalle(seguimiento)


    }


    // FUNCIÓN PARA CONTROLAR 'NO SE REQUIRIÓ NINGUNA ACCIÓN'
    const handleNingunaAccion = (event) => {
        const isChecked = event.target.checked;
        const maintenanceActivities = document.querySelectorAll('#maintenanceActivities input[type="checkbox"]');

        maintenanceActivities.forEach(checkbox => {
            if (checkbox !== checkboxNinguna) {
                if (isChecked) {
                    checkbox.checked = false;
                    checkbox.disabled = true;
                    checkbox.parentElement.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    checkbox.disabled = false;
                    checkbox.parentElement.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        });
    };

    const renderConfirmationCard = (selectElement, targetContainer, title) => {
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        if (selectedOption.value) {
            const cardHTML = `
                <div class="p-4 bg-sky-50 border border-sky-300 rounded-lg shadow-md flex items-center 
                             transition-opacity duration-300 ease-in-out opacity-0 transform translate-y-2" id="confirmCard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-600 mr-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a8 8 0 01-8-8 8 8 0 0116 0m-8 8v-9"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-500">${title}</p>
                        <h4 class="text-lg font-bold text-sky-800">${selectedOption.text}</h4>
                    </div>
                </div>
            `;

            targetContainer.innerHTML = cardHTML;

            setTimeout(() => {
                const cardElement = targetContainer.querySelector('#confirmCard');
                if (cardElement) {
                    cardElement.classList.remove('opacity-0', 'translate-y-2');
                }
            }, 10);

        } else {
            targetContainer.innerHTML = '';
        }
    };

    const cargarTanques = (cod_zoo) => {
        selectTanque.innerHTML = '';
        selectedTanqueCard.innerHTML = '';

        if (!cod_zoo) {
            selectTanque.disabled = true;
            selectTanque.classList.remove("bg-white");
            selectTanque.classList.add("bg-gray-50");

            const disabledOption = document.createElement("option");
            disabledOption.value = "";
            disabledOption.textContent = "Seleccione primero un zoocriadero";
            selectTanque.appendChild(disabledOption);
            return;
        }

        const loadingOption = document.createElement("option");
        loadingOption.value = "";
        loadingOption.textContent = "Cargando tanques...";
        selectTanque.appendChild(loadingOption);
        selectTanque.disabled = true;
        selectTanque.classList.add("bg-gray-50");

        fetch(`../backend/api.php?ajax=traer_tanques&id=${cod_zoo}`)
            .then(respuesta => {
                if (!respuesta.ok) {
                    throw new Error(`Error en el servidor: ${respuesta.status}`);
                }
                return respuesta.json();
            })
            .then(tanques => {

                selectTanque.innerHTML = '';

                selectTanque.disabled = false;
                selectTanque.classList.remove("bg-gray-50");
                selectTanque.classList.add("bg-white");

                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "Seleccione el tanque";
                selectTanque.appendChild(defaultOption);

                tanques.forEach(tanque => {
                    const option = document.createElement("option");

                    option.value = tanque.cod_zootanque;
                    option.textContent = `${tanque.nombre} ${tanque.nomtiptan}`;
                    selectTanque.appendChild(option);
                });

            })

    };


    selectZoocriadero.addEventListener("change", function () {
        const cod_zoo = this.value;
        cargarTanques(cod_zoo);
        pintarOperarios(cod_zoo);
        renderConfirmationCard(selectZoocriadero, selectedZoocriaderoCard, "Zoocriadero Seleccionado");
    });


    selectTanque.addEventListener("change", function () {
        renderConfirmationCard(selectTanque, selectedTanqueCard, "Tanque Seleccionado");
    });

    function EventosBotones() {

        divSeguimientos.addEventListener('click', (e) => {
            const boton = e.target.closest('button');
            if (!boton) return;

            const cod_segzooact = boton.dataset.id;

            if (boton.classList.contains('btn-editar')) {
                abrirPanelEditar(cod_segzooact);
            } else if (boton.classList.contains('btn-eliminar')) {
                AnularSeguimiento(cod_segzooact);
            } else if (boton.classList.contains('btn-ver-detalle')) {
                VerDetalleSeguimiento(cod_segzooact);
            }
        });
    }



    // ===================================================================


    document.getElementById('btnCancelarForm').addEventListener('click', () => {
        cerrarPanel()
    })
    document.getElementById('btnX').addEventListener('click', () => {
        cerrarPanel()
    })


    function abrirPanelEditar(codSeguimiento) {
        const panel = document.getElementById('panelEditar');
        const overlay = document.getElementById('overlay');
        const content = document.getElementById('contentWrapper');

        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.remove('hidden'), 10);

        panel.classList.remove('hidden-panel');
        panel.classList.add('visible-panel');

        content.classList.add('shifted');
        document.body.style.overflow = 'hidden';

        fetch(`../backend/api.php?ajax=traer_seguimiento_detalle&id=${codSeguimiento}`)
            .then(respuesta => respuesta.json())
            .then(data => {

                document.getElementById('fecha_actividad').value = data.fecha_actividad || '';
                document.getElementById('ph').value = data.ph || '';
                document.getElementById('temperatura').value = data.temperatura || '';
                document.getElementById('cloro').value = data.cloro || '';
                document.getElementById('alevines_nacimiento').value = data.alevines_nacimiento || '';
                document.getElementById('muerte_hembras').value = data.muerte_hembras || '';
                document.getElementById('muerte_machos').value = data.muerte_machos || '';
                document.getElementById('observaciones').value = data.observaciones || '';


                document.getElementById('cod_zoocriadero').value = data.cod_zoo;

                // Disparar evento change para cargar los tanques
                const eventoChange = new Event('change', { bubbles: true });
                document.getElementById('cod_zoocriadero').dispatchEvent(eventoChange);

                setTimeout(() => {
                    // Seleccionar el tanque
                    if (data.cod_zootanque) {
                        document.getElementById('cod_tanque').value = data.cod_zootanque;
                    }

                    // Seleccionar el operario
                    if (data.id_zooadmin) {
                        selectOperario.value = String(data.id_zooadmin);
                    }

                    // actividades
                    if (data.actividades_ids) {
                        const actividadesArray = data.actividades_ids.split(',');
                        const checkboxes = document.querySelectorAll('#maintenanceActivities input[type="checkbox"]');

                        checkboxes.forEach(checkbox => {
                            checkbox.checked = actividadesArray.includes(checkbox.value);
                        });
                    }
                }, 800);


                formEditarSeguimiento.dataset.codSeguimiento = codSeguimiento;
                formEditarSeguimiento.querySelector('#cod_segzooact').value = codSeguimiento
                formEditarSeguimiento.querySelector('#cod_segzoo').value = data.cod_segzoo
            })
            .catch(error => {
                console.error('Error al cargar datos:', error);
                alert('Error al cargar los datos del seguimiento');
                cerrarPanel();
            });
    }

    function cerrarPanel() {
        const panel = document.getElementById('panelEditar');
        const overlay = document.getElementById('overlay');
        const content = document.getElementById('contentWrapper');

        overlay.classList.add('hidden');
        panel.classList.remove('visible-panel');
        panel.classList.add('hidden-panel');
        content.classList.remove('shifted');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') cerrarPanel();
    });

    document.getElementById('overlay').addEventListener('click', cerrarPanel);


    // ================= VER DETALLE =======================================

    // ANIMACIÓN al abrir
    function animarApertura() {
        const content = document.getElementById('modalContent');
        setTimeout(() => {
            content.style.opacity = "1";
            content.style.scale = "1";
        }, 10);
    }

    // ANIMACIÓN al cerrar
    function animarCierre(callback) {
        const content = document.getElementById('modalContent');
        content.style.opacity = "0";
        content.style.scale = "0.95";
        setTimeout(callback, 150);
    }

    function abrirModalDetalle(datos) {
        const modal = document.getElementById('modalDetalle');
        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        content.style.opacity = "0";
        content.style.scale = "0.95";
        document.body.style.overflow = 'hidden';

        // Mapear los datos de la BD a lo que espera el modal
        document.getElementById('detalle_fecha').textContent =
            datos.fecha_actividad ? new Date(datos.fecha_actividad).toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' }) : '--';

        document.getElementById('detalle_operario').textContent =
            `${datos.nombre_usu || ''} ${datos.apellido_usu || ''}`.trim() || '--';

        document.getElementById('detalle_zoocriadero').textContent =
            datos.nombre_zoo ? `${datos.nombre_zoo} (Z-${String(datos.cod_zoo).padStart(3, '0')})` : '--';

        document.getElementById('detalle_tanque').textContent =
            datos.nombre_tanque ? `${datos.tipo_tanque} - ${datos.nombre_tanque}` : '--';

        document.getElementById('detalle_ph').textContent = datos.ph ?? '--';

        document.getElementById('detalle_temperatura').textContent =
            datos.temperatura ? `${datos.temperatura}°C` : '--';

        document.getElementById('detalle_cloro').textContent = datos.cloro ?? '--';

        document.getElementById('detalle_alevines').textContent = datos.alevines_nacimiento ?? '0';

        document.getElementById('detalle_muerte_hembras').textContent = datos.muerte_hembras ?? '0';

        document.getElementById('detalle_muerte_machos').textContent = datos.muerte_machos ?? '0';

        document.getElementById('detalle_observaciones').textContent = datos.observaciones ?? 'Sin observaciones registradas.';

        // Actividades: convertir el string "Act1 - Act2 - Act3" en array
        const cont = document.getElementById('detalle_actividades');
        cont.innerHTML = "";

        const actividades = datos.actividades ? datos.actividades.split(' - ') : [];

        if (actividades.length > 0 && actividades[0] !== '') {
            actividades.forEach(act => {
                cont.innerHTML += `
            <div class="flex items-center gap-2 bg-white rounded-lg p-2 border border-purple-200">
                <div class="w-6 h-6 rounded bg-purple-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="font-semibold text-purple-900">${act}</span>
            </div>`;
            });
        } else {
            cont.innerHTML = '<p class="text-sm text-gray-500 italic">No hay actividades registradas</p>';
        }

        animarApertura();
    }

    function cerrarModalDetalle() {
        const modal = document.getElementById('modalDetalle');

        animarCierre(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        });
    }

    document.getElementById('btnCerrarModal').onclick = cerrarModalDetalle;
    document.getElementById('btnCerrarModalFooter').onclick = cerrarModalDetalle;

    // Cerrar al hacer clic fuera
    document.getElementById('modalDetalle').addEventListener('click', function (e) {
        if (e.target === this) cerrarModalDetalle();
    });

    // Cerrar con ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrarModalDetalle();
    });

})