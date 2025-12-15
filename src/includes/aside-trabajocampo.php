<div id="btn-aside"
    class="absolute z-40 left-0 w-2 hover:w-3 bg-slate-500/40 min-h-screen 
    transition-all duration-300 cursor-pointer backdrop-blur-xl">
</div>

<aside id="aside"
    class="fixed z-50 top-0 left-0 h-screen w-20 -translate-x-full 
    transition-transform duration-500 ease-in-out
    bg-white/20 backdrop-blur-2xl border-r border-white/30 shadow-2xl
    flex flex-col items-center justify-between py-10">

    <div class="flex flex-col items-center gap-10">

        <a href="dashboard.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/casa.png" alt="" class="w-7 h-7">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)]">
                Inicio
            </span>
        </a>

        <a href="actividades.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/campo.png" alt="" class="w-7 h-7">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 text-center translate-y-2 
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)] leading-tight px-2">
                Actividades
            </span>
        </a>

        <a href="../../sitiocampo/front/listar.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/trabajp.png" alt="" class="w-7 h-7">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 text-center translate-y-2 
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)] leading-tight px-2">
                Sitios
            </span>
        </a>

        <a href="estadisticas.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/search.png" alt="" class="w-7 h-7">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 text-center translate-y-2 
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)] leading-tight px-2">
                Estadisticas
            </span>
        </a>

    </div>

    <div class="flex flex-col items-center">
        <a href="#" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/cerrar-sesion.png" alt="" class="w-7 h-7">
            </div>
            <span class="mt-2 text-xs text-center font-medium opacity-0 translate-y-2 
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-red-600 group-hover:text-red-700">
                Cerrar Sesion
            </span>
        </a>
    </div>

</aside>