<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../src/css/styles.css">
    <title>Document</title>
</head>

<body class="h-screen bg-gradient-to-tr from-blue-900 via-sky-700 to-sky-400
flex justify-center items-center">


    <main class="my-[20vh] mx-[10vh] grid grid-cols-2 w-3/4 h-[80vh] bg-white rounded-full shadow-2xl animate-fade-in">

        <!--MITAD 1-->
        <div class=" bg-sky-400 col-span-1 relative overflow-hidden rounded-r-4xl rounded-l-4xl ">
            <section class=" w-2/3 m-auto mt-20 relative z-50">
                <h1 class="text-white text-5xl font-extrabold animate-zoom-in"> BIENVENIDOS </h1>
                <h3 class="text-white text-2xl mt-3 font-semibold"> Llevemos un control del dengue que nos proteja a
                    <span class="font-bold">TODOS</span>
                </h3>
            </section>

            <!--Primer circulo-->
            <div
                class="h-[780px] w-[780px] rounded-full absolute -top-80 -left-36 -z-0 bg-blue-800 animate-slide-in-top">

            </div>
            <!--Segundo circulo-->
            <div class=" h-72 w-72 absolute rounded-full -bottom-16 -left-20 z-0 bg-blue-500">

            </div>

            <!--Tercer circulo-->
            <div class=" h-52 w-52 rounded-full absolute bottom-24 right-20 z-0 bg-blue-500">

            </div>
        </div>

        <!--MITAD 2-->
        <div class="bg-white col-span-1 flex justify-center rounded-r-4xl overflow-hidden">
            <form action="" method="POST" class="w-3/4 p-5">
                <div class="relative w-full">
                    <h1 class="block text-gray-400 font-bold text-5xl mt-5 text-center">INICIAR SESION</h1>
                </div>

                <p class="font-semibold text-center mt-5">Por favor inicia sesión</p>
                <div class=" relative mt-10">
                    <span class="absolute left-3 top-2">
                        <i class="fa-solid fa-user-tie text-2xl"></i>
                    </span>
                    <input type="text" name="" id="" placeholder="Nombre de usuario" class="border h-11
                    rounded-4xl py-3 px-14 w-full font-semibold">
                </div>
                <div class=" relative mt-4">
                    <span class="absolute left-3 top-2.5">
                        <i class="fa-solid fa-lock text-2xl"></i>
                    </span>
                    <input type="text" name="" id="" placeholder="Escribe tu contraseña" class="border h-11
                    rounded-4xl py-3 px-14 w-full font-semibold">
                </div>
                <a href="#" class="block mt-10 text-center text-blue-900 font-semibold text-xl">¿Olvidó la
                    contraseña?</a>
                <div class="flex items-center mt-2">
                    <hr class="flex-grow border-t-4 border-gray-300">
                    <span class="px-3 text-gray-400 text-sm font-bold">O</span>
                    <hr class="flex-grow border-t-4 border-gray-300">
                </div>
                <button
                    class="cursor-pointer block border w-4/5 mx-auto mt-3 h-12 rounded-full text-white bg-blue-900 font-semibold text-xl hover:scale-105 transition">Iniciar
                    Sesion</button>

                <div class="flex justify-center">
                    <img src="./src/img/ChatGPT Image 21 ago 2025, 03_13_12 p.m..png" alt="" class="h-32 mt-4">
                </div>

            </form>
        </div>

    </main>



</body>

</html>