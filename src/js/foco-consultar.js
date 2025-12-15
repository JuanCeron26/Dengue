document.addEventListener('DOMContentLoaded', () => {

    let currentFocoId = null;
    const tBody = document.getElementById('tableBody');
    const modal = document.getElementById('formEditar')
    const selectEditFoco = document.getElementById('editFoco')
    const selectEditRealizo = document.getElementById('editRealizo')

    modal.addEventListener('submit', (e) => {
        e.preventDefault()

        const form = new FormData(modal)
        EditarFocoPotencial(form)
    })



    // Render table
    function renderTable() {
        const tableBody = document.getElementById('tableBody');
        const emptyState = document.getElementById('emptyState');
        const resultsCount = document.getElementById('resultsCount');

        fetch('../backend/api.php?ajax=traer_focospotenciales')
            .then(respuesta => respuesta.json())
            .then(data => {
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    emptyState.classList.remove('hidden');
                    resultsCount.textContent = `Mostrando 0 de ${focos.length} registros`;
                    return;
                }


                resultsCount.textContent = `Mostrando ${data.length} de ${3} registros`;

                data.forEach((foco, index) => {
                    console.log(foco);
                    const row = document.createElement('tr');
                    row.className = `hover:bg-emerald-50 transition-colors ${index % 2 === 0 ? 'bg-white' : 'bg-slate-50'}`;

                    row.innerHTML = `
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-slate-700">${foco.fecha}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm text-slate-700">${foco.realizo}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm text-slate-700">${foco.dirección}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700">${foco.nombre_foco}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">${foco.lugar}</td>
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button
                                data-id-foco="${foco.cod_focopotencial_tipofoco}"
                                class="cursor-pointer btn-ver-detalle p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors"
                                title="Ver detalle"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button
                                data-id-foco="${foco.cod_focopotencial_tipofoco}"
                                class="cursor-pointer btn-editar p-2 bg-sky-100 text-sky-700 rounded-lg hover:bg-sky-200 transition-colors"
                                title="Editar"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button
                                data-id-foco="${foco.cod_focopotencial_tipofoco}"
                                class="cursor-pointer btn-eliminar p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors"
                                title="Eliminar"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                `;

                    tableBody.appendChild(row);
                })

                EventosBotones()
            })
    }

    function EventosBotones() {
        tBody.addEventListener('click', (e) => {
            const boton = e.target.closest('button')
            if (!boton) return;

            const cod_focopotencial_tipofoco = boton.dataset.idFoco
            if (boton.classList.contains('btn-editar')) {
                abrirModalEditar(cod_focopotencial_tipofoco)
            }
        })
    }

    async function EditarFocoPotencial(form) {
        const solicito = await fetch('../backend/api.php?accion=editar', {
            method: 'POST',
            body: form
        })

        const respuesta = await solicito.text()
        if (respuesta == 'exito') {
            alert('exito')
            window.location.href = 'consultar.php'
        } else {
            alert('error')
        }
    }


    // View detail
    function viewDetail(id) {
        const foco = focos.find(f => f.id === id);
        if (!foco) return;

        currentFocoId = id;

        document.getElementById('modalTitle').textContent = `Detalle del Foco #${foco.id}`;
        document.getElementById('modalRealizo').textContent = foco.realizo;
        document.getElementById('modalFecha').textContent = foco.fecha;
        document.getElementById('modalDireccion').textContent = foco.direccion;
        document.getElementById('modalTipoFoco').textContent = foco.tipoFoco;
        document.getElementById('modalLugar').textContent = foco.lugar;

        const estadoElement = document.getElementById('modalEstado');
        estadoElement.textContent = foco.estado;
        estadoElement.className = `inline-block px-3 py-1 text-sm font-semibold rounded-full border ${getEstadoColor(foco.estado)}`;

        document.getElementById('detailModal').classList.remove('hidden');
    }


    // ====================== MODALES ==========================================

    // Close modal
    document.getElementById('closeModalBtn').addEventListener('click', () => {
        document.getElementById('detailModal').classList.add('hidden');
    });

    // Edit from modal
    document.getElementById('editFromModalBtn').addEventListener('click', () => {
        if (currentFocoId) {
            editFoco(currentFocoId);
            document.getElementById('detailModal').classList.add('hidden');
        }
    });

    // Close modal on background click
    document.getElementById('detailModal').addEventListener('click', (e) => {
        if (e.target.id === 'detailModal') {
            document.getElementById('detailModal').classList.add('hidden');
        }
    });

    function abrirModalEditar(cod_focopotencial_tipofoco) {
        const modal = document.getElementById('modalEditar');
        const content = document.getElementById('modalContent');


        modal.classList.remove('hidden');
        modal.classList.add('flex')
        setTimeout(() => {
            modal.classList.remove('opacity-0', 'invisible');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);

        try {
            fetch(`../backend/api.php?ajax=traer_focopotencial&id=${cod_focopotencial_tipofoco}`)
                .then(respuesta => respuesta.json())
                .then(foco => {
                    let promesa = null;
                    if (foco.cod_actividadeco && foco.cod_territorio) {
                        // RECORDAR ESTE MALDITO ERROR: siempre parsear a Entero lo que llegue en JSON
                        const cod_territorio = parseInt(foco.cod_territorio)
                        const cod_actividad = parseInt(foco.cod_actividadeco)
                        switch (cod_actividad) {
                            case 1:
                                promesa = GetInvolucrados('usuarios_eco', cod_territorio)
                                break;
                            case 3:
                                promesa = GetInvolucrados('participantes', cod_territorio)
                                break;
                        }
                    }

                    if (promesa) {
                        promesa.then(() => {
                            const opciones = selectEditRealizo.querySelectorAll('option');
                            const valor = Array.from(opciones).find((elemento) => {
                                return elemento.textContent == foco.realizo
                            })
                            // console.log(valor);  --> es el elemento option completo
                            selectEditRealizo.value = valor.value
                        });
                    } else {
                        console.warn("No se ejecutó GetInvolucrados");
                    }

                    document.getElementById("editFecha").value = foco.fecha;


                    const direccion = foco.dirección;

                    // Separar por espacios
                    // Ej: ["Avenida", "6F", "#", "15-22"]
                    const partes = direccion.split(" ");
                    const tipo = partes[0];

                    const numero = partes[1];

                    const complemento = partes[3] ? partes[3] : "";

                    // ya llega el id y nombre de sea quien sea.

                    document.getElementById("dirTipo").value = tipo;
                    document.getElementById("dirNumero").value = numero;
                    document.getElementById("dirComplemento").value = complemento;


                    document.getElementById("editFoco").value = foco.cod_tipo_foc;

                    document.getElementById("editLugar").value = foco.lugar;
                    document.getElementById('cod_focopotlugar').value = foco.cod_focopotlugar
                })
        } catch (error) {
            console.log(error);
        }
    }

    function GetFocosPotenciales() {
        fetch('../backend/api.php?ajax=traer_tiposfocos')
            .then(respuesta => respuesta.json())
            .then(tiposfocos => {
                selectEditFoco.innerHTML = '';
                tiposfocos.forEach((foco) => {
                    const option = document.createElement('option');
                    option.value = foco.cod_tipo_foc;
                    option.textContent = foco.nombre_foco;
                    option.dataset.descripcion = foco.descripcion_foco || 'Sin descripción disponible';
                    selectEditFoco.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function GetInvolucrados(quien, cod_territorio) {
        // quien = usuarios_eco
        // quien = participantes
        const form = new FormData();
        form.append('cod_territorio', cod_territorio);

        return fetch(`../backend/api.php?accion=traer_${quien}`, {
            method: 'POST',
            body: form
        })
            .then(respuesta => respuesta.json())
            .then(involucrados => {
                involucrados.forEach((inv) => {
                    const option = document.createElement('option');
                    option.value = inv.id;
                    option.textContent = inv.nombre;
                    selectEditRealizo.appendChild(option);
                });
                return true;
            });
    }

    document.getElementById('btnCerrarEditar').addEventListener('click', () => {
        cerrarModalEditar()
    })


    function cerrarModalEditar() {
        const modal = document.getElementById('modalEditar');
        const content = document.getElementById('modalContent');

        modal.classList.add('opacity-0', 'invisible');
        content.classList.add('scale-95');
        content.classList.remove('scale-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex')
        }, 300); // coincide con duration-300
    }


    renderTable();
    GetFocosPotenciales()

})