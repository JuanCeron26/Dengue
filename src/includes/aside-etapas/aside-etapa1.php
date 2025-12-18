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

        <a href="../../seg_zoocriadero/views/consulta3.php" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/ecosalud.png" alt="" class="w-9 h-9 drop-shadow-md group-hover:drop-shadow-xl">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 text-center leading-tight px-2
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)]">
                Seguimientos
            </span>
        </a>

        <a href="#" class="btn-foco-potencial group flex flex-col items-center justify-center">
            <i class="fa-solid fa-mosquito text-2xl transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-3"></i>

            <span class="mt-2 text-xs opacity-0 translate-y-2 text-center
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Focos Potenciales
            </span>
        </a>

    </div>

    <div class="flex flex-col items-center">
        <a href="../backend/api.php?view=consultar" class="group flex flex-col items-center">
            <img src="../../../src/icons/icono_exit.png" alt="" class=" w-5 h-6  transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-6">

            <span class="mt-2 text-xs opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                Salir
            </span>
        </a>
    </div>

</aside>