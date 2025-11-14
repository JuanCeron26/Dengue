<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Zoocriadero</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-sky-100 flex justify-center items-center min-h-screen p-4">

  
    <div class="bg-white w-full max-w-[700px] rounded-3xl p-10 shadow-2xl border border-blue-100">

        <h1 class="text-3xl font-extrabold text-center mb-10 text-gray-700 tracking-wide">
            Registrar Zoocriadero
        </h1>

        <form class="space-y-6">

            
            <div class="grid grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label class="text-sm font-semibold">Nombre del Zoocriadero</label>
                    <input class="w-full bg-sky-100 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-400 outline-none"
                        placeholder="Escribe el nombre">
                </div>

                <!-- Usuario  en la tabla de registrar zoocriadero aparece un usuario entonces
                 no se como lo vamos a manejar por eso puse el input de usuario-->
                <div>
                    <label class="text-sm font-semibold">Usuario</label>
                    <input class="w-full bg-sky-100 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-400 outline-none"
                        placeholder="Usuario">
                </div>
            </div>

            <!-- Barrio -->
            <div>
                <label class="text-sm font-semibold">Barrio</label>
                <div class="relative">
                    <select
                        class="w-full bg-sky-100 rounded-xl px-4 py-3 text-sm pr-10 focus:ring-2 focus:ring-blue-400 outline-none cursor-pointer">
                        <option value="">Selecciona un barrio</option>
                        <option>Manrique</option>
                        <option>Aranjuez</option>
                        <option>Villa Hermosa</option>
                        <option>Robledo</option>
                        <option>Belén</option>
                        <option>El Poblado</option>
                        <option>Buenos Aires</option>
                        <option>Castilla</option>
                        <option>La América</option>
                    </select>

                    
                </div>
            </div>

            <!-- DIRECCIÓN Vi en internet y masomenos de estas opciones asi aparecen las direcciones algunas
             tienen todos esos numeros y letras y otras no -->
            <div>
                <label class="text-sm font-semibold">Dirección</label>

                <div class="grid grid-cols-3 gap-4 mt-2">

                    <!-- Columna izquierda -->
                    <div class="space-y-3">
                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>CALLE</option>
                            <option>CARRERA</option>
                            <option>AV</option>
                            <option>DIAGONAL</option>
                        </select>

                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>1</option>
                            <option>50</option>
                            <option>71</option>
                            <option>71B</option>
                        </select>

                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option></option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                        </select>
                    </div>

                    <!-- Columna central -->
                    <div class="space-y-3">
                        <div class="font-bold text-center text-xl">#</div>

                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>1</option>
                            <option>5</option>
                            <option>8</option>
                        </select>

                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option></option>
                            <option>A</option>
                            <option>B</option>
                        </select>
                    </div>

                    <!-- Columna derecha -->
                    <div class="space-y-3">
                        <div class="font-bold text-center text-xl">-</div>

                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>1</option>
                            <option>10</option>
                            <option>20</option>
                        </select>

                        <select class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option></option>
                            <option>A</option>
                            <option>B</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- TIPOS DE TANQUES (prometo mjeorar los iconos pero no se me ocurre más por el momento)-->
            <div>
                <label class="text-sm font-semibold">Tipo de tanques</label>

                <div class="grid grid-cols-4 gap-5 mt-3">

                   
                    <label class="cursor-pointer">
                        <input type="checkbox" class="hidden peer">
                        <div
                            class="bg-sky-100 rounded-2xl p-4 flex flex-col items-center gap-2 border-2 border-transparent peer-checked:border-blue-500 peer-checked:bg-blue-100 shadow hover:shadow-lg transition">
                            <img src="../../images/reproduccion.png" class="w-20 h-20">
                            <span class="text-sm font-medium">Reproduccion</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" class="hidden peer">
                        <div
                            class="bg-sky-100 rounded-2xl p-4 flex flex-col items-center gap-2 border-2 border-transparent peer-checked:border-blue-500 peer-checked:bg-blue-100 shadow hover:shadow-lg transition">
                            <img src="../../images/alevines.png" class="w-15 h-20">
                            <span class="text-sm font-medium">Alevines</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" class="hidden peer">
                        <div
                            class="bg-sky-100 rounded-2xl p-4 flex flex-col items-center gap-2 border-2 border-transparent peer-checked:border-blue-500 peer-checked:bg-blue-100 shadow hover:shadow-lg transition">
                            <img src="../../images/siembra (2).png" class="w-20 h-20">
                            <span class="text-sm font-medium">Siembra</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" class="hidden peer">
                        <div
                            class="bg-sky-100 rounded-2xl p-4 flex flex-col items-center gap-2 border-2 border-transparent peer-checked:border-blue-500 peer-checked:bg-blue-100 shadow hover:shadow-lg transition">
                            <img src="../../images/reserva.png" class="w-18 h-20">
                            <span class="text-sm font-medium">Reserva</span>
                        </div>
                    </label>

                </div>
            </div>

            <!-- BOTÓN -->
            <button
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-lg shadow-lg transition font-semibold">
                Registrar
            </button>

        </form>

    </div>

</body>

</html>
 <!-- Si hay algo que quieres cambiar o modificar avisame por favor esta sencillo pero tampoco 
  hay muchas ideas de como hacer que un formulario se vea bien -->
