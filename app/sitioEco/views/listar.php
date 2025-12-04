<?php
include_once '../controllers/controllerListar.php';

$obj = new ListarSitioEco();
$sitioEco = $obj->MostrarSitioEco();
$barrios = $obj->ObtenerBarrios();
$comunas = $obj->ObtenerComunas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECO-Salud - Listar Sitios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

<body class="bg-gradient-to-br from-eco-cyan to-eco-green-light min-h-screen">
    <div class="container mx-auto p-6">
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
                    <button class="bg-eco-green-dark hover:bg-eco-teal text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-plus mr-2"></i>Registrar
                    </button>
                    <button class="bg-eco-blue hover:bg-eco-blue-light text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-search mr-2"></i>Consultar
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Left Section - Filters and List -->
            <div class="col-span-8">
                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fas fa-filter text-eco-blue text-xl"></i>
                        <h2 class="text-xl font-bold text-eco-green-dark">Consultar Sitios</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Selecciona un sitio para editar</p>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt text-eco-blue"></i>
                                Buscar por Comuna
                            </label>
                            <select id="filterComuna" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light transition-all">
                                <option value="">--Todas las comunas--</option>

                                <?php if (!empty($sitioEco)) { ?>
                                    <?php foreach ($comunas as $comuna) { ?>
                                        <option value="<?= $comuna['cod_comun'] ?>">
                                            <?= htmlspecialchars($comuna['nomcomun']) ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-building text-eco-green-dark"></i>
                                Buscar por Barrio
                            </label>
                            <select id="filterBarrio" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light transition-all">
                                <option value="">--Todos los barrios--</option>

                                <?php if (!empty($sitioEco)) { ?>
                                    <?php foreach ($barrios as $barrio) { ?>
                                        <option value="<?= $barrio['cod_barrio'] ?>">
                                            <?= htmlspecialchars($barrio['nombarrio']) ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="applyFilters()" class="flex-1 bg-eco-green-dark hover:bg-eco-teal text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Buscar
                        </button>
                        <button onclick="clearFilters()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-eraser"></i>
                            Limpiar Filtros
                        </button>
                    </div>
                </div>

                <!-- Sites List -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-700">
                            Mostrando <?= count($sitioEco) ?> sitio<?= count($sitioEco) != 1 ? 's' : '' ?>
                        </h3>
                        <button onclick="location.reload()" class="text-eco-blue hover:text-eco-green-dark font-semibold">
                            <i class="fas fa-sync-alt mr-2"></i>Actualizar
                        </button>
                    </div>

                    <!-- Site Cards -->
                    <div class="space-y-4" id="sitesContainer">
                        <?php if (!empty($sitioEco)) { ?>
                            <?php
                            $iconos = ['fa-home', 'fa-building', 'fa-tree', 'fa-hospital', 'fa-school', 'fa-landmark'];
                            $colores = [
                                'bg-eco-green-light text-eco-green-dark',
                                'bg-eco-blue-light text-eco-blue',
                                'bg-eco-cyan text-eco-teal'
                            ];
                            ?>

                            <?php foreach ($sitioEco as $index => $sitio) {
                                $iconIndex = $index % count($iconos);
                                $colorIndex = $index % count($colores);
                                $sitioJson = htmlspecialchars(json_encode($sitio), ENT_QUOTES, 'UTF-8');
                            ?>
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-eco-blue hover:shadow-md transition-all cursor-pointer"
                                    onclick='loadSiteData(<?= $sitioJson ?>)'
                                    data-cod-sitio="<?= htmlspecialchars($sitio['cod_sitioeco']) ?>"
                                    data-cod-barrio="<?= htmlspecialchars($sitio['cod_barrio']) ?>"
                                    data-cod-comuna="<?= htmlspecialchars($sitio['cod_comun']) ?>">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="<?= $colores[$colorIndex] ?> w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg">
                                                    <i class="fas <?= $iconos[$iconIndex] ?>"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-eco-green-dark">
                                                        <?= htmlspecialchars($sitio['nombre_sitio']) ?>
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        ID: <?= htmlspecialchars(substr($sitio['cod_sitioeco'], 0, 36)) ?>...
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div class="flex items-center gap-2 text-gray-600">
                                                    <i class="fas fa-map-marked-alt text-eco-blue"></i>
                                                    <span><strong>Barrio:</strong> <?= htmlspecialchars($sitio['nombarrio']) ?></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-gray-600">
                                                    <i class="fas fa-location-dot text-eco-green-dark"></i>
                                                    <span><strong>Dirección:</strong> <?= htmlspecialchars($sitio['direccion']) ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex gap-2">
                                            <button onclick="viewDetails(<?= $sitioJson ?>); event.stopPropagation();"
                                                class="bg-eco-cyan hover:bg-eco-teal text-white px-3 py-2 rounded-lg transition-all shadow-md"
                                                title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick='loadSiteData(<?= $sitioJson ?>); event.stopPropagation();'
                                                class="bg-eco-blue hover:bg-eco-green-dark text-white px-3 py-2 rounded-lg transition-all shadow-md"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deactivateSite('<?= htmlspecialchars($sitio['cod_sitioeco']) ?>', '<?= htmlspecialchars($sitio['nombre_sitio']) ?>'); event.stopPropagation();"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all shadow-md"
                                                title="Anular Sitio">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-center py-12">
                                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg">No se encontraron sitios</p>
                                <p class="text-gray-400 text-sm">Intenta con otros filtros o verifica la base de datos</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Right Section - Edit Form (Fixed) -->
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

    <script src="../../../src/js/sitio-eco-listar.js"></script>
</body>

</html>