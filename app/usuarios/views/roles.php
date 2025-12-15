<?php
session_start();
$rol = $_SESSION["rol"];
$nombreCompleto = mb_strtoupper($_SESSION["nombre"] .  ' ' . $_SESSION["apellido"], 'UTF-8'); // GóMEZ
$inicial = substr($_SESSION["nombre"], 0, 1);
$final = substr($_SESSION["apellido"], 0, 1);
$comodin = strtoupper($inicial . $final);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Roles y Permisos</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">

    <style>
        .content-section {
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            transform: translateX(0);
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            padding: 1.5rem;
        }

        .content-section.hidden-left {
            opacity: 0;
            transform: translateX(-100%);
            pointer-events: none;
        }

        .content-section.hidden-right {
            opacity: 0;
            transform: translateX(100%);
            pointer-events: none;
        }

        .content-section.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            pointer-events: auto;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .card-hover:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .tab-button.active {
            position: relative;
            background-color: #4f46e5;
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.5);
        }
    </style>
</head>

<body class="min-h-screen w-full bg-gray-50">

    <?php include_once '../../../src/includes/aside-usuarios.php'; ?>

    <div class="min-h-screen flex flex-col">

        <header
            class="sticky top-0 z-30 flex justify-between items-center px-10 py-4 bg-gray-900 bg-opacity-90 backdrop-blur-sm shadow-xl border-b border-gray-700">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-violet-900 rounded-lg shadow-inner glow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-violet-300" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2a7 7 0 110 14 7 7 0 010-14zm1 7h4v2h-6V5h2v4zM5 20h14v2H5v-2z" />
                    </svg>
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold text-white tracking-wide">Gestión de Roles y Permisos</h1>
                    <p class="mt-1 text-violet-400 text-sm">Modulo de Administracion</p>
                </div>
            </div>

            <div class="flex items-center space-x-5">
                <div class="text-right">
                    <p class="font-semibold text-gray-300"><?php echo $nombreCompleto; ?></p>
                    <p class="text-violet-400 text-sm"><?php echo $rol; ?></p>
                </div>
                <div
                    class="cursor-pointer bg-violet-700 text-white font-semibold rounded-full h-12 w-12 flex items-center justify-center ring-2 ring-violet-500 hover:ring-4 hover:bg-violet-800 transition transform hover:scale-110">
                    <?php echo $comodin; ?>
                </div>
            </div>
        </header>

        <div class="bg-white sticky top-[69px] z-20 shadow-md">
            <div class="max-w-7xl mx-auto px-6">
                <nav class="flex space-x-2 py-3 border-b border-gray-200">
                    <button id="tab-roles-segmentos" data-target="gestion-roles-segmentos"
                        class="tab-button active px-4 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 cursor-pointer">
                        <span class="mr-2">🔑</span> Roles y Segmentos
                    </button>
                    <button id="tab-asignacion-permisos" data-target="asignacion-permisos"
                        class="tab-button px-4 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 cursor-pointer">
                        <span class="mr-2">🛡️</span> Asignación de Permisos
                    </button>
                </nav>
            </div>
        </div>

        <main class="grow max-w-7xl mx-auto w-full relative overflow-hidden h-full">
            <div class="relative min-h-[600px] flex items-start w-full">
                <section id="gestion-roles-segmentos" class="content-section active space-y-6">

                    <h1 class="text-3xl font-bold tracking-tight text-gray-800">Administración de Entidades</h1>
                    <p class="text-gray-600">Crea y gestiona los Roles y Segmentos que definen la estructura de permisos.</p>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div
                            class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 ease-in-out card-hover border-t-4 border-indigo-600">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="font-extrabold text-2xl text-indigo-700 flex items-center">
                                    <span class="mr-3">👥</span> Roles
                                </h2>
                                <button id="btnCrearRol"
                                    class="bg-indigo-500 text-white p-2 rounded-full font-semibold text-sm hover:bg-indigo-600 cursor-pointer transition transform hover:scale-105 shadow-md">
                                    + Crear Rol
                                </button>
                            </div>

                            <input type="text" placeholder="Buscar Rol..."
                                class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">

                            <div id="listaRoles" class="space-y-3 h-64 overflow-y-auto pr-2">
                                <!--Aqui estan los roles-->
                            </div>
                        </div>

                        <div
                            class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 ease-in-out card-hover border-t-4 border-purple-600">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="font-extrabold text-2xl text-purple-700 flex items-center">
                                    <span class="mr-3">🎯</span> Segmentos
                                </h2>
                                <!--
                                <button id="btnCrearSegmento"
                                    class="bg-purple-500 text-white p-2 rounded-full font-semibold text-sm hover:bg-purple-600 cursor-pointer transition transform hover:scale-105 shadow-md">
                                    + Crear Segmento
                                </button>
                                -->
                            </div>

                            <input type="text" placeholder="Buscar Segmento..."
                                class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 transition">

                            <div id="listaSegmentos" class="space-y-3 h-64 overflow-y-auto pr-2">
                                <div class="flex justify-between items-center p-3 bg-gray-50 border rounded-lg hover:bg-purple-50 transition duration-200">
                                    <span class="font-medium text-gray-800">CONTROL BIOLOGICO</span>

                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 border rounded-lg hover:bg-purple-50 transition duration-200">
                                    <span class="font-medium text-gray-800">ECOSALUD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 border rounded-lg hover:bg-purple-50 transition duration-200">
                                    <span class="font-medium text-gray-800">ADMINISTRACION</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 border rounded-lg hover:bg-purple-50 transition duration-200">
                                    <span class="font-medium text-gray-800">JEFES DIRECTORIOS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="asignacion-permisos" class="content-section hidden-right space-y-6">

                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">
                        Asignación de Permisos por Perfil
                    </h1>

                    <p class="text-gray-600">
                        Administra las acciones disponibles según la combinación de Rol y Segmento.
                    </p>

                    <div class="bg-white shadow-2xl rounded-2xl p-8 border-t-4 border-emerald-600">

                        <!-- filtros -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Seleccionar Rol</label>
                                <select id="filtroRol"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    <option value="">Seleccionar Rol</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Seleccionar Segmento</label>
                                <select id="filtroSegmento"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition">
                                </select>
                            </div>

                        </div>

                        <!-- LISTA DE PERFILES -->
                        <div id="listaPermisosPerfiles" class="space-y-4 h-96 overflow-y-auto pr-2">




                        </div>
                    </div>
                </section>

            </div>
        </main>

        <div id="modalPermisos"
            class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm items-center justify-center transition z-50">

            <div class="bg-white rounded-3xl w-full max-w-lg p-8 shadow-2xl scale-95 opacity-0 transition duration-300 relative"
                id="modalContent">

                <h2 class="text-2xl font-extrabold mb-2 text-gray-800 flex items-center">
                    <span class="mr-3 text-emerald-600">⚙️</span> Editar Permisos
                </h2>

                <p id="modalInfo" class="text-sm text-gray-600 mb-6 border-b pb-3"></p>

                <div id="listaAcciones" class="space-y-4 h-64 overflow-y-auto pr-2">

                    <!-- Aqui van los modulos -->

                    <!--fin-->
                </div>

                <div class="flex justify-end mt-8 space-x-3">
                    <button id="btnCancelarModal"
                        class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer transition">
                        Cancelar
                    </button>

                    <button type="submit" id="btnGuardarPermisos"
                        class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 cursor-pointer transition shadow-lg shadow-emerald-500/50">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

        <footer class="py-4 text-center text-gray-500 border-t border-gray-200 mt-auto">
            © 2025 Gestión de Roles. Todos los derechos reservados.
        </footer>

    </div>

    <div id="modalCrearRol" class="hidden fixed inset-0 bg-black/50 backdrop-blur-md items-center justify-center z-60">
        <div class="bg-white w-full max-w-md p-8 rounded-3xl shadow-2xl relative transition duration-300 transform scale-95 opacity-0" id="crearRolContent">

            <button id="cerrarCrearRol" class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 text-2xl transition">✕</button>

            <h2 class="text-2xl font-extrabold mb-6 text-gray-800 border-b pb-3">Crear Nuevo Rol</h2>

            <form id="formCrearRol" class="space-y-4">
                <div>
                    <label class="font-semibold text-gray-700 mb-1 block">Nombre del Rol</label>
                    <input type="text" name="nombreRol" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-3 focus:ring-violet-500 focus:border-violet-500 transition" required>
                </div>

                <button type="submit"
                    class="cursor-pointer w-full bg-violet-600 text-white py-3 rounded-xl font-bold hover:bg-violet-700 transition shadow-lg shadow-violet-500/50 mt-6">
                    Guardar Rol
                </button>
            </form>
        </div>
    </div>


    <script src="../../../src/js/iziToast.min.js"></script>
    <script src="../../../src/js/roles-main.js"></script>
    <script src="../../../src/js/permisos.js"></script>
    <script src="../../../src/js/aside.js"></script>
</body>

</html>