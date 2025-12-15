<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../src/css/styles.css">
    <link rel="stylesheet" href="../../src/css/iziToast.min.css">
    <title>Inicio de Sesión</title>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 0.9;
            }
        }

        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 6s ease-in-out infinite 2s;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .animate-slide-in-left {
            animation: slide-in-left 0.8s ease-out;
        }

        .animate-slide-in-right {
            animation: slide-in-right 0.8s ease-out;
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus-effect:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .gradient-border {
            position: relative;
            background: white;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6, #06b6d4);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gradient-border:focus-within::before {
            opacity: 1;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-700 to-cyan-500 flex items-center justify-center p-4 animate-fade-in">

    <!-- Contenedor Principal -->
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row transform hover:shadow-blue-500/20 hover:shadow-3xl transition-all duration-500">

        <!-- Panel Izquierdo - Hero -->
        <div class="md:w-1/2 bg-gradient-to-br from-blue-950 via-blue-800 to-blue-600 p-12 relative overflow-hidden flex flex-col animate-slide-in-left rounded-r-3xl">

            <!-- Elementos decorativos animados -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-400/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl animate-float-delayed"></div>
            <div class="absolute top-1/2 left-1/2 w-40 h-40 bg-purple-400/10 rounded-full blur-2xl animate-pulse-glow"></div>

            <!-- Contenido centrado -->
            <div class="relative z-10 flex flex-col justify-center items-center text-center flex-grow">

                <!-- Icono decorativo -->
                <div class="mb-8 transform hover:scale-110 transition-transform duration-500">
                    <div class="w-24 h-24 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-3xl flex items-center justify-center shadow-2xl rotate-12 hover:rotate-0 transition-transform duration-500">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-white text-5xl md:text-6xl mb-6 font-bold tracking-tight">
                    BIENVENIDOS
                </h1>

                <div class="h-1 w-24 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full mb-6"></div>

                <p class="text-blue-100 text-base md:text-lg mb-4 leading-relaxed max-w-md">
                    Llevemos un control del dengue<br />
                    que nos proteja a <span class="font-bold text-cyan-300">TODOS</span>
                </p>

                <div class="mt-8 flex gap-3">
                    <div class="w-3 h-3 bg-cyan-400 rounded-full animate-pulse"></div>
                    <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                    <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                </div>

            </div>

        </div>

        <!-- Panel Derecho - Formulario -->
        <div class="md:w-1/2 p-12 flex flex-col justify-center items-center bg-gradient-to-br from-gray-50 to-blue-50 animate-slide-in-right">

            <div class="w-full max-w-md">

                <!-- Header del formulario -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl text-gray-800 mb-3 font-bold tracking-tight">
                        Iniciar Sesión
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Accede a tu panel de control
                    </p>
                </div>

                <form class="space-y-6" id="formLogin">

                    <!-- Campo Usuario -->
                    <div class="gradient-border rounded-full transition-all duration-300">
                        <div class="relative group">
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                <img src="../../src/icons/icono_user.png" class="w-5 h-5" />
                            </div>
                            <input
                                type="text"
                                placeholder="Escribe tu documento"
                                id="documento"
                                class="w-full pl-14 pr-5 py-4 bg-white border-2 border-gray-200 rounded-full focus:outline-none focus:border-blue-500 transition-all duration-300 input-focus-effect hover:border-blue-300" />
                        </div>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="gradient-border rounded-full transition-all duration-300">
                        <div class="relative group">
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                <img src="../../src/icons/icono_lock.png" class="w-5 h-5" />
                            </div>
                            <input
                                type="password"
                                placeholder="Escribe tu contraseña"
                                id="password"
                                class="w-full pl-14 pr-5 py-4 bg-white border-2 border-gray-200 rounded-full focus:outline-none focus:border-blue-500 transition-all duration-300 input-focus-effect hover:border-blue-300" />
                        </div>
                    </div>

                    <!-- Link olvidó contraseña -->
                    <div class="text-center">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline transition-all duration-300 inline-block hover:scale-105">
                            ¿Olvidó la contraseña?
                        </a>
                    </div>

                    <!-- Botón Submit -->
                    <button
                        type="submit"
                        class="cursor-pointer w-full bg-linear-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white py-4 text-lg font-semibold rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/50 active:scale-95">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Logo Alcaldía -->
                <div class="mt-10 flex justify-center">
                    <div class="transform hover:scale-105 transition-transform duration-300">
                        <img
                            src="../../src/icons/logo-secretaria.png"
                            alt="Alcaldía de Santiago de Cali"
                            class="h-40 w-auto opacity-90 hover:opacity-100 transition-opacity duration-300" />
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!--JS-->
    <script src="../../src/js/iziToast.min.js"></script>
    <script src="../../src/js/login.js"></script>

</body>

</html>