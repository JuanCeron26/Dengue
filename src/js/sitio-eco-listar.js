// Cargar datos del sitio en el formulario de edición
function loadSiteData(sitio) {
    document.getElementById('emptyState').classList.add('hidden');
    document.getElementById('editForm').classList.remove('hidden');

    document.getElementById('siteId').value = sitio.cod_sitioeco;
    document.getElementById('neighborhood').value = sitio.nombarrio;
    document.getElementById('address').value = sitio.direccion;
    document.getElementById('siteName').value = sitio.nombre_sitio;

    // Guardar el código del sitio para usarlo al guardar
    document.getElementById('editForm').dataset.codSitio = sitio.cod_sitioeco;

    // Scroll to form on mobile/tablet
    if (window.innerWidth < 1280) {
        document.getElementById('editForm').scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }
}

// ========================================
// FUNCIÓN ACTUALIZADA CON AJAX
// ========================================
// Guardar cambios del sitio
async function saveSite() {
    // Obtener valores
    const siteName = document.getElementById('siteName').value;
    const codSitio = document.getElementById('editForm').dataset.codSitio;

    // Validar que el nombre no esté vacío
    if (siteName.trim() === '') {
        alert('⚠️ Por favor ingresa un nombre para el sitio');
        return;
    }

    // Confirmar antes de guardar
    if (!confirm(`¿Deseas guardar los cambios?\n\nNuevo nombre: ${siteName}`)) {
        return;
    }

    try {
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('cod_sitioeco', codSitio);    // ✅ CORREGIDO: cod_sitioeco
        formData.append('nombre_sitio', siteName);

        // Enviar datos al servidor
        const response = await fetch('../controllers/controllerEditar.php', {
            method: 'POST',
            body: formData
        });

        // Obtener respuesta JSON
        const result = await response.json();

        // Verificar resultado
        if (result.success) {
            alert('✅ ' + result.message);
            location.reload(); // Recargar para ver cambios
        } else {
            alert('❌ Error: ' + result.message);
        }

    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al conectar con el servidor. Por favor intenta de nuevo.');
    }
}
// ========================================

// Cancelar edición
function cancelEdit() {
    document.getElementById('editForm').classList.add('hidden');
    document.getElementById('emptyState').classList.remove('hidden');
    document.getElementById('editForm').dataset.codSitio = '';

    // Limpiar campos
    document.getElementById('siteId').value = '';
    document.getElementById('neighborhood').value = '';
    document.getElementById('address').value = '';
    document.getElementById('siteName').value = '';
}

// Función para abrir el modal de detalles
function viewDetails(sitio) {
    // Llenar el modal con los datos del sitio
    document.getElementById('modalNombre').textContent = sitio.nombre_sitio;
    document.getElementById('modalId').textContent = sitio.cod_sitioeco;
    document.getElementById('modalBarrio').textContent = sitio.nombarrio;
    document.getElementById('modalComuna').textContent = sitio.nomcomun || 'N/A';
    document.getElementById('modalDireccion').textContent = sitio.direccion;

    // Mostrar el modal
    document.getElementById('detailsModal').classList.remove('hidden');

    // Prevenir scroll del body
    document.body.style.overflow = 'hidden';
}

// Función para cerrar el modal de detalles
function closeDetailsModal() {
    document.getElementById('detailsModal').classList.add('hidden');

    // Restaurar scroll del body
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('detailsModal');

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeDetailsModal();
        }
    });

    // Cerrar modal con la tecla Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeDetailsModal();
        }
    });
});

// ========================================
// FUNCIÓN PARA ANULAR SITIO CON AJAX
// ========================================
async function deactivateSite(codSitio, nombreSitio) {
    // Confirmación única
    if (!confirm(
        `⚠️ ¿Estás seguro de que deseas anular el sitio "${nombreSitio}"?\n\n` +
        `Esta acción cambiará el estado del sitio.`
    )) {
        return; // Si cancela, salimos
    }

    try {
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('cod_sitioeco', codSitio);

        // Enviar petición al servidor
        const response = await fetch('../controllers/controllerAnular.php', {
            method: 'POST',
            body: formData
        });

        // Obtener respuesta JSON
        const result = await response.json();

        // Verificar resultado
        if (result.success) {
            alert('✅ ' + result.message);
            location.reload(); // Recargar para ver cambios
        } else {
            alert('❌ Error: ' + result.message);
        }

    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al conectar con el servidor. Por favor intenta de nuevo.');
    }
}
// ========================================

// Aplicar filtros
function applyFilters() {
    const comuna = document.getElementById('filterComuna').value;
    const barrio = document.getElementById('filterBarrio').value;

    // Construir URL con parámetros
    let url = window.location.pathname + '?';
    const params = [];

    if (comuna) {
        params.push('comuna=' + encodeURIComponent(comuna));
    }
    if (barrio) {
        params.push('barrio=' + encodeURIComponent(barrio));
    }

    if (params.length > 0) {
        url += params.join('&');
        window.location.href = url;
    } else {
        alert('⚠️ Por favor selecciona al menos un filtro');
    }
}

// Limpiar filtros
function clearFilters() {
    window.location.href = window.location.pathname;
}

// Animación suave al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    // Agregar animación de entrada a las cards
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});