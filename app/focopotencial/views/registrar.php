<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <title>Registro de Focos Potenciales</title>
</head>

<style>
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
</style>



<body class="bg-linear-to-br from-slate-50 to-slate-100 min-h-screen">

    <div class="container mx-auto py-12 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto">

            <!-- Registrar -->
            <div class="w-full">
                <!-- Header -->
                <div class="text-center mb-10 fade-in-up">
                    <h1 class="text-4xl font-bold text-slate-800 mb-2">
                        Registro de Focos Potenciales
                    </h1>
                    <p class="text-slate-600">Complete la información del foco identificado</p>
                    <div class="w-24 h-1 bg-linear-to-r from-purple-500 to-blue-500 mx-auto mt-4 rounded-full"></div>
                </div>

                <!-- Form Container -->
                <div class="form-container rounded-2xl shadow-2xl p-8 backdrop-blur-sm slide-in">
                    <form action="" method="post" class="space-y-8" id="formRegistrarFoco">
                        <input type="hidden" value="1" name="cod_actividadeco">

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
                                Realizó
                            </label>
                            <select name="realizo" id="selectRealizo"
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
                            <br>
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


    <script src="../../../src/js/foco-registrar2.js"></script>
</body>

</html>