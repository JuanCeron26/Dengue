document.addEventListener('DOMContentLoaded', () => {

    // 🔥 ELEMENTOS DE LA SECCIÓN 8 (con sufijo _8)
    const containerFocosActuales = document.getElementById('containerFocosActuales8');
    const selectTipoFoco8 = document.getElementById('selectTipoFoco8');
    const focoDescription8 = document.getElementById('focoDescription8');
    const focoDescriptionText8 = document.getElementById('focoDescriptionText8');
    const formRegistrarFoco = document.getElementById('formRegistrarFoco8');
    const selectRealizo = document.getElementById('selectRealizo8');

    let modoEdicion = false;
    let focoIdActual = null;

    GetFocosPotenciales();
    BotonEventos();
    recuperarTerritorioActivo();

    function recuperarTerritorioActivo() {
        const territorioGuardado = sessionStorage.getItem('territorioActivo');

        if (territorioGuardado) {
            const inputTerritorio = document.getElementById('foco_cod_territorio_8');
            if (inputTerritorio) {
                inputTerritorio.value = territorioGuardado;

                TraerFocosActuales(territorioGuardado, 'participantes'); // ⚠️ Usar 'participantes' aquí
                GetInvolucrados('participantes', territorioGuardado);
            }
        } else {
            console.log('ℹ️ [Sección 8] No hay territorio activo guardado');

            if (containerFocosActuales) {
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
    }

    formRegistrarFoco.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const realizado = formData.get('realizo');

        const datos = {
            tipoVia: document.getElementById('tipoVia8').value,
            numeroVia: document.getElementById('numeroVia8').value,
            sufijo: document.getElementById('sufijo8').value,
            distancia: document.getElementById('distancia8').value,
            cod_tipo_foc: formData.get('cod_tipo_foc'),
            lugar: formData.get('lugar'),
            cod_territorio: document.getElementById('foco_cod_territorio_8').value
        };

        if (realizado) {
            datos.realizo = realizado;
        }

        try {
            let url, mensaje;

            if (modoEdicion) {
                datos.cod_focopotlugar = focoIdActual;
                url = '../backend/api-foco.php?accion=actualizar_foco';
                mensaje = 'Foco actualizado correctamente';
            } else {
                url = '../backend/api-foco.php?accion=registrar';
                mensaje = 'Foco registrado correctamente';
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (resultado.success) {
                alert(mensaje);
                e.target.reset();

                if (modoEdicion) {
                    cancelarEdicion();
                }

                TraerFocosActuales(datos.cod_territorio, 'participantes');
                formRegistrarFoco.scrollIntoView({ behavior: 'smooth', block: 'start' });

            } else {
                alert('Error: ' + (resultado.message || 'No se pudo completar la operación'));
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        }
    });

    selectTipoFoco8.addEventListener('change', (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const descripcion = selectedOption.dataset.descripcion;

        if (descripcion && e.target.value && focoDescription8) {
            focoDescriptionText8.textContent = descripcion;
            focoDescription8.classList.remove('hidden');
        } else if (focoDescription8) {
            focoDescription8.classList.add('hidden');
        }
    });

    async function TraerFocosActuales(cod_territorio, quien) {
        if (!containerFocosActuales) return;

        let url;
        if (quien == 'ecosalud') {
            url = `../backend/api-foco.php?ajax=traer_focosactuales&id=${cod_territorio}&ecosalud=true`;
        } else {
            url = `../backend/api-foco.php?ajax=traer_focosactuales&id=${cod_territorio}&ecosalud=false`;
        }

        const solicito = await fetch(url);
        const focos = await solicito.json();

        if (focos.length == 0) {
            containerFocosActuales.innerHTML = `
                <h1 class="text-2xl text-red-600 font-bold text-center">No hay focos aún</h1>
            `;
            return;
        }

        console.log('[Sección 8] Focos:', focos);
        containerFocosActuales.innerHTML = '';

        focos.forEach(foco => {
            const div = document.createElement('div');
            div.className = 'rounded-xl shadow-sm p-4 border border-slate-200 hover:border-purple-300 bg-white w-full hover:shadow-md transition-all duration-300 hover:-translate-y-0.5';
            div.innerHTML = `
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-linear-to-br from-purple-500 to-blue-500 
                            flex items-center justify-center shadow-md shrink-0
                            hover:scale-110 hover:rotate-3 transition-all duration-300">
                            <img src="../../../src/icons/icono_ubicacion.png" class="w-6 h-6">
                        </div>

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

                    <div class="flex gap-2 shrink-0">
                        <button data-id-foco="${foco.id}" class="cursor-pointer btn-editar-foco 
                            w-9 h-9 rounded-full bg-blue-200 hover:bg-blue-400 
                            flex items-center justify-center shadow-sm
                            hover:rotate-12 hover:scale-110 transition-all duration-300
                            focus:outline-none focus:ring-2 focus:ring-blue-300 group">
                            <img src="../../../src/icons/icono_edit2.png" alt="Editar"
                                class="h-5 w-5 group-hover:brightness-0 group-hover:invert transition-all">
                        </button>

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
            `;

            containerFocosActuales.appendChild(div);
        });
    }

    async function cargarFocoParaEditar(idFoco) {
        try {
            const response = await fetch(`../backend/api-foco.php?ajax=obtener_foco&id=${idFoco}`);
            const foco = await response.json();

            modoEdicion = true;
            focoIdActual = parseInt(idFoco);
            document.getElementById('modoEdicion8').value = '1';
            document.getElementById('focoIdEditar8').value = idFoco;

            if (selectRealizo) {
                selectRealizo.value = foco.realizo || '';
            }
            document.getElementById('tipoVia8').value = foco.tipo_via || '';
            document.getElementById('numeroVia8').value = foco.numero_via || '';
            document.getElementById('sufijo8').value = foco.sufijo || '';
            document.getElementById('distancia8').value = foco.distancia || '';
            document.getElementById('selectTipoFoco8').value = foco.cod_tipo_foc || '';
            document.getElementById('lugar8').value = foco.lugar || '';

            const btnTexto = document.getElementById('btnTexto8');
            if (btnTexto) {
                btnTexto.textContent = 'Editar foco potencial';
            }

            const btnCancelar = document.getElementById('btnCancelarEdicion8');
            if (btnCancelar) {
                btnCancelar.classList.remove('hidden');
            }

            formRegistrarFoco.scrollIntoView({ behavior: 'smooth', block: 'start' });

        } catch (error) {
            console.error('Error al cargar foco:', error);
            alert('Error al cargar los datos del foco');
        }
    }

    function GetFocosPotenciales() {
        if (!selectTipoFoco8) return;

        fetch('../backend/api-foco.php?ajax=traer_tiposfocos')
            .then(respuesta => respuesta.json())
            .then(tiposfocos => {
                selectTipoFoco8.innerHTML = '<option value="">Seleccione el tipo de foco...</option>';
                tiposfocos.forEach((foco) => {
                    const option = document.createElement('option');
                    option.value = foco.cod_tipo_foc;
                    option.textContent = foco.nombre_foco;
                    option.dataset.descripcion = foco.descripcion_foco || 'Sin descripción disponible';
                    selectTipoFoco8.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function GetInvolucrados(quien, cod_territorio) {
        if (!selectRealizo) {
            console.log('[Sección 8] Select realizo no encontrado');
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
                selectRealizo.innerHTML = '<option value="">Seleccione quien realizó...</option>';
                involucrados.forEach((inv) => {
                    const option = document.createElement('option');
                    option.value = inv.nombre;
                    option.textContent = inv.nombre;
                    selectRealizo.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function BotonEventos() {
        if (!containerFocosActuales) return;

        containerFocosActuales.addEventListener('click', (e) => {
            const boton = e.target.closest('button');
            if (!boton) return;

            const cod_focopotlugar = boton.dataset.idFoco;

            if (boton.classList.contains('btn-eliminar-foco')) {
                eliminarFocoActual(cod_focopotlugar);
            }
            if (boton.classList.contains('btn-editar-foco')) {
                cargarFocoParaEditar(cod_focopotlugar);
            }
        });
    }

    function eliminarFocoActual(cod_focopotlugar) {
        if (!confirm('¿Estás seguro de eliminar este foco?')) return;

        fetch(`../backend/api-foco.php?ajax=eliminar_focoactual&id=${cod_focopotlugar}`)
            .then(respuesta => respuesta.text())
            .then(res => {
                if (res == 'exito') {
                    alert('Se eliminó el foco actual');
                    const cod_territorio = document.getElementById('foco_cod_territorio_8').value;
                    TraerFocosActuales(cod_territorio, 'participantes');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el foco');
            });
    }

    function cancelarEdicion() {
        modoEdicion = false;
        focoIdActual = null;

        document.getElementById('modoEdicion8').value = '0';
        document.getElementById('focoIdEditar8').value = '';

        formRegistrarFoco.reset();

        const btnTexto = document.getElementById('btnTexto8');
        if (btnTexto) {
            btnTexto.textContent = 'Registrar Foco potencial';
        }

        const btnCancelar = document.getElementById('btnCancelarEdicion8');
        if (btnCancelar) {
            btnCancelar.classList.add('hidden');
        }
    }

    const btnCancelarEdicion = document.getElementById('btnCancelarEdicion8');
    if (btnCancelarEdicion) {
        btnCancelarEdicion.addEventListener('click', cancelarEdicion);
    }

    function handleTerritorioRegistrado(e) {
        const codigo = e.detail.cod_territorio;
        const inputTerritorio = document.getElementById('foco_cod_territorio_8');

        if (inputTerritorio) {
            inputTerritorio.value = codigo;
        }

        TraerFocosActuales(codigo, 'participantes');
        GetInvolucrados('participantes', codigo);
    }

    window.removeEventListener('territorioRegistrado', handleTerritorioRegistrado);
    window.addEventListener('territorioRegistrado', handleTerritorioRegistrado);

});