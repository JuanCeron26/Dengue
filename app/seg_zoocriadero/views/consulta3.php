<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>ZooMonitor Pro — Seguimientos</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">
    <script defer src="../../../src/js/segzoo-consultar.js"></script>

    <style>
        /* Mejor select */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath fill='%23038CDA' d='M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* TARJETA REINVENTADA */
        .card-elegant {
            @apply bg-gradient-to-br from-white to-sky-50 rounded-2xl border border-slate-200 shadow-lg hover:shadow-2xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 hover:rotate-[0.3deg];
        }

        /* Botones iconos */
        .action-button {
            @apply p-2 rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-200 hover:text-sky-800 transition-all duration-300 shadow-sm;
        }

        /* Panel lateral de edición */
        #panelEditar {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #panelEditar.hidden-panel {
            transform: translateX(100%);
        }

        #panelEditar.visible-panel {
            transform: translateX(0);
        }

        /* Overlay oscuro */
        #overlay {
            transition: opacity 0.3s ease-in-out;
        }

        #overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Animación suave para el contenido */
        .content-wrapper {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        }

        .content-wrapper.shifted {
            transform: translateX(-50px);
            opacity: 0.6;
        }

        /* Scroll suave en el panel */
        #panelEditar {
            scrollbar-width: thin;
            scrollbar-color: #0ea5e9 #f0f9ff;
        }

        #panelEditar::-webkit-scrollbar {
            width: 8px;
        }

        #panelEditar::-webkit-scrollbar-track {
            background: #f0f9ff;
        }

        #panelEditar::-webkit-scrollbar-thumb {
            background: #0ea5e9;
            border-radius: 4px;
        }

        /* Animaciones para el modal */
        #modalDetalle.show {
            opacity: 1;
            visibility: visible;
        }

        #modalDetalle.show #modalContent {
            transform: scale(1);
        }

        /* Scroll personalizado */
        #modalContent {
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        #modalContent .overflow-y-auto {
            min-height: 0;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }

        #modalDetalle {
            -webkit-overflow-scrolling: touch;
            position: fixed;
            z-index: 99999 !important;
        }
    </style>
</head>

