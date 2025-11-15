

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Zoocriadero</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
</head>

<body class="bg-linear-to-br from-sky-100 to-blue-200 flex justify-center items-center min-h-screen p-6">

    <div class="bg-white w-full max-w-2xl rounded-3xl p-10 shadow-xl border border-blue-100 animate-fadeIn">

        <h1 class="text-3xl font-extrabold text-center mb-10 text-gray-700 tracking-wide">
            Registrar Zoocriadero
        </h1>

        <form action="../backend/api.php?accion=registrar" method="POST" class="space-y-6">

            <!-- Nombre + Usuario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 place-items-center self-center">
                <div class="">
                    <label class="text-sm font-semibold">Nombre del Zoocriadero</label>
                    <input name="nombre" class="w-full bg-sky-100 rounded-xl px-4 py-3 text-sm" placeholder="Escribe el nombre">
                </div>

            </div>

            <!-- Barrio -->
            <div>
                <label class="text-sm font-semibold">Barrio</label>
                <select name="barrio" class="mt-1 w-full bg-sky-100 rounded-xl px-4 py-3 text-sm">
                    <option value="">Selecciona un barrio</option>
                    <?php foreach ($barrios as $barrio) { ?>
                        <option value="<?php echo $barrio['cod_barrio'] ?>"><?php echo $barrio['nombarrio']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Dirección -->
            <div>
                <label class="text-sm font-semibold">Dirección</label>

                <div class="grid grid-cols-3 gap-4 mt-3">

                    <div class="space-y-3">
                        <select name="dir_tipo" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>CALLE</option>
                            <option>CARRERA</option>
                            <option>AV</option>
                            <option>DIAGONAL</option>
                        </select>

                        <select name="dir_num1" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>1</option>
                            <option>50</option>
                            <option>71</option>
                            <option>71B</option>
                        </select>

                        <select name="dir_letra1" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option></option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <div class="font-bold text-center text-xl text-gray-600">#</div>

                        <select name="dir_num2" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>1</option>
                            <option>5</option>
                            <option>8</option>
                        </select>

                        <select name="dir_letra2" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option></option>
                            <option>A</option>
                            <option>B</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <div class="font-bold text-center text-xl text-gray-600">-</div>

                        <select name="dir_num3" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option>1</option>
                            <option>10</option>
                            <option>20</option>
                        </select>

                        <select name="dir_letra3" class="bg-sky-100 rounded-xl p-3 text-sm w-full">
                            <option></option>
                            <option>A</option>
                            <option>B</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- Tipo de tanques -->
            <div>
                <label class="text-sm font-semibold">Tipo de tanques</label>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mt-3">

                    <label>
                        <input name="tanques[]" value="Reproducción" type="checkbox" class="hidden peer">
                        <div class="bg-sky-100 rounded-2xl p-4 text-center peer-checked:bg-blue-100">
                            Reproducción
                        </div>
                    </label>

                    <label>
                        <input name="tanques[]" value="Alevines" type="checkbox" class="hidden peer">
                        <div class="bg-sky-100 rounded-2xl p-4 text-center peer-checked:bg-blue-100">
                            Alevines
                        </div>
                    </label>

                    <label>
                        <input name="tanques[]" value="Siembra" type="checkbox" class="hidden peer">
                        <div class="bg-sky-100 rounded-2xl p-4 text-center peer-checked:bg-blue-100">
                            Siembra
                        </div>
                    </label>

                    <label>
                        <input name="tanques[]" value="Reserva" type="checkbox" class="hidden peer">
                        <div class="bg-sky-100 rounded-2xl p-4 text-center peer-checked:bg-blue-100">
                            Reserva
                        </div>
                    </label>

                </div>
            </div>

            <button class="w-full bg-blue-600 text-white py-3 rounded-xl">Registrar</button>

        </form>


    </div>

</body>

</html>