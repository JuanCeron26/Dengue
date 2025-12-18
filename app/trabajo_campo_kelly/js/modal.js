// ================================
// ARCHIVO: ui-modals.js
// Propósito: Modales, detalles, informes y exportación PDF
// ================================

// ======================================================
// MOSTRAR DETALLES
// ======================================================
function mostrarDetalles(btn) {
    const tipo = btn.getAttribute("data-tipo");

    const campos = {
        fecha: btn.getAttribute("data-fecha") || 'N/A',
        barrio: btn.getAttribute("data-barrio") || 'N/A',
        sitio: btn.getAttribute("data-sitio") || 'N/A',
        deposito: btn.getAttribute("data-deposito") || 'N/A',
        responsable: btn.getAttribute("data-responsable") || 'N/A',
        usuario: btn.getAttribute("data-usuario") || 'N/A',
        ph: btn.getAttribute("data-ph") || 'N/A',
        cloro: btn.getAttribute("data-cloro") || 'N/A',
        temperatura: btn.getAttribute("data-temperatura") || 'N/A',
        larvas: btn.getAttribute("data-larvas") || '0',
        pupas: btn.getAttribute("data-pupas") || '0',
        culex: btn.getAttribute("data-culex") || '0',
        ancho: btn.getAttribute("data-ancho") || 'N/A',
        largo: btn.getAttribute("data-largo") || 'N/A',
        profundidad: btn.getAttribute("data-profundidad") || 'N/A',
        alevines: btn.getAttribute("data-alevines") || 'N/A',
        adultos: btn.getAttribute("data-adultos") || 'N/A',
        observaciones: btn.getAttribute("data-observaciones") || 'Sin observaciones'
    };

    const binarioASiNo = valor => {
        if (valor === '1') {
            return '<span class="text-red-700 font-bold">✓ Sí (Positivo)</span>';
        }
        return '<span class="text-emerald-600 font-medium">✗ No (Negativo)</span>';
    };

    const detalleCompacto = (label, value) => `
        <p class="text-sm"><strong class="text-teal-700">${label}:</strong> <span class="text-gray-800">${value}</span></p>
    `;

    const resultadoCard = (label, valueBinario) => {
        const esPositivo = valueBinario === '1';
        const colorBg = esPositivo ? 'bg-red-50' : 'bg-emerald-50';
        const colorBorder = esPositivo ? 'border-red-300' : 'border-emerald-300';
        
        return `
            <div class="p-3 ${colorBg} ${colorBorder} border-2 rounded-lg shadow-md text-center">
                <p class="font-semibold text-sm text-gray-700 mb-1">${label}</p>
                <p class="text-base">${binarioASiNo(valueBinario)}</p>
            </div>
        `;
    };

    const parametroCard = (label, value, icon, colorClass = "teal") => `
        <div class="text-center p-3 bg-gradient-to-br from-${colorClass}-50 to-${colorClass}-100 rounded-lg shadow-md border border-${colorClass}-200">
            <i class="${icon} text-${colorClass}-600 text-xl mb-1"></i>
            <p class="font-bold text-${colorClass}-700 text-xs uppercase tracking-wide">${label}</p>
            <p class="text-lg font-semibold text-gray-800 mt-1">${value}</p>
        </div>
    `;

    let htmlCampos = `
        <h3 class="text-lg font-bold text-teal-700 mb-3 border-b-2 pb-2 border-teal-300 flex items-center">
            <i class="fas fa-info-circle mr-2 text-teal-500"></i> Datos Generales
        </h3>
        <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm mb-5 bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-lg border-2 border-teal-200 shadow-sm">
            ${detalleCompacto("Fecha", campos.fecha)}
            ${detalleCompacto("Barrio", campos.barrio)}
            ${detalleCompacto("Sitio", campos.sitio)}
            ${detalleCompacto("Depósito", campos.deposito)}
            <p class="col-span-2 text-sm mt-2 pt-2 border-t border-teal-200">
                <strong class="text-teal-700">Responsable:</strong> ${campos.responsable} / 
                <strong class="text-teal-700">Usuario:</strong> ${campos.usuario}
            </p>
        </div>
    `;

    htmlCampos += `<h3 class="text-lg font-bold text-cyan-700 mb-3 border-b-2 pb-2 border-cyan-300 flex items-center">
        <i class="fas fa-clipboard-check mr-2 text-cyan-500"></i> Detalles de ${tipo}
    </h3>`;

    if (tipo === "Inspección" || tipo === "Seguimiento") {
        htmlCampos += `
            <h4 class="font-semibold text-blue-600 mb-3 flex items-center">
                <i class="fas fa-vial mr-2"></i> Parámetros del Agua
            </h4>
            <div class="grid grid-cols-3 gap-3 mb-5">
                ${parametroCard("pH", campos.ph, "fas fa-flask", "blue")}
                ${parametroCard("Cloro", campos.cloro, "fas fa-tint", "cyan")}
                ${parametroCard("Temperatura", campos.temperatura, "fas fa-thermometer-half", "orange")}
            </div>
        `;

        htmlCampos += `
            <h4 class="font-semibold text-purple-600 mb-3 pt-4 border-t-2 border-gray-200 flex items-center">
                <i class="fas fa-bug mr-2"></i> Presencia de Vectores
            </h4>
            <div class="grid grid-cols-3 gap-3 mb-4">
                ${resultadoCard("Larvas Aedes", campos.larvas)}
                ${resultadoCard("Pupas", campos.pupas)}
                ${resultadoCard("Culex", campos.culex)}
            </div>
        `;
    }

    if (tipo === "Inspección") {
        htmlCampos += `
            <div class="my-4 border-t-2 border-dashed border-gray-300"></div>
            <h4 class="font-semibold text-indigo-600 mb-3 flex items-center">
                <i class="fas fa-ruler-combined mr-2"></i> Dimensiones del Depósito
            </h4>
            <div class="grid grid-cols-3 gap-4 p-4 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg border-2 border-indigo-200">
                ${parametroCard("Ancho", campos.ancho, "fas fa-arrows-alt-h", "indigo")}
                ${parametroCard("Largo", campos.largo, "fas fa-arrows-alt-v", "violet")}
                ${parametroCard("Profundidad", campos.profundidad, "fas fa-ruler-vertical", "purple")}
            </div>
        `;
    }

    if (tipo === "Siembra" || tipo === "Resiembra") {
        const accion = tipo === "Siembra" ? "sembrados" : "resiembrados";
        htmlCampos += `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gradient-to-br from-blue-50 to-teal-50 rounded-lg border-2 border-blue-200">
                ${parametroCard(`Alevines ${accion}`, campos.alevines, "fas fa-fish", "blue")}
                ${parametroCard(`Adultos ${accion}`, campos.adultos, "fas fa-fish", "teal")}
            </div>
        `;
    }

    htmlCampos += `
        <div class="my-5 border-t-2 border-dashed border-gray-300"></div>
        <h3 class="text-lg font-bold text-amber-700 mb-3 border-b-2 pb-2 border-amber-300 flex items-center">
            <i class="fas fa-comment-dots mr-2 text-amber-500"></i> Observaciones
        </h3>
        <div class="p-4 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-lg border-2 border-amber-200 shadow-sm">
            <p class="italic text-gray-700 text-sm leading-relaxed">${campos.observaciones}</p>
        </div>
    `;

    const modalHtml = `
        <div id="modalDetalles" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4 transition-opacity duration-300 ease-out opacity-0" 
             style="transition-delay: 100ms;">
            <div class="bg-white w-full max-w-2xl p-6 rounded-2xl shadow-2xl transform transition-transform duration-300 ease-out scale-95" 
                 id="modalContent">
                
                <div class="bg-gradient-to-r from-teal-500 to-cyan-500 -mx-6 -mt-6 px-6 py-4 rounded-t-2xl mb-5 shadow-lg">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-list mr-3"></i> Detalles de ${tipo}
                    </h2>
                </div>
                
                <div class="max-h-[65vh] overflow-y-auto pr-2 custom-scrollbar">
                    ${htmlCampos}
                </div>

                <div class="text-right pt-4 border-t-2 border-gray-200 mt-5 -mx-6 -mb-6 px-6 pb-6 bg-gray-50 rounded-b-2xl">
                    <button onclick="cerrarModalDetalles()" 
                        class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white font-bold px-8 py-3 rounded-full hover:from-teal-600 hover:to-cyan-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-times mr-2"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 8px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #14b8a6, #06b6d4);
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #0d9488, #0891b2);
            }
        </style>
    `;

    window.cerrarModalDetalles = function () {
        const modal = document.getElementById('modalDetalles');
        const content = document.getElementById('modalContent');
        if (modal && content) {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.remove();
                delete window.cerrarModalDetalles;
            }, 300);
        }
    }

    document.body.insertAdjacentHTML("beforeend", modalHtml);
    setTimeout(() => {
        document.getElementById('modalDetalles').classList.add('opacity-100');
        document.getElementById('modalDetalles').classList.remove('opacity-0');
        document.getElementById('modalContent').classList.add('scale-100');
        document.getElementById('modalContent').classList.remove('scale-95');
    }, 10);
}

