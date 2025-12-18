<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 1 - Sistema de Gestión</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">
    <link rel="stylesheet" href="../../../src/css/territorioo.css">
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

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

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .slide-in {
            animation: slideIn 0.4s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
        }

        .description-card {
            animation: fadeInUp 0.4s ease-out;
            backdrop-filter: blur(10px);
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -10px rgba(102, 126, 234, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .form-container {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        }

        select,
        input[type="text"] {
            transition: all 0.3s ease;
        }

        select:hover,
        input[type="text"]:hover {
            border-color: #667eea;
        }

        .label-text {
            transition: color 0.3s ease;
        }

        .field-wrapper:hover .label-text {
            color: #667eea;
        }

        .icon-wrapper {
            transition: transform 0.3s ease;
        }

        .field-wrapper:hover .icon-wrapper {
            transform: scale(1.1);
        }

        .delete-btn {
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px -5px rgba(239, 68, 68, 0.4);
        }

        .badge {
            transition: all 0.3s ease;
        }

        .divider-line {
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            height: 2px;
            margin: 1rem 0;
        }

        .section-content {
            animation: slideIn 0.4s ease-out;
        }

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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.7s ease-out;
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

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .card-shadow {
            box-shadow: 0 20px 60px rgba(5, 150, 105, 0.15);
        }

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

        .checkmark-icon {
            animation: checkmark 0.4s ease-out;
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .progress-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .btn-check {
            transition: all 0.3s ease;
        }

        .btn-check:active {
            transform: scale(0.95);
        }

        /* ------------------------------------------- */
        /* Estilos Personalizados */
        /* ------------------------------------------- */

        /* Fondo de la página */
        .page-bg {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        /* Ajuste de ícono dentro del input para inputs de 3.5 padding */
        .input-icon {
            position: absolute;
            left: 12px;
            top: 14px;
            /* 14px centra con py-3.5 */
            color: #059669;
            opacity: 0.8;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-group:focus-within .input-icon {
            color: #047857;
            opacity: 1;
        }
    </style>
</head>

<body class="bg-linear-to-br from-gray-50 to-gray-100 min-h-screen">

    <?php include_once '../../../src/includes/aside-etapas/aside-etapa1.php'; ?>
    <!-- Barra de Progreso de Etapas (REUTILIZABLE) -->


    <div class="bg-white shadow-lg border-b-4 border-indigo-500 sticky top-0 z-40">
        <div class="container mx-auto px-6 py-3">

            <div class="flex items-center justify-between max-w-4xl mx-auto">

                <div class="absolute top-2 left-5">
                    <a href="#" id="btnMenu">
                        <img id="btnMenu2" src="../../../src/icons/ecosalud.png" alt="" class=" h-12 w-12 hover:scale-110 hover:translate-y-2 transition-all ease-in-out duration-300">
                    </a>
                </div>

                <!-- Etapa 1 - ACTIVA -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center text-xl font-bold shadow-lg ring-4 ring-indigo-200">
                        1
                    </div>
                    <span class="mt-2 text-sm font-semibold text-indigo-600">Etapa 1</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-gradient-to-r from-indigo-500 to-gray-300 mx-4 rounded-full"></div>

                <!-- Etapa 2 - PENDIENTE -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer opacity-60 hover:opacity-100">
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-xl font-bold shadow-md">
                        2
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Etapa 2</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-gray-300 mx-4 rounded-full"></div>

                <!-- Etapa 3 - PENDIENTE -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer opacity-60 hover:opacity-100">
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-xl font-bold shadow-md">
                        3
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Etapa 3</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-gray-300 mx-4 rounded-full"></div>

                <!-- Etapa 4 - PENDIENTE -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer opacity-60 hover:opacity-100">
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-xl font-bold shadow-md">
                        4
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Etapa 4</span>
                </div>

                <!-- Línea conectora -->
                <div class="flex-1 h-1 bg-gray-300 mx-4 rounded-full"></div>
                <!-- Etapa 5 - PENDIENTE -->
                <div class="flex flex-col items-center stage-indicator cursor-pointer opacity-60 hover:opacity-100">
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center text-xl font-bold shadow-md">
                        5
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Etapa 4</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor Principal -->
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
                                    1
                                </div>
                                <span class="font-bold text-gray-800">ACTIVIDAD 1</span>
                            </div>
                            <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="tareas-container hidden mt-2 ml-4 space-y-1 transition-all ease-in-out">
                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-indigo-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="1">
                                <div class="w-2 h-2 rounded-full bg-indigo-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-indigo-600 transition-colors text-sm">Territorio Priorizado</span>
                            </button>

                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-indigo-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="2">
                                <div class="w-2 h-2 rounded-full bg-indigo-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-indigo-600 transition-colors text-sm">Focos Potenciales</span>
                            </button>
                        </div>
                    </div>

                    <!-- ACTIVIDAD 2 -->
                    <div class="actividad-group">
                        <button class="actividad-toggle w-full text-left px-4 py-3 rounded-lg bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 cursor-pointer flex items-center justify-between group transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-500 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md">
                                    2
                                </div>
                                <span class="font-bold text-gray-800">ACTIVIDAD 2</span>
                            </div>
                            <svg class="w-5 h-5 text-purple-600 transition-transform duration-300 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="tareas-container hidden mt-2 ml-4 space-y-1">
                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-purple-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="3">
                                <div class="w-2 h-2 rounded-full bg-purple-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-purple-600 transition-colors text-sm">Grupo de Valor</span>
                            </button>

                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-purple-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="4">
                                <div class="w-2 h-2 rounded-full bg-purple-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-purple-600 transition-colors text-sm">PRE-TEST</span>
                            </button>

                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-purple-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="5">
                                <div class="w-2 h-2 rounded-full bg-purple-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-purple-600 transition-colors text-sm">Encuesta Satisfacción</span>
                            </button>

                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-purple-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="6">
                                <div class="w-2 h-2 rounded-full bg-purple-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-purple-600 transition-colors text-sm">Asistencia</span>
                            </button>
                        </div>
                    </div>

                    <!-- ACTIVIDAD 3 -->
                    <div class="actividad-group">
                        <button class="actividad-toggle w-full text-left px-4 py-3 rounded-lg bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 cursor-pointer flex items-center justify-between group transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md">
                                    3
                                </div>
                                <span class="font-bold text-gray-800">ACTIVIDAD 3</span>
                            </div>
                            <svg class="w-5 h-5 text-green-600 transition-transform duration-300 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="tareas-container hidden mt-2 ml-4 space-y-1">
                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-green-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="7">
                                <div class="w-2 h-2 rounded-full bg-green-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-green-600 transition-colors text-sm">Asistencia</span>
                            </button>

                            <button class="btn-seccion menu-item w-full text-left px-4 py-2.5 rounded-lg hover:bg-green-50 cursor-pointer flex items-center group transition-all duration-300" data-seccion="8">
                                <div class="w-2 h-2 rounded-full bg-green-400 mr-3 group-hover:scale-125 transition-transform"></div>
                                <span class="font-medium text-gray-700 group-hover:text-green-600 transition-colors text-sm">Focos Participantes</span>
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

        <!-- Área de Contenido Principal -->
        <main class="flex-1 p-8">
            <div class="max-w-6xl mx-auto">

                <!-- SECCIÓN 1 -->
                <div id="seccion1" class="section-container section-content">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-indigo-500">

                        <!-- AQUÍ TUS COMPAÑERAS PEGAN SU HTML -->
                        <div class="content-area w-full max-w-7xl glass p-8 shadow-2xl rounded-3xl" style="animation: scaleIn 0.3s ease-out;">
                            <div class="flex justify-between items-center mb-6">
                                <h2 id="modalCrearTitle" class="text-3xl font-bold text-[var(--color-primary)] flex items-center gap-3">
                                    <i class="fas fa-user-plus"></i> Asociar Líder a Territorio
                                </h2>
                                <button id="closeCrear" class="text-3xl text-slate-600 hover:text-[var(--color-primary)] hover:scale-125 hover:rotate-90 transition-all duration-300">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="mb-6 flex gap-4">
                                <button type="button" id="btnModoNuevo" class="flex-1 px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                                    <i class="fas fa-user-plus"></i> Registrar Nuevo Líder
                                </button>
                                <button type="button" id="btnModoExistente" class="flex-1 px-6 py-3 glass-dark border-2 border-[var(--color-border)] rounded-xl font-semibold text-slate-700 hover:border-[var(--color-tertiary)] transition-colors">
                                    <i class="fas fa-users"></i> Asociar Líder Existente
                                </button>
                            </div>

                            <form id="formLider">
                                <div id="formNuevo" class="grid grid-cols-2 gap-5">
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Nombre *
                                        </label>
                                        <input id="inNombre" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" autocomplete="given-name" />
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Apellido *
                                        </label>
                                        <input id="inApellido" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" autocomplete="family-name" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-id-card"></i> Cédula *
                                        </label>
                                        <input
                                            type="text"
                                            id="inCedula"
                                            placeholder="Ingresa la cédula"
                                            maxlength="10"
                                            required
                                            class="w-full p-3 border-2 border-gray-300 rounded-xl focus:border-[#7DD3C0] focus:outline-none">
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                            <i class="fas fa-envelope text-[var(--color-tertiary)]"></i> Correo
                                        </label>
                                        <input id="inCorreo" type="email" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                            <i class="fas fa-phone text-[var(--color-tertiary)]"></i> Celular
                                        </label>
                                        <input id="inCelular" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" inputmode="numeric" />
                                    </div>

                                    <div class="col-span-2">
                                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                            <i class="fas fa-crown text-[var(--color-tertiary)]"></i> Clase de liderazgo
                                        </label>
                                        <input id="inClase" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                                    </div>
                                </div>

                                <div id="formExistente" class="hidden">
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Seleccionar Líder *
                                        </label>
                                        <select id="inLiderExistente" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                                            <option value="">Selecciona un líder</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                                        <i class="fas fa-globe text-[var(--color-tertiary)]"></i> Territorio *
                                    </label>
                                    <select id="inTerritorio" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                                        <option value="">Selecciona sitio</option>
                                    </select>
                                </div>

                                <div class="flex justify-between mt-6 gap-4">
                                    <button type="button" id="btnCancelarCrear" class="px-8 py-3 glass-dark border-2 border-red-300 rounded-xl font-bold text-red-600 hover:bg-red-50 hover:scale-105 transition-transform">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                    <button type="submit" id="btnGuardarLider" class="px-8 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- FIN ÁREA DE CONTENIDO -->
                    </div>
                </div>

                <!-- SECCIÓN 2 -->
                <div id="seccion2" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-purple-500">
                        <div class="container mx-auto px-4">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto">

                                <!-- Registrar -->
                                <div class="w-full">
                                    <!-- Header -->
                                    <div class="text-center mb-10 fade-in-up">
                                        <h1 class="text-4xl font-bold text-slate-800 mb-2">
                                            Registralos
                                        </h1>
                                        <p class="text-slate-600">Complete la información del foco identificado</p>
                                        <div class="w-24 h-1 bg-linear-to-r from-purple-500 to-blue-500 mx-auto mt-4 rounded-full"></div>
                                    </div>

                                    <!-- Form Container -->
                                    <div class="form-container rounded-2xl shadow-2xl p-8 backdrop-blur-sm slide-in">
                                        <form action="" method="post" class="space-y-8" id="formRegistrarFoco">
                                            <input type="hidden" name="foco_cod_territorio" id="foco_cod_territorio" value="">
                                            <input type="hidden" id="modoEdicion" value="0">
                                            <input type="hidden" id="focoIdEditar" value="">
                                            <!-- Realizó Field -->
                                            <div class="field-wrapper">
                                                <label class="label-text flex items-center gap-2 text-sm font-semibold text-slate-700 mb-3">
                                                    <span class="icon-wrapper">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </span>
                                                    Direccion
                                                </label>
                                                <!--
                                                <select name="realizo" id="selectRealizo"
                                                    class="input-focus w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white shadow-sm">
                                                    <option value="">Seleccione quien realizó...</option>
                                                </select>-->

                                            </div>

                                            <!-- Dirección Section -->
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

                                            <!-- Tipo de Foco Section -->
                                            <div class="field-wrapper">
                                                <label class="label-text flex items-center gap-2 text-sm font-semibold text-slate-700 mb-3">
                                                    <span class="icon-wrapper">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                        </svg>
                                                    </span>
                                                    Tipo de Foco
                                                </label>
                                                <select name="cod_tipo_foc" id="selectTipoFoco" required
                                                    class="input-focus w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white shadow-sm">
                                                    <option value="">Seleccione el tipo de foco...</option>
                                                </select>

                                                <div id="focoDescription" class="hidden mt-4 p-5 bg-linear-to-br from-purple-50 to-blue-50 border-2 border-purple-200 rounded-xl description-card">
                                                    <div class="flex items-start gap-3">
                                                        <svg class="w-6 h-6 text-purple-600 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <div>
                                                            <h3 class="font-semibold text-purple-900 mb-1">Descripción del Foco</h3>
                                                            <p id="focoDescriptionText" class="text-slate-700 text-sm leading-relaxed"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Lugar Field -->
                                            <div class="field-wrapper">
                                                <label class="label-text flex items-center gap-2 text-sm font-semibold text-slate-700 mb-3">
                                                    <span class="icon-wrapper">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                    </span>
                                                    Lugar Específico
                                                </label>
                                                <input type="text" name="lugar" required
                                                    class="input-focus w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white shadow-sm"
                                                    placeholder="Ingrese el lugar específico del foco...">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="pt-4">
                                                <button type="submit" id="btnTexto"
                                                    class="cursor-pointer submit-btn w-full py-4 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-purple-300">
                                                    <span class="flex items-center justify-center gap-2">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Registrar Foco Potencial
                                                    </span>
                                                </button>
                                                <br><br>

                                                <button type="button" id="btnCancelarEdicion" class="cursor-pointer hidden w-full py-3 bg-gray-300 hover:bg-gray-400 rounded-xl font-semibold transition-all">
                                                    Cancelar Edición
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="text-center mt-8 text-slate-600 text-sm fade-in-up">
                                        <p>Todos los campos son obligatorios</p>
                                    </div>
                                </div>

                                <!-- Focos registrados -->
                                <div class="w-full">
                                    <div class="text-center mb-10 fade-in-up">
                                        <h2 class="text-4xl font-bold text-slate-800 mb-2">
                                            Focos Registrados
                                        </h2>
                                        <p class="text-slate-600">Lista de focos potenciales identificados</p>
                                        <div class="w-24 h-1 bg-linear-to-r from-blue-500 to-purple-500 mx-auto mt-4 rounded-full"></div>
                                    </div>

                                    <!-- Focos Container -->
                                    <div class="space-y-6 slide-in-right" id="containerFocosActuales">

                                        <!--Focos-->

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3 -->
                <div id="seccion3" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-green-500">

                        <!-- AQUÍ TUS COMPAÑERAS PEGAN SU HTML -->
                        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in">

                            <header class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-8 text-center sm:py-10 shadow-lg">
                                <div class="bg-white/30 backdrop-blur-sm rounded-full w-16 h-16 mx-auto mb-3 flex items-center justify-center">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h1 class="text-3xl sm:text-4xl font-black">Registro de Participantes</h1>
                                <p class="text-emerald-100 text-sm sm:text-base mt-1">Agregue participantes y seleccione al Líder del grupo.</p>
                            </header>

                            <div class="p-4 sm:p-8 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                                <form onsubmit="agregarParticipante(event)" class="bg-white rounded-2xl border-2 border-emerald-100 p-6 shadow-xl space-y-5 lg:col-span-5 h-fit">
                                    <h2 class="text-2xl font-extrabold text-emerald-800 flex items-center gap-2 border-b-2 pb-3 border-emerald-100">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        Datos del Participante
                                    </h2>

                                    <div class="space-y-4">
                                        <div class="relative input-group">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                </svg>
                                            </span>
                                            <input
                                                type="text"
                                                id="cedula"
                                                name="cedula"
                                                placeholder="Cédula (8-10 dígitos)"
                                                inputmode="numeric"
                                                pattern="[0-9]{8,10}"
                                                maxlength="10"
                                                required
                                                class="pl-11 w-full px-4 py-3.5 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition shadow-inner">
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <input
                                                type="text"
                                                id="nombre"
                                                name="nombre"
                                                placeholder="Nombre"
                                                required
                                                class="px-4 py-3.5 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition shadow-inner">
                                            <input
                                                type="text"
                                                id="apellido"
                                                name="apellido"
                                                placeholder="Apellido"
                                                required
                                                class="px-4 py-3.5 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition shadow-inner">
                                        </div>

                                        <div class="relative input-group">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </span>
                                            <input
                                                type="tel"
                                                id="celular"
                                                name="celular"
                                                placeholder="Celular (10 dígitos)"
                                                inputmode="numeric"
                                                pattern="[0-9]{10}"
                                                maxlength="10"
                                                required
                                                class="pl-11 w-full px-4 py-3.5 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition shadow-inner">
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-extrabold py-4 rounded-xl shadow-lg flex items-center justify-center gap-3 transition transform hover:scale-[1.01] active:scale-[0.99]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Añadir a la Lista
                                    </button>
                                </form>

                                <div id="listaParticipantes" class="bg-white rounded-2xl border-2 border-emerald-100 p-6 shadow-xl lg:col-span-7 hidden animate-slide-in">
                                    <div class="flex items-center justify-between mb-5 border-b-2 pb-3 border-emerald-100">
                                        <h2 class="text-2xl font-extrabold text-emerald-800 flex items-center gap-2">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21h-6a2 2 0 01-2-2v-1a6 6 0 0112 0v1a2 2 0 01-2 2z" />
                                            </svg>
                                            Lista del Grupo
                                        </h2>
                                        <span id="contador" class="bg-emerald-600 text-white text-lg font-extrabold px-4 py-1.5 rounded-full shadow-md">0</span>
                                    </div>

                                    <div id="contenedorParticipantes" class="space-y-3 overflow-y-auto max-h-[300px] p-2 -m-2 mb-6">
                                    </div>

                                    <form id="formRegistrarTodos" class="pt-4 border-t-2 border-emerald-200">
                                        <!-- aca mando el cod del territorio para hacer el regsitro de los particpantes en el territorio!-->
                                        <input type="hidden" name="territorio" id="participantes_cod_territorio" value="">
                                        <input type="hidden" name="action" value="registrar_multiple">
                                        <div id="participantesHidden"></div>

                                        <button type="submit" id="btnRegistrarTodos" disabled
                                            class="w-full bg-gradient-to-r from-emerald-600 to-green-700 hover:from-emerald-700 hover:to-green-800 disabled:bg-gray-400 text-white font-black py-4 rounded-xl shadow-xl text-xl flex items-center justify-center gap-3 transition transform hover:scale-[1.01] active:scale-[0.99] disabled:opacity-70 disabled:cursor-not-allowed">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            REGISTRAR TODO EL GRUPO
                                        </button>
                                    </form>
                                </div>

                                <div id="mensajeInicial" class="lg:col-span-7 flex flex-col items-center justify-center p-12 text-center text-gray-500 border-4 border-dashed border-emerald-300 rounded-2xl bg-emerald-50/50 animate-fade-in">
                                    <div class="bg-emerald-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center shadow-inner">
                                        <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M12 4.354a4 4 0 000 5.292m7 5a7 7 0 01-7 7h-2a7 7 0 01-7-7m7 0a7 7 0 007-7h-2a7 7 0 00-7 7m-7 0h2"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-emerald-800 mb-2">Comience su Grupo</h3>
                                    <p class="text-base font-medium">Agregue el primer participante usando el formulario de la izquierda para habilitar la lista de registro.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FIN ÁREA DE CONTENIDO -->
                    </div>
                </div>

                <!-- SECCIÓN 5 -->
                <div id="seccion5" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-orange-500">

                        <!-- CONTENIDO DE TU COMPAÑERA -->
                        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-10">

                            <!-- Botón Eventos -->
                            <a href="../../ENCUESTAS/front/Encuestasasti.php"
                                id="btnEncuesta1"
                                target="_blank"
                                class="cursor-pointer group relative inline-flex items-center justify-center
                                    px-8 py-4 text-lg font-semibold text-white
                                    rounded-2xl
                                    bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                                shadow-lg shadow-purple-500/40
                                    transition-all duration-300
                                hover:scale-105 hover:shadow-xl hover:shadow-purple-500/60
                                active:scale-95">
                                <span class="absolute inset-0 rounded-2xl bg-white/10 opacity-0 group-hover:opacity-100 transition"></span>
                                🎉 Eventos
                            </a>

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

                <!-- SECCIÓN 6 -->
                <div id="seccion6" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-orange-500">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center font-bold text-xl shadow-lg">
                                6
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 ml-4">Control de Asistencia</h2>
                        </div>

                        <!-- CONTENIDO DE TU COMPAÑERA -->
                        <div class="max-w-7xl mx-auto">

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
                                                    Territorio: <strong id="nombreTerritorioAsistencia">Seleccione...</strong>
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
                                            <input type="hidden" name="selectTerritorioAsistencia" id="selectTerritorioAsistencia" value="">
                                            <div>
                                                <label class="text-xs font-bold text-emerald-700 mb-2 block">ACTIVIDAD</label>
                                                <select id="selectActividadAsistencia" onchange="cargarParticipantesAsistencia()" class="w-full px-4 py-2 rounded-xl border-2 border-emerald-300 focus:border-emerald-500 focus:ring-0 text-sm font-semibold">
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
                                            <p id="totalParticipantesAsistencia" class="text-4xl font-bold text-gray-800">0</p>
                                            <p class="text-xs text-gray-400 mt-1">Participantes</p>
                                        </div>
                                        <div class="relative w-20 h-20">
                                            <svg class="w-20 h-20">
                                                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="8" />
                                                <circle id="circleTotalAsistencia" cx="40" cy="40" r="36" fill="none" stroke="#3b82f6" stroke-width="8" stroke-dasharray="226" stroke-dashoffset="0" class="progress-ring" />
                                            </svg>
                                            <i class="bi bi-people-fill text-blue-500 text-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl p-6 card-shadow animate-fade-in-up" style="animation-delay: 0.2s">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Presentes</p>
                                            <p id="totalPresentesAsistencia" class="text-4xl font-bold text-green-600">0</p>
                                            <p id="porcentajePresentesAsistencia" class="text-xs text-gray-400 mt-1">0%</p>
                                        </div>
                                        <div class="relative w-20 h-20">
                                            <svg class="w-20 h-20">
                                                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="8" />
                                                <circle id="circlePresentesAsistencia" cx="40" cy="40" r="36" fill="none" stroke="#10b981" stroke-width="8" stroke-dasharray="226" stroke-dashoffset="226" class="progress-ring" />
                                            </svg>
                                            <i class="bi bi-check-circle-fill text-green-500 text-xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl p-6 card-shadow animate-fade-in-up" style="animation-delay: 0.3s">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">Ausentes</p>
                                            <p id="totalAusentesAsistencia" class="text-4xl font-bold text-red-600">0</p>
                                            <p id="porcentajeAusentesAsistencia" class="text-xs text-gray-400 mt-1">0%</p>
                                        </div>
                                        <div class="relative w-20 h-20">
                                            <svg class="w-20 h-20">
                                                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="8" />
                                                <circle id="circleAusentesAsistencia" cx="40" cy="40" r="36" fill="none" stroke="#ef4444" stroke-width="8" stroke-dasharray="226" stroke-dashoffset="226" class="progress-ring" />
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
                                    <button onclick="marcarTodosAsistencia()" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg hover:shadow-xl">
                                        <i class="bi bi-check-all"></i> Marcar Todos
                                    </button>
                                </div>

                                <div id="listaParticipantesAsistencia" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <!-- Las tarjetas se generarán aquí -->
                                </div>

                                <div id="mensajeVacioAsistencia" class="hidden text-center py-12">
                                    <div class="inline-block bg-gray-100 rounded-full p-6 mb-4">
                                        <i class="bi bi-inbox text-gray-400 text-5xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg font-semibold">No hay participantes para mostrar</p>
                                    <p class="text-gray-400 text-sm mt-2">Seleccione un territorio y actividad</p>
                                </div>
                            </div>

                            <!-- Botón de guardar flotante -->
                            <div id="btnGuardarContainerAsistencia" class="hidden fixed bottom-8 right-8 z-50">
                                <button onclick="guardarAsistenciaTotal()" class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all flex items-center gap-3">
                                    <i class="bi bi-save-fill text-2xl"></i>
                                    <span>Guardar Asistencia</span>
                                </button>
                            </div>

                        </div>
                        <!-- FIN CONTENIDO DE TU COMPAÑERA -->

                    </div>
                </div>

                <div id="seccion4" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-orange-500">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center font-bold text-xl shadow-lg">
                                4
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 ml-4">Configuración</h2>
                        </div>

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

                <!-- SECCIÓN 8 -->
                <div id="seccion8" class="section-container section-content hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 content-card border-l-4 border-purple-500">
                        <div class="container mx-auto px-4">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto">

                                <!-- Registrar -->
                                <div class="w-full">
                                    <!-- Header -->
                                    <div class="text-center mb-10 fade-in-up">
                                        <h1 class="text-4xl font-bold text-slate-800 mb-2">
                                            Registralos
                                        </h1>
                                        <p class="text-slate-600">Complete la información del foco identificado</p>
                                        <div class="w-24 h-1 bg-linear-to-r from-purple-500 to-blue-500 mx-auto mt-4 rounded-full"></div>
                                    </div>

                                    <!-- Form Container -->
                                    <div class="form-container rounded-2xl shadow-2xl p-8 backdrop-blur-sm slide-in">
                                        <form action="" method="post" class="space-y-8" id="formRegistrarFoco8">
                                            <input type="hidden" name="foco_cod_territorio" id="foco_cod_territorio_8" value="">
                                            <input type="hidden" id="modoEdicion8" value="0">
                                            <input type="hidden" id="focoIdEditar8" value="">
                                            <!-- Realizó Field -->
                                            <div class="field-wrapper">
                                                <label class="label-text flex items-center gap-2 text-sm font-semibold text-slate-700 mb-3">
                                                    <span class="icon-wrapper">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </span>
                                                    Realizó
                                                </label>

                                                <select name="realizo" id="selectRealizo8"
                                                    class="input-focus w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white shadow-sm">
                                                    <option value="">Seleccione quien realizó...</option>
                                                </select>

                                            </div>

                                            <!-- Dirección Section -->
                                            <div class="grid grid-cols-3 gap-6 mb-6">

                                                <!-- Tipo de Vía -->
                                                <div>
                                                    <label class="block text-sm font-medium text-cyan-600 mb-2">Tipo de Vía</label>
                                                    <select
                                                        id="tipoVia8"
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
                                                        id="numeroVia8"
                                                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50">
                                                </div>

                                                <!-- # -->
                                                <div>
                                                    <label class="block text-sm font-medium text-cyan-600 mb-2">#</label>
                                                    <input
                                                        type="text"
                                                        id="numeroSimbolo8"
                                                        value="#"
                                                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50"
                                                        readonly>
                                                </div>

                                                <!-- Sufijo / Letra -->
                                                <div>
                                                    <label class="block text-sm font-medium text-cyan-600 mb-2">Sufijo / Letra</label>
                                                    <input
                                                        type="text"
                                                        id="sufijo8"
                                                        maxlength="5"
                                                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50">
                                                </div>

                                                <!-- Distancia -->
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-cyan-600 mb-2">Complemento</label>
                                                    <input
                                                        type="text"
                                                        id="distancia8"
                                                        class="w-full px-4 py-3 border-2 border-cyan-300 rounded-lg focus:outline-none focus:border-cyan-500 bg-cyan-50">
                                                </div>

                                            </div>

                                            <!-- Tipo de Foco Section -->
                                            <div class="field-wrapper">
                                                <label class="label-text flex items-center gap-2 text-sm font-semibold text-slate-700 mb-3">
                                                    <span class="icon-wrapper">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                        </svg>
                                                    </span>
                                                    Tipo de Foco
                                                </label>
                                                <select name="cod_tipo_foc" id="selectTipoFoco8" required
                                                    class="input-focus w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white shadow-sm">
                                                    <option value="">Seleccione el tipo de foco...</option>
                                                </select>

                                                <div id="focoDescription8" class="hidden mt-4 p-5 bg-linear-to-br from-purple-50 to-blue-50 border-2 border-purple-200 rounded-xl description-card">
                                                    <div class="flex items-start gap-3">
                                                        <svg class="w-6 h-6 text-purple-600 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <div>
                                                            <h3 class="font-semibold text-purple-900 mb-1">Descripción del Foco</h3>
                                                            <p id="focoDescriptionText8" class="text-slate-700 text-sm leading-relaxed"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Lugar Field -->
                                            <div class="field-wrapper">
                                                <label class="label-text flex items-center gap-2 text-sm font-semibold text-slate-700 mb-3">
                                                    <span class="icon-wrapper">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                    </span>
                                                    Lugar Específico
                                                </label>
                                                <input type="text" name="lugar" id="lugar8" required
                                                    class="input-focus w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white shadow-sm"
                                                    placeholder="Ingrese el lugar específico del foco...">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="pt-4">
                                                <button type="submit" id="btnTexto"
                                                    class="cursor-pointer submit-btn w-full py-4 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-purple-300">
                                                    <span class="flex items-center justify-center gap-2">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Registrar Foco Potencial
                                                    </span>
                                                </button>
                                                <br><br>

                                                <button type="button" id="btnCancelarEdicion" class="cursor-pointer hidden w-full py-3 bg-gray-300 hover:bg-gray-400 rounded-xl font-semibold transition-all">
                                                    Cancelar Edición
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="text-center mt-8 text-slate-600 text-sm fade-in-up">
                                        <p>Todos los campos son obligatorios</p>
                                    </div>
                                </div>

                                <!-- Focos registrados -->
                                <div class="w-full">
                                    <div class="text-center mb-10 fade-in-up">
                                        <h2 class="text-4xl font-bold text-slate-800 mb-2">
                                            Focos Registrados
                                        </h2>
                                        <p class="text-slate-600">Lista de focos potenciales identificados</p>
                                        <div class="w-24 h-1 bg-linear-to-r from-blue-500 to-purple-500 mx-auto mt-4 rounded-full"></div>
                                    </div>

                                    <!-- Focos Container -->
                                    <div class="space-y-6 slide-in-right" id="containerFocosActuales8">

                                        <!--Focos-->

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="../../../src/js/iziToast.min.js"></script>
    <script src="../../../src/js/etapa1.js"></script>
    <script src="../../../src/js/participantes.js"></script>
    <script src="../../../src/js/foco-registrar2.js"></script>
    <script src="../../../src/js/asistencia.js"></script>
    <script src="../../../src/js/ecosalud-terr.js"></script>
    <script src="../../../src/js/focos-seccion8.js"></script>
    <script>
        const btnSigEtapa = document.getElementById('btnSiguienteEtp')
        btnSigEtapa.addEventListener('click', () => {
            window.location.href = 'etapa2.php'
        })
    </script>
    <script>
        const btnAside = document.getElementById("btnMenu2");
        const aside = document.getElementById("aside");

        btnAside.addEventListener('click', () => {
            aside.classList.toggle("-translate-x-full");
        });

        document.addEventListener('click', (e) => {
            if (!aside.contains(e.target) && !btnAside.contains(e.target)) {
                aside.classList.add("-translate-x-full");
            }
        })
    </script>


</body>

</html>