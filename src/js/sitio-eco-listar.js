// Cargar datos del sitio en el formulario
function loadSiteData(sitio) {
    document.getElementById('emptyState').classList.add('hidden');
    document.getElementById('editForm').classList.remove('hidden');

    document.getElementById('siteId').value = sitio.cod_sitioeco;
    document.getElementById('neighborhood').value = sitio.nombarrio;
    document.getElementById('address').value = sitio.direccion;
    document.getElementById('siteName').value = sitio.nombre_sitio;

    // Guardar el código del sitio para usarlo al guardar
    document.getElementById('editForm').dataset.codSitio = sitio.cod_sitioeco;

    // Scroll to form on mobile
    if (window.innerWidth < 1024) {
        document.getElementById('editForm').scrollIntoView({
            behavior: 'smooth'
        });
    }
}

// Guardar cambios del sitio
function saveSite() {
    const siteName = document.getElementById('siteName').value;
    const codSitio = document.getElementById('editForm').dataset.codSitio;

    if (siteName.trim() === '') {
        alert('Por favor ingresa un nombre para el sitio');
        return;
    }

    // Aquí implementarías la llamada AJAX para guardar en la BD
    // Por ahora solo mostramos alerta
    alert('Sitio guardado exitosamente: ' + siteName + '\nID: ' + codSitio);

    // TODO: Implementar guardado real con AJAX
    // fetch('guardar_sitio.php', {
    //     method: 'POST',
    //     body: JSON.stringify({cod_sitio: codSitio, nombre: siteName})
    // })
}

// Cancelar edición
function cancelEdit() {
    document.getElementById('editForm').classList.add('hidden');
    document.getElementById('emptyState').classList.remove('hidden');
    document.getElementById('editForm').dataset.codSitio = '';
}

// Ver detalles del sitio
function viewDetails(sitio) {
    alert('Ver detalles completos de:\n\n' +
        'Nombre: ' + sitio.nombre_sitio + '\n' +
        'ID: ' + sitio.cod_sitioeco + '\n' +
        'Barrio: ' + sitio.nombarrio + '\n' +
        'Comuna: ' + sitio.nomcomun + '\n' +
        'Dirección: ' + sitio.direccion);
}

// Anular sitio
function deactivateSite(codSitio, nombreSitio) {
    if (confirm('¿Estás seguro de que deseas anular el sitio "' + nombreSitio + '"?\n\nEsta acción puede ser irreversible.')) {
        alert('Sitio "' + nombreSitio + '" ha sido anulado exitosamente');

        // TODO: Implementar anulación real con AJAX
        // fetch('anular_sitio.php', {
        //     method: 'POST',
        //     body: JSON.stringify({cod_sitio: codSitio})
        // })
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
        alert('Por favor selecciona al menos un filtro');
    }
}

// Limpiar filtros
function clearFilters() {
    window.location.href = window.location.pathname;
}