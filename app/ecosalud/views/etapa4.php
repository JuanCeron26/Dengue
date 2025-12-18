<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 4</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">
    <link rel="stylesheet" href="../../../src/css/territorioo.css">

    <style>
        /* ============================= */
        /* ANIMACIONES BASE */
        /* ============================= */

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* ============================= */
        /* CLASES DE ANIMACIÓN */
        /* ============================= */

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        .section-content {
            animation: slideIn 0.4s ease-out;
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* ============================= */
        /* COMPONENTES INTERACTIVOS */
        /* ============================= */

        .menu-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-item:hover {
            transform: translateX(8px);
        }

        .stage-indicator {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stage-indicator:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .content-card {
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-2px);
            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* ============================= */
        /* TARJETAS Y SOMBRAS */
        /* ============================= */

        .card-shadow {
            box-shadow: 0 20px 60px rgba(5, 150, 105, 0.15);
        }

        /* ============================= */
        /* PARTICIPANTES */
        /* ============================= */

        .participante-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .participante-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(5, 150, 105, 0.2);
        }

        .participante-card.presente {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid #10b981;
        }

        .participante-card.ausente {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
        }

        /* ============================= */
        /* PROGRESS RING SVG */
        /* ============================= */

        .progress-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
</head>

<body class="bg-linear-to-br from-gray-50 to-gray-100 min-h-screen">

    <!-- Barra de Progreso de Etapas -->
    <div class="bg-white shadow-lg border-b-4 border-indigo-500 sticky top-0 z-40">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between max-w-4xl mx-auto">

                <!-- Etapa 1 - COMPLETADA -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-green-500 text-white flex items-center justify-center text-xl font-bold shadow-lg">
                        ✓
                    </div>
                    <span class="mt-2 text-sm font-medium text-green-600">Etapa 1</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-green-500 mx-4 rounded-full"></div>

                <!-- Etapa 2 - COMPLETADA -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-green-500 text-white flex items-center justify-center text-xl font-bold shadow-lg">
                        ✓
                    </div>
                    <span class="mt-2 text-sm font-medium text-green-600">Etapa 2</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-green-500 mx-4 rounded-full"></div>

                <!-- Etapa 3 - COMPLETADA -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-green-500 text-white flex items-center justify-center text-xl font-bold shadow-lg">
                        ✓
                    </div>
                    <span class="mt-2 text-sm font-medium text-green-600">Etapa 3</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-gradient-to-r from-green-500 to-indigo-500 mx-4 rounded-full"></div>

                <!-- Etapa 4 - ACTIVA -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center text-xl font-bold shadow-lg ring-4 ring-indigo-200">
                        4
                    </div>
                    <span class="mt-2 text-sm font-semibold text-indigo-600">Etapa 4</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-gray-300 mx-4 rounded-full"></div>

                <!-- Etapa 5 - PENDIENTE -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer opacity-60 hover:opacity-100">
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-xl font-bold shadow-md">
                        5
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Etapa 5</span>
                </div>

            </div>
        </div>
    </div>

    <div class="flex">
        <!-- Menú Lateral (Aside) -->
        <aside class="w-72 bg-white shadow-2xl min-h-screen sticky top-32 self-start">
            <div class="p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    ACTIVIDADES
                </h3>

                <nav class="space-y-3">
                    <!-- ACTIVIDAD 1 -->
                    <div class="actividad-group">
                        <button class="actividad-toggle w-full text-left px-4 py-3 rounded-lg bg-gradient-to-r from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 cursor-pointer flex items-center justify-between group transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md">

                                </div>
                                <span class="font-bold text-gray-800">ACTIVIDADES</span>
                            </div>
                            <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="tareas-container hidden mt-2 ml-4 space-y-1 transition-all ease-in-out">
                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-indigo-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="1">
                                <div class="w-2 h-2 rounded-full bg-indigo-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-indigo-600 transition-colors text-sm">Asistencia</span>
                            </button>

                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-indigo-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="2">
                                <div class="w-2 h-2 rounded-full bg-indigo-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-indigo-600 transition-colors text-sm">Encuesta de satisfacción</span>
                            </button>
                        </div>
                    </div>

                </nav>
            </div>

            <!-- BOTÓN SIGUIENTE ETAPA -->
            <div class="mt-10 flex justify-center" id="btnSiguienteEtp">
                <button
                    class="group w-[85%] relative overflow-hidden
                px-6 py-4 rounded-2xl
                bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700
                text-white font-extrabold text-sm tracking-wider
                shadow-xl shadow-indigo-500/40
                cursor-pointer
                transition-all duration-300 ease-out
                hover:scale-[1.03] hover:-translate-y-1
                hover:shadow-2xl hover:shadow-indigo-600/60
                active:scale-95">

                    <!-- Efecto brillo -->
                    <span
                        class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100
                transition-opacity duration-300 rounded-2xl">
                    </span>

                    <!-- Contenido -->
                    <span class="relative z-10 flex items-center justify-center gap-3">
                        <span class="text-lg"></span>
                        SIGUIENTE ETAPA
                        <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </button>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="max-w-6xl mx-auto">
                <!-- SECCIÓN 1 -->
                <div id="seccion1" class="section-container section-content">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-indigo-500">

                        <!-- AQUÍ TUS COMPAÑERAS PEGAN SU HTML -->
                        <div class="max-w-7xl mx-auto p-4 lg:p-8">

                            <!-- Header con información de la actividad -->
                            <div class="bg-white rounded-3xl p-8 mb-8 card-shadow animate-fade-in-up">
                                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                    <div class="flex items-center gap-6">
                                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg floating">
                                            <i class="bi bi-calendar-check text-white text-4xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Control de Asistencia</p>
                                            <h1 class="text-3xl font-bold text-gray-800 mb-2">Actividad Ecosalud</h1>
                                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                                <span class="flex items-center gap-1">
                                                    <i class="bi bi-geo-alt-fill text-emerald-600"></i>
                                                    Territorio: <strong id="nombreTerritorio">Seleccione...</strong>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="bi bi-calendar3 text-emerald-600"></i>
                                                    <strong id="fechaActual"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selector de Territorio y Actividad -->
                                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border-2 border-emerald-200">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-xs font-bold text-emerald-700 mb-2 block">TERRITORIO</label>
                                                <select id="selectTerritorio" class="w-full px-4 py-2 rounded-xl border-2 border-emerald-300 focus:border-emerald-500 focus:ring-0 text-sm font-semibold">
                                                    <option value="">Seleccione territorio</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-emerald-700 mb-2 block">ACTIVIDAD</label>
                                                <select id="selectActividad" class="w-full px-4 py-2 rounded-xl border-2 border-emerald-300 focus:border-emerald-500 focus:ring-0 text-sm font-semibold">
                                                    <option value="">Seleccione actividad</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel de estadísticas circulares -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <div class="bg-white rounded-2xl p-6 card-shadow animate-fade-in-up" style="animation-delay: 0.1s">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Total</p>
                                            <p id="totalParticipantes" class="text-4xl font-bold text-gray-800">0</p>
                                            <p class="text-xs text-gray-400 mt-1">Participantes</p>
                                        </div>
                                        <div class="relative w-20 h-20">
                                            <svg class="w-20 h-20">
                                                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="8" />
                                                <circle id="circleTotal" cx="40" cy="40" r="36" fill="none" stroke="#3b82f6" stroke-width="8" stroke-dasharray="226" stroke-dashoffset="0" class="progress-ring" />
                                            </svg>
                                            <i class="bi bi-people-fill text-blue-500 text-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl p-6 card-shadow animate-fade-in-up" style="animation-delay: 0.2s">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Presentes</p>
                                            <p id="totalPresentes" class="text-4xl font-bold text-green-600">0</p>
                                            <p id="porcentajePresentes" class="text-xs text-gray-400 mt-1">0%</p>
                                        </div>
                                        <div class="relative w-20 h-20">
                                            <svg class="w-20 h-20">
                                                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="8" />
                                                <circle id="circlePresentes" cx="40" cy="40" r="36" fill="none" stroke="#10b981" stroke-width="8" stroke-dasharray="226" stroke-dashoffset="226" class="progress-ring" />
                                            </svg>
                                            <i class="bi bi-check-circle-fill text-green-500 text-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl p-6 card-shadow animate-fade-in-up" style="animation-delay: 0.3s">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Ausentes</p>
                                            <p id="totalAusentes" class="text-4xl font-bold text-red-600">0</p>
                                            <p id="porcentajeAusentes" class="text-xs text-gray-400 mt-1">0%</p>
                                        </div>
                                        <div class="relative w-20 h-20">
                                            <svg class="w-20 h-20">
                                                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="8" />
                                                <circle id="circleAusentes" cx="40" cy="40" r="36" fill="none" stroke="#ef4444" stroke-width="8" stroke-dasharray="226" stroke-dashoffset="226" class="progress-ring" />
                                            </svg>
                                            <i class="bi bi-x-circle-fill text-red-500 text-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lista de participantes con tarjetas -->
                            <div class="bg-white rounded-3xl p-8 card-shadow animate-fade-in-up" style="animation-delay: 0.4s">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                                        <i class="bi bi-list-check text-emerald-600"></i>
                                        Lista de Participantes
                                    </h2>
                                    <button id="btnMarcaTodos" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg hover:shadow-xl">
                                        <i class="bi bi-check-all"></i> Marcar Todos
                                    </button>
                                </div>

                                <div id="listaParticipantes" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <!-- Las tarjetas se generarán aquí -->
                                </div>

                                <div id="mensajeVacio" class="hidden text-center py-12">
                                    <div class="inline-block bg-gray-100 rounded-full p-6 mb-4">
                                        <i class="bi bi-inbox text-gray-400 text-5xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg font-semibold">No hay participantes para mostrar</p>
                                    <p class="text-gray-400 text-sm mt-2">Seleccione un territorio y actividad</p>
                                </div>
                            </div>

                            <!-- Botón de guardar flotante -->
                            <div id="btnGuardarContainer" class="hidden fixed bottom-8 right-8 z-50">
                                <button id="btnGuardarAsistencia" class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all flex items-center gap-3">
                                    <i class="bi bi-save-fill text-2xl"></i>
                                    <span>Guardar Asistencia</span>
                                </button>
                            </div>

                        </div>
                        <!-- FIN ÁREA DE CONTENIDO -->
                    </div>
                </div>

                <!-- SECCIÓN 2 -->
                <div id="seccion2" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-orange-500">

                        <!-- CONTENIDO DE TU COMPAÑERA -->
                        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-2">

                            <!-- Botón Actividad -->
                            <a
                                id="btnEncuesta2"
                                href="../../ENCUESTAS/front/sastifacionactividad.php"
                                target="_blank"
                                class="cursor-pointer group relative inline-flex items-center justify-center
                                    px-8 py-4 text-lg font-semibold text-white
                                    rounded-2xl
                                    bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500
                                    shadow-lg shadow-teal-500/40
                                    transition-all duration-300
                                    hover:scale-105 hover:shadow-xl hover:shadow-teal-500/60
                                    active:scale-95">
                                <span class="absolute inset-0 rounded-2xl bg-white/10 opacity-0 group-hover:opacity-100 transition"></span>
                                ⚡ Actividad
                            </a>

                        </div>
                        <!-- FIN CONTENIDO DE TU COMPAÑERA -->

                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../../../src/js/etapa3.js"></script>
    <script>
        const btnSigEtapa = document.getElementById('btnSiguienteEtp')
        btnSigEtapa.addEventListener('click', () => {
            window.location.href = 'etapa5.php'
        })
    </script>

</body>

</html>