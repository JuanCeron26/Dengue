<?php
include_once '../controllers/controllerRegistrar.php';

$obj = new RegistrarSitioEco();
$barrios = $obj->ObtenerBarrios();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECO-Salud - Registrar Nuevo Sitio</title>
    <link rel="stylesheet" href="../../../src/css/registrar.css">
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6 max-w-6xl">
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
                    <a href="registrar.php" class="bg-eco-green-dark hover:bg-eco-green-light text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>Registrar
                    </a>
                    <a href="listar.php" class="bg-eco-green-light hover:bg-eco-green-dark text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md inline-flex items-center">
                        <i class="fas fa-search mr-2"></i>Consultar
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-3xl mx-auto">
            <!-- Registration Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-eco-green-dark text-white p-4 rounded-lg">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-eco-green-dark">Registrar Nuevo Sitio</h2>
                        <p class="text-gray-600">Completa la información del sitio</p>
                    </div>
                </div>

                <form id="registerForm" method="POST" action="../controllers/controllerRegistrar.php" class="space-y-6">
                    <!-- Nombre del Sitio -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-eco-green-dark mb-2">
                            <i class="fas fa-home"></i>
                            Nombre del Sitio
                        </label>
                        <input
                            type="text"
                            id="siteName"
                            name="sitioEco"
                            placeholder="Ej: Centro de Salud El Bosque"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none transition-all"
                            required>
                    </div>

                    <!-- Barrio -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-eco-green-dark mb-2">
                            <i class="fas fa-building"></i>
                            Barrio
                        </label>
                        <select
                            id="barrio"
                            name="barrio"
                            class="w-full px-4 py-3 border-2 border-eco-green-dark rounded-lg focus:outline-none focus:border-eco-green-light transition-all bg-green-50 appearance-none cursor-pointer"
                            required>
                            <option value="">Seleccionar barrio</option>
                            <?php if (!empty($barrios)) { ?>
                                <?php foreach ($barrios as $barrio) { ?>
                                    <option value="<?= $barrio['cod_barrio'] ?>">
                                        <?= htmlspecialchars($barrio['nombarrio']) ?>
                                    </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Dirección del Sitio -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-bold text-eco-green-dark mb-2">
                            <i class="fas fa-location-dot"></i>
                            Dirección del Sitio
                        </label>
                        <div class="flex gap-3">
                            <input
                                type="text"
                                id="address"
                                name="direccion"
                                placeholder="Haz clic en el botón para ingresar dirección"
                                class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none transition-all"
                                readonly
                                required>
                            <button
                                type="button"
                                id="btnAbrirModalAdreess"
                                class="bg-eco-green-dark hover:bg-eco-green-light text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md whitespace-nowrap">
                                Ingresar
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-eco-green-dark hover:bg-eco-green-light text-white px-6 py-4 rounded-lg font-bold text-lg transition-all shadow-lg flex items-center justify-center gap-3">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                        Registrar Sitio
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Mejorado para Dirección -->
    <div id="addressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-eco-green-dark text-white p-3 rounded-lg">
                        <i class="fas fa-location-dot text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-eco-green-dark">Ingreso de Dirección</h3>
                </div>
                <button id="btnCloseAdress" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="space-y-4">
                <!-- Primera fila: Tipo de Vía, Número Vía y # -->
                <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-5">
                        <label class="text-sm font-semibold text-eco-green-dark mb-2 block">
                            Tipo de Vía
                        </label>
                        <select id="viaType" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none">
                            <option value="">-</option>
                            <option value="Calle">Calle</option>
                            <option value="Carrera">Carrera</option>
                            <option value="Avenida">Avenida</option>
                            <option value="Transversal">Transversal</option>
                            <option value="Diagonal">Diagonal</option>
                            <option value="Circular">Circular</option>
                        </select>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-semibold text-eco-green-dark mb-2 block">
                            Número Vía
                        </label>
                        <input
                            type="text"
                            id="viaNumber"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm font-semibold text-eco-green-dark mb-2 block">
                            #
                        </label>
                        <input
                            type="text"
                            id="hashNumber"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none">
                    </div>
                </div>

                <!-- Segunda fila: Sufijo/Letra y Distancia -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-semibold text-eco-green-dark mb-2 block">
                            Sufijo / Letra <span class="text-gray-400 text-xs">(opcional)</span>
                        </label>
                        <input
                            type="text"
                            id="suffix"
                            placeholder="Ej: A, B, BIS"
                            maxlength="3"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-eco-green-dark mb-2 block">
                            Distancia <span class="text-gray-400 text-xs">(opcional)</span>
                        </label>
                        <input
                            type="text"
                            id="distance"
                            placeholder="Ej: 25, 30"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none">
                    </div>
                </div>

                <!-- Tercera fila: Punto Cardinal (opcional) -->
                <div>
                    <label class="text-sm font-semibold text-eco-green-dark mb-2 block">
                        Punto Cardinal <span class="text-gray-400 text-xs">(opcional)</span>
                    </label>
                    <select id="cardinalPoint" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-green-dark focus:ring-2 focus:ring-eco-green-light focus:outline-none">
                        <option value="">Ninguno</option>
                        <option value="Norte">Norte</option>
                        <option value="Sur">Sur</option>
                        <option value="Este">Este</option>
                        <option value="Oeste">Oeste</option>
                    </select>
                </div>

                <!-- Dirección Generada (Vista previa) -->
                <div class="bg-eco-green-light bg-opacity-30 p-4 rounded-lg border-2 border-eco-green-dark">
                    <label class="text-sm font-bold text-eco-green-dark mb-2 block">
                        DIRECCIÓN GENERADA
                    </label>
                    <div id="generatedAddress" class="text-lg font-semibold text-eco-green-dark min-h-[30px]">
                        -
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3 pt-4">
                    <button
                        id="btnClearAddress"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-eraser mr-2"></i>
                        Borrar
                    </button>
                    <button
                        id="btnClearLastField"
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-undo mr-2"></i>
                        Borrar Último
                    </button>
                    <button
                        id="btnSaveAdress"
                        class="flex-1 bg-eco-green-dark hover:bg-eco-green-light text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-check mr-2"></i>
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../src/js/sitio-eco-registrar.js"></script>
</body>

</html>