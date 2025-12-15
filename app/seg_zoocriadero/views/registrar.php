<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Seguimiento de Zoocriadero - Tailwind Nativo V4</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">
</head>

<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-4xl mx-auto mt-10">

        <h1 class="text-4xl font-extrabold text-center mb-12 text-gray-800">
            🐟 Registro de Seguimiento de Zoocriadero
        </h1>

        <form id="formRegistrarSegZoo" class="space-y-8">

            <div class="bg-white shadow-xl rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl hover:translate-y-[-5px]">
                <h2 class="text-2xl font-bold mb-6 text-sky-700">0. Zoocriadero y Fecha</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label for="fecha_actividad" class="block font-semibold mb-1 text-gray-700">Fecha del seguimiento</label>
                        <input type="date" id="fecha_actividad" name="fecha_actividad"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200">
                    </div>

                    <div>
                        <label for="cod_zoocriadero" class="block font-semibold mb-1 text-gray-700">Seleccionar Zoocriadero</label>
                        <div class="relative">
                            <select id="cod_zoocriadero" name="cod_zoocriadero"
                                class="select-custom w-full p-3 border border-gray-300 rounded-xl appearance-none pr-10 cursor-pointer 
                                    focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200">
                                <!--Zoocriaderos-->
                            </select>
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">▼</span>
                        </div>
                    </div>
                </div>

                <div id="selectedZoocriaderoCard" class="mt-6">
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl hover:translate-y-[-5px]">
                <h2 class="text-2xl font-bold mb-6 text-sky-700">1. Tanque</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="cod_tanque" class="block font-semibold mb-1 text-gray-700">Seleccionar Tanque</label>
                        <div class="relative">
                            <select id="cod_tanque" name="cod_tanque" disabled
                                class="select-custom w-full p-3 border border-gray-300 rounded-xl appearance-none pr-10 cursor-pointer bg-gray-50
                                    focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200">
                                <option value="">Seleccione primero un zoocriadero</option>
                            </select>
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">▼</span>
                        </div>
                    </div>
                </div>

                <div id="selectedTanqueCard" class="mt-6">
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl hover:translate-y-[-5px]">
                <h2 class="text-2xl font-bold mb-6 text-sky-700">2. Estado Físico-químico y Biológico</h2>

                <h3 class="text-xl font-semibold mb-4 text-sky-800 border-b pb-2">Parámetros del Agua</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div>
                        <label for="ph" class="block font-semibold mb-1 text-gray-700">pH</label>
                        <input type="number" step="0.1" id="ph" name="ph" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Ej: 7" required>
                    </div>
                    <div>
                        <label for="temperatura" class="block font-semibold mb-1 text-gray-700">Temperatura (°T)</label>
                        <input type="number" step="0.1" id="temperatura" name="temperatura" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Ej: 28" required>
                    </div>
                    <div>
                        <label for="cloro" class="block font-semibold mb-1 text-gray-700">Cloro (mg/L)</label>
                        <input type="number" step="0.01" id="cloro" name="cloro" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Ej: 5">
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-4 text-sky-800 border-b pb-2">Registro Biológico</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="alevines_nacimiento" class="block font-semibold mb-1 text-gray-700">Número de Alevines (Nacimientos)</label>
                        <input type="number" id="alevines_nacimiento" name="alevines_nacimiento" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Cantidad de alevines nuevos">
                    </div>
                    <div>
                        <label for="muerte_hembras" class="block font-semibold mb-1 text-gray-700">Número de Muertes Hembras</label>
                        <input type="number" id="muerte_hembras" name="muerte_hembras" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Número de hembras">
                    </div>
                    <div>
                        <label for="muerte_machos" class="block font-semibold mb-1 text-gray-700">Número de Muertes Machos</label>
                        <input type="number" id="muerte_machos" name="muerte_machos" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Número de machos">
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl hover:translate-y-[-5px]">
                <h2 class="text-2xl font-bold mb-6 text-sky-700">3. Actividades de Mantenimiento</h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="maintenanceActivities">

                    <!--Actividades-->

                </div>

            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl hover:translate-y-[-5px]">
                <h2 class="text-2xl font-bold mb-6 text-sky-700">4. Detalles Adicionales y Operario</h2>
                <div class="space-y-6">
                    <div>
                        <label for="observaciones" class="block font-semibold mb-1 text-gray-700">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="w-full p-3 border border-gray-300 rounded-xl h-32 focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Notas importantes sobre el seguimiento..."></textarea>
                    </div>

                    <div>
                        <label for="operario" class="block font-semibold mb-1 text-gray-700">Operario responsable</label>
                        <div class="relative">
                            <select id="selectOperario" name="operario"
                                class="w-full p-3 border border-gray-300 rounded-xl appearance-none pr-10 cursor-pointer
                                    focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200">
                                <option value="">Seleccione operario</option>
                                <!--Operarios-->
                            </select>
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">▼</span>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full cursor-pointer bg-sky-600 hover:bg-sky-700 text-white py-4 rounded-xl text-xl font-bold 
                                         transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.01]">
                Guardar Seguimiento
            </button>
        </form>
    </div>

    <script src="../../../src/js/iziToast.min.js"></script>
    <script src="../../../src/js/segzoo-registrar.js"></script>

    <script>
        document.querySelectorAll('.select-custom').forEach(select => {
            select.addEventListener('focus', () => {
                const icon = select.nextElementSibling;
                if (icon) icon.style.transform = 'translateY(-50%) rotate(180deg)';
            });
            select.addEventListener('blur', () => {
                const icon = select.nextElementSibling;
                if (icon) icon.style.transform = 'translateY(-50%) rotate(0deg)';
            });
        });
    </script>
</body>

</html>