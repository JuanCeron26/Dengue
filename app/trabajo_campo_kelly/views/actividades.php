<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Actividades - Registro de Inspección</title>

    <link rel="stylesheet" href="../../../src/css/toast-alert.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <style>
        :root {
            --verde-principal: #10b981;
            --verde-hover: #059669;
            --verde-claro: #d1fae5;
            --fondo-gris: #f0f4f8;
        }

        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #e5e7eb 100%);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .fade-out {
            animation: fadeOut 0.3s ease-out;
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

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(10px);
            }
        }

        .alert {
            padding: 16px 20px;
            margin: 16px 0;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            border-left: 5px solid;
            animation: slideIn 0.4s ease-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-left-color: #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left-color: #ef4444;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .card-filtros {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border: 2px solid #d1fae5;
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.1);
        }

        .input-moderno {
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .input-moderno:focus {
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            transform: translateY(-1px);
        }

        .btn-verde {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }

        .btn-verde:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }

        .formulario-card {
            background: white;
            border: 2px solid #d1fae5;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15);
        }

        .seccion-verde {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 2px solid #a7f3d0;
        }

        .header-formulario {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<div id="btn-aside"
    class="fixed z-40 left-0 top-0 w-1 hover:w-3 bg-slate-500/40 h-screen 
    transition-all duration-300 cursor-pointer backdrop-blur-xl">
</div>

<!-- MENÚ LATERAL -->
<aside id="aside"
    class="fixed z-50 top-0 left-0 h-screen w-20 -translate-x-full 
    transition-transform duration-500 ease-in-out
    bg-white/20 backdrop-blur-2xl border-r border-white/30 shadow-2xl
    flex flex-col items-center justify-between py-10">

    <<div class="flex flex-col items-center gap-10 mt-20">


        <a href="dashboard.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img
                    src="../../../src/icons/casa.png"
                    class="w-9 h-9 drop-shadow-md group-hover:drop-shadow-xl">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)]">
                Inicio
            </span>
        </a>

        <!-- Sitios Control Biológico -->
        <a href="../../sitiocampo/front/listar.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img
                    src="../../../src/icons/planta (2).png"
                    class="w-11 h-11 drop-shadow-md group-hover:drop-shadow-xl">
            </div>
            <span class="mt-2 text-[10px] font-medium opacity-0 text-center translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)] leading-tight px-2">
                Sitios Control<br>Biológico
            </span>
        </a>

        </div>

        <!-- Botón Salir -->
        <div class="flex flex-col items-center">
            <a href="../logout.php" class="group flex flex-col items-center">
                <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    <i class="fa-solid fa-power-off text-2xl text-red-600 drop-shadow-md
                    group-hover:text-red-700 group-hover:drop-shadow-xl group-hover:rotate-12"></i>
                </div>
                <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-red-600 group-hover:text-red-700">
                    Salir
                </span>
            </a>
        </div>

</aside>

