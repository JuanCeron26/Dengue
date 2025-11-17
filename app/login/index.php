<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#0B5394] via-[#1E88E5] to-[#42A5F5] flex items-center justify-center p-4">

    <!-- Contenedor -->
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

        <!-- Panel Izquierdo -->
        <div class="md:w-1/2 bg-gradient-to-br from-[#1e3a8a] via-[#1e40af] to-[#2563eb] p-10 relative overflow-hidden flex flex-col">

            <!-- Decoraciones -->
            <div class="absolute top-0 left-0 w-72 h-52 bg-blue-400/20 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400/20 rounded-full -translate-x-1/3 translate-y-1/3"></div>
            <div class="absolute bottom-16 left-16 w-30 h-40 bg-blue-500/30 rounded-full"></div>

            <!-- Texto centrado -->
            <div class="relative z-10 flex flex-col justify-center items-center text-center flex-grow">

                <h1 class="text-white text-7xl md:text-5xl mb-4 font-bold">
                    BIENVENIDOS
                </h1>

                <p class="text-white text-sm md:text-base mb-10 leading-snug">
                    Llevemos un control del dengue<br />
                    que nos proteja a <span class="font-semibold">TODOS</span>
                </p>

            </div>

        </div>

        <!-- Panel Derecho -->
        <div class="md:w-1/2 p-10 flex flex-col justify-center items-center bg-gray-50">

            <div class="w-full max-w-md">

                <h2 class="text-2xl text-gray-400 text-center mb-2 font-semibold">INICIAR SESIÓN</h2>
                <p class="text-center text-gray-600 mb-6 text-sm">Por favor inicia sesión</p>

                <form class="space-y-5">

                    <!-- Usuario -->
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600">
                            <img src="../../src/icons/user-solid-full.svg" class="w-5 h-5" />
                        </div>
                        <input type="text" placeholder="Nombre de usuario"
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500 transition" />
                    </div>

                    <!-- Contraseña -->
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600">
                            <img src="../../src/icons/lock-solid-full.svg" class="w-5 h-5" />
                        </div>
                        <input type="password" placeholder="Escribe tu contraseña"
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500 transition" />
                    </div>

                    <div class="text-center">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">¿Olvidó la contraseña?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#1e3a8a] hover:bg-[#1e40af] text-white py-3 text-lg rounded-full transition">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Logo Alcaldía -->
                <div class="mt-8 flex justify-center">
                    <img src="../../src/img/logo-secretaria.png"
                        alt="Alcaldía de Santiago de Cali"
                        class="h-32 w-auto" />
                </div>

            </div>
        </div>

    </div>

</body>

</html>