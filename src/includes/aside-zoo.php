<div id="btn-aside"
    class="absolute z-80 left-0 w-3 hover:w-4 bg-slate-500/40 h-full 
    transition-all duration-300 cursor-pointer backdrop-blur-xl">
</div>

<aside id="aside"
    class="fixed z-9999 top-0 left-0 h-screen w-20 -translate-x-full overflow-y-auto scrollbar-hide
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

        <?php if ($permiso == '9' || $permiso == '4') { ?>

            <a href="registrar.php" class="group flex flex-col items-center">
                <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    <img src="../../../src/icons/pez-koi.png" alt="" class="w-11 h-11 drop-shadow-md group-hover:drop-shadow-xl">
                </div>
                <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 text-center leading-tight px-2
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)]">
                    Registrar Zoocriadero
                </span>
            </a>

            <a href="listar.php" class="group flex flex-col items-center">
                <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    <img src="../../../src/icons/campo.png" alt="" class="w-11 h-11 drop-shadow-md group-hover:drop-shadow-xl">
                </div>
                <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 text-center leading-tight px-2
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)]">
                    Consultar<br>Zoocriadero
                </span>
            </a>

            <a href="../../seg_zoocriadero/views/consulta3.php" class="group flex flex-col items-center">
                <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    <img src="../../../src/icons/tanque_zoo.png" alt="" class="w-9 h-9 drop-shadow-md group-hover:drop-shadow-xl">
                </div>
                <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 text-center leading-tight px-2
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-gray-700 group-hover:text-[color:var(--verde-principal)]">
                    Seguimientos
                </span>
            </a>

        <?php } ?>


    </div>

    <div class="flex flex-col items-center">
        <?php if ($permiso == '9' || $permiso == '4') { ?>
            <a href="../../biologico.php" class="group flex flex-col items-center mb-4">
                <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    <img src="../../../src/icons/icono_exit.png" alt="" class="w-7 h-7">
                </div>
                <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 text-center
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-red-600 group-hover:text-red-700">
                    Salir
                </span>
            </a>
        <?php } ?>

        <a href="../backend/api.php?cerrar_sesion" class="group flex flex-col items-center">
            <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                <img src="../../../src/icons/cerrar-sesion.png" alt="" class="w-7 h-7">
            </div>
            <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 text-center
                        group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                        text-red-600 group-hover:text-red-700">
                Cerrar Sesion
            </span>
        </a>
    </div>

</aside>