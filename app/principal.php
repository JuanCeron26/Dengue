<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Ecosalud</title>
    <link rel="stylesheet" href="../src/css/styles.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 50%, #eff6ff 100%);
            min-height: 100vh;
        }

        /* Animaciones */
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-slide-left {
            animation: slideInFromLeft 0.6s ease-out forwards;
        }

        .animate-slide-right {
            animation: slideInFromRight 0.6s ease-out forwards;
        }

        .animate-fade {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Hero Section */
        .hero-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(30, 64, 175, 0.3);
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 50%;
        }

        .hero-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08), transparent);
            border-radius: 50%;
        }

        /* Module Cards con efecto 3D */
        .module-card {
            background: #ffffff;
            border-radius: 24px;
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
        }

        .module-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 2px;
            background: linear-gradient(135deg, #3b82f6, #7c8db5);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s;
        }

        .module-card:hover::before {
            opacity: 1;
        }

        .module-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px rgba(30, 64, 175, 0.25);
        }

        /* Icon container con gradiente */
        .icon-box {
            width: 90px;
            height: 90px;
            border-radius: 22px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .module-card:hover .icon-box {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            transform: rotate(-5deg) scale(1.1);
        }

        .icon-box img {
            width: 55px;
            height: 55px;
            transition: all 0.3s ease;
            filter: saturate(1.2);
        }

        .module-card:hover .icon-box img {
            filter: brightness(1.3) saturate(1.4);
        }

        /* Stats mini cards */
        .stat-mini {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e0e7ff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(30, 64, 175, 0.05);
        }

        .stat-mini:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.15);
            transform: translateY(-3px);
        }

        /* Sidebar Navigation */
        .sidebar-item {
            background: #ffffff;
            border-radius: 16px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .sidebar-item:hover {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-color: #3b82f6;
            transform: translateX(8px);
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
        }

        /* Badge pulse */
        @keyframes badge-pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .badge-animate {
            animation: badge-pulse 2s ease-in-out infinite;
        }

        /* Floating decorations */
        .float-decoration {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 64, 175, 0.05));
            pointer-events: none;
        }

        @keyframes float-gentle {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .float-1 {
            animation: float-gentle 8s ease-in-out infinite;
        }

        .float-2 {
            animation: float-gentle 10s ease-in-out infinite;
            animation-delay: 1s;
        }

        .float-3 {
            animation: float-gentle 12s ease-in-out infinite;
            animation-delay: 2s;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .icon-box {
                width: 70px;
                height: 70px;
            }

            .icon-box img {
                width: 42px;
                height: 42px;
            }
        }
    </style>
</head>

<body>

    <div id="loader" class="fixed inset-0 flex justify-center items-center bg-white z-50">
        <div
            class="w-32 aspect-square rounded-full relative flex justify-center items-center animate-[spin_3s_linear_infinite] z-40 bg-[conic-gradient(white_0deg,white_300deg,transparent_270deg,transparent_360deg)] before:animate-[spin_2s_linear_infinite] before:absolute before:w-[60%] before:aspect-square before:rounded-full before:z-[80] before:bg-[conic-gradient(white_0deg,white_270deg,transparent_180deg,transparent_360deg)] after:absolute after:w-3/4 after:aspect-square after:rounded-full after:z-[60] after:animate-[spin_3s_linear_infinite] after:bg-[conic-gradient(#1e3a8a_0deg,#1e3a8a_180deg,transparent_180deg,transparent_360deg)]">
            <span
                class="absolute w-[85%] aspect-square rounded-full z-[60] animate-[spin_5s_linear_infinite] bg-[conic-gradient(#3b82f6_0deg,#3b82f6_180deg,transparent_180deg,transparent_360deg)]">
            </span>
        </div>
    </div>


    <!-- Decorative floating elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="float-decoration w-64 h-64 top-20 right-20 float-1"></div>
        <div class="float-decoration w-80 h-80 bottom-40 left-10 float-2"></div>
        <div class="float-decoration w-48 h-48 top-1/2 left-1/3 float-3"></div>
    </div>

    <div class="min-h-screen p-4 md:p-8">
        <div class="max-w-[1400px] mx-auto">

            <!-- Top Navigation Bar -->
            <nav class="flex items-center justify-between mb-8 animate-fade">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center shadow-xl">
                        <span class="text-white font-bold text-2xl">C</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-blue-900">CERO DENGUE</h1>
                        <p class="text-sm text-blue-600">Sistema de Gestión</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button class="hidden md:flex items-center gap-2 px-4 py-2 bg-white rounded-full border-2 border-blue-200 hover:border-blue-400 transition-all">
                        <span class="w-2 h-2 bg-green-500 rounded-full badge-animate"></span>
                        <span class="text-sm font-medium text-blue-900">En línea</span>
                    </button>
                    <button class="w-12 h-12 rounded-full bg-white border-2 border-blue-200 hover:border-blue-400 flex items-center justify-center transition-all shadow-sm hover:shadow-md">
                        <span class="text-xl">🔔</span>
                    </button>
                    <button class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center shadow-md hover:shadow-xl transition-all">
                        <span class="text-xl">👤</span>
                    </button>
                </div>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Sidebar -->
                <aside class="lg:col-span-3 space-y-4 animate-slide-left">

                    <!-- Hero Card -->
                    <div class="hero-card p-8 relative z-10">
                        <div class="relative z-10">
                            <h2 class="text-white text-2xl font-bold mb-2">¡Hola! 👋</h2>
                            <p class="text-blue-100 text-sm mb-6">Bienvenido de nuevo a tu dashboard</p>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-white">
                                    <span class="text-sm">Progreso del día</span>
                                    <span class="text-sm font-bold">78%</span>
                                </div>
                                <div class="w-full bg-blue-800/30 rounded-full h-2">
                                    <div class="bg-white rounded-full h-2" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="space-y-3">
                        <div class="stat-mini p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-blue-600 font-medium">Usuarios Activos</p>
                                    <p class="text-2xl font-bold text-blue-900">1,234</p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-2xl">👥</span>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2 font-medium">↑ 12% este mes</p>
                        </div>

                        <div class="stat-mini p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-blue-600 font-medium">Tareas Hoy</p>
                                    <p class="text-2xl font-bold text-blue-900">48</p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-2xl">✅</span>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2 font-medium">6 completadas</p>
                        </div>

                        <div class="stat-mini p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-blue-600 font-medium">Rendimiento</p>
                                    <p class="text-2xl font-bold text-blue-900">94%</p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-2xl">⚡</span>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2 font-medium">Excelente</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-blue-900 px-2">Acceso Rápido</h3>
                        <button class="sidebar-item w-full p-4 text-left">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">⚙️</span>
                                <span class="text-sm font-medium text-blue-900">Configuración</span>
                            </div>
                        </button>
                        <button class="sidebar-item w-full p-4 text-left">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">📊</span>
                                <span class="text-sm font-medium text-blue-900">Estadísticas</span>
                            </div>
                        </button>
                        <button class="sidebar-item w-full p-4 text-left">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">💬</span>
                                <span class="text-sm font-medium text-blue-900">Soporte</span>
                            </div>
                        </button>
                    </div>

                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-9 animate-slide-right">

                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Módulos del Sistema</h2>
                        <p class="text-blue-600">Selecciona un módulo para comenzar</p>
                    </div>

                    <!-- Modules Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <!-- Usuarios -->
                        <a href="./usuarios/views/dashboard.php" class="module-card p-6 block group" style="animation-delay: 0.1s;">
                            <div class="icon-box mb-5 mx-auto">
                                <img src="../src/gif/lider.gif" alt="Usuarios">
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2 text-center group-hover:text-blue-600 transition-colors">Usuarios</h3>
                            <p class="text-sm text-blue-600 text-center mb-4">Gestión de usuarios y permisos</p>
                            <div class="flex items-center justify-center gap-2 text-blue-500 text-sm font-semibold">
                                <span>Acceder</span>
                                <span class="group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </a>

                        <!-- Gráficas -->
                        <a href="#" class="module-card p-6 block group" style="animation-delay: 0.2s;">
                            <div class="icon-box mb-5 mx-auto">
                                <img src="../src/gif/grafico-de-linea.gif" alt="Gráficas">
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2 text-center group-hover:text-blue-600 transition-colors">Gráficas</h3>
                            <p class="text-sm text-blue-600 text-center mb-4">Visualización de datos</p>
                            <div class="flex items-center justify-center gap-2 text-blue-500 text-sm font-semibold">
                                <span>Acceder</span>
                                <span class="group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </a>

                        <!-- Mapa -->
                        <a href="#" class="module-card p-6 block group" style="animation-delay: 0.3s;">
                            <div class="icon-box mb-5 mx-auto">
                                <img src="../src/gif/ubicacion.gif" alt="Mapa">
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2 text-center group-hover:text-blue-600 transition-colors">Mapa</h3>
                            <p class="text-sm text-blue-600 text-center mb-4">Geolocalización en tiempo real</p>
                            <div class="flex items-center justify-center gap-2 text-blue-500 text-sm font-semibold">
                                <span>Acceder</span>
                                <span class="group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </a>

                        <!-- Empresa -->
                        <a href="./ecosalud/views/consultar.php" class="module-card p-6 block group" style="animation-delay: 0.4s;">
                            <div class="icon-box mb-5 mx-auto">
                                <img src="../src/gif/ecologico.gif" alt="Empresa">
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2 text-center group-hover:text-blue-600 transition-colors">Ecosalud</h3>
                            <p class="text-sm text-blue-600 text-center mb-4">Información corporativa</p>
                            <div class="flex items-center justify-center gap-2 text-blue-500 text-sm font-semibold">
                                <span>Acceder</span>
                                <span class="group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </a>

                        <!-- Control Biológico -->
                        <a href="biologico.php" class="module-card p-6 block group" style="animation-delay: 0.5s;">
                            <div class="icon-box mb-5 mx-auto">
                                <img src="../src/gif/sostenibilidad.gif" alt="Control">
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2 text-center group-hover:text-blue-600 transition-colors">Control Biológico</h3>
                            <p class="text-sm text-blue-600 text-center mb-4">Monitoreo de procesos</p>
                            <div class="flex items-center justify-center gap-2 text-blue-500 text-sm font-semibold">
                                <span>Acceder</span>
                                <span class="group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </a>

                        <!-- Reportes -->
                        <a href="./INFORMES/actividadescampo/views/estadisticas.php" class="module-card p-6 block group" style="animation-delay: 0.6s;">
                            <div class="icon-box mb-5 mx-auto">
                                <img src="../src/gif/informe.gif" alt="Reportes">
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2 text-center group-hover:text-blue-600 transition-colors">Reportes</h3>
                            <p class="text-sm text-blue-600 text-center mb-4">Informes y análisis</p>
                            <div class="flex items-center justify-center gap-2 text-blue-500 text-sm font-semibold">
                                <span>Acceder</span>
                                <span class="group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </a>

                    </div>

                    <!-- Bottom Banner -->
                    <div class="mt-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-8 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold mb-2">¿Necesitas ayuda?</h3>
                            <p class="text-blue-100 mb-4">Nuestro equipo está disponible 24/7 para asistirte</p>
                            <button class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-blue-50 transition-all shadow-lg">
                                Contactar Soporte
                            </button>
                        </div>
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                    </div>

                </main>

            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden')
            }, 1000);
        })
    </script>
</body>

</html>