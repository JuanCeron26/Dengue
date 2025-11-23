<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>ZooMonitor Pro — Seguimientos</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">

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
    </style>
</head>

<body class="min-h-screen bg-sky-100 font-sans text-slate-700 antialiased overflow-x-hidden">

    <!-- Overlay oscuro -->
    <div id="overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden"></div>

    <!-- Panel lateral de edición (oculto por defecto) -->
    <aside id="panelEditar" class="fixed top-0 right-0 h-screen w-full md:w-[600px] bg-white shadow-2xl z-50 overflow-y-auto hidden-panel">

        <!-- Header del panel -->
        <div class="sticky top-0 bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4 flex items-center justify-between shadow-lg z-10">
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
            <button onclick="cerrarPanel()" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all duration-300 hover:rotate-90">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Contenido del formulario -->
        <form id="formEditarSeguimiento" class="p-6 space-y-6">

            <!-- Info del seguimiento -->
            <div class="bg-sky-50 border-l-4 border-sky-500 p-4 rounded-r-xl">
                <p class="text-sm text-sky-900"><strong>ID:</strong> <span id="editCodigo">12</span></p>
                <p class="text-sm text-sky-900"><strong>Fecha original:</strong> <span id="editFechaOriginal">20/Nov/2024</span></p>
            </div>

            <!-- Fecha -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-sky-900">Fecha de actividad</label>
                <input type="date" id="editFecha" class="w-full p-3 border-2 border-sky-200 rounded-xl focus:ring-4 focus:ring-sky-300 focus:border-sky-500 transition">
            </div>

            <!-- Parámetros físico-químicos -->
            <div class="border-2 border-sky-200 rounded-xl p-4 space-y-4">
                <h3 class="text-lg font-bold text-sky-900 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Parámetros del Agua
                </h3>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">pH</label>
                        <input type="number" step="0.1" id="editPh" class="w-full p-2 border-2 border-sky-200 rounded-lg focus:ring-2 focus:ring-sky-400 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Temperatura (°C)</label>
                        <input type="number" step="0.1" id="editTemp" class="w-full p-2 border-2 border-sky-200 rounded-lg focus:ring-2 focus:ring-sky-400 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Cloro (mg/L)</label>
                        <input type="number" step="0.01" id="editCloro" class="w-full p-2 border-2 border-sky-200 rounded-lg focus:ring-2 focus:ring-sky-400 focus:border-sky-500">
                    </div>
                </div>
            </div>

            <!-- Datos biológicos -->
            <div class="border-2 border-emerald-200 rounded-xl p-4 space-y-4">
                <h3 class="text-lg font-bold text-emerald-900 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    Datos Biológicos
                </h3>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alevines</label>
                        <input type="number" id="editAlevines" class="w-full p-2 border-2 border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Muertes ♀</label>
                        <input type="number" id="editMuertesH" class="w-full p-2 border-2 border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Muertes ♂</label>
                        <input type="number" id="editMuertesM" class="w-full p-2 border-2 border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-400">
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-sky-900">Observaciones</label>
                <textarea id="editObservaciones" rows="4" class="w-full p-3 border-2 border-sky-200 rounded-xl focus:ring-4 focus:ring-sky-300 focus:border-sky-500 transition resize-none"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex gap-3 sticky bottom-0 bg-white pt-4 border-t-2 border-sky-100">
                <button type="button" onclick="cerrarPanel()" class="flex-1 py-3 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-xl transition-all duration-300 hover:scale-105">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-3 px-4 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white font-bold rounded-xl transition-all duration-300 hover:scale-105 shadow-lg">
                    Guardar Cambios
                </button>
            </div>

        </form>

    </aside>

    <!-- Contenido principal (wrapper para animación) -->
    <div id="contentWrapper" class="content-wrapper">

        <!-- HEADER ORIGINAL -->
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

            <!-- ASIDE CON FILTROS -->
            <aside class="col-span-12 lg:col-span-3 bg-white border-2 border-gray-400 rounded-2xl">
                <div class="card-elegant p-6 sticky top-20">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <path d="M4 6h16M6 12h12M10 18h4" stroke="currentColor" stroke-width="1.8" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-sky-900">Filtros Avanzados</h3>
                            <p class="text-xs text-slate-500">Opciones elegantes</p>
                        </div>
                    </div>

                    <hr class="my-5 border-sky-200">

                    <div class="space-y-5">

                        <div>
                            <h4 class="font-semibold text-sky-800 mb-1 text-sm">Zoocriadero</h4>
                            <select class="form-select w-full border border-sky-300 rounded-xl p-3 bg-white text-sm font-medium shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-300 ease-out">
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

                    <!-- CARD EJEMPLO -->
                    <article class="card-elegant p-5 bg-white border-2 border-sky-500 rounded-2xl">

                        <div class="text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">Control de agua - Lavado - Ajuste nivel del agua</div>

                        <div class="space-y-2 text-sm">

                            <div class="flex justify-between">
                                <span class="text-slate-500 font-medium">Fecha:</span>
                                <span class="text-sky-800 font-bold">19/Nov/2024</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500 font-medium">Zoocriadero:</span>
                                <span class="text-sky-800 font-semibold">Norte (Z-001)</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500 font-medium">Tanque:</span>
                                <span class="text-sky-800 font-semibold">Circular (#1)</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500 font-medium">Realizó:</span>
                                <span class="text-sky-800 font-semibold">Juan Pérez</span>
                            </div>

                        </div>

                        <hr class="my-3 border-sky-200">

                        <!-- Valores -->
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-xl bg-blue-100 p-3 text-center border border-blue-300 shadow-inner">
                                <div class="text-xs uppercase font-bold text-blue-800">pH</div>
                                <div class="text-xl font-black text-blue-900">7.2</div>
                            </div>
                            <div class="rounded-xl bg-orange-100 p-3 text-center border border-orange-300 shadow-inner">
                                <div class="text-xs uppercase font-bold text-orange-800">Temp</div>
                                <div class="text-xl font-black text-orange-900">24°C</div>
                            </div>
                            <div class="rounded-xl bg-teal-100 p-3 text-center border border-teal-300 shadow-inner">
                                <div class="text-xs uppercase font-bold text-teal-800">Cloro</div>
                                <div class="text-xl font-black text-teal-900">0.5</div>
                            </div>
                        </div>

                        <hr class="my-3 border-sky-200">

                        <!-- BOTONES DE ACCIÓN -->
                        <div class="flex justify-center gap-2">
                            <button title="Ver Detalle" class="cursor-pointer action-button p-2 rounded-xl bg-gray-200  hover:bg-gray-300 hover:-translate-y-0.5 transition shadow-sm">
                                <img src="../../../src/icons/icono_eye.png" alt="" class="h-6 w-6">
                            </button>

                            <button title="Editar" onclick="abrirPanelEditar(12)" class="cursor-pointer action-button p-2 rounded-xl bg-purple-200  hover:bg-purple-300 hover:-translate-y-0.5 transition shadow-sm">
                                <img src="../../../src/icons/icono_edit2.png" alt="" class="h-6 w-6">
                            </button>

                            <button title="Eliminar"
                                class="cursor-pointer p-2 rounded-xl bg-red-100 text-red-600 hover:bg-red-200 hover:-translate-y-0.5 transition shadow-sm">
                                <img src="../../../src/icons/icono_delete2.png" alt="" class="h-6 w-6">
                            </button>
                        </div>

                    </article>

                </div>

            </section>
        </main>

    </div>

    <script>
        
        function abrirPanelEditar(codSeguimiento) {
            console.log('Editando seguimiento:', codSeguimiento);

            const panel = document.getElementById('panelEditar');
            const overlay = document.getElementById('overlay');
            const content = document.getElementById('contentWrapper');

            y
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('hidden'), 10);

            // Mostrar panel con animación
            panel.classList.remove('hidden-panel');
            panel.classList.add('visible-panel');

            // Desplazar contenido principal
            content.classList.add('shifted');

            // Prevenir scroll en el body
            document.body.style.overflow = 'hidden';

            // Aquí cargarías los datos del seguimiento
            // fetch(`../backend/api.php?ajax=traer_seguimiento_detalle&id=${codSeguimiento}`)...
        }

        // Cerrar panel
        function cerrarPanel() {
            const panel = document.getElementById('panelEditar');
            const overlay = document.getElementById('overlay');
            const content = document.getElementById('contentWrapper');

            overlay.classList.add('hidden');
            panel.classList.remove('visible-panel');
            panel.classList.add('hidden-panel');
            content.classList.remove('shifted');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') cerrarPanel();
        });

        document.getElementById('overlay').addEventListener('click', cerrarPanel);

        
        document.getElementById('formEditarSeguimiento').addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Guardando cambios...');
            cerrarPanel();
        });
    </script>

    <script src="../../../src/js/segzoo-consultar.js"></script>

</body>

</html>