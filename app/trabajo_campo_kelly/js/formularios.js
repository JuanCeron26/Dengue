// ================================
// ARCHIVO: formularios.js
// Propósito: Gestión de apertura, edición y envío de formularios
// ================================

// ======================================================
// ANIMACIONES DE FORMULARIOS
// ======================================================
function mostrarConAnimacion(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('hidden', 'fade-out');
    el.classList.add('fade-in');
    setTimeout(() => el.classList.remove('fade-in'), 300);
}

function ocultarConAnimacion(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('fade-in');
    el.classList.add('fade-out');
    setTimeout(() => {
        el.classList.add('hidden');
        el.classList.remove('fade-out');
    }, 300);
}

// ======================================================
// ABRIR FORMULARIO DE SIEMBRA
// ======================================================
function abrirFormularioSiembra(btn) {
    ocultarConAnimacion('inspeccion-formulario');
    ocultarConAnimacion('seguimiento-formulario');
    ocultarConAnimacion('resiembra-formulario');
    mostrarConAnimacion('siembra-formulario');

    document.getElementById('id_actividad').value = "1";
    document.getElementById('cod_padre').value = parseInt(btn.getAttribute('data-id')) || 0;
    document.getElementById('cod_sitiodepo').value = parseInt(btn.getAttribute('data-cod_sitiodepo')) || 0;
}

// ======================================================
// ABRIR SEGUIMIENTO DE SIEMBRA
// ======================================================
function abrirSeguimiento(btn) {
    ocultarConAnimacion('inspeccion-formulario');
    ocultarConAnimacion('siembra-formulario');
    ocultarConAnimacion('resiembra-formulario');
    mostrarConAnimacion('seguimiento-formulario');

    const idSiembra = btn.getAttribute('data-id-siembra');
    const codSitiodepo = btn.getAttribute('data-cod_sitiodepo');

    // ✅ OBTENER EL FORM (no el div contenedor)
    const formContainer = document.getElementById('seguimiento-formulario');
    const form = formContainer.querySelector('form');  // ← Buscar el <form> dentro del div
    
    if (!form) {
        console.error('❌ No se encontró el formulario dentro de seguimiento-formulario');
        return;
    }
    
    // IMPORTANTE: Limpiar el formulario primero
    form.reset();  // ✅ Ahora sí funciona
    
    // Resetear acción a "registrar"
    const accionInput = document.getElementById('accion_seguimiento');
    if (accionInput) {
        accionInput.value = 'registrar';
        console.log('✅ Acción reseteada a: registrar');
    }
    
    // Resetear ID a vacío (para nuevo registro)
    const idInput = document.getElementById('cod_actividadtrabajocampo_seg');
    if (idInput) {
        idInput.value = '';
        console.log('✅ ID reseteado a vacío');
    }
    
    // Establecer datos del padre y sitio
    document.getElementById('cod_padre_seg').value = idSiembra ? parseInt(idSiembra) : 0;
    document.getElementById('cod_sitiodepo_seg').value = codSitiodepo ? parseInt(codSitiodepo) : 0;
    
    // Asegurar que cod_act_campo está correcto
    const codActCampo = form.querySelector('[name="cod_act_campo"]');
    if (codActCampo) codActCampo.value = '3';
    
    // Cambiar título a modo registrar
    const titulo = form.querySelector('h3');
    if (titulo) {
        titulo.textContent = 'Registrar Seguimiento';
    }
    
    // Cambiar botón a modo registrar
    const btnSubmit = form.querySelector('button[type="submit"]');
    if (btnSubmit) {
        btnSubmit.innerHTML = '<i class="bi bi-save-fill"></i> Guardar';
        btnSubmit.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
        btnSubmit.classList.add('btn-verde');
    }
    
    console.log('=== FORMULARIO SEGUIMIENTO ABIERTO PARA REGISTRAR ===');
    console.log('cod_padre:', idSiembra);
    console.log('cod_sitiodepo:', codSitiodepo);
}

