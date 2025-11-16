<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">
    <title>Gestión de Usuarios</title>

    <style>
        /* Animación flotante suave */
        .float-soft {
            animation: floatSoft 6s ease-in-out infinite;
        }

        @keyframes floatSoft {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Animación pulse-glow */
        .pulse-glow {
            animation: pulseGlow 3s infinite;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                /* Color verde para el glow (opcional, puedes ajustarlo) */
                box-shadow: 0 0 10px rgba(34, 197, 94, 0.4);
            }

            50% {
                box-shadow: 0 0 20px rgba(34, 197, 94, 0.8);
            }
        }
    </style>
</head>

<body class="min-h-screen w-full bg-gray-50">

    <div id="layout" class="min-h-screen flex flex-col">

        <header class="sticky top-0 z-20 flex justify-between items-center px-10 py-4 bg-gray-800 bg-opacity-95 backdrop-blur-sm shadow-xl border-b border-gray-700 transition-colors duration-300">
            <div class="flex items-center space-x-5">
                <div class="p-3 rounded-lg bg-blue-900 shadow-inner animate-pulse-slow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm-1 9h2v2h-2v-2zm0-6h2v5h-2V5z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-100 tracking-wide select-none">Gestión de Usuarios</h1>
                    <p class="mt-1 text-blue-400 font-medium text-sm select-none">Módulo de administración</p>
                </div>
            </div>

            <div class="flex items-center space-x-5">
                <div class="text-right">
                    <p class="font-semibold text-gray-300 select-none">Juan José Cerón</p>
                    <p class="text-blue-400 text-sm select-none">Administrador</p>
                </div>
                <div class="cursor-pointer bg-blue-700 text-white font-semibold rounded-full h-12 w-12 flex items-center justify-center ring-2 ring-blue-500 hover:ring-4 hover:bg-blue-800 transition duration-300 ease-in-out transform hover:scale-110 select-none">
                    JC
                </div>
            </div>
        </header>

        <div id="view" class="transition-transform duration-700 ease-out">

            <main class="px-10 py-8 grow">

                <div class="flex justify-between items-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 select-none tracking-wider border-b-2 border-blue-500 pb-1">🗂️ Directorio de Perfiles</h2>
                    <button id="btnRegistrarUsuario"
                        class="cursor-pointer relative overflow-hidden bg-green-600 text-white px-6 py-3 rounded-full font-bold shadow-xl ring-4 ring-green-400 hover:ring-green-600 transition-transform duration-300 transform hover:scale-105 hover:shadow-green-700/50 active:scale-95"
                        title="Registrar nuevo usuario">
                        + Crear Nuevo Usuario
                    </button>
                </div>

                <div class="flex items-center space-x-6 mb-8 p-4 bg-white rounded-xl shadow-lg border border-gray-200">
                    <label for="filtro-rol" class="text-gray-600 font-semibold select-none">Filtrar por Rol:</label>
                    <select id="filtro-rol"
                        class="bg-gray-100 text-gray-800 border border-gray-300 rounded-lg py-2 px-4 focus:ring-blue-500 focus:border-blue-500 transition duration-200 w-48 appearance-none cursor-pointer">
                        <option value="todos">Todos los Roles</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Editor">Editor</option>
                        <option value="Vendedor">Vendedor</option>
                    </select>

                    <label for="buscar-usuario" class="text-gray-600 font-semibold select-none ml-auto">Buscar:</label>
                    <input type="text" id="buscar-usuario" placeholder="Nombre o Cédula..."
                        class="bg-gray-100 text-gray-800 border border-gray-300 rounded-lg py-2 px-4 focus:ring-blue-500 focus:border-blue-500 transition duration-200 w-64">
                </div>

                <div id="divUsuarios" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <div class="user-card bg-white rounded-2xl p-6 shadow-xl border border-gray-200 hover:shadow-blue-300/50 transition-all duration-300 transform hover:scale-[1.03] float-soft" data-rol="Administrador">

                        <div class="flex items-center space-x-4 border-b border-gray-200 pb-4 mb-4">
                            <div class="bg-blue-600 text-white font-bold rounded-full h-14 w-14 flex items-center justify-center text-xl ring-2 ring-blue-400 select-none pulse-glow">
                                JC
                            </div>
                            <div>
                                <h3 class="text-xl font-extrabold text-gray-800 select-none">Juan José Cerón</h3>
                                <p class="text-sm text-blue-600 font-semibold select-none">Administrador</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-gray-600 flex items-center">
                                <span class="text-blue-500 mr-3">📧</span>
                                <span class="font-medium truncate" title="juan.ceron@email.com">juan.ceron@email.com</span>
                            </p>
                            <p class="text-gray-600 flex items-center">
                                <span class="text-blue-500 mr-3">🆔</span>
                                <span class="font-medium">C.C. 1002345678</span>
                            </p>
                            <p class="text-gray-600 flex items-center">
                                <span class="text-blue-500 mr-3">🏷️</span>
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-green-300">Empleado</span>
                            </p>
                        </div>

                        <div class="mt-6 flex justify-between space-x-3">
                            <button
                                class="flex-1 bg-blue-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition duration-200 transform hover:scale-[1.05] shadow-md hover:shadow-blue-500/50"
                                title="Ver detalles completos">
                                Ver Detalle
                            </button>
                            <button
                                class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition duration-200 transform hover:rotate-6"
                                title="Editar">
                                <img src="../../../src/icons/icono_edit.png" class="w-5 h-5" alt="">
                            </button>
                            <button
                                class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition duration-200 transform hover:-rotate-6"
                                title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </main>

            <footer class="py-4 text-center text-gray-500 border-t border-gray-200">
                © 2025 Gestión de Usuarios. Todos los derechos reservados.
            </footer>
        </div>

        <!-- MODAL REGISTRO USUARIO -->
        <main id="ui-registrar-usuario" class="hidden mt-5 opacity-0 translate-x-full transition-transform duration-700 ease-out px-10 pb-20 grow justify-center mx-auto">


            <form action="../backend/api.php?accion=registrar" method="POST" id="formRegistro" class="w-full max-w-4xl bg-white rounded-2xl p-10 shadow-2xl border border-gray-200 transform transition-all duration-500 hover:shadow-blue-300/50 float-soft">


                <h2 class="text-3xl font-bold text-gray-800 mb-8 tracking-wide border-b-4 pb-2 border-blue-500">📝 Nuevo Registro</h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


                    <div class="group">
                        <label class="text-gray-700 font-bold">Nombre</label>
                        <input type="text" name="nombre" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]" />
                    </div>


                    <div class="group">
                        <label class="text-gray-700 font-bold">Apellido</label>
                        <input type="text" name="apellido" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]" />
                    </div>


                    <div class="group">
                        <label class="text-gray-700 font-bold">Tipo de Documento</label>
                        <select id="selectTI" name="tipo_documento" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 cursor-pointer focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]">
                            <!--Aqui va la parte que se hace con JS-->
                        </select>
                    </div>


                    <div class="group">
                        <label class="text-gray-700 font-bold">Número Documento</label>
                        <input type="text" name="numero_documento" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]" />
                    </div>


                    <div class="group">
                        <label class="text-gray-700 font-bold">Correo Electrónico</label>
                        <input type="email" name="correo" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]" />
                    </div>


                    <div class="group">
                        <label class="text-gray-700 font-bold">Rol</label>
                        <select id="selectRol"
                            name="rol" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 cursor-pointer focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]">
                            <!--Lo mismo-->
                        </select>
                    </div>


                    <div class="group">
                        <label class="text-gray-700 font-bold">Segmento</label>
                        <select id="selectSegmento" name="segmento" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 cursor-pointer focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]">
                            <!--Lo mismo-->
                        </select>
                    </div>

                    <div class="group">
                        <label class="text-gray-700 font-bold">Contraseña</label>
                        <input type="password" name="password" class="w-full mt-2 bg-gray-100 border border-gray-300 rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:scale-[1.02]" />
                    </div>


                </div>


                <div class="mt-12 flex justify-end space-x-4">
                    <button id="cancelarRegistro" type="button" class="cursor-pointer bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-xl shadow-md hover:bg-gray-400 transition duration-300 transform hover:-rotate-2">Cancelar</button>


                    <button type="submit" class="cursor-pointer bg-blue-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-blue-500/50 transition duration-300 transform hover:scale-105 hover:rotate-1">Guardar Usuario</button>
                </div>
            </form>
        </main>

        <!-- Modal Editar Usuario -->
        <div id="modalEditarUsuario" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 h-screen w-full">
            <div class="bg-white rounded-2xl p-6 w-96 relative m-auto">
                <button id="cerrarModal" type="button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>
                <form id="formEditarUsuario" class="space-y-4">
                    <!-- ID oculto -->
                    <input type="hidden" id="idUsuario" name="idUsuario">

                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-medium">Nombre</label>
                        <input type="text" id="nombreUsuario" name="nombreUsuario" class="w-full border rounded-lg p-2">
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label class="block text-sm font-medium">Apellido</label>
                        <input type="text" id="apellidoUsuario" name="apellidoUsuario" class="w-full border rounded-lg p-2">
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium">Correo</label>
                        <input type="email" id="correoUsuario" name="correoUsuario" class="w-full border rounded-lg p-2">
                    </div>

                    <!-- Número de Identificación -->
                    <div>
                        <label class="block text-sm font-medium">Número de Identificación</label>
                        <input type="text" id="idCedulaUsuario" name="idCedulaUsuario" class="w-full border rounded-lg p-2">
                    </div>

                    <!-- Tipo de Documento -->
                    <div>
                        <label class="block text-sm font-medium">Tipo de Documento</label>
                        <select id="tipoDocUsuario" name="tipoDocUsuario" class="w-full border rounded-lg p-2">

                        </select>
                    </div>

                    <!-- Segmento -->
                    <div>
                        <label class="block text-sm font-medium">Segmento</label>
                        <select id="segmentoUsuario" name="segmentoUsuario" class="w-full border rounded-lg p-2">

                        </select>
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="block text-sm font-medium">Rol</label>
                        <select id="rolUsuario" name="rolUsuario" class="w-full border rounded-lg p-2">

                        </select>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label class="block text-sm font-medium">Contraseña</label>
                        <input type="password" id="passUsuario" name="passUsuario" class="w-full border rounded-lg p-2" placeholder="Dejar vacío para no cambiar">
                    </div>

                    <button type="submit" class="bg-yellow-500 text-white w-full p-2 rounded-lg hover:bg-yellow-600 transition">Guardar Cambios</button>
                </form>
            </div>
        </div>

        <!-- MODAL DE DETALLE -->
        <div id="modalDetalleUsuario"
            class="hidden fixed inset-0 items-center justify-center backdrop-blur-md bg-black/20 z-50 transition-all duration-300">

            <div class="relative bg-gray-500 backdrop-blur-xl rounded-3xl p-8 w-[420px] shadow-2xl border border-white/30
                scale-90 opacity-0 transition-all duration-500" id="cardDetalle">

                <!-- Cerrar -->
                <button id="cerrarDetalle"
                    class="cursor-pointer absolute top-4 right-4 text-white bg-white/20 backdrop-blur-lg p-2 rounded-full hover:bg-white/40 transition">
                    ✕
                </button>

                <!-- Avatar -->
                <div class="flex flex-col items-center mb-6">
                    <div class="h-28 w-28 rounded-full bg-linear-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg ring-4 ring-white/30 select-none">
                        <span id="detalleIniciales">AB</span>
                    </div>

                    <h2 id="detalleNombre"
                        class="mt-4 text-2xl font-extrabold text-white drop-shadow-lg tracking-wide">
                        Nombre Apellido
                    </h2>
                    <p id="detalleRol" class="text-blue-200 font-semibold -mt-1">
                        Rol del usuario
                    </p>
                </div>

                <!-- Datos -->
                <div class="space-y-4 text-white">
                    <div class="flex items-center space-x-3">
                        <span class="text-xl">📧</span>
                        <p id="detalleCorreo" class="font-medium"></p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <span class="text-xl">🆔</span>
                        <p id="detalleCedula" class="font-medium"></p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <span class="text-xl">🏷</span>
                        <p id="detalleSegmento" class="font-medium"></p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <span class="text-xl">📄</span>

                        <div class="relative flex items-center">
                            <input readonly type="password" id="detallePassword" class="font-medium pr-10">

                            <button id="togglePassword" type="button"
                                class="cursor-pointer absolute right-2 text-gray-700 hover:text-gray-800">
                                <img src="../../../src/icons/icono_eye.png" class=" w-7 h-7" alt="">
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <script src="../../../src/js/iziToast.min.js"></script>
    <script src="../../../src/js/usuarios-main.js"></script>
</body>

</html>