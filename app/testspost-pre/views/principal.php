<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Evaluación</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-dark': '#005F3D',
                        'primary-light': '#A5D7AE',
                        'accent-light': '#8EBBFF',
                        'accent-blue': '#4A7BFF',
                        'secondary-light': '#9AC2DA',
                        'secondary-dark': '#3E6E83',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-primary-light/30 to-secondary-light/30 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-accent-blue rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-primary-dark mb-2">Sistema de Evaluación</h1>
            <p class="text-secondary-dark">Selecciona el tipo de evaluación que deseas realizar</p>
        </div>

        <!-- Main Cards -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Pre-Test Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-accent-light">
                <div class="p-8">
                    <div class="flex justify-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-accent-light to-accent-blue rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-primary-dark text-center mb-3">Pre-Test</h2>
                    <p class="text-secondary-dark text-center mb-6">Evaluación inicial antes de la capacitación</p>
                    <button class="w-full bg-gradient-to-r from-accent-light to-accent-blue text-white font-semibold py-3 px-6 rounded-lg hover:from-accent-blue hover:to-accent-light transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5" href= "pre.php">
                        Iniciar Pre-Test
                    </button>
                </div>
            </div>

            <!-- Post-Test Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-primary-light" href= "post.php">
                <div class="p-8">
                    <div class="flex justify-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-primary-light to-primary-dark rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-primary-dark text-center mb-3">Post-Test</h2>
                    <p class="text-secondary-dark text-center mb-6">Evaluación final después de la capacitación</p>
                    <button class="w-full bg-gradient-to-r from-primary-light to-primary-dark text-white font-semibold py-3 px-6 rounded-lg hover:from-primary-dark hover:to-primary-light transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Iniciar Post-Test
                    </button>
                </div>
            </div>
        </div>

        <!-- Instructions Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-accent-blue">
            <h3 class="text-xl font-bold text-primary-dark mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Instrucciones
            </h3>
            <ol class="space-y-4">
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-light to-accent-blue text-white rounded-full flex items-center justify-center font-bold mr-4">1</span>
                    <p class="text-secondary-dark pt-1">Selecciona el tipo de evaluación según el momento de la capacitación</p>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-light to-accent-blue text-white rounded-full flex items-center justify-center font-bold mr-4">2</span>
                    <p class="text-secondary-dark pt-1">Utiliza los botones + y - para registrar las respuestas de cada participante</p>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-light to-accent-blue text-white rounded-full flex items-center justify-center font-bold mr-4">3</span>
                    <p class="text-secondary-dark pt-1">Revisa el resumen automático con los totales y porcentajes</p>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-light to-accent-blue text-white rounded-full flex items-center justify-center font-bold mr-4">4</span>
                    <p class="text-secondary-dark pt-1">Puedes reiniciar los contadores en cualquier momento si es necesario</p>
                </li>
            </ol>
        </div>

        <!-- Additional Features Section -->
        <div class="mt-8 grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-primary-dark hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-primary-light rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-primary-dark mb-2">Exportar Resultados</h4>
                <p class="text-sm text-secondary-dark">Descarga los resultados en formato CSV o PDF</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-secondary-dark hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-secondary-light rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-secondary-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-primary-dark mb-2">Gráficos Visuales</h4>
                <p class="text-sm text-secondary-dark">Compara resultados entre Pre-Test y Post-Test</p>
            </div>
        </div>
    </div>
</body>

</html>