// ======================================================
// ABRIR FORMULARIO DE RESIEMBRA
// ======================================================
function abrirResiembra(btn) {
    ocultarConAnimacion('inspeccion-formulario');
    ocultarConAnimacion('siembra-formulario');
    ocultarConAnimacion('seguimiento-formulario');
    mostrarConAnimacion('resiembra-formulario');

    document.getElementById('id_resiembra').value = "2";
    document.getElementById('cod_padre_res').value = parseInt(btn.getAttribute('data-id')) || 0;
    document.getElementById('cod_sitiodepo_res').value = parseInt(btn.getAttribute('data-cod_sitiodepo')) || 0;
}

// ======================================================
// ABRIR INSPECCIÓN DESDE RESIEMBRA
// ======================================================

function abrirInspeccionDesdeResiembra(btn) {
    ocultarConAnimacion('resiembra-formulario');
    ocultarConAnimacion('siembra-formulario');
    ocultarConAnimacion('seguimiento-formulario');
    mostrarConAnimacion('inspeccion-formulario');

    document.getElementById('id_actividad').value = "4";
    document.getElementById('cod_padre').value = parseInt(btn.getAttribute('data-actividad_padre')) || 0;
    document.getElementById('cod_sitiodepo').value = parseInt(btn.getAttribute('data-cod_sitiodepo')) || 0;
}

