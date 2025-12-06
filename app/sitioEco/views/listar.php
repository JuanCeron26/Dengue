<?php
include_once '../controllers/controllerListar.php';

$obj = new ListarSitioEco();
$sitioEco = $obj->MostrarSitioEco();
$barrios = $obj->ObtenerBarrios();
$comunas = $obj->ObtenerComunas();

// Configuración de paginación
$itemsPorPagina = 6; // 2 filas x 3 columnas
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$totalSitios = count($sitioEco);
$totalPaginas = ceil($totalSitios / $itemsPorPagina);
$offset = ($paginaActual - 1) * $itemsPorPagina;
$sitiosPaginados = array_slice($sitioEco, $offset, $itemsPorPagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECO-Salud - Listar Sitios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/css/listar.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'eco-green-dark': '#005F3D',
                        'eco-green-light': '#A5D7AE',
                        'eco-blue-light': '#8EBBFF',
                        'eco-blue': '#4A7BFF',
                        'eco-cyan': '#9AC2DA',
                        'eco-teal': '#3E6E83'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-eco-green-dark text-white p-4 rounded-xl">
                        <i class="fas fa-leaf text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-eco-green-dark">ECO-Salud</h1>
                        <p class="text-gray-600">Sistema de Gestión de Sitios de Salud Ambiental</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="registrar.php" class="bg-eco-green-dark hover:bg-eco-teal text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>Registrar
                    </a>
                    <a href="listar.php" class="bg-eco-blue hover:bg-eco-blue-light text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md inline-flex items-center">
                        <i class="fas fa-search mr-2"></i>Consultar
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros Compactos -->
        <div class="bg-white rounded-lg shadow-lg p-5 mb-6">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 text-eco-green-dark font-bold">
                    <i class="fas fa-filter text-xl"></i>
                    <span>Filtros:</span>
                </div>

                <div class="flex-1 grid grid-cols-2 gap-4">
                    <select id="filterComuna" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light transition-all text-sm">
                        <option value="">Todas las comunas</option>
                        <?php foreach ($comunas as $comuna) { ?>
                            <option value="<?= $comuna['cod_comun'] ?>">
                                <?= htmlspecialchars($comuna['nomcomun']) ?>
                            </option>
                        <?php } ?>
                    </select>

                    <select id="filterBarrio" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light transition-all text-sm">
                        <option value="">Todos los barrios</option>
                        <?php foreach ($barrios as $barrio) { ?>
                            <option value="<?= $barrio['cod_barrio'] ?>">
                                <?= htmlspecialchars($barrio['nombarrio']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button onclick="applyFilters()" class="bg-eco-green-dark hover:bg-eco-teal text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-search mr-1"></i>Buscar
                    </button>
                    <button onclick="clearFilters()" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-eraser mr-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Header de resultados -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700">
                Mostrando <?= count($sitiosPaginados) ?> de <?= $totalSitios ?> sitio<?= $totalSitios != 1 ? 's' : '' ?>
            </h3>
            <button onclick="location.reload()" class="text-eco-blue hover:text-eco-green-dark font-semibold">
                <i class="fas fa-sync-alt mr-2"></i>Actualizar
            </button>
        </div>

        <!-- Contenedor principal con Grid y Formulario -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Columna izquierda: Grid de Cards (8 columnas) -->
            <div class="col-span-8">
                <!-- Grid de Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <?php if (!empty($sitiosPaginados)) { ?>
                        <?php foreach ($sitiosPaginados as $sitio) {
                            $sitioJson = htmlspecialchars(json_encode($sitio), ENT_QUOTES, 'UTF-8');
                        ?>
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                                <!-- Card Header con degradado igual al modal -->
                                <div class="bg-gradient-to-r from-eco-green-dark to-eco-teal p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                            <i class="fas fa-hospital text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-bold text-lg line-clamp-1">
                                                <?= htmlspecialchars($sitio['nombre_sitio']) ?>
                                            </h3>
                                            <p class="text-white text-opacity-80 text-xs">
                                                ID: <?= htmlspecialchars(substr($sitio['cod_sitioeco'], 0, 8)) ?>...
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-5">
                                    <div class="space-y-3 mb-4">
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-map-marked-alt text-eco-blue mt-1"></i>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500 font-semibold">Barrio</p>
                                                <p class="text-sm text-gray-800"><?= htmlspecialchars($sitio['nombarrio']) ?></p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-location-dot text-eco-green-dark mt-1"></i>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500 font-semibold">Dirección</p>
                                                <p class="text-sm text-gray-800"><?= htmlspecialchars($sitio['direccion']) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="grid grid-cols-3 gap-2 pt-3 border-t border-gray-200">
                                        <button onclick="viewDetails(<?= $sitioJson ?>)"
                                            class="bg-eco-cyan hover:bg-eco-teal text-white px-3 py-2 rounded-lg transition-all text-sm font-semibold"
                                            title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick='loadSiteData(<?= $sitioJson ?>)'
                                            class="bg-eco-blue hover:bg-eco-green-dark text-white px-3 py-2 rounded-lg transition-all text-sm font-semibold"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deactivateSite('<?= htmlspecialchars($sitio['cod_sitioeco']) ?>', '<?= htmlspecialchars($sitio['nombre_sitio']) ?>')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all text-sm font-semibold"
                                            title="Anular">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="col-span-full bg-white rounded-xl shadow-lg p-12 text-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold">No se encontraron sitios</p>
                            <p class="text-gray-400 text-sm">Intenta con otros filtros o registra un nuevo sitio</p>
                        </div>
                    <?php } ?>
                </div>

                <!-- Paginación -->
                <?php if ($totalPaginas > 1) { ?>
                    <div class="bg-white rounded-lg shadow-lg p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                Página <span class="font-bold"><?= $paginaActual ?></span> de <span class="font-bold"><?= $totalPaginas ?></span>
                            </p>

                            <div class="flex gap-2">
                                <!-- Botón anterior -->
                                <?php if ($paginaActual > 1) { ?>
                                    <a href="?pagina=<?= $paginaActual - 1 ?>"
                                        class="bg-eco-green-dark hover:bg-eco-teal text-white px-4 py-2 rounded-lg font-semibold transition-all">
                                        <i class="fas fa-chevron-left mr-1"></i>Anterior
                                    </a>
                                <?php } ?>

                                <!-- Números de página -->
                                <div class="flex gap-1">
                                    <?php
                                    $rango = 2;
                                    $inicio = max(1, $paginaActual - $rango);
                                    $fin = min($totalPaginas, $paginaActual + $rango);

                                    for ($i = $inicio; $i <= $fin; $i++) {
                                        $activa = $i === $paginaActual;
                                        $clase = $activa
                                            ? 'bg-eco-green-dark text-white'
                                            : 'bg-gray-200 hover:bg-gray-300 text-gray-700';
                                    ?>
                                        <a href="?pagina=<?= $i ?>"
                                            class="<?= $clase ?> px-4 py-2 rounded-lg font-semibold transition-all">
                                            <?= $i ?>
                                        </a>
                                    <?php } ?>
                                </div>

                                <!-- Botón siguiente -->
                                <?php if ($paginaActual < $totalPaginas) { ?>
                                    <a href="?pagina=<?= $paginaActual + 1 ?>"
                                        class="bg-eco-green-dark hover:bg-eco-teal text-white px-4 py-2 rounded-lg font-semibold transition-all">
                                        Siguiente<i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Columna derecha: Formulario de Edición Fijo (4 columnas) -->
            <div class="col-span-4">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-eco-blue text-white p-3 rounded-lg">
                            <i class="fas fa-edit text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-eco-green-dark">Editar Sitio</h2>
                    </div>

                    <div id="emptyState" class="text-center py-12">
                        <i class="fas fa-hand-pointer text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Haz clic en una card de la izquierda para editar un sitio</p>
                    </div>

                    <div id="editForm" class="hidden">
                        <!-- Non-editable Information -->
                        <div class="bg-eco-blue-light bg-opacity-20 rounded-lg p-4 mb-4">
                            <div class="flex items-center gap-2 text-sm font-semibold text-eco-teal mb-3">
                                <i class="fas fa-lock"></i>
                                <span>Información No Modificable</span>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-600 flex items-center gap-1">
                                        <i class="fas fa-hashtag text-xs"></i>
                                        ID del Sitio
                                    </label>
                                    <input type="text" id="siteId" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-sm mt-1" readonly>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-600 flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt text-xs"></i>
                                        Barrio
                                    </label>
                                    <input type="text" id="neighborhood" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-sm mt-1" readonly>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-600 flex items-center gap-1">
                                        <i class="fas fa-location-dot text-xs"></i>
                                        Dirección
                                    </label>
                                    <input type="text" id="address" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-sm mt-1" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Editable Field -->
                        <div class="bg-eco-green-light bg-opacity-20 rounded-lg p-4 mb-4">
                            <div class="flex items-center gap-2 text-sm font-semibold text-eco-green-dark mb-3">
                                <i class="fas fa-pencil"></i>
                                <span>Campo Editable</span>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-600 flex items-center gap-1">
                                    <i class="fas fa-home text-xs"></i>
                                    Nombre del Sitio
                                </label>
                                <input type="text" id="siteName" class="w-full px-3 py-2 border-2 border-eco-green-dark rounded-lg mt-1 focus:ring-2 focus:ring-eco-green-light focus:outline-none" placeholder="Ingresa el nombre del sitio">
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i>
                                    Este es el único campo modificable
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button onclick="saveSite()" class="flex-1 bg-eco-green-dark hover:bg-eco-teal text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                                <i class="fas fa-save mr-2"></i>Guardar
                            </button>
                            <button onclick="cancelEdit()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalles del Sitio -->
    <div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-eco-green-dark to-eco-teal p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-xl">
                            <i class="fas fa-hospital text-white text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Detalles del Sitio</h3>
                            <p class="text-white text-opacity-80">Información completa</p>
                        </div>
                    </div>
                    <button onclick="closeDetailsModal()" class="text-white hover:text-gray-200 transition-all">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Nombre del Sitio -->
                <div class="bg-gradient-to-r from-eco-blue-light to-eco-cyan bg-opacity-20 rounded-xl p-5 mb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-hospital-alt text-eco-green-dark text-xl"></i>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wide">Nombre del Sitio</h4>
                    </div>
                    <p id="modalNombre" class="text-2xl font-bold text-eco-green-dark"></p>
                </div>

                <!-- Información en Grid -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- ID -->
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-eco-blue">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-hashtag text-eco-blue"></i>
                            <p class="text-xs font-bold text-gray-600 uppercase">Código</p>
                        </div>
                        <p id="modalId" class="text-sm font-mono text-gray-800 break-all"></p>
                    </div>

                    <!-- Comuna -->
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-eco-teal">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-city text-eco-teal"></i>
                            <p class="text-xs font-bold text-gray-600 uppercase">Comuna</p>
                        </div>
                        <p id="modalComuna" class="text-sm font-semibold text-gray-800"></p>
                    </div>

                    <!-- Barrio -->
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-eco-green-dark">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-map-marked-alt text-eco-green-dark"></i>
                            <p class="text-xs font-bold text-gray-600 uppercase">Barrio</p>
                        </div>
                        <p id="modalBarrio" class="text-sm font-semibold text-gray-800"></p>
                    </div>

                    <!-- Dirección -->
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-red-500">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-location-dot text-red-500"></i>
                            <p class="text-xs font-bold text-gray-600 uppercase">Dirección</p>
                        </div>
                        <p id="modalDireccion" class="text-sm font-semibold text-gray-800"></p>
                    </div>
                </div>

                <!-- Botón cerrar -->
                <button onclick="closeDetailsModal()"
                    class="w-full bg-eco-green-dark hover:bg-eco-teal text-white px-6 py-3 rounded-lg font-bold transition-all shadow-lg">
                    <i class="fas fa-check mr-2"></i>Aceptar
                </button>
            </div>
        </div>
    </div>

    <script src="../../../src/js/sitio-eco-listar.js"></script>
</body>

</html>