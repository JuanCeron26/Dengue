document.addEventListener("DOMContentLoaded", () => {
    const selectZoocriadero = document.getElementById("cod_zoocriadero");
    const selectedZoocriaderoCard = document.getElementById("selectedZoocriaderoCard");
    const selectTanque = document.getElementById("cod_tanque");
    const selectedTanqueCard = document.getElementById("selectedTanqueCard");
    const selectOperario = document.getElementById('selectOperario');
    const contenedorAcciones = document.getElementById('maintenanceActivities');
    const formSegZoo = document.getElementById('formRegistrarSegZoo');

    let checkboxNinguna = null; // Variable para el checkbox "No requirió"

    pintarZoocriaderos();
    pintarActividades();

    function pintarZoocriaderos() {
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

    async function RegistrarSeguimientoZoo(form) {

        const solicito = await fetch('../backend/api.php?accion=registrar', {
            method: 'POST',
            body: form
        });

        const respuesta = await solicito.text();
        console.log("Respuesta del backend:", respuesta);

        if (respuesta === 'exito') {

            iziToast.success({
                title: '¡Registrado!',
                message: 'El seguimiento se registró correctamente.',
                position: 'topRight',
                timeout: 2000
            });

            // Redirigir después del toast
            setTimeout(() => {
                window.location.href = 'consulta3.php';
            }, 2000);

        } else {

            iziToast.error({
                title: 'Error',
                message: 'Hubo un problema al registrar el seguimiento.',
                position: 'topRight'
            });

            console.log(respuesta);
        }
    }

    formSegZoo.addEventListener('submit', (e) => {
        e.preventDefault();
        const form = new FormData(formSegZoo)
        RegistrarSeguimientoZoo(form)
    })

    // FUNCIÓN GENÉRICA PARA RENDERIZAR TARJETAS DE CONFIRMACIÓN
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

    // FUNCIÓN PARA CARGAR DINÁMICAMENTE LOS TANQUES (CASCADA)
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

    // EVENT LISTENER: SELECCIÓN DE ZOOCRIADERO
    selectZoocriadero.addEventListener("change", function () {
        const cod_zoo = this.value;
        cargarTanques(cod_zoo);
        pintarOperarios(cod_zoo);
        renderConfirmationCard(selectZoocriadero, selectedZoocriaderoCard, "Zoocriadero Seleccionado");
    });

    // EVENT LISTENER: SELECCIÓN DE TANQUE
    selectTanque.addEventListener("change", function () {
        renderConfirmationCard(selectTanque, selectedTanqueCard, "Tanque Seleccionado");
    });

});