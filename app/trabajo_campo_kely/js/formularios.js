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

    document.getElementById('cod_padre_seg').value = idSiembra ? parseInt(idSiembra) : 0;
    document.getElementById('cod_sitiodepo_seg').value = codSitiodepo ? parseInt(codSitiodepo) : 0;
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
function abrirSeguimientoResiembra(btn) {
    ocultarConAnimacion('inspeccion-formulario');
    ocultarConAnimacion('siembra-formulario');
    ocultarConAnimacion('resiembra-formulario');
    mostrarConAnimacion('seguimiento-formulario');

    const codActividadTrabajoCampo = btn.getAttribute('data-id');
    document.getElementById('cod_actividadtrabajocampo_seg').value = codActividadTrabajoCampo ? parseInt(codActividadTrabajoCampo) : 0;

    const idResiembra = btn.getAttribute('data-id-resiembra');
    document.getElementById('cod_padre_seg').value = idResiembra ? parseInt(idResiembra) : 0;
    document.getElementById('cod_sitiodepo_seg').value = parseInt(btn.getAttribute('data-cod_sitiodepo')) || 0;

    document.getElementById('fecha_seg').value = btn.getAttribute('data-fecha') || "";
    document.getElementById('sitio_siembra').value = btn.getAttribute('data-sitio') || "";
    document.getElementById('deposito_siembra').value = btn.getAttribute('data-deposito') || "";
    document.getElementById('responsable_siembra').value = btn.getAttribute('data-responsable') || "";

    document.getElementById('ph_original').value = btn.getAttribute('data-ph') || "";
    document.getElementById('cloro_original').value = btn.getAttribute('data-cloro') || "";
    document.getElementById('temp_original').value = btn.getAttribute('data-temperatura') || "";

    document.getElementById('alevines').value = btn.getAttribute('data-alevines') || "0";
    document.getElementById('adultos').value = btn.getAttribute('data-adultos') || "0";
}

// =============================================
// FUNCIÓN PARA ABRIR FORMULARIO DE EDICIÓN
// =============================================
function abrirFormularioEdicion(formId, btn, campos, inputId, tipoOperacionId = null) {
    console.log("=== ABRIENDO FORMULARIO DE EDICIÓN ===");
    console.log("Tipo:", btn.dataset.tipo);
    console.log("ID del botón:", btn.dataset.id);
    console.log("Formulario:", formId);
    console.log("Input ID destino:", inputId);


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

    // Cambiar acción a editar
    const accionInput = form.querySelector('input[name="accion"]');
    if (accionInput) {
        console.log("Input acción ANTES:", accionInput.value);
        accionInput.value = 'editar';
        console.log("✅ Input acción DESPUÉS:", accionInput.value);
    } else {
        console.error("❌ No se encontró input[name='accion']");
    }

    // Establecer ID
    const idValue = btn.dataset.id || '';
    console.log("ID a establecer:", idValue);

    const idInput = document.getElementById(inputId);
    if (idInput) {
        console.log("Input encontrado:", inputId, "| Valor ANTES:", idInput.value);
        idInput.value = idValue;
        console.log("✅ Valor DESPUÉS:", idInput.value);
    } else {
        console.error("❌ No se encontró el input:", inputId);
    }

    const idInputByName = form.querySelector(`input[name="${inputId}"]`);
    if (idInputByName && idInputByName !== idInput) {
        console.log("Estableciendo también por name:", inputId);
        idInputByName.value = idValue;
    }


    // Rellenar campos visibles
    Object.entries(campos).forEach(([campo, atributo]) => {
        const input = form.querySelector(`[name="${campo}"]`);
        if (!input) return;

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
    // ===============================
    // Hacer usuario y fecha solo lectura
    // ===============================
    // ===============================
    // Hacer usuario y fecha solo lectura
    // ===============================
    const usuarioInput = form.querySelector('[name="usuario"]');
    if (usuarioInput) usuarioInput.readOnly = true;

    const fechaInput = form.querySelector('[name="fecha"], [name="fecha_seguimiento"]');
    if (fechaInput) fechaInput.readOnly = true;



    // Campos ocultos críticos
    const codSitioDepo = btn.dataset.cod_sitiodepo || '';
    const codTipoDepo = btn.dataset.cod_tipodepo || '';
    const codSitioControlBiolo = btn.dataset.cod_sitiocontrolbiolo || '';

    console.log("Datos adicionales:");
    console.log("- cod_sitiodepo:", codSitioDepo);
    console.log("- cod_tipodepo:", codTipoDepo);
    console.log("- cod_sitiocontrolbiolo:", codSitioControlBiolo);

    const inputSitioDepo = document.getElementById('cod_sitiodepo');
    const inputTipoDepo = document.getElementById('cod_tipodepo');
    const inputSitioControl = document.getElementById('cod_sitiocontrolbiolo');

    if (inputSitioDepo) inputSitioDepo.value = codSitioDepo;
    if (inputTipoDepo) inputTipoDepo.value = codTipoDepo;
    if (inputSitioControl) inputSitioControl.value = codSitioControlBiolo;

    // Cambiar título y botón
    const titulo = form.querySelector('h3');
    if (titulo) titulo.textContent = `Editar ${btn.dataset.tipo}`;

    const btnSubmit = form.querySelector('button[type="submit"]');
    if (btnSubmit) {
        btnSubmit.innerHTML = '<i class="bi bi-save-fill mr-2"></i> Guardar Cambios';
        btnSubmit.classList.remove('bg-green-700', 'hover:bg-green-800');
        btnSubmit.classList.add('bg-green-600', 'hover:bg-grenn-700');
    }

    console.log("=== FIN DE ABRIRFORMULARIOEDICION ===");
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
            'cod_actividadtrabajocampo_insp',
            'tipo_operacion_inspeccion'
        );

        const idSitio = btn.getAttribute("data-cod_sitiodepo");
        if (idSitio) {
            document.getElementById("cod_sitiodepo").value = idSitio;
        }
        document.querySelector('#inspeccion-formulario h3').textContent = "Editar Inspección";
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
            'id_actividad',
            'tipo_operacion_siembra'
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
            'id_resiembra',
            'tipo_operacion_resiembra'
        );
    }

    else if (tipo === 'Seguimiento') {
        console.log("=== DEBUG SEGUIMIENTO ===");
        console.log("ID del botón:", btn.dataset.id);

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
            'cod_actividadtrabajocampo_seg',
            'tipo_operacion_seg'
        );

        const inputId = document.getElementById('cod_actividadtrabajocampo_seg');
        const inputAccion = document.getElementById('accion_seguimiento');

        if (inputId) inputId.value = btn.dataset.id || '';
        if (inputAccion) inputAccion.value = 'editar';

        console.log("Valor en cod_actividadtrabajocampo_seg:", inputId?.value);
        console.log("Valor en accion_seguimiento:", inputAccion?.value);

        const titulo = document.querySelector('#seguimiento-formulario h3');
        if (titulo) titulo.textContent = "Editar Seguimiento";
    }
});

