<?php
include_once '../controllers/controllerRegistrar.php';
session_start();

$nombre   = $_SESSION["nombre"] ?? 'Usuario';
$apellido = $_SESSION["apellido"] ?? 'Prueba';
$rol      = $_SESSION["rol"] ?? 'Administrador';
$nombreCompleto = mb_strtoupper($nombre . ' ' . $apellido, 'UTF-8');
$inicial = substr($nombre, 0, 1);
$final   = substr($apellido, 0, 1);
$comodin = strtoupper($inicial . $final);
$permiso = $_SESSION["permiso"] ?? '';
$obj = new RegistrarZoo();
$barrios = $obj->ObtenerBarrio();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Zoocriadero</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'azul-primario': '#0891b2',
                        'azul-oscuro': '#0e7490',
                        'azul-medio': '#22d3ee',
                        'azul-claro-1': '#ecfeff',
                        'azul-claro-2': '#67e8f9'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-blue-200 min-h-screen flex items-center justify-center p-6">

    <?php include_once '../../../src/includes/aside-zoo.php';  ?>

    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-2xl">

        <!-- Indicador de página -->
        <div class="flex justify-center mb-6">
            <div class="flex items-center gap-2">
                <span id="page-indicator-1" class="w-3 h-3 rounded-full bg-cyan-500 transition-all"></span>
                <span id="page-indicator-2" class="w-3 h-3 rounded-full bg-gray-300 transition-all"></span>
            </div>
        </div>

        <!-- ✅ UN SOLO FORMULARIO para ambas páginas -->
        <form id="formCompleto" method="POST" action="../controllers/controllerRegistrar.php">

            <!-- PÁGINA 1: Datos del Zoocriadero -->
            <div id="page1" class="page-content">
                <h1 class="text-4xl font-bold text-gray-700 text-center mb-8">Registrar Zoocriadero</h1>

                <!-- Nombre del Zoocriadero -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Nombre del Zoocriadero</label>
                    <input
                        type="text"
                        id="nombreZoo"
                        name="nombreZoo"
                        class="w-full px-4 py-3 border-2 border-cyan-400 rounded-full focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50"
                        required>
                </div>

                <!-- Barrio -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Barrio</label>
                    <select
                        id="barrio"
                        name="barrio"
                        class="w-full px-4 py-3 border-2 border-cyan-400 rounded-full focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50 appearance-none cursor-pointer"
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

                <!-- Dirección -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-medium mb-2">Dirección</label>
                    <div class="flex gap-2">
                        <input
                            type="text"
                            id="direccion"
                            name="direccion"
                            class="flex-1 px-4 py-3 border-2 border-cyan-400 rounded-full focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50"
                            placeholder="Haz clic en el botón para construir la dirección"
                            readonly
                            required>
                        <button
                            type="button"
                            id="btnAbrirModal"
                            class="bg-cyan-500 text-white px-6 py-3 rounded-full hover:bg-cyan-600 transition-all shadow-lg font-medium">
                            Construir
                        </button>
                    </div>
                </div>

                <!-- Botón Siguiente -->
                <div class="flex justify-center">
                    <button
                        type="button"
                        id="btnSiguiente"
                        class="bg-cyan-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Siguiente
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- PÁGINA 2: Asociación de Tanques -->
            <div id="page2" class="page-content hidden">
                <h1 class="text-4xl font-bold text-gray-700 text-center mb-8">Asociación de Tanques</h1>

                <!-- Tabla de Tanques -->
                <div class="mb-8">
                    <!-- Encabezados -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-cyan-500 text-white font-semibold py-3 px-4 rounded-lg text-center">
                            Tipo de Tanque
                        </div>
                        <div class="bg-cyan-500 text-white font-semibold py-3 px-4 rounded-lg text-center flex items-center justify-center gap-2">
                            Nombre del Tanque
                            <button
                                type="button"
                                id="btnAgregarTanque"
                                class="bg-white text-cyan-500 rounded-full w-7 h-7 flex items-center justify-center hover:bg-cyan-100 transition-all shadow-md"
                                title="Agregar tanque">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Filas de tanques -->
                    <div id="tanquesContainer" class="space-y-3">
                        <!-- Primera fila (siempre visible) -->
                        <div class="grid grid-cols-2 gap-4 tanque-row">
                            <select
                                name="tipoTanque[]"
                                class="px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50"
                                required>
                                <option value="">Seleccionar tipo</option>
                                <option value="1">Acuícola</option>
                                <option value="2">Reproductor</option>
                                <option value="3">Cría</option>
                            </select>
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="nombreTanque[]"
                                    placeholder="Ingrese nombre"
                                    class="flex-1 px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-600 transition-all bg-cyan-50"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-center gap-4">
                    <button
                        type="button"
                        id="btnAnterior"
                        class="bg-gray-300 text-gray-700 px-8 py-3 rounded-full shadow-lg hover:shadow-xl hover:bg-gray-400 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                        </svg>
                        Anterior
                    </button>
                    <button
                        type="submit"
                        class="bg-cyan-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:shadow-xl hover:bg-cyan-600 transition-all">
                        Registrar
                    </button>
                </div>
            </div>

        </form>
        <!-- ✅ FIN del formulario único -->

        <!-- Contador de páginas -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            <span id="pageCounter">1/2</span>
        </div>

    </div>

    <!-- ✅ MODAL PARA CONSTRUIR DIRECCIÓN CON COLORES -->
    <div id="modalDireccion" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-3xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-cyan-600">Ingreso de Dirección</h2>
                <button
                    type="button"
                    id="btnCerrarModal"
                    class="text-gray-400 hover:text-gray-600 text-3xl font-bold leading-none">
                    ×
                </button>
            </div>

            <!-- Grid de campos -->
            <div class="grid grid-cols-3 gap-6 mb-6">

                <!-- Tipo de Vía -->
                <div>
                    <label class="block text-sm font-medium text-cyan-600 mb-2">Tipo de Vía</label>
                    <select
                        id="tipoVia"
                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50 text-gray-700">
                        <option value="">-</option>
                        <option value="Calle">Calle</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Avenida">Avenida</option>
                        <option value="Diagonal">Diagonal</option>
                        <option value="Transversal">Transversal</option>
                    </select>
                </div>

                <!-- Número Vía -->
                <div>
                    <label class="block text-sm font-medium text-cyan-600 mb-2">Número Vía</label>
                    <input
                        type="text"
                        id="numeroVia"
                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50">
                </div>

                <!-- # -->
                <div>
                    <label class="block text-sm font-medium text-cyan-600 mb-2">#</label>
                    <input
                        type="text"
                        id="numeroSimbolo"
                        value="#"
                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50"
                        readonly>
                </div>

                <!-- Sufijo / Letra -->
                <div>
                    <label class="block text-sm font-medium text-cyan-600 mb-2">Sufijo / Letra</label>
                    <input
                        type="text"
                        id="sufijo"
                        maxlength="5"
                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50">
                </div>

                <!-- Distancia -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-cyan-600 mb-2">Distancia</label>
                    <input
                        type="text"
                        id="distancia"
                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50">
                </div>

            </div>

            <!-- Dirección Generada -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-cyan-600 mb-2">DIRECCIÓN GENERADA</label>
                <div class="w-full px-4 py-4 border-2 border-cyan-300 rounded-lg bg-cyan-50 min-h-[60px] flex items-center">
                    <p id="vistaPrevia" class="text-lg text-gray-700 font-medium">
                        -
                    </p>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    id="btnBorrarModal"
                    class="bg-red-100 text-red-600 font-semibold px-8 py-3 rounded-lg hover:bg-red-200 transition-all uppercase">
                    BORRAR
                </button>
                <button
                    type="button"
                    id="btnBorrarUltimoModal"
                    class="bg-yellow-100 text-yellow-700 font-semibold px-8 py-3 rounded-lg hover:bg-yellow-200 transition-all uppercase">
                    BORRAR ÚLTIMO
                </button>
                <button
                    type="button"
                    id="btnAplicarDireccion"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold px-8 py-3 rounded-lg transition-all uppercase shadow-lg">
                    GUARDAR
                </button>
            </div>
        </div>
    </div>
    <script src="../../../src/js/zoo-registrar.js"></script>
    <script src="../../../src/js/aside.js"></script>
</body>

</html>