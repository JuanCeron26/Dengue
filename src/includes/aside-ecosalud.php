<div id="btn-aside"
    class="absolute z-40 left-0 w-1 hover:w-3 bg-slate-500/40 min-h-screen 
    transition-all duration-300 cursor-pointer backdrop-blur-xl">
</div>

<aside id="aside"
    class="fixed z-9999 top-0 left-0 h-screen w-20 -translate-x-full 
    transition-transform duration-500 ease-in-out
    bg-white/20 backdrop-blur-2xl border-r border-white/30 shadow-2xl
    flex flex-col items-center justify-between py-10">

    <div class="flex flex-col items-center gap-10">

        <a href="../backend/api.php?view=dashboard" class="group flex flex-col items-center">
            <i class="fa-solid fa-house text-2xl transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-3"></i>

            <span class="mt-2 text-xs opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Inicio
            </span>
        </a>

        <a href="../backend/api.php?view=registrar" class="group flex flex-col items-center justify-center">
            <i class="fa-solid fa-mosquito text-2xl transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-3"></i>

            <span class="mt-2 text-xs opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Iniciar Evento
            </span>
        </a>

        <a href="../backend/api.php?view=consultar" class="group flex flex-col items-center justify-center">
            <i class="fa-solid fa-mosquito text-2xl transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-3"></i>

            <span class="mt-2 text-xs opacity-0 translate-y-2 w-20 text-center
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Consultar Eventos
            </span>
        </a>

        <a href="#" class="group flex flex-col items-center">
            <i class="fa-solid fa-gear text-2xl transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-3"></i>

            <span class="mt-2 text-xs opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Configuración
            </span>
        </a>

    </div>

    <div class="flex flex-col items-center">
        <a href="../backend/api.php?menu=cerrar_sesion" class="group flex flex-col items-center">
            <i class="fa-solid fa-power-off text-2xl text-red-600 transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-6"></i>

            <span class="mt-2 text-xs opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Cerrar Sesion
            </span>
        </a>
    </div>

</aside>