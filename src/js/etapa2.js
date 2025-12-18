document.addEventListener('DOMContentLoaded', () => {

    const botonesSecciones = document.querySelectorAll('.btn-seccion');
    const actividadToggles = document.querySelectorAll('.actividad-toggle');


    botonesSecciones.forEach((boton) => {
        boton.addEventListener('click', () => {
            showSection(boton.dataset.seccion)
        })
    })

    actividadToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const tareasContainer = this.nextElementSibling;
            const chevron = this.querySelector('.chevron');
            const isOpen = !tareasContainer.classList.contains('hidden');

            // Cerrar todos los demás
            document.querySelectorAll('.tareas-container').forEach(container => {
                container.classList.add('hidden');
            });
            document.querySelectorAll('.chevron').forEach(ch => {
                ch.style.transform = 'rotate(0deg)';
            });

            // Toggle el actual
            if (!isOpen) {
                tareasContainer.classList.remove('hidden');
                chevron.style.transform = 'rotate(180deg)';
            }
        });
    });



    function showSection(sectionId) {
        // Ocultar todas las secciones
        const sections = document.querySelectorAll('.section-container');
        sections.forEach(section => {
            section.classList.add('hidden');
        });

        // Mostrar la sección seleccionada
        const targetSection = document.getElementById(`seccion${sectionId}`);
        if (targetSection) {
            targetSection.classList.remove('hidden');
        }

        // Actualizar estilos del menú
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.classList.remove('bg-indigo-100', 'shadow-md');
        });

        const activeItem = document.querySelector(`[data-section="${sectionId}"]`);
        if (activeItem) {
            activeItem.classList.add('bg-indigo-100', 'shadow-md');
        }

        // Scroll suave al inicio del contenido
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }


})