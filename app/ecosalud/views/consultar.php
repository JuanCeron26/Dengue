<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Territorios - EcoSalud</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            }

            50% {
                box-shadow: 0 0 40px rgba(16, 185, 129, 0.6);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .card-territorio {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 2px solid transparent;
            background-clip: padding-box;
            position: relative;
        }

        .card-territorio::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            padding: 2px;
            background: linear-gradient(135deg, #10b981, #3b82f6, #06b6d4);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card-territorio:hover::before {
            opacity: 1;
        }

        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            background-size: 1000px 100%;
        }

        .card-territorio:hover .shimmer-effect {
            animation: shimmer 2s infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-white via-emerald-50 to-emerald-100 min-h-screen p-8 relative">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-sky-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="mb-12 flex justify-between items-center">
            <div class="float-animation">
                <h1 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-700 via-teal-500 to-blue-600 mb-3 tracking-tight">
                    Territorios EcoSalud
                </h1>
                <p class="text-slate-700 text-xl font-light tracking-wide">Gestión inteligente de eventos territoriales</p>
            </div>
            <button id="btnIniciarEvento" class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-blue-500 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-300 pulse-glow"></div>
                <div class="relative px-10 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl leading-none flex items-center gap-4 transform group-hover:scale-105 transition-all duration-300 cursor-pointer">
                    <i class="fas fa-play-circle text-3xl text-white group-hover:rotate-90 transition-transform duration-500"></i>
                    <span class="text-white font-bold text-xl tracking-wide">INICIAR EVENTO</span>
                </div>
            </button>
        </div>

        <div id="listadoTerritorios" class="space-y-6">
        </div>

        <div id="mensajeVacio" class="hidden text-center py-20">
            <div class="float-animation">
                <i class="fas fa-map-marked-alt text-8xl text-slate-600 mb-6"></i>
                <p class="text-slate-600 text-2xl font-light">No hay territorios registrados</p>
            </div>
        </div>
    </div>

    <div id="modalTerritorio" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 bg-opacity-60 backdrop-blur-sm">
        <div class="modal-container bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-auto transform scale-95 opacity-0 transition-all duration-500">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-blue-600 px-8 py-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-map-marked-alt text-3xl text-black"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-1">Territorio Priorizado</h2>
                            <p class="text-emerald-100 text-sm font-medium">Información completa del territorio</p>
                        </div>
                    </div>
                    <button id="btnCerrarModal" class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl flex items-center justify-center transition-all duration-300 hover:rotate-90 cursor-pointer group">
                        <i class="fas fa-times text-2xl text-black group-hover:scale-110 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- Contenido del modal -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-120px)] custom-scrollbar">
                <!-- Loading state -->
                <div id="modalLoading" class="flex flex-col items-center justify-center py-20">
                    <div class="relative">
                        <div class="w-20 h-20 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin"></div>
                        <i class="fas fa-map-marked-alt absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-2xl text-emerald-600"></i>
                    </div>
                    <p class="text-slate-600 text-lg font-medium mt-6">Cargando información del territorio...</p>
                </div>

                <!-- Contenido principal -->
                <div id="modalContenido" class="hidden space-y-6">
                    <!-- Información del Sitio EcoSalud -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 border-2 border-emerald-200 transform hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-leaf text-white text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-emerald-800">Sitio EcoSalud</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Nombre del Sitio</p>
                                <p id="nombreSitio" class="text-lg font-bold text-slate-800">---</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Código Sitio</p>
                                <p id="codSitio" class="text-lg font-bold text-slate-800">---</p>
                            </div>
                            <div class="col-span-2 bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Dirección</p>
                                <p id="direccionSitio" class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-emerald-600"></i>
                                    <span>---</span>
                                </p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Estado</p>
                                <p id="estadoSitio" class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-100 text-emerald-800 font-bold">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <span>---</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Barrio -->
                    <div class="bg-gradient-to-br from-blue-50 to-sky-50 rounded-2xl p-6 border-2 border-blue-200 transform hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-sky-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-map text-white text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-800">Ubicación</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Barrio</p>
                                <p id="nombreBarrio" class="text-lg font-bold text-slate-800">---</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Código Barrio</p>
                                <p id="codBarrio" class="text-lg font-bold text-slate-800">---</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Líder -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200 transform hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-tie text-white text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-purple-800">Líder del Territorio</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Nombre Completo</p>
                                <p id="nombreLider" class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-user-circle text-purple-600 text-2xl"></i>
                                    <span>---</span>
                                </p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Correo Electrónico</p>
                                <p id="correoLider" class="text-base font-semibold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-envelope text-purple-600"></i>
                                    <span class="break-all">---</span>
                                </p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Celular</p>
                                <p id="celularLider" class="text-base font-semibold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-phone text-purple-600"></i>
                                    <span>---</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Territorio -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border-2 border-amber-200 transform hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-amber-800">Datos del Registro</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Código Territorio</p>
                                <p id="codTerritorio" class="text-lg font-bold text-slate-800">---</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-sm text-slate-500 font-medium mb-1">Fecha de Registro</p>
                                <p id="fechaRegistro" class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-clock text-amber-600"></i>
                                    <span>---</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error state -->
                <div id="modalError" class="hidden flex flex-col items-center justify-center py-20">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-600"></i>
                    </div>
                    <p class="text-slate-800 text-xl font-bold mb-2">Error al cargar la información</p>
                    <p class="text-slate-600 text-base">No se pudo obtener los datos del territorio</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Participantes -->
    <div id="modalParticipantes" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 bg-opacity-60 backdrop-blur-sm">
        <div class="modal-container bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-auto transform scale-95 opacity-0 transition-all duration-500">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 px-8 py-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-black/40 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm animate-pulse">
                            <i class="fas fa-users text-3xl text-black"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-1">Participantes Activos</h2>
                            <p class="text-sky-100 text-sm font-medium">Lista de personas en este territorio</p>
                        </div>
                    </div>
                    <button id="btnCerrarModalParticipantes" class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl flex items-center justify-center transition-all duration-300 hover:rotate-90 cursor-pointer group">
                        <i class="fas fa-times text-2xl text-black group-hover:scale-110 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- Contenido del modal -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-120px)] custom-scrollbar bg-white">
                <!-- Loading state -->
                <div id="modalParticipantesLoading" class="flex flex-col items-center justify-center py-20">
                    <div class="relative">
                        <div class="w-20 h-20 border-4 border-sky-200 border-t-sky-600 rounded-full animate-spin"></div>
                        <i class="fas fa-users absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-2xl text-sky-600"></i>
                    </div>
                    <p class="text-slate-600 text-lg font-medium mt-6">Cargando participantes...</p>
                </div>

                <!-- Contenido principal -->
                <div id="modalParticipantesContenido" class="hidden">
                    <!-- Header con contador -->
                    <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-2xl p-6 mb-6 border-2 border-sky-200 bg-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-sky-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-users text-3xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-slate-600 text-sm font-medium mb-1">Total de Participantes</p>
                                    <p id="totalParticipantes" class="text-4xl font-black text-sky-600">0</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-slate-500 mb-1 font-bold">Territorio</p>
                                <p id="nombreTerritorioParticipantes" class="text-lg font-bold text-slate-800">---</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de participantes -->
                    <div id="listaParticipantes" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Los participantes se cargarán aquí -->
                    </div>

                    <!-- Mensaje si no hay participantes -->
                    <div id="sinParticipantes" class="hidden text-center py-16">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-slash text-5xl text-slate-400"></i>
                        </div>
                        <p class="text-slate-600 text-xl font-bold mb-2">No hay participantes registrados</p>
                        <p class="text-slate-500 text-base">Este territorio aún no tiene personas asignadas</p>
                    </div>
                </div>

                <!-- Error state -->
                <div id="modalParticipantesError" class="hidden flex flex-col items-center justify-center py-20">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-600"></i>
                    </div>
                    <p class="text-slate-800 text-xl font-bold mb-2">Error al cargar participantes</p>
                    <p class="text-slate-600 text-base">No se pudo obtener la información</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../src/js/ecosalud-consultar.js"></script>
</body>

</html>