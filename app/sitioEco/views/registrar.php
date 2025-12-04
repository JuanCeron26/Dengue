<?php 
include_once '../controllers/controllerRegistar.php';

$obj= new RegistrarSitioEco();
$barrios= $obj->ObtenerBarrios();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECO-Salud - Registrar Nuevo Sitio</title>
    <link rel="stylesheet" href="../../../src/css/registrar.css">
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

<body class="bg-eco-green-light min-h-screen">
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
                            class="w-full px-4 py-3 border-2 border-eco-blue rounded-full focus:outline-none focus:eco-blue transition-all bg-cyan-50 appearance-none cursor-pointer"
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
                                type="button" id="btnAbrirModalAdreess"
                                onclick="openAddressModal()"
                                class="bg-eco-blue hover:bg-eco-blue-light text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md whitespace-nowrap">
                                Ingresar
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-eco-green-dark hover:bg-eco-teal text-white px-6 py-4 rounded-lg font-bold text-lg transition-all shadow-lg flex items-center justify-center gap-3">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                        Registrar Sitio
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal for Address Input -->
    <div id="addressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-eco-blue text-white p-3 rounded-lg">
                        <i class="fas fa-location-dot text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-eco-green-dark">Ingresar Dirección</h3>
                </div>
                <button id="btnCloseAdress" onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">
                        Tipo de Vía
                    </label>
                    <select id="viaType" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light focus:outline-none">
                        <option value="">Selecciona...</option>
                        <option value="Calle">Calle</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Avenida">Avenida</option>
                        <option value="Transversal">Transversal</option>
                        <option value="Diagonal">Diagonal</option>
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Principal
                        </label>
                        <input
                            type="text"
                            id="mainNumber"
                            placeholder="3"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Secundaria
                        </label>
                        <input
                            type="text"
                            id="secundaryNumber"
                            placeholder="123"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Número
                        </label>
                        <input
                            type="text"
                            id="plateNumber"
                            placeholder="456"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-eco-blue focus:ring-2 focus:ring-eco-blue-light focus:outline-none">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button
                    id="btnSaveAdress"
                        onclick="saveAddress()"
                        class="flex-1 bg-eco-green-dark hover:bg-eco-teal text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-check mr-2"></i>
                        Guardar
                    </button>
                    <button
                        onclick="closeAddressModal()"
                        class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-4 py-3 rounded-lg font-semibold transition-all shadow-md">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../src/js/sitio-eco-registrar.js"></script>
</body>

</html>