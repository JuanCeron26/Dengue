document.addEventListener('DOMContentLoaded', () => {

    const btnGenerarReporte = document.getElementById('btnGenerarReporte');
    const btnLimpiarFiltros = document.getElementById('btnLimpiarFiltros');
    const selectZooFiltro = document.getElementById('filtroZooReporte');
    const selectTanqueFiltro = document.getElementById('filtroTanqueReporte');
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');

    // Cargar zoocriaderos en el select de filtros
    cargarZoocriaderosFiltro();

    // Event listener para cambio de zoocriadero
    selectZooFiltro.addEventListener('change', function () {
        const cod_zoo = this.value;
        if (cod_zoo) {
            cargarTanquesFiltro(cod_zoo);
        } else {
            selectTanqueFiltro.innerHTML = '<option value="">Todos los tanques</option>';
            selectTanqueFiltro.disabled = true;
        }
    });

    // Generar reporte
    btnGenerarReporte.addEventListener('click', generarReporteExcel);

    // Limpiar filtros
    btnLimpiarFiltros.addEventListener('click', limpiarFiltros);

    /**
     * Carga los zoocriaderos en el select de filtros
     */
    function cargarZoocriaderosFiltro() {
        fetch('../backend/api.php?ajax=traer_zoocriaderos')
            .then(respuesta => respuesta.json())
            .then(zoocriaderos => {
                selectZooFiltro.innerHTML = '<option value="">Todos los zoocriaderos</option>';

                zoocriaderos.forEach(zoo => {
                    const option = document.createElement('option');
                    option.value = zoo.cod_zoo;
                    option.textContent = zoo.nombre_zoo;
                    selectZooFiltro.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar zoocriaderos:', error);
                iziToast.error({
                    title: 'Error',
                    message: 'No se pudieron cargar los zoocriaderos',
                    position: 'topRight'
                });
            });
    }

    /**
     * Carga los tanques según el zoocriadero seleccionado
     */
    function cargarTanquesFiltro(cod_zoo) {
        selectTanqueFiltro.innerHTML = '<option value="">Cargando...</option>';
        selectTanqueFiltro.disabled = true;

        fetch(`../backend/api.php?ajax=traer_tanques&id=${cod_zoo}`)
            .then(respuesta => respuesta.json())
            .then(tanques => {
                selectTanqueFiltro.innerHTML = '<option value="">Todos los tanques</option>';

                tanques.forEach(tanque => {
                    const option = document.createElement('option');
                    option.value = tanque.cod_zootanque;
                    option.textContent = `${tanque.nombre} - ${tanque.nomtiptan}`;
                    selectTanqueFiltro.appendChild(option);
                });

                selectTanqueFiltro.disabled = false;
            })
            .catch(error => {
                console.error('Error al cargar tanques:', error);
                selectTanqueFiltro.innerHTML = '<option value="">Error al cargar</option>';
                iziToast.error({
                    title: 'Error',
                    message: 'No se pudieron cargar los tanques',
                    position: 'topRight'
                });
            });
    }

    /**
     * Limpia todos los filtros
     */
    function limpiarFiltros() {
        fechaInicio.value = '';
        fechaFin.value = '';
        selectZooFiltro.value = '';
        selectTanqueFiltro.innerHTML = '<option value="">Todos los tanques</option>';
        selectTanqueFiltro.disabled = true;

        iziToast.info({
            title: 'Filtros limpiados',
            message: 'Se han restablecido todos los filtros',
            position: 'topRight',
            timeout: 2000
        });
    }

    /**
     * Genera el reporte Excel con los filtros aplicados
     */
    async function generarReporteExcel() {
        // Construir parámetros de la URL
        const params = new URLSearchParams();

        if (fechaInicio.value) params.append('fecha_inicio', fechaInicio.value);
        if (fechaFin.value) params.append('fecha_fin', fechaFin.value);
        if (selectZooFiltro.value) params.append('cod_zoo', selectZooFiltro.value);
        if (selectTanqueFiltro.value) params.append('cod_tanque', selectTanqueFiltro.value);

        // Mostrar loading
        iziToast.info({
            title: 'Generando reporte',
            message: 'Por favor espere...',
            position: 'topRight',
            timeout: false,
            id: 'loadingReporte'
        });

        try {
            const respuesta = await fetch(`../backend/api.php?ajax=traer_seguimientos_filtrados&${params.toString()}`);
            const seguimientos = await respuesta.json();

            // Cerrar el loading
            iziToast.hide({}, document.getElementById('loadingReporte'));

            if (!seguimientos || seguimientos.length === 0) {
                iziToast.warning({
                    title: 'Sin datos',
                    message: 'No se encontraron seguimientos con los filtros aplicados',
                    position: 'topRight'
                });
                return;
            }

            // Generar Excel
            generarArchivoExcel(seguimientos);

        } catch (error) {
            iziToast.hide({}, document.getElementById('loadingReporte'));
            console.error('Error al generar reporte:', error);
            iziToast.error({
                title: 'Error',
                message: 'No se pudo generar el reporte',
                position: 'topRight'
            });
        }
    }

    /**
     * Genera el archivo Excel usando SheetJS
     */
    function generarArchivoExcel(seguimientos) {
        // Preparar los datos para Excel
        const datosExcel = seguimientos.map(seg => ({
            'Fecha': seg.fecha_actividad,
            'Zoocriadero': seg.nombre_zoo,
            'Numero de tanque': seg.nombre_tanque,
            'Tipo tanque': seg.tipo_tanque,
            'pH': parseFloat(seg.ph) || 'N/A',
            '°T': parseInt(seg.temperatura) || 'N/A',
            'Cloro': parseInt(seg.cloro) || 'N/A',
            'Alevines Nacidos': parseInt(seg.alevines_nacimiento) || 0,
            'Muertes Hembras': parseInt(seg.muerte_hembras) || 0,
            'Muertes Machos': parseInt(seg.muerte_machos) || 0,
            'Actividades Realizadas': seg.actividades || 'Sin actividades',
            'Realizó': `${seg.nombre_usu} ${seg.apellido_usu}`,
            'Observaciones': seg.observaciones || 'Sin observaciones'
        }));

        // Crear libro y hoja
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.json_to_sheet(datosExcel);

        // === 🔹 Estilos de bordes delgados ===
        const estiloBorde = {
            top: { style: "thin", color: { rgb: "000000" } },
            bottom: { style: "thin", color: { rgb: "000000" } },
            left: { style: "thin", color: { rgb: "000000" } },
            right: { style: "thin", color: { rgb: "000000" } }
        };

        // Obtener rango de la hoja
        const range = XLSX.utils.decode_range(ws['!ref']);

        for (let R = range.s.row; R <= range.e.row; ++R) {
            for (let C = range.s.col; C <= range.e.col; ++C) {
                const cell_ref = XLSX.utils.encode_cell({ r: R, c: C });
                if (!ws[cell_ref]) continue;

                // Aplicar bordes
                ws[cell_ref].s = ws[cell_ref].s || {};
                ws[cell_ref].s.border = estiloBorde;

                // Si es la fila de encabezados (R === 0)
                if (R === 0) {
                    ws[cell_ref].s.fill = {
                        patternType: "solid",
                        fgColor: { rgb: "E4E7EB" }   // gris suave estilo Excel
                    };
                    ws[cell_ref].s.font = {
                        bold: true
                    };

                    ws[cell_ref].s.border = {
                        top: { style: "medium", color: { rgb: "000000" } },
                        bottom: { style: "medium", color: { rgb: "000000" } },
                        left: { style: "medium", color: { rgb: "000000" } },
                        right: { style: "medium", color: { rgb: "000000" } }
                    };
                }
            }
        }

        // === 🔹 Activar AutoFilter (filtros de columna) ===
        ws['!autofilter'] = { ref: ws['!ref'] };

        // === 🔹 Ancho de columnas ===
        ws['!cols'] = [
            { wch: 12 }, // Fecha
            { wch: 20 }, // Zoo
            { wch: 18 }, // Tanque
            { wch: 15 }, // Tipo
            { wch: 6 },  // pH
            { wch: 10 }, // Temp
            { wch: 8 },  // Cloro
            { wch: 16 }, // Alevines
            { wch: 16 }, // Hembras
            { wch: 16 }, // Machos
            { wch: 30 }, // Actividades
            { wch: 20 }, // Realizó
            { wch: 25 }  // Observaciones
        ];

        XLSX.utils.book_append_sheet(wb, ws, "Seguimientos");

        const fechaActual = new Date().toISOString().split('T')[0];
        const nombreArchivo = `Reporte_Seguimientos_${fechaActual}.xlsx`;

        XLSX.writeFile(wb, nombreArchivo, { bookType: "xlsx", cellStyles: true });

        iziToast.success({
            title: 'Reporte generado',
            message: `Se descargó el archivo: ${nombreArchivo}`,
            position: 'topRight',
            timeout: 3000
        });
    }


    /**
     * Formatea una fecha en formato español
     */
    function formatearFecha(fechaStr) {
        if (!fechaStr) return 'N/A';
        const fecha = new Date(fechaStr + 'T00:00:00');
        return fecha.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

});