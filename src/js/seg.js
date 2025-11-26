document.addEventListener("DOMContentLoaded", () => {
    const tablaSeguimientos = document.getElementById('tablaSeguimientos');

    pintarSeguimientos();

    function pintarSeguimientos() {
        fetch('../backend/api.php?ajax=traer_seguimientos')
            .then(respuesta => respuesta.json())
            .then(seguimientos => {
                console.log(seguimientos);
                tablaSeguimientos.innerHTML = '';

                if (seguimientos.length === 0) {
                    tablaSeguimientos.innerHTML = `
                        <tr>
                            <td colspan="8" class="px-3 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-lg font-semibold">No hay seguimientos registrados</p>
                                    <p class="text-sm">Comienza registrando un nuevo seguimiento</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                seguimientos.forEach((seg) => {
                    const tr = document.createElement('tr');
                    tr.className = 'table-row-hover transition duration-150 ease-in-out';

                    // Calcular total de muertes
                    const totalMuertes = parseInt(seg.muerte_hembras || 0) + parseInt(seg.muerte_machos || 0);

                    // Determinar color del pH
                    const ph = parseFloat(seg.ph);
                    let phClass = 'bg-gray-100 text-gray-800';
                    if (ph >= 6.5 && ph <= 7.5) {
                        phClass = 'bg-green-100 text-green-800';
                    } else if (ph >= 6.0 && ph < 6.5 || ph > 7.5 && ph <= 8.0) {
                        phClass = 'bg-yellow-100 text-yellow-800';
                    } else {
                        phClass = 'bg-red-100 text-red-800';
                    }

                    // Determinar color de muertes
                    let muertesClass = 'bg-gray-100 text-gray-800';
                    if (totalMuertes === 0) {
                        muertesClass = 'bg-green-100 text-green-800';
                    } else if (totalMuertes <= 3) {
                        muertesClass = 'bg-yellow-100 text-yellow-800';
                    } else {
                        muertesClass = 'bg-red-100 text-red-800';
                    }

                    tr.innerHTML = `
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${seg.fecha_actividad}
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                            ${seg.nombre_tanque} (${seg.tipo_tanque})
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full ${phClass}">
                                ${seg.ph || 'N/A'}
                            </span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${seg.temperatura || 'N/A'}
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full ${muertesClass}">
                                ${totalMuertes}
                            </span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${seg.actividades || 'Sin actividades'}
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${seg.nombre_operario}
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-sky-600 hover:text-sky-900 font-semibold transition duration-150 ease-in-out" 
                               onclick="verDetalle(${seg.cod_segzooact}); return false;">
                                Ver Detalle
                            </a>
                        </td>
                    `;

                    tablaSeguimientos.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error al cargar seguimientos:', error);
                tablaSeguimientos.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-3 py-8 text-center text-red-500">
                            Error al cargar los seguimientos. Por favor, intente nuevamente.
                        </td>
                    </tr>
                `;
            });
    }

    // Función para ver el detalle (puedes implementarla después)
    window.verDetalle = function (cod_segzooact) {
        console.log('Ver detalle de:', cod_segzooact);
        // Aquí puedes redirigir o abrir un modal con los detalles
        // window.location.href = `detalle.php?id=${cod_segzooact}`;
    }
});


// ============================================================
// API.PHP - Agregar este case en el GET
// ============================================================
/*
case 'traer_seguimientos':
    $seguimientos = $objZoo->traerSeguimientos();
    if ($seguimientos) {
        echo json_encode($seguimientos);
    } else {
        echo json_encode([]);
    }
    break;
*/


// ============================================================
// CONTROLLER (controllerSegZoo.php)
// ============================================================
/*
public function traerSeguimientos() {
    return $this->ListarSeguimientos();
}
*/


// ============================================================
// MODEL (modelSegZoo.php)
// ============================================================
/*
protected function ListarSeguimientos() {
    $sql = "
        SELECT
            sza.cod_segzooact,
            sza.cod_segzoo,
            sza.fecha_actividad,
            sza.ph,
            sza.temperatura,
            sza.cloro,
            sza.alevines_nacimiento,
            sza.muerte_hembras,
            sza.muerte_machos,
            sza.observaciones,
            t.nombre as nombre_tanque,
            tt.nomtiptan as tipo_tanque,
            CONCAT(u.nombre_usu, ' ', u.apellido_usu) as nombre_operario,
            STRING_AGG(ta.nombre_actividad, ', ') as actividades
        FROM tblsegzooact sza
        INNER JOIN tblseguimientozoo sz ON sza.cod_segzoo = sz.cod_segzoo
        INNER JOIN tblzootanques t ON sz.cod_zootanque = t.cod_zootanque
        INNER JOIN tbltipotanque tt ON t.cod_tipotanque = tt.cod_tipotanque
        INNER JOIN tblusuario u ON sz.id_zooadmin = u.id_usu
        LEFT JOIN tblsegzooact_actividades szaa ON sza.cod_segzooact = szaa.cod_segzooact
        LEFT JOIN tblactividadzoo ta ON szaa.cod_tipoactividadzoo = ta.cod_tipoactividadzoo
        GROUP BY
            sza.cod_segzooact,
            sza.cod_segzoo,
            sza.fecha_actividad,
            sza.ph,
            sza.temperatura,
            sza.cloro,
            sza.alevines_nacimiento,
            sza.muerte_hembras,
            sza.muerte_machos,
            sza.observaciones,
            t.nombre,
            tt.nomtiptan,
            u.nombre_usu,
            u.apellido_usu
        ORDER BY sza.fecha_actividad DESC
    ";

    $result = pg_query($this->objDB->conectar, $sql);

    if ($result) {
        $seguimientos = [];
        while ($row = pg_fetch_assoc($result)) {
            $seguimientos[] = $row;
        }
        return $seguimientos;
    }

    return false;
}
*/


// ============================================================
// HTML - Asegúrate de tener este ID en tu tbody
// ============================================================
/*
<tbody id="tablaSeguimientos" class="bg-white divide-y divide-gray-200">
    <!-- Los datos se cargan dinámicamente aquí -->
</tbody>

<!-- Y este script al final del HTML -->
<script src="../../../src/js/segzoo-consultar.js"></script>
*/