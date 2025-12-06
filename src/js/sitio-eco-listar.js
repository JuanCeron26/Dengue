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

// Guardar cambios del sitio
function saveSite() {
    const siteName = document.getElementById('siteName').value;
    const codSitio = document.getElementById('editForm').dataset.codSitio;

    if (siteName.trim() === '') {
        alert('⚠️ Por favor ingresa un nombre para el sitio');
        return;
    }

    // Aquí implementarías la llamada AJAX para guardar en la BD
    alert('✅ Sitio guardado exitosamente:\n\n' + siteName + '\nID: ' + codSitio);

    // TODO: Implementar guardado real con AJAX
    /*
    fetch('../controllers/guardarSitio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            cod_sitio: codSitio,
            nombre: siteName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sitio guardado exitosamente');
            location.reload();
        } else {
            alert('Error al guardar: ' + data.message);
        }
    });
    */
}

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
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('detailsModal');
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeDetailsModal();
        }
    });

    // Cerrar modal con la tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailsModal();
        }
    });
});

// Función para anular sitio
function deactivateSite(codSitio, nombreSitio) {
    if (confirm(
        `⚠️ ¿Estás seguro de que deseas anular el sitio "${nombreSitio}"?\n\n` +
        `Esta acción puede ser irreversible.\n` +
        `Código: ${codSitio}`
    )) {
        // Mostrar confirmación de seguridad adicional
        const confirmarAnulacion = prompt(
            `Para confirmar la anulación, escribe "ANULAR" (en mayúsculas):`
        );

        if (confirmarAnulacion === 'ANULAR') {
            // Aquí implementarías la llamada AJAX para anular
            alert(`✅ Sitio "${nombreSitio}" ha sido anulado exitosamente`);

            // TODO: Implementar anulación real con AJAX
            /*
            fetch('../controllers/anularSitio.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    cod_sitio: codSitio
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sitio anulado exitosamente');
                    location.reload();
                } else {
                    alert('Error al anular el sitio: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
            */
        } else if (confirmarAnulacion !== null) {
            alert('❌ Anulación cancelada. Debes escribir "ANULAR" exactamente para confirmar.');
        }
    }
}

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
document.addEventListener('DOMContentLoaded', function() {
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