// =============================================
// SUBMIT DE FORMULARIOS
// =============================================
document.addEventListener('submit', async function (e) {
    const formularios = ['inspeccion-formulario', 'siembra-formulario', 'resiembra-formulario', 'seguimiento-formulario'];
    if (!formularios.includes(e.target.id)) return;

    e.preventDefault();

    console.log("🚀 SUBMIT CAPTURADO");

    const form = e.target;
    const formData = new FormData(form);

    console.log("=== FORMULARIO ENVIADO ===");
    console.log("ID del formulario:", form.id);

    let esEdicion = false;
    let idValue = null;
    let nombreCampoId = '';

    const accionInput = form.querySelector('[name="accion"]');
    console.log("Acción en input:", accionInput ? accionInput.value : 'NO EXISTE');

    if (form.id === 'seguimiento-formulario') {
        nombreCampoId = 'cod_actividadtrabajocampo_seg';
    } else if (form.id === 'siembra-formulario') {
        nombreCampoId = 'id_actividad';
    } else if (form.id === 'resiembra-formulario') {
        nombreCampoId = 'id_resiembra';
    } else if (form.id === 'inspeccion-formulario') {
        nombreCampoId = 'cod_actividadtrabajocampo_insp';
    }

    const inputId = form.querySelector(`[name="${nombreCampoId}"]`) || document.getElementById(nombreCampoId);
    if (inputId) {
        idValue = inputId.value;
        console.log(`ID encontrado en ${nombreCampoId}:`, idValue);
    } else {
        console.error("❌ No se encontró el input de ID:", nombreCampoId);
    }

    if (accionInput && accionInput.value === 'editar') {
        if (!idValue || idValue === '0' || idValue === '') {
            console.error("❌ Modo edición pero sin ID válido");
            Swal.fire('Error', 'No se pudo obtener el ID de la actividad para editar', 'error');
            return;
        }
        esEdicion = true;
    }

    console.log("¿Es edición?", esEdicion);
    console.log("ID a enviar:", idValue);

    formData.set('accion', esEdicion ? 'editar' : 'registrar');

    if (esEdicion && idValue) {
        formData.set(nombreCampoId, idValue);
        console.log(`✅ ID añadido a FormData como ${nombreCampoId}:`, idValue);
    }

    console.log("=== DATOS A ENVIAR ===");
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            console.log(key, ": [Archivo]", value.name);
        } else {
            console.log(key, ":", value);
        }
    }

    try {
        const url = `../controller/actividadescontrol.php`;
        console.log("URL:", url);

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const text = await response.text();
        console.log("📄 Respuesta cruda:", text);

        let result;
        try {
            result = JSON.parse(text);
            console.log("✅ Respuesta parseada:", result);
        } catch (parseError) {
            console.error("❌ Error al parsear JSON:", parseError);
            console.error("Texto recibido:", text);
            Swal.fire('Error', 'El servidor devolvió una respuesta inválida', 'error');
            return;
        }

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: result.mensaje || 'Operación exitosa',
                timer: 2000
            });

            form.classList.add('hidden');
            form.reset();
            const accionInputReset = form.querySelector('[name="accion"]');
            if (accionInputReset) accionInputReset.value = 'registrar';

            if (inputId) inputId.value = '0';

            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            console.error("❌ Error del servidor:", result);
            Swal.fire('Error', result.error || result.mensaje || 'Error en la operación', 'error');
        }
    } catch (err) {
        console.error("❌ Error en fetch:", err);
        Swal.fire('Error', 'No se pudo conectar con el servidor: ' + err.message, 'error');
    }
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