// ======================================================
// ABRIR SEGUIMIENTO DE RESIEMBRA
// ======================================================
// ======================================================
// ABRIR SEGUIMIENTO DE RESIEMBRA
// ======================================================
function abrirSeguimientoResiembra(btn) {
    ocultarConAnimacion('inspeccion-formulario');
    ocultarConAnimacion('siembra-formulario');
    ocultarConAnimacion('resiembra-formulario');
    mostrarConAnimacion('seguimiento-formulario');

    // ✅ OBTENER EL FORM (no el div)
    const formContainer = document.getElementById('seguimiento-formulario');
    const form = formContainer.querySelector('form');
    
    if (!form) {
        console.error('❌ No se encontró el formulario');
        return;
    }
    
    // Resetear completamente el formulario
    form.reset();
    
    // ✅ ESTABLECER MODO REGISTRAR (NO EDITAR)
    const accionInput = document.getElementById('accion_seguimiento');
    if (accionInput) {
        accionInput.value = 'registrar';
        console.log('✅ Acción: registrar');
    }
    
    // ✅ IMPORTANTE: DEJAR EL ID VACÍO (PARA REGISTRAR NUEVO)
    const idInput = document.getElementById('cod_actividadtrabajocampo_seg');
    if (idInput) {
        idInput.value = '';  // ← VACÍO para registro nuevo
        console.log('✅ ID reseteado a vacío');
    }
    
    // ✅ ESTABLECER EL PADRE (la resiembra)
    const idResiembra = btn.getAttribute('data-id-resiembra') || btn.getAttribute('data-id');
    document.getElementById('cod_padre_seg').value = idResiembra ? parseInt(idResiembra) : 0;
    document.getElementById('cod_sitiodepo_seg').value = parseInt(btn.getAttribute('data-cod_sitiodepo')) || 0;
    
    // Asegurar que cod_act_campo es 3 (seguimiento)
    const codActCampo = form.querySelector('[name="cod_act_campo"]');
    if (codActCampo) codActCampo.value = '3';
    
    // ✅ CAMBIAR TÍTULO Y BOTÓN A MODO REGISTRAR
    const titulo = form.querySelector('h3');
    if (titulo) {
        titulo.textContent = 'Registrar Seguimiento de Resiembra';
    }
    
    const btnSubmit = form.querySelector('button[type="submit"]');
    if (btnSubmit) {
        btnSubmit.innerHTML = '<i class="bi bi-save-fill"></i> Guardar';
        btnSubmit.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
        btnSubmit.classList.add('btn-verde');
    }
    
    console.log('=== SEGUIMIENTO DE RESIEMBRA - MODO REGISTRAR ===');
    console.log('cod_padre (resiembra):', idResiembra);
    console.log('cod_sitiodepo:', btn.getAttribute('data-cod_sitiodepo'));
}
// =============================================
// FUNCIÓN PARA ABRIR FORMULARIO DE EDICIÓN
// =============================================
// =============================================
// FUNCIÓN PARA ABRIR FORMULARIO DE EDICIÓN
// =============================================
function abrirFormularioEdicion(formId, btn, campos, inputId) {
    console.log("=== ABRIENDO FORMULARIO DE EDICIÓN ===");
    console.log("Tipo:", btn.dataset.tipo);
    console.log("ID del botón:", btn.dataset.id);
    console.log("Formulario:", formId);

    // Ocultar todos los formularios
    ['inspeccion-formulario', 'siembra-formulario', 'resiembra-formulario', 'seguimiento-formulario']
        .forEach(id => {
            const form = document.getElementById(id);
            if (form) {
                form.classList.add('hidden');
                form.classList.remove('fade-in');
            }
        });

    const form = document.getElementById(formId);
    if (!form) {
        console.error("❌ Formulario no encontrado:", formId);
        return;
    }

    form.classList.remove('hidden');
    form.classList.add('fade-in');
    setTimeout(() => form.classList.remove('fade-in'), 300);

    // ========================================
    // CAMBIAR ACCIÓN A EDITAR
    // ========================================
    const accionInput = form.querySelector('input[name="accion"]');
    if (accionInput) {
        accionInput.value = 'editar';
        console.log("✅ Acción establecida a 'editar'");
    } else {
        console.error("❌ No se encontró input[name='accion']");
    }

    // ========================================
    // ESTABLECER EL ID
    // ========================================
    const idValue = btn.dataset.id || '';
    console.log("ID a establecer:", idValue);

    // Buscar el input por ID o por nombre
    let idInput = document.getElementById(inputId);
    if (!idInput) {
        idInput = form.querySelector(`input[name="${inputId}"]`);
    }
    
    if (idInput) {
        idInput.value = idValue;
        console.log("✅ ID establecido en", inputId, ":", idValue);
    } else {
        console.error("❌ No se encontró el input:", inputId);
    }

    // ========================================
    // RELLENAR CAMPOS DEL FORMULARIO
    // ========================================
    Object.entries(campos).forEach(([campo, atributo]) => {
        const input = form.querySelector(`[name="${campo}"]`);
        if (!input) {
            console.warn(`Campo ${campo} no encontrado en el formulario`);
            return;
        }

        const valor = btn.getAttribute(atributo) || '';

        if (input.tagName === 'SELECT') {
            let encontrado = false;
            for (let opt of input.options) {
                if (opt.value == valor || opt.textContent.trim() === valor.trim()) {
                    input.value = opt.value;
                    encontrado = true;
                    break;
                }
            }
            if (!encontrado && valor) {
                console.warn(`No se encontró opción para ${campo} con valor:`, valor);
            }
            input.dispatchEvent(new Event('change'));
        }
        else if (input.type === 'radio') {
            form.querySelectorAll(`[name="${campo}"]`).forEach(r => {
                r.checked = (r.value === valor);
            });
        }
        else {
            input.value = valor;
        }
    });

    // ========================================
    // HACER USUARIO Y FECHA DE SOLO LECTURA
    // ========================================
    const usuarioInput = form.querySelector('[name="usuario"]');
    if (usuarioInput) {
        usuarioInput.readOnly = true;
        usuarioInput.style.backgroundColor = '#e5e7eb';
        usuarioInput.style.cursor = 'not-allowed';
        usuarioInput.style.opacity = '0.7';
        console.log("✅ Campo usuario bloqueado");
    }

    const fechaInput = form.querySelector('[name="fecha"], [name="fecha_seguimiento"]');
    if (fechaInput) {
        fechaInput.readOnly = true;
        fechaInput.style.backgroundColor = '#e5e7eb';
        fechaInput.style.cursor = 'not-allowed';
        fechaInput.style.opacity = '0.7';
        console.log("✅ Campo fecha bloqueado");
    }

    // ========================================
    // CAMPOS OCULTOS PARA SITIO/DEPÓSITO
    // ========================================
    const codSitioDepo = btn.dataset.cod_sitiodepo || '';
    const codTipoDepo = btn.dataset.cod_tipodepo || '';
    const codSitioControlBiolo = btn.dataset.cod_sitiocontrolbiolo || '';

    console.log("Datos adicionales:");
    console.log("- cod_sitiodepo:", codSitioDepo);
    console.log("- cod_tipodepo:", codTipoDepo);
    console.log("- cod_sitiocontrolbiolo:", codSitioControlBiolo);

    const inputSitioDepo = form.querySelector('[name="cod_sitiodepo"]') || document.getElementById('cod_sitiodepo');
    const inputTipoDepo = form.querySelector('[name="cod_tipodepo"]') || document.getElementById('cod_tipodepo');
    const inputSitioControl = form.querySelector('[name="cod_sitiocontrolbiolo"]') || document.getElementById('cod_sitiocontrolbiolo');

    if (inputSitioDepo) inputSitioDepo.value = codSitioDepo;
    if (inputTipoDepo) inputTipoDepo.value = codTipoDepo;
    if (inputSitioControl) inputSitioControl.value = codSitioControlBiolo;

    // ========================================
    // CAMBIAR TÍTULO Y BOTÓN
    // ========================================
    const titulo = form.querySelector('h3');
    if (titulo) titulo.textContent = `Editar ${btn.dataset.tipo}`;

    const btnSubmit = form.querySelector('button[type="submit"]');
    if (btnSubmit) {
        btnSubmit.innerHTML = '<i class="bi bi-save-fill mr-2"></i> Guardar Cambios';
        btnSubmit.classList.remove('bg-green-700', 'hover:bg-green-800');
        btnSubmit.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
    }

    console.log("=== FORMULARIO LISTO PARA EDITAR ===");
}