// ======================================================
// INFORME COMPLETO
// ======================================================
/*****************************************
 *   ABRIR INFORME AL HACER CLICK
 *****************************************/
document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-informe");
    if (!btn) return;

    const idActividad = btn.dataset.id;
    const tipoActividad = btn.dataset.tipo;

    try {
        const resp = await fetch(
            `http://localhost/PROYECTO/Dengue/app/trabajo_campo/controller/actividadescontrol.php?accion=informe&id=${idActividad}`
        );

        const data = await resp.json();
        console.log("Datos recibidos:", data);

        if (!data || Object.keys(data).length === 0) {
            alert("Error obteniendo datos del informe");
            return;
        }

        // Guardamos los datos globales para el PDF
        window.datosInforme = data;

        const cont = document.getElementById("contenidoInforme");
        const tieneValor = (v) => v !== null && v !== undefined && v !== "";

        const field = (icon, label, value, unit = "") => `
            <div class="flex items-center gap-2 text-sm text-gray-700">
                <i class="bi ${icon} text-blue-600 text-lg"></i>
                <span class="font-semibold">${label}:</span>
                <span>${tieneValor(value) ? value : "N/A"} ${unit}</span>
            </div>
        `;

        const mostrarFisicos =
            tieneValor(data.ph) ||
            tieneValor(data.temperatura) ||
            tieneValor(data.cloro);

        const mostrarDimensiones =
            tieneValor(data.ancho_deposito) ||
            tieneValor(data.largo_deposito) ||
            tieneValor(data.profundidad_deposito);

        const mostrarBiologicos =
            tieneValor(data.adultos_guppies) ||
            tieneValor(data.alevines_guppies) ||
            tieneValor(data.positivo_larvas_aedes) ||
            tieneValor(data.positivo_pupas) ||
            tieneValor(data.positivo_culex) ||
            tieneValor(data.peces_muertos);

        /**************************************
         *   ARMAR CONTENIDO DEL INFORME
         **************************************/
        cont.innerHTML = `
            <div class="space-y-6">

                <!-- ENCABEZADO -->
                <div class="flex items-center justify-between bg-gradient-to-r from-blue-700 to-blue-900 text-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center gap-4">
                        <img src="logocali.jpg" class="w-14 h-14 rounded-md shadow border-2 border-white"/>
                        <div>
                            <h2 class="text-2xl font-extrabold">Informe de Actividad</h2>
                            <p class="text-sm opacity-90">
                                Tipo: <b>${tipoActividad}</b> | ID: <b>${data.cod_actividadtrabajocampo}</b>
                            </p>
                        </div>
                    </div>

                    <button id="btnExportarPDF" class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition shadow-md flex items-center gap-2">
                        <i class="bi bi-file-pdf-fill"></i> Exportar PDF
                    </button>
                </div>

                <!-- UBICACIÓN -->
                <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center mb-4">
                        <i class="bi bi-geo-alt-fill text-blue-600 mr-2"></i>
                        Ubicación y Datos Generales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        ${field("bi-calendar-date", "Fecha", data.fecha_actividad)}
                        ${field("bi-person-fill", "Responsable", data.responsable)}
                        ${field("bi-person-badge", "Usuario que realizó", data.usuario_registro)}
                        ${field("bi-geo-fill", "Nombre del Sitio", data.nombre_sitio)}
                        ${field("bi-house-door-fill", "Barrio", data.nombarrio)}
                        ${field("bi-building", "Comuna", data.nomcomun)}
                        ${field("bi-box-seam", "Nombre del Depósito", data.nombre_deposito)}
                    </div>
                </div>

                <!-- PARÁMETROS FÍSICO-QUÍMICOS -->
                ${mostrarFisicos ? `
                    <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center mb-4">
                            <i class="bi bi-thermometer-sun text-green-600 mr-2"></i>
                            Parámetros de Inspección
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-green-50 p-4 rounded-lg">
                            ${field("bi-thermometer-half", "Temperatura", data.temperatura, "°C")}
                            ${field("bi-droplet", "PH", data.ph)}
                            ${field("bi-bezier", "Cloro", data.cloro)}
                        </div>
                    </div>
                ` : ""}

                <!-- DIMENSIONES -->
                ${mostrarDimensiones ? `
                    <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center mb-4">
                            <i class="bi bi-box text-yellow-600 mr-2"></i>
                            Dimensiones del Depósito
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-yellow-50 p-4 rounded-lg">
                            ${field("bi-arrows-h", "Ancho", data.ancho_deposito, "cm")}
                            ${field("bi-arrows-expand", "Largo", data.largo_deposito, "cm")}
                            ${field("bi-arrows-v", "Profundidad", data.profundidad_deposito, "cm")}
                        </div>
                    </div>
                ` : ""}

                <!-- CONTROL BIOLÓGICO -->
                ${mostrarBiologicos ? `
                    <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-purple-500">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center mb-4">
                            <i class="bi bi-bug-fill text-purple-600 mr-2"></i>
                            Control Biológico y Larvario
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-purple-50 p-4 rounded-lg">
                            ${field("bi-bug-fill", "Larvas Aedes (+)", data.positivo_larvas_aedes)}
                            ${field("bi-bug", "Pupas (+)", data.positivo_pupas)}
                            ${field("bi-bug", "Culex (+)", data.positivo_culex)}
                            ${field("bi-tropical-fish", "Peces Adultos", data.adultos_guppies)}
                            ${field("bi-droplet-half", "Alevines", data.alevines_guppies)}
                            ${field("bi-emoji-dizzy", "Peces Muertos", data.peces_muertos)}
                        </div>
                    </div>
                ` : ""}

                <!-- OBSERVACIONES -->
                <div class="bg-gray-100 p-5 rounded-lg shadow-inner border-l-4 border-gray-400">
                    <h3 class="text-lg font-bold flex items-center mb-3 text-gray-800">
                        <i class="bi bi-chat-left-quote-fill text-gray-600 mr-2"></i>
                        Observaciones
                    </h3>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap bg-white p-3 rounded-lg">
                        ${data.observaciones || "No se registraron observaciones."}
                    </p>
                </div>

                <!-- INFORMACIÓN DEL PADRE (INSPECCIÓN) -->
                ${data.cod_actividad_padre ? `
                <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-red-600">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center mb-4">
                        <i class="bi bi-search text-red-600 mr-2"></i> Datos de la Inspección Padre
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-red-50 p-4 rounded-lg">

                        ${field("bi-hash", "Código Actividad Padre", data.cod_actividad_padre)}
                        ${field("bi-calendar-day", "Fecha de Inspección", data.fecha_padre)}

                        ${field("bi-bezier", "PH", data.padre_ph)}
                        ${field("bi-thermometer-sun", "Temperatura", data.padre_temperatura, "°C")}
                        ${field("bi-droplet", "Cloro", data.padre_cloro)}

                        ${field("bi-bug-fill", "Larvas Aedes (+)", data.padre_larvas)}
                        ${field("bi-bug", "Pupas (+)", data.padre_pupas)}
                        ${field("bi-bug", "Culex (+)", data.padre_culex)}

                        ${field("bi-arrows-h", "Ancho Depósito", data.padre_ancho, "cm")}
                        ${field("bi-arrows-expand", "Largo Depósito", data.padre_largo, "cm")}
                        ${field("bi-arrows-v", "Profundidad Depósito", data.padre_profundidad, "cm")}
                    </div>

                    <div class="mt-4">
                        <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                            <i class="bi bi-chat-square-text"></i> Observaciones de la Inspección
                        </h4>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap bg-white p-3 rounded-lg shadow">
                            ${data.observaciones_padre || "No registra observaciones."}
                        </p>
                    </div>
                </div>
                ` : ""}
            </div>
        `;

        // Mostrar modal
        document.getElementById("modalInforme").classList.remove("hidden");

    } catch (err) {
        console.error("Error:", err);
        alert("Error consultando el informe.");
    }
});


/*****************************************
 * CERRAR MODAL
 *****************************************/
document.getElementById("cerrarInforme").addEventListener("click", () => {
    document.getElementById("modalInforme").classList.add("hidden");
});


/*****************************************
 * EXPORTAR PDF
 *****************************************/
document.addEventListener("click", async (e) => {
    if (e.target && e.target.id === "btnExportarPDF") {
        await exportarPDF(window.datosInforme);
    }
});

async function exportarPDF(data) {
    try {
        const resp = await fetch(
            `http://localhost/PROYECTO/Dengue/app/trabajo_campo/controller/exportarinforme.php`,
            {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            }
        );

        if (!resp.ok) throw new Error("Error en el servidor");

        const blob = await resp.blob();
        const url = window.URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = `Informe_${data.cod_actividadtrabajocampo}.pdf`;
        document.body.appendChild(a);
        a.click();
        a.remove();

        window.URL.revokeObjectURL(url);
    } catch (err) {
        console.error("Error al exportar PDF:", err);
        alert("Error exportando el PDF.");
    }
}