<body class="min-h-screen bg-sky-100 font-sans text-slate-700 antialiased overflow-x-hidden">

    <!-- Overlay oscuro -->
    <div id="overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden"></div>

    <!-- Panel lateral de edición (oculto por defecto) -->
    <aside id="panelEditar" class="fixed top-0 right-0 h-screen w-full md:w-[600px] bg-white shadow-2xl z-50 overflow-y-auto hidden-panel">

        <!-- Header del panel -->
        <div class="sticky top-0 bg-linear-to-r from-sky-600 to-sky-700 text-white px-6 py-4 flex items-center justify-between shadow-lg z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Editar Seguimiento</h2>
                    <p class="text-xs text-sky-100">Modifica los datos del registro</p>
                </div>
            </div>
            <button id="btnX" class="cursor-pointer w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all duration-300 hover:rotate-90">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Contenido del formulario -->
        <form id="formEditarSeguimiento" class="p-6 space-y-6">
            <input type="hidden" name="cod_segzooact" id="cod_segzooact">
            <input type="hidden" name="cod_segzoo" id="cod_segzoo">

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
                        <input type="number" step="0.1" id="ph" name="ph" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Ej: 7.2" required>
                    </div>
                    <div>
                        <label for="temperatura" class="block font-semibold mb-1 text-gray-700">Temperatura (°T)</label>
                        <input type="number" step="0.1" id="temperatura" name="temperatura" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Ej: 28.5" required>
                    </div>
                    <div>
                        <label for="cloro" class="block font-semibold mb-1 text-gray-700">Cloro (mg/L)</label>
                        <input type="number" step="0.01" id="cloro" name="cloro" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-sky-300 transition duration-200" placeholder="Ej: 0.05">
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

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="maintenanceActivities">

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

            <!-- Botones -->
            <div class="flex gap-3 sticky bottom-0 bg-white pt-4 border-t-2 border-sky-100">
                <button type="button" id="btnCancelarForm" class="cursor-pointer flex-1 py-3 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-xl transition-all duration-300 hover:scale-105">
                    Cancelar
                </button>
                <button type="submit" class="cursor-pointer flex-1 py-3 px-4 bg-linear-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white font-bold rounded-xl transition-all duration-300 hover:scale-105 shadow-lg">
                    Guardar Cambios
                </button>
            </div>

        </form>

    </aside>

    <!-- Contenido principal (wrapper para animación) -->
    <div id="contentWrapper" class="content-wrapper">

        <!-- encabezado -->
        <header class="bg-white/90 border-b border-sky-200 backdrop-blur-md sticky top-0 z-10 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center gap-6">

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-600 flex items-center justify-center shadow-lg text-white transform transition hover:scale-110">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2.5C7.31 2.5 3.5 6.31 3.5 11c0 4.69 3.81 8.5 8.5 8.5s8.5-3.81 8.5-8.5S16.69 2.5 12 2.5z"
                                stroke="white" stroke-width="1.6" />
                            <path d="M9.5 12.5l1.8 1.8L15 10.6" stroke="white" stroke-width="1.8" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-sky-900">ZooMonitor Pro</div>
                        <div class="text-xs text-slate-500">Consulta de seguimientos</div>
                    </div>
                </div>

                <div class="ml-auto">
                    <div class="rounded-full bg-sky-100 py-1.5 px-3 text-sm text-sky-700 font-semibold border border-sky-300">
                        Usuario: <strong class="ml-1">JuanCeron26</strong>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10 grid grid-cols-12 gap-6 lg:gap-8">

            <!-- ASIDE -->
            <aside class="col-span-12 lg:col-span-3 bg-white border-2 border-gray-400 rounded-2xl">
                <div class="card-elegant p-6 sticky top-20">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <path d="M4 6h16M6 12h12M10 18h4" stroke="currentColor" stroke-width="1.8" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-sky-900">Filtros</h3>
                            <p class="text-xs text-slate-500">Escoge alguna opcion</p>
                        </div>
                    </div>

                    <hr class="my-5 border-sky-200">

                    <div class="space-y-5">

                        <div>
                            <h4 class="font-semibold text-sky-800 mb-1 text-sm">Zoocriadero</h4>
                            <select id="filtroZoocriaderos" class="form-select w-full border border-sky-300 rounded-xl p-3 bg-white text-sm font-medium shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-300 ease-out">
                                <option>Todos los zoocriaderos</option>
                            </select>
                        </div>

                        <div>
                            <h4 class="font-semibold text-sky-800 mb-1 text-sm">Tipo de Tanque</h4>
                            <select class="form-select w-full border border-sky-300 rounded-xl p-3 bg-white text-sm font-medium shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-300 ease-out">
                                <option>Todos los tipos</option>
                            </select>
                        </div>

                        <div>
                            <h4 class="font-semibold text-sky-800 mb-1 text-sm">Quién Realizó</h4>
                            <select class="form-select w-full border border-sky-300 rounded-xl p-3 bg-white text-sm font-medium shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-300 ease-out">
                                <option>Todos los técnicos</option>
                            </select>
                        </div>

                    </div>

                </div>
            </aside>

            <!-- CONTENIDO -->
            <section class="col-span-12 lg:col-span-9">

                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-black text-sky-900">Seguimientos Registrados</h1>
                        <p class="text-slate-600 mt-1">5 registros encontrados</p>
                    </div>
                </div>

                <!-- TARJETAS -->
                <div id="divSeguimientos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                </div>

            </section>
        </main>

    </div>

    <div id="modalDetalle"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100]
             hidden items-center justify-center p-4">

        <div id="modalContent"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-xl 
                max-h-[90vh] flex flex-col overflow-hidden 
                text-sm transform transition-all duration-200 scale-95 opacity-0">

            <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-4 py-3 
                    flex items-center justify-between sticky top-0 z-10 shadow-md">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                            5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Detalle del Seguimiento</h2>
                        <p class="text-xs text-sky-100">Información completa</p>
                    </div>
                </div>

                <button id="btnCerrarModal"
                    class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all hover:rotate-90">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto flex-1 p-4 space-y-4" style="min-height: 0;">

                <div class="bg-sky-50 rounded-lg p-3 border border-sky-200">
                    <h3 class="text-sm font-bold text-sky-900 mb-2">Información General</h3>

                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-xs text-sky-600 font-semibold">Fecha</p>
                            <p id="detalle_fecha" class="font-bold text-sky-900 text-base">--</p>
                        </div>
                        <div>
                            <p class="text-xs text-purple-600 font-semibold">Operario</p>
                            <p id="detalle_operario" class="font-bold text-purple-900 text-base">--</p>
                        </div>
                        <div>
                            <p class="text-xs text-green-600 font-semibold">Zoocriadero</p>
                            <p id="detalle_zoocriadero" class="font-bold text-green-900 text-base">--</p>
                        </div>
                        <div>
                            <p class="text-xs text-orange-600 font-semibold">Tanque</p>
                            <p id="detalle_tanque" class="font-bold text-orange-900 text-base">--</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                    <h3 class="text-sm font-bold text-blue-900 mb-2">Parámetros del Agua</h3>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-blue-100 rounded p-3 text-center border border-blue-300">
                            <p class="text-xs font-bold text-blue-700">pH</p>
                            <p id="detalle_ph" class="text-2xl font-black text-blue-900">--</p>
                        </div>
                        <div class="bg-orange-100 rounded p-3 text-center border border-orange-300">
                            <p class="text-xs font-bold text-orange-700">Temp</p>
                            <p id="detalle_temperatura" class="text-2xl font-black text-orange-900">--</p>
                        </div>
                        <div class="bg-teal-100 rounded p-3 text-center border border-teal-300">
                            <p class="text-xs font-bold text-teal-700">Cloro</p>
                            <p id="detalle_cloro" class="text-2xl font-black text-teal-900">--</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                    <h3 class="text-sm font-bold text-green-900 mb-2">Registro Biológico</h3>

                    <div class="grid grid-cols-3 gap-3 text-sm">
                        <div class="bg-green-100 rounded p-3 text-center border border-green-200">
                            <p class="text-xl mb-1">🐟</p>
                            <p class="text-xs text-green-600 font-semibold">Alevines</p>
                            <p id="detalle_alevines" class="text-xl font-black text-green-900">--</p>
                        </div>
                        <div class="bg-pink-100 rounded p-3 text-center border border-pink-200">
                            <p class="text-xl mb-1">♀️</p>
                            <p class="text-xs text-pink-600 font-semibold">Hembras †</p>
                            <p id="detalle_muerte_hembras" class="text-xl font-black text-pink-900">--</p>
                        </div>
                        <div class="bg-blue-100 rounded p-3 text-center border border-blue-200">
                            <p class="text-xl mb-1">♂️</p>
                            <p class="text-xs text-blue-600 font-semibold">Machos †</p>
                            <p id="detalle_muerte_machos" class="text-xl font-black text-blue-900">--</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-lg p-3 border border-purple-200">
                    <h3 class="text-sm font-bold text-purple-900 mb-2">Actividades Realizadas</h3>
                    <div id="detalle_actividades" class="space-y-1 text-sm"></div>
                </div>

                <div class="bg-amber-50 rounded-lg p-3 border border-amber-200">
                    <h3 class="text-sm font-bold text-amber-900 mb-1">Observaciones</h3>
                    <p id="detalle_observaciones" class="text-sm text-gray-700 bg-white rounded p-3 border border-amber-200">
                        --
                    </p>
                </div>

            </div>

            <div class="bg-gradient-to-r from-sky-600 to-sky-700 px-4 py-3 rounded-b-2xl flex justify-end sticky bottom-0 z-10 shadow-md">
                <button id="btnCerrarModalFooter" class="px-5 py-2 bg-white/20 hover:bg-white/30 text-white font-bold rounded text-sm">
                    Cerrar
                </button>
            </div>

        </div>

    </div>


    <script src="../../../src/js/iziToast.min.js"></script>


</body>

</html>