// =============================================
// DELEGACIÓN DE CLICS - BOTÓN EDITAR
// =============================================
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-editar');
    if (!btn) return;

    const tipo = btn.dataset.tipo;
    console.log("Click en editar →", tipo);

    if (tipo === 'Inspección') {
        abrirFormularioEdicion(
            'inspeccion-formulario',
            btn,
            {
                fecha: 'data-fecha',
                ph: 'data-ph',
                cloro: 'data-cloro',
                temperatura: 'data-temperatura',
                ancho: 'data-ancho',
                largo: 'data-largo',
                profundidad: 'data-profundidad',
                positivo_larvas: 'data-larvas',
                positivo_pupas: 'data-pupas',
                positivo_culex: 'data-culex',
                observaciones: 'data-observaciones',
                usuario: 'data-usuario',
                sitio: 'data-sitio',
                deposito: 'data-deposito'
            },
            'cod_actividadtrabajocampo_insp'
        );
    }
    else if (tipo === 'Siembra') {
        abrirFormularioEdicion(
            'siembra-formulario',
            btn,
            {
                fecha: 'data-fecha',
                ph: 'data-ph',
                cloro: 'data-cloro',
                usuario: 'data-usuario',
                temperatura: 'data-temperatura',
                alevines: 'data-alevines',
                adultos: 'data-adultos',
                observaciones: 'data-observaciones'
            },
            'id_actividad'
        );
    }
    else if (tipo === 'Resiembra') {
        abrirFormularioEdicion(
            'resiembra-formulario',
            btn,
            {
                fecha: 'data-fecha',
                ph: 'data-ph',
                cloro: 'data-cloro',
                temperatura: 'data-temperatura',
                usuario: 'data-usuario',
                alevines: 'data-alevines',
                adultos: 'data-adultos',
                observaciones: 'data-observaciones'
            },
            'id_resiembra'
        );
    }
    else if (tipo === 'Seguimiento') {
        abrirFormularioEdicion(
            'seguimiento-formulario',
            btn,
            {
                fecha_seguimiento: 'data-fecha',
                larvas_aedes: 'data-larvas',
                pupas: 'data-pupas',
                positivo_culex: 'data-culex',
                ph_actual: 'data-ph',
                cloro_actual: 'data-cloro',
                temperatura_actual: 'data-temperatura',
                observaciones: 'data-observaciones',
                usuario: 'data-usuario'
            },
            'cod_actividadtrabajocampo_seg'
        );
    }
});