<body class="min-h-screen">

    <!-- HEADER -->
    <header class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-2xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                    <i class="bi bi-grid-fill text-3xl"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Gestión de Actividades de Campo</h1>
            </div>
            <div class="flex items-center gap-3 bg-white bg-opacity-20 rounded-full py-2 pl-4 pr-2 backdrop-blur-sm">
                <span class="text-sm font-semibold">Administrador</span>
                <div class="bg-white rounded-full p-1">
                    <i class="bi bi-person-circle text-3xl text-emerald-600"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- COLUMNA IZQUIERDA: Actividades -->
            <div class="lg:col-span-2 space-y-8">

                <!-- FILTROS DE BÚSQUEDA -->
                <div class="card-filtros rounded-3xl shadow-2xl p-7">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-emerald-200">
                        <h3 class="font-bold text-xl text-emerald-700 flex items-center gap-3">
                            <div class="bg-emerald-100 rounded-lg p-2">
                                <i class="bi bi-funnel-fill text-2xl"></i>
                            </div>
                            Filtros de Búsqueda
                        </h3>
                        <button id="btn_nueva_inspeccion"
                            class="btn-verde text-white font-bold py-3 px-6 rounded-xl flex items-center gap-2 text-sm">
                            <i class="bi bi-plus-circle-fill text-xl"></i>
                            Añadir Inspección
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Filtro Fecha -->
                        <div class="relative">
                            <label for="filtro_fecha" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-calendar-event mr-1"></i> Fecha
                            </label>
                            <input id="filtro_fecha" type="date"
                                class="input-moderno w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                        </div>

                        <!-- Filtro Sitio -->
                        <div class="relative">
                            <label for="select_sitio_filtro" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-geo-alt-fill mr-1"></i> Sitio
                            </label>
                            <select name="sitio_filtro" id="select_sitio_filtro"
                                class="input-moderno w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none">
                                <option value="">Todos los sitios</option>
                            </select>
                            <i class="bi bi-chevron-down absolute right-4 top-12 text-gray-400 pointer-events-none"></i>
                        </div>

                        <!-- Filtro Actividad -->
                        <div class="relative">
                            <label for="tipo_actividad_filtro" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-card-checklist mr-1"></i> Actividad
                            </label>
                            <select id="tipo_actividad_filtro" name="tipo_actividad_filtro"
                                class="input-moderno w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none">
                                <option value="">Todas las actividades</option>
                            </select>
                            <i class="bi bi-chevron-down absolute right-4 top-12 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex justify-start gap-4 mt-6">
                        <button id="btn_aplicar_filtros" onclick="aplicarFiltros(); return false;"
                            class="btn-verde text-white font-bold py-3 px-8 rounded-xl flex items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i>
                            Aplicar
                        </button>
                        <button id="btn_limpiar_filtros" onclick="limpiarFiltros(); return false;"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl transition shadow-md">
                            <i class="bi bi-x-circle-fill mr-1"></i>
                            Limpiar
                        </button>
                    </div>
                </div>

                <!-- CONTENEDOR DE ACTIVIDADES -->
                <div id="contenedor_actividades" class="space-y-8">
                </div>
            </div>

            <!-- COLUMNA DERECHA: Formularios -->
            <div class="space-y-8">

                <!-- ==================== FORMULARIO DE SIEMBRA ==================== -->
                <div id="siembra-formulario" class="hidden">
                    <div class="formulario-card rounded-3xl overflow-hidden">

                        <div class="header-formulario px-6 py-5">
                            <h3 class="text-2xl font-bold flex items-center gap-3">
                                <i class="bi bi-fish text-3xl"></i> Registro de Siembra
                            </h3>
                        </div>

                        <div class="p-6">

                            <p class="text-sm text-gray-600 mb-4">
                                <span class="text-red-600 font-bold">*</span> Campos obligatorios
                            </p>

                            <form method="POST" action="../controller/actividadescontrol.php"
                                enctype="multipart/form-data"
                                id="form_siembra"
                                class="space-y-6">

                                <input type="hidden" name="cod_act_campo" value="1">
                                <input type="hidden" name="cod_padre" id="cod_padre">
                                <input type="hidden" name="cod_sitiodepo" id="cod_sitiodepo">
                                <input type="hidden" name="tipo_operacion" id="tipo_operacion_siembra" value="registrar">
                                <input type="hidden" name="accion" value="registrar">
                                <input type="hidden" name="id_actividad" id="id_actividad">

                                <!-- ==================== DATOS DE LA ACTIVIDAD ==================== -->
                                <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                        <i class="bi bi-person-bounding-box"></i> Datos de la Actividad
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-calendar-date mr-1"></i> Fecha
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="date" name="fecha" id="fecha_siembra" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-person-circle mr-1"></i> Responsable
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <select name="usuario" class="select_usuario w-full p-3 border-2 border-emerald-200 rounded-xl
                                    focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" required>
                                                <option value="" disabled selected>-- Seleccione --</option>
                                            </select>
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== PARÁMETROS DEL AGUA ==================== -->
                                <section class="border-2 border-gray-300 rounded-2xl p-5 shadow-md bg-white">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
                                        <i class="bi bi-droplet-fill"></i> Parámetros del Agua
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-water mr-1"></i> pH
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.01" name="ph" placeholder="7.0" required
                                                class="w-full p-3 border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-thermometer-half mr-1"></i> Temp. (°C)
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.1" name="temperatura" placeholder="26.5" required
                                                class="w-full p-3 border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-bandaid mr-1"></i> Cloro (mg/L)
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.01" name="cloro" placeholder="0.2" required
                                                class="w-full p-3 border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== CANTIDAD DE GUPPIES ==================== -->
                                <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                        <i class="bi bi-hash"></i> Cantidad de Guppies
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-chevron-bar-up mr-1"></i> Alevines
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" name="alevines" min="0" placeholder="0" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-person mr-1"></i> Adultos
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" name="adultos" min="0" placeholder="0" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== OBSERVACIONES Y FOTOS ==================== -->
                                <div class="space-y-4">

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="bi bi-chat-left-text mr-1"></i> Observaciones
                                        </label>
                                        <textarea name="observaciones" rows="3"
                                            placeholder="Condiciones del agua, estado del sitio..."
                                            class="w-full p-3 border-2 border-gray-200 rounded-xl
                                  focus:ring-2 focus:ring-emerald-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="bi bi-camera mr-1"></i> Fotos (opcional)
                                        </label>
                                        <input type="file" name="fotos[]" multiple accept="image/*"
                                            class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0 file:text-sm file:font-semibold
                               file:bg-emerald-100 file:text-emerald-700
                               hover:file:bg-emerald-200 transition">
                                    </div>

                                </div>

                                <!-- ==================== BOTONES ==================== -->
                                <div class="flex justify-end gap-4 pt-4 border-t-2 border-gray-200">
                                    <button type="button" id="btn-cancelar-seguimiento"
                                        class="px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white
                            font-bold rounded-xl transition shadow-md">
                                        Cancelar
                                    </button>

                                    <button type="submit"
                                        class="btn-verde text-white font-bold text-lg py-3 px-8
                            rounded-xl flex items-center gap-2">
                                        <i class="bi bi-save-fill"></i> Guardar
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <!-- ==================== FORMULARIO DE RESIEMBRA ==================== -->
                <div id="resiembra-formulario" class="hidden">
                    <div class="formulario-card rounded-3xl overflow-hidden">

                        <div class="header-formulario px-6 py-5">
                            <h3 class="text-2xl font-bold flex items-center gap-3">
                                <i class="bi bi-fish text-3xl"></i> Resiembra de Guppies
                            </h3>
                        </div>

                        <div class="p-6">

                            <p class="text-sm text-gray-600 mb-4">
                                <span class="text-red-600 font-bold">*</span> Campos obligatorios
                            </p>

                            <form method="POST" action="../controller/actividadescontrol.php"
                                enctype="multipart/form-data"
                                id="form_resiembra"
                                class="space-y-6">

                                <input type="hidden" name="cod_act_campo" value="2">
                                <input type="hidden" name="cod_padre" id="cod_padre_res">
                                <input type="hidden" name="cod_sitiodepo" id="cod_sitiodepo_res">
                                <input type="hidden" name="accion" value="registrar">
                                <input type="hidden" name="id_resiembra" id="id_resiembra" value="0">

                                <!-- ==================== DATOS DE LA RESIEMBRA ==================== -->
                                <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                        <i class="bi bi-person-lines-fill"></i> Datos de la Resiembra
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-calendar-date mr-1"></i> Fecha
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="date" name="fecha" id="fecha_resiembra" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-person-circle mr-1"></i> Responsable
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <select name="usuario"
                                                class="select_usuario w-full p-3 border-2 border-emerald-200 rounded-xl
                                    focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                                                required>
                                                <option value="" disabled selected>-- Seleccione --</option>
                                            </select>
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== PARÁMETROS DEL AGUA ==================== -->
                                <section class="border-2 border-gray-300 rounded-2xl p-5 shadow-md bg-white">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
                                        <i class="bi bi-thermometer-half"></i> Parámetros del Agua
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                pH <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.01" name="ph" placeholder="7.0" required
                                                class="w-full p-3 border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Temp. (°C) <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" name="temperatura" placeholder="25" required
                                                class="w-full p-3 border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Cloro (mg/L) <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.01" name="cloro" placeholder="0.2" required
                                                class="w-full p-3 border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== CANTIDAD DE PECES ==================== -->
                                <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                        <i class="bi bi-patch-plus-fill"></i> Cantidad de Peces
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Alevines <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" name="alevines" min="0" placeholder="0" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Adultos <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" name="adultos" min="0" placeholder="0" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== OBSERVACIONES Y FOTOS ==================== -->
                                <div class="space-y-4">

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Observaciones
                                        </label>
                                        <textarea name="observaciones" rows="3"
                                            placeholder="Estado de los peces, depósito..."
                                            class="w-full p-3 border-2 border-gray-200 rounded-xl
                                  focus:ring-2 focus:ring-emerald-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Fotos (opcional)
                                        </label>
                                        <input type="file" name="fotos[]" multiple accept="image/*"
                                            class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0 file:text-sm file:font-semibold
                               file:bg-emerald-100 file:text-emerald-700
                               hover:file:bg-emerald-200 transition">
                                    </div>

                                </div>

                                <!-- ==================== BOTONES ==================== -->
                                <div class="flex justify-end gap-4 pt-4 border-t-2 border-gray-200">

                                    <button type="button" onclick="cerrarFormularioSiembra()"
                                        class="px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white
                            font-bold rounded-xl transition shadow-md">
                                        Cancelar
                                    </button>

                                    <button type="submit"
                                        class="btn-verde text-white font-bold text-lg py-3 px-8
                            rounded-xl flex items-center gap-2">
                                        <i class="bi bi-save-fill"></i> Guardar
                                    </button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- ==================== FORMULARIO DE SEGUIMIENTO ==================== -->
                <div id="seguimiento-formulario" class="hidden">
                    <div class="formulario-card rounded-3xl overflow-hidden">

                        <div class="header-formulario px-6 py-5">
                            <h3 class="text-2xl font-bold flex items-center gap-3">
                                <i class="bi bi-journal-check text-3xl"></i> Seguimiento
                            </h3>
                        </div>

                        <div class="p-6">

                            <p class="text-sm text-gray-600 mb-4">
                                <span class="text-red-600 font-bold">*</span> Campos obligatorios
                            </p>

                            <form class="space-y-6"
                                method="POST"
                                action="../controller/actividadescontrol.php"
                                enctype="multipart/form-data">

                                <input type="hidden" id="accion_seguimiento" name="accion" value="registrar">
                                <input type="hidden" id="cod_actividadtrabajocampo_seg" name="cod_actividadtrabajocampo_seg">
                                <input type="hidden" name="cod_act_campo" value="3">
                                <input type="hidden" id="cod_padre_seg" name="cod_padre">
                                <input type="hidden" id="cod_sitiodepo_seg" name="cod_sitiodepo">

                                <!-- ==================== DATOS DEL SEGUIMIENTO ==================== -->
                                <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                        <i class="bi bi-calendar-check"></i> Datos del Seguimiento
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-calendar-date mr-1"></i> Fecha
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <input type="date" name="fecha_seguimiento" id="fecha_seguimiento" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="bi bi-person-circle mr-1"></i> Responsable
                                                <span class="text-red-600">*</span>
                                            </label>
                                            <select name="usuario"
                                                class="select_usuario w-full p-3 border-2 border-emerald-200 rounded-xl
                                    focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                                                required>
                                                <option value="" disabled selected>-- Seleccione --</option>
                                            </select>
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== PRESENCIA DE VECTORES ==================== -->
                                <section class="border-2 border-gray-300 rounded-2xl p-5 shadow-md bg-white">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
                                        <i class="bi bi-bug-fill"></i> Presencia de Vectores
                                        <span class="text-red-600">*</span>
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-emerald-50 rounded-xl border-2 border-emerald-200">

                                        <div class="text-center">
                                            <p class="font-semibold text-sm text-gray-700 mb-3">Larvas Aedes</p>
                                            <div class="flex justify-center gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="larvas_aedes" value="1" required
                                                        class="form-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="ml-2 font-medium">Sí</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="larvas_aedes" value="0" checked
                                                        class="form-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="ml-2 font-medium">No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <p class="font-semibold text-sm text-gray-700 mb-3">Pupas</p>
                                            <div class="flex justify-center gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="pupas" value="1"
                                                        class="form-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="ml-2 font-medium">Sí</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="pupas" value="0" checked
                                                        class="form-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="ml-2 font-medium">No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <p class="font-semibold text-sm text-gray-700 mb-3">Larvas Culex</p>
                                            <div class="flex justify-center gap-4">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="larvas_culex" value="1"
                                                        class="form-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="ml-2 font-medium">Sí</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="radio" name="larvas_culex" value="0" checked
                                                        class="form-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="ml-2 font-medium">No</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== PARÁMETROS DEL AGUA ==================== -->
                                <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                    <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                        <i class="bi bi-droplet-fill"></i> Parámetros del Agua
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                pH <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.1" name="ph_actual" placeholder="7.0" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Cloro (mg/L)
                                            </label>
                                            <input type="number" step="0.1" name="cloro_actual" placeholder="0.2"
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Temp. (°C) <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" step="0.1" name="temperatura_actual" placeholder="26.5" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                   focus:ring-2 focus:ring-emerald-500">
                                        </div>

                                    </div>
                                </section>

                                <!-- ==================== OBSERVACIONES Y FOTO ==================== -->
                                <div class="space-y-4">

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Observaciones
                                        </label>
                                        <textarea name="observaciones" rows="3"
                                            placeholder="Estado de los peces, mortalidad..."
                                            class="w-full p-3 border-2 border-gray-200 rounded-xl
                                  focus:ring-2 focus:ring-emerald-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Foto (opcional)
                                        </label>
                                        <input type="file" name="foto_seguimiento" accept="image/*"
                                            class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0 file:text-sm file:font-semibold
                               file:bg-emerald-100 file:text-emerald-700
                               hover:file:bg-emerald-200 transition">
                                    </div>

                                </div>

                                <!-- ==================== BOTONES ==================== -->
                                <div class="flex justify-end gap-4 pt-4 border-t-2 border-gray-200">

                                    <button type="button" id="btn-cancelar-seguimiento"
                                        class="px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white
                            font-bold rounded-xl transition shadow-md">
                                        Cancelar
                                    </button>

                                    <button type="submit"
                                        class="btn-verde text-white font-bold text-lg py-3 px-8
                            rounded-xl flex items-center gap-2">
                                        <i class="bi bi-save-fill"></i> Guardar
                                    </button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- ==================== FORMULARIO DE INSPECCIÓN ==================== -->
                <div id="inspeccion-formulario" class="formulario-card rounded-3xl overflow-hidden">
                    <div class="header-formulario px-6 py-5">
                        <h3 class="text-2xl font-bold flex items-center gap-3">
                            <i class="bi bi-search text-3xl"></i> Nueva Inspección
                        </h3>
                    </div>

                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">
                            <span class="text-red-600 font-bold">*</span> Campos obligatorios
                        </p>

                        <form class="space-y-6" method="POST" action="../controller/actividadescontrol.php"
                            id="form_actividad" enctype="multipart/form-data">

                            <input type="hidden" name="accion" value="registrar" id="accion_inspeccion">
                            <input type="hidden" name="id_actividad_inspeccion" id="cod_actividadtrabajocampo_insp" value="0">
                            <input type="hidden" name="cod_act_campo" value="4">
                            <input type="hidden" name="cod_sitiodepo" id="cod_sitiodepo">
                            <input type="hidden" name="cod_tipodepo" id="cod_tipodepo">
                            <input type="hidden" name="cod_sitiocontrolbiolo" id="cod_sitiocontrolbiolo">

                            <!-- ==================== DATOS GENERALES ==================== -->
                            <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                    <i class="bi bi-person-lines-fill"></i> Datos Generales
                                </h4>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="bi bi-calendar-date mr-1"></i> Fecha de Inspección
                                            <span class="text-red-600">*</span>
                                        </label>
                                        <input type="date" name="fecha" required
                                            class="w-full p-3 border-2 border-emerald-200 rounded-xl
                               focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="bi bi-person-circle mr-1"></i> Responsable
                                            <span class="text-red-600">*</span>
                                        </label>
                                        <select name="usuario" required
                                            class="select_usuario w-full p-3 border-2 border-emerald-200 rounded-xl
                                focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                            <option value="" disabled selected>-- Seleccione --</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="bi bi-geo-alt-fill mr-1"></i> Sitio de Inspección
                                            <span class="text-red-600">*</span>
                                        </label>
                                        <select name="sitio" id="select_sitio" required
                                            class="w-full p-3 border-2 border-emerald-200 rounded-xl
                                focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                            <option value="">Seleccione un sitio...</option>
                                        </select>
                                    </div>
                                </div>
                            </section>

                            <!-- ==================== RESULTADOS BIOLÓGICOS ==================== -->
                            <section class="border-2 border-gray-300 rounded-2xl p-5 shadow-md bg-white">
                                <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-gray-300 flex items-center gap-2">
                                    <i class="bi bi-bug-fill"></i> Resultados Biológicos
                                </h4>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Tipo de Depósito <span class="text-red-600">*</span>
                                        </label>
                                        <select name="deposito" id="select_deposito" required
                                            class="w-full p-3 border-2 border-gray-200 rounded-xl
                                focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-emerald-50 rounded-xl border-2 border-emerald-200">

                                        <div>
                                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                                Larvas Aedes <span class="text-red-600">*</span>
                                            </label>
                                            <select name="positivo_larvas" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl focus:ring-emerald-500">
                                                <option value="" disabled selected>Seleccione...</option>
                                                <option value="Sí">Sí (Positivo)</option>
                                                <option value="No">No (Negativo)</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                                Pupas <span class="text-red-600">*</span>
                                            </label>
                                            <select name="positivo_pupas" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl focus:ring-emerald-500">
                                                <option value="" disabled selected>Seleccione...</option>
                                                <option value="Sí">Sí (Positivo)</option>
                                                <option value="No">No (Negativo)</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                                Larvas Culex <span class="text-red-600">*</span>
                                            </label>
                                            <select name="positivo_culex" required
                                                class="w-full p-3 border-2 border-emerald-200 rounded-xl focus:ring-emerald-500">
                                                <option value="" disabled selected>Seleccione...</option>
                                                <option value="Sí">Sí (Positivo)</option>
                                                <option value="No">No (Negativo)</option>
                                            </select>
                                        </div>

                                    </div>


                                    <!-- ==================== MEDICIONES ==================== -->
                                    <section class="seccion-verde rounded-2xl p-5 shadow-md">
                                        <h4 class="font-bold text-lg text-emerald-800 mb-4 pb-3 border-b-2 border-emerald-300 flex items-center gap-2">
                                            <i class="bi bi-thermometer-half"></i> Mediciones
                                        </h4>

                                        <h5 class="font-semibold text-emerald-700 mb-3">
                                            Parámetros del Agua <span class="text-red-600">*</span>
                                        </h5>

                                        <div class="grid grid-cols-3 gap-4 mb-6">
                                            <div>
                                                <label class="block text-sm font-medium mb-1">pH *</label>
                                                <input type="number" step="0.1" name="ph" required
                                                    class="w-full p-3 border-2 border-emerald-200 rounded-xl focus:ring-emerald-500">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-1">Cloro (mg/L) *</label>
                                                <input type="number" step="0.1" name="cloro" required
                                                    class="w-full p-3 border-2 border-emerald-200 rounded-xl focus:ring-emerald-500">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-1">Temp. (°C) *</label>
                                                <input type="number" step="0.1" name="temperatura" required
                                                    class="w-full p-3 border-2 border-emerald-200 rounded-xl focus:ring-emerald-500">
                                            </div>
                                        </div>

                                        <div class="pt-4 border-t-2 border-emerald-300">
                                            <h5 class="font-semibold text-emerald-700 mb-3">
                                                Medidas del Depósito (cm) <span class="text-red-600">*</span>
                                            </h5>
                                            <p class="text-sm text-gray-600 mb-4">Todas las medidas son obligatorias</p>

                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                        Ancho <span class="text-red-600">*</span>
                                                    </label>
                                                    <input type="number" name="ancho" placeholder="Ancho" required
                                                        class="w-full p-3 border-2 border-emerald-200 rounded-xl
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                        Largo <span class="text-red-600">*</span>
                                                    </label>
                                                    <input type="number" name="largo" placeholder="Largo" required
                                                        class="w-full p-3 border-2 border-emerald-200 rounded-xl
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                        Profundidad <span class="text-red-600">*</span>
                                                    </label>
                                                    <input type="number" name="profundidad" placeholder="Profundidad" required
                                                        class="w-full p-3 border-2 border-emerald-200 rounded-xl
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </section>

                            <!-- ==================== OBSERVACIONES Y FOTO ==================== -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
                                    <textarea name="observaciones" rows="3"
                                        class="w-full p-3 border-2 border-gray-200 rounded-xl
                              focus:ring-2 focus:ring-emerald-500"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto (opcional)</label>
                                    <input type="file" name="foto"
                                        class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0 file:text-sm file:font-semibold
                           file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 transition">
                                </div>
                            </div>

                            <!-- ==================== BOTÓN ==================== -->
                            <button type="submit" id="btn-submit-inspeccion"
                                class="w-full btn-verde text-white font-bold text-lg py-4 rounded-xl
                    flex items-center justify-center gap-2">
                                <i class="bi bi-save-fill text-xl"></i> Registrar Inspección
                            </button>

                        </form>
                    </div>
                </div>


                <!-- Modal Informe -->
                <div id="modalInforme" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden backdrop-blur-sm">
                    <div class="bg-white w-11/12 md:w-3/4 lg:w-1/2 max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden relative">
                        <button id="cerrarInforme"
                            class="absolute top-3 right-3 text-white bg-red-500 hover:bg-red-600 
                w-10 h-10 rounded-full flex items-center justify-center text-xl shadow-lg z-10 transition">
                            ×
                        </button>
                        <div id="contenidoInforme" class="p-6 overflow-y-auto max-h-[85vh]">
                        </div>
                        <div id="alertaCustom" style="display:none;">
                        </div>
                    </div>
                </div>

                <script src="../js/iziToast.min.js"></script>
                <script src="../js/cards.js"></script>

                <script src="../js/modal.js"></script>
                <script src="../js/formularios.js"></script>
                <script src="../js/cargardatos.js"></script>
                <script src="../js/validaciones.js"></script>
                <script src="../js/toast-alert.js"></script>








</body>

</html>