// =============================================
// SUBMIT DE FORMULARIOS
// =============================================
document.addEventListener('submit', async function (e) {
    const formularios = ['inspeccion-formulario', 'siembra-formulario', 'resiembra-formulario', 'seguimiento-formulario'];
    if (!formularios.includes(e.target.id)) return;

    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    console.log("=== ENVIANDO FORMULARIO ===");
    console.log("ID del formulario:", form.id);

    // Verificar acción
    const accion = formData.get('accion');
    console.log("Acción:", accion);

    // Verificar cod_act_campo
    const codActCampo = formData.get('cod_act_campo');
    console.log("cod_act_campo:", codActCampo);

    // Mostrar todos los datos
    console.log("=== DATOS EN FORMDATA ===");
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            console.log(key, ": [Archivo]", value.name);
        } else {
            console.log(key, ":", value);
        }
    }

    // Validar que si es edición, tenga ID
    if (accion === 'editar') {
        const idFields = [
            'cod_actividadtrabajocampo_insp',
            'id_actividad_inspeccion',
            'id_actividad',
            'id_resiembra',
            'cod_actividadtrabajocampo_seg'
        ];
        
        let tieneId = false;
        let idEncontrado = null;
        
        for (let field of idFields) {
            const valor = formData.get(field);
            if (valor && valor !== '0' && valor !== '') {
                tieneId = true;
                idEncontrado = valor;
                console.log(`✅ ID encontrado en ${field}:`, valor);
                break;
            }
        }

        if (!tieneId) {
            console.error("❌ Modo edición pero sin ID válido");
            Swal.fire('Error', 'No se pudo obtener el ID de la actividad para editar', 'error');
            return;
        }
    }

    try {
        // IMPORTANTE: Agregar acción en la URL
        const url = `actividadescontrol.php?accion=${accion}`;
        console.log("URL:", url);

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const text = await response.text();
        console.log("📄 Respuesta del servidor:", text);

        let result;
        try {
            result = JSON.parse(text);
        } catch (parseError) {
            console.error("❌ Error al parsear JSON");
            console.error("Texto recibido:", text);
            Swal.fire('Error', 'El servidor devolvió una respuesta inválida', 'error');
            return;
        }

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: result.mensaje || 'Operación exitosa',
                timer: 2000,
                showConfirmButton: false
            });

            // Resetear formulario
            form.reset();
            const accionInputReset = form.querySelector('[name="accion"]');
            if (accionInputReset) accionInputReset.value = 'registrar';

            // Resetear IDs
            const idInputs = form.querySelectorAll('input[type="hidden"]');
            idInputs.forEach(input => {
                if (input.name.includes('id_') || input.name.includes('cod_actividadtrabajocampo')) {
                    input.value = '0';
                }
            });

            // Quitar readonly
            const usuarioInput = form.querySelector('[name="usuario"]');
            if (usuarioInput) {
                usuarioInput.readOnly = false;
                usuarioInput.style.backgroundColor = '';
                usuarioInput.style.cursor = '';
                usuarioInput.style.opacity = '';
            }

            const fechaInput = form.querySelector('[name="fecha"], [name="fecha_seguimiento"]');
            if (fechaInput) {
                fechaInput.readOnly = false;
                fechaInput.style.backgroundColor = '';
                fechaInput.style.cursor = '';
                fechaInput.style.opacity = '';
            }

            // Ocultar formulario
            form.classList.add('hidden');

            // Recargar página
            setTimeout(() => location.reload(), 1500);
        } else {
            console.error("❌ Error:", result);
            Swal.fire('Error', result.error || result.mensaje || 'Error en la operación', 'error');
        }
    } catch (err) {
        console.error("❌ Error en fetch:", err);
        Swal.fire('Error', 'No se pudo conectar con el servidor: ' + err.message, 'error');
    }
});

// =============================================
// BOTONES DE CANCELAR
// =============================================
document.querySelectorAll('.btn-cancelar').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('form');
        if (!form) return;

        // Resetear formulario
        form.reset();
        
        // Resetear acción
        const accionInput = form.querySelector('[name="accion"]');
        if (accionInput) accionInput.value = 'registrar';

        // Resetear IDs
        const idInputs = form.querySelectorAll('input[type="hidden"]');
        idInputs.forEach(input => {
            if (input.name.includes('id_') || input.name.includes('cod_actividadtrabajocampo')) {
                input.value = '0';
            }
        });

        // Quitar readonly
        const usuarioInput = form.querySelector('[name="usuario"]');
        if (usuarioInput) {
            usuarioInput.readOnly = false;
            usuarioInput.style.backgroundColor = '';
            usuarioInput.style.cursor = '';
            usuarioInput.style.opacity = '';
        }

        const fechaInput = form.querySelector('[name="fecha"], [name="fecha_seguimiento"]');
        if (fechaInput) {
            fechaInput.readOnly = false;
            fechaInput.style.backgroundColor = '';
            fechaInput.style.cursor = '';
            fechaInput.style.opacity = '';
        }

        // Restaurar título
        const titulo = form.querySelector('h3');
        if (titulo) {
            const formId = form.id;
            if (formId === 'inspeccion-formulario') titulo.textContent = 'Registrar Inspección';
            else if (formId === 'siembra-formulario') titulo.textContent = 'Registrar Siembra';
            else if (formId === 'resiembra-formulario') titulo.textContent = 'Registrar Resiembra';
            else if (formId === 'seguimiento-formulario') titulo.textContent = 'Registrar Seguimiento';
        }

        // Restaurar botón
        const btnSubmit = form.querySelector('button[type="submit"]');
        if (btnSubmit) {
            btnSubmit.innerHTML = '<i class="bi bi-plus-circle-fill mr-2"></i> Registrar';
            btnSubmit.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
            btnSubmit.classList.add('bg-green-700', 'hover:bg-green-800');
        }

        // Ocultar formulario
        form.classList.add('hidden');
    });
});
// ======================================================
// ABRIR FORMULARIO DE NUEVA INSPECCIÓN
// ======================================================
document.addEventListener('DOMContentLoaded', function () {
    const btnNuevaInspeccion = document.getElementById('btn_nueva_inspeccion');

    if (btnNuevaInspeccion) {
        btnNuevaInspeccion.addEventListener('click', () => {
            // Ocultar los demás formularios
            ['siembra-formulario', 'resiembra-formulario', 'seguimiento-formulario'].forEach(ocultarConAnimacion);

            const form = document.getElementById('inspeccion-formulario');
            if (!form) return console.error("❌ No se encontró #inspeccion-formulario");

            // Limpiar todos los campos visibles
            form.querySelectorAll('input, select, textarea').forEach(input => input.value = '');

            // Configurar campos ocultos para nuevo registro
            const accionInput = form.querySelector('[name="accion"]');
            if (accionInput) accionInput.value = 'registrar';

            const idInput = form.querySelector('[name="cod_actividadtrabajocampo_insp"]');
            if (idInput) idInput.value = '0';

            // Cambiar título y botón
            const titulo = form.querySelector('h3');
            if (titulo) titulo.textContent = "Nueva Inspección";

            const btnSubmit = form.querySelector('button[type="submit"]');
            if (btnSubmit) {
                btnSubmit.innerHTML = '<i class="bi bi-plus-circle-fill mr-2"></i> Registrar Inspección';
                btnSubmit.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                btnSubmit.classList.add('bg-green-700', 'hover:bg-green-800');
            }

            // Mostrar formulario con animación
            mostrarConAnimacion('inspeccion-formulario');
        });
    } else {
        console.error("❌ No se encontró el botón #btn_nueva_inspeccion");
    }
});