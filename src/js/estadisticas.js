// ==========================================
// VARIABLES GLOBALES
// ==========================================
let chartInstances = {};
let datosActuales = null;

// ==========================================
// INICIALIZACIÓN
// ==========================================
document.addEventListener('DOMContentLoaded', function () {
    cargarFiltros();
    cargarEstadisticas();
});

// ==========================================
// CARGAR FILTROS
// ==========================================
async function cargarFiltros() {
    try {
        const formData = new FormData();
        formData.append('accion', 'obtener_filtros');

        const response = await fetch('../controller/estadisticascontroler.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            const sitioSelect = document.getElementById('sitio');
            result.data.sitios.forEach(sitio => {
                const option = document.createElement('option');
                option.value = sitio.cod_sitiocontrolbiolo;
                option.textContent = sitio.nombre_sitio;
                sitioSelect.appendChild(option);
            });

            const tipoSelect = document.getElementById('tipo_actividad');
            result.data.tipos_actividad.forEach(tipo => {
                const option = document.createElement('option');
                option.value = tipo.cod_act_campo;
                option.textContent = tipo.nombre_actividad;
                tipoSelect.appendChild(option);
            });

            const usuarioSelect = document.getElementById('usuario');
            result.data.usuarios.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.id_usuarios;
                option.textContent = usuario.nombre_completo;
                usuarioSelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error cargando filtros:', error);
    }
}

// ==========================================
// CARGAR ESTADÍSTICAS
// ==========================================
async function cargarEstadisticas() {
    mostrarLoading(true);

    try {
        const formData = new FormData();
        formData.append('accion', 'obtener_estadisticas');
        formData.append('fecha_inicio', document.getElementById('fecha_inicio').value);
        formData.append('fecha_fin', document.getElementById('fecha_fin').value);
        formData.append('sitio', document.getElementById('sitio').value);
        formData.append('tipo_actividad', document.getElementById('tipo_actividad').value);
        formData.append('usuario', document.getElementById('usuario').value);

        const response = await fetch('../controller/estadisticascontroler.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            datosActuales = result.data;

            // Verificar si hay datos
            const hayDatos = verificarDatosDisponibles(result.data);

            if (hayDatos) {
                renderizarCards(result.data.resumen);
                renderizarGraficas(result.data);
                document.getElementById('no-data').style.display = 'none';
            } else {
                document.getElementById('cards-resumen').innerHTML = '';
                document.getElementById('graficas').innerHTML = '';
                document.getElementById('no-data').style.display = 'block';
            }
        } else {
            alert('Error: ' + result.error);
        }
    } catch (error) {
        console.error('Error cargando estadísticas:', error);
        alert('Error al cargar las estadísticas');
    } finally {
        mostrarLoading(false);
    }
}

// ==========================================
// VERIFICAR SI HAY DATOS
// ==========================================
function verificarDatosDisponibles(data) {
    return (
        (data.resumen && (data.resumen.total_activas > 0 || data.resumen.total_anuladas > 0)) ||
        (data.sitios_inspecciones && data.sitios_inspecciones.length > 0) ||
        (data.sitios_siembras && data.sitios_siembras.length > 0) ||
        (data.sitios_resiembras && data.sitios_resiembras.length > 0) ||
        (data.usuarios_activos && data.usuarios_activos.length > 0)
    );
}

// ==========================================
// MOSTRAR/OCULTAR LOADING
// ==========================================
function mostrarLoading(mostrar) {
    document.getElementById('loading').style.display = mostrar ? 'flex' : 'none';
}

// ==========================================
// RENDERIZAR CARDS DE RESUMEN
// ==========================================
function renderizarCards(resumen) {
    const container = document.getElementById('cards-resumen');
    container.innerHTML = '';

    if (!resumen) return;

    const cards = [
        {
            icon: 'bi-check-circle-fill',
            title: 'Actividades Activas',
            value: resumen.total_activas || 0,
            color: 'green',
            delay: '0.3s'
        },
        {
            icon: 'bi-x-circle-fill',
            title: 'Actividades Anuladas',
            value: resumen.total_anuladas || 0,
            color: 'red',
            delay: '0.4s'
        },
        {
            icon: 'bi-flower2',
            title: 'Total Siembras',
            value: resumen.total_siembras || 0,
            color: 'blue',
            delay: '0.5s'
        },
        {
            icon: 'bi-arrow-repeat',
            title: 'Total Resiembras',
            value: resumen.total_resiembras || 0,
            color: 'yellow',
            delay: '0.6s'
        },
        {
            icon: 'bi-search',
            title: 'Total Inspecciones',
            value: resumen.total_inspecciones || 0,
            color: 'purple',
            delay: '0.7s'
        },
        {
            icon: 'bi-geo-alt-fill',
            title: 'Sitios Trabajados',
            value: resumen.sitios_trabajados || 0,
            color: 'teal',
            delay: '0.8s'
        }
    ];

    cards.forEach(card => {
        const cardDiv = document.createElement('div');
        cardDiv.className = `stat-card ${card.color}`;
        cardDiv.style.animationDelay = card.delay;
        cardDiv.innerHTML = `
            <div class="stat-icon">
                <i class="bi ${card.icon}"></i>
            </div>
            <div class="stat-title">${card.title}</div>
            <div class="stat-value">${card.value}</div>
        `;
        container.appendChild(cardDiv);
    });
}

// ==========================================
// RENDERIZAR GRÁFICAS
// ==========================================
function renderizarGraficas(data) {
    const container = document.getElementById('graficas');
    container.innerHTML = '';

    // Destruir gráficas anteriores
    Object.values(chartInstances).forEach(chart => chart.destroy());
    chartInstances = {};

    // Solo crear gráficas si hay datos
    if (data.sitios_inspecciones && data.sitios_inspecciones.length > 0) {
        crearGraficaBarras(container, 'Sitios con Más Inspecciones', data.sitios_inspecciones, 'total_inspecciones', 'bi-search');
    }

    if (data.sitios_siembras && data.sitios_siembras.length > 0) {
        crearGraficaBarras(container, 'Sitios con Más Siembras', data.sitios_siembras, 'total_siembras', 'bi-flower2');
    }

    if (data.sitios_resiembras && data.sitios_resiembras.length > 0) {
        crearGraficaBarras(container, 'Sitios con Más Resiembras', data.sitios_resiembras, 'total_resiembras', 'bi-arrow-repeat');
    }

    if (data.usuarios_activos && data.usuarios_activos.length > 0) {
        crearGraficaUsuarios(container, 'Usuarios Más Activos', data.usuarios_activos);
    }

    if (data.actividades_barrio && data.actividades_barrio.length > 0) {
        crearGraficaBarrios(container, 'Actividades por Barrio', data.actividades_barrio);
    }

    if (data.tendencias_mensuales && data.tendencias_mensuales.length > 0) {
        crearGraficaTendencias(container, 'Tendencias Mensuales', data.tendencias_mensuales);
    }

    if (data.actividades_anuladas && data.actividades_anuladas.length > 0) {
        crearGraficaAnuladas(container, 'Actividades Anuladas por Mes', data.actividades_anuladas);
    }
}

// ==========================================
// CREAR GRÁFICA DE BARRAS
// ==========================================
function crearGraficaBarras(container, titulo, datos, campo, icono) {
    if (!datos || datos.length === 0) return;

    const div = document.createElement('div');
    div.className = 'chart-card';

    const canvas = document.createElement('canvas');
    const chartId = 'chart_' + Date.now() + Math.random();
    canvas.id = chartId;

    div.innerHTML = `<h3 class="chart-title"><i class="bi ${icono}"></i> ${titulo}</h3>`;
    div.appendChild(canvas);
    container.appendChild(div);

    const labels = datos.map(d => d.nombre_sitio + '\n' + d.nombarrio);
    const values = datos.map(d => parseInt(d[campo]) || 0);

    const ctx = canvas.getContext('2d');
    chartInstances[chartId] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total',
                data: values,
                backgroundColor: 'rgba(22, 163, 74, 0.8)',
                borderColor: 'rgba(22, 163, 74, 1)',
                borderWidth: 2,
                borderRadius: 12,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(22, 163, 74, 0.9)',
                    padding: 15,
                    cornerRadius: 10,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#64748b',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// ==========================================
// CREAR GRÁFICA DE USUARIOS
// ==========================================
function crearGraficaUsuarios(container, titulo, datos) {
    if (!datos || datos.length === 0) return;

    const div = document.createElement('div');
    div.className = 'chart-card';

    const canvas = document.createElement('canvas');
    const chartId = 'chart_usuarios_' + Date.now();
    canvas.id = chartId;

    div.innerHTML = `<h3 class="chart-title"><i class="bi bi-people-fill"></i> ${titulo}</h3>`;
    div.appendChild(canvas);
    container.appendChild(div);

    const labels = datos.map(d => d.usuario);
    const values = datos.map(d => parseInt(d.total_actividades) || 0);

    const ctx = canvas.getContext('2d');
    chartInstances[chartId] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Actividades Realizadas',
                data: values,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                borderRadius: 12
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(59, 130, 246, 0.9)',
                    padding: 15,
                    cornerRadius: 10
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#64748b'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                y: {
                    ticks: {
                        color: '#64748b'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// ==========================================
// CREAR GRÁFICA DE BARRIOS (DONA)
// ==========================================
function crearGraficaBarrios(container, titulo, datos) {
    if (!datos || datos.length === 0) return;

    const div = document.createElement('div');
    div.className = 'chart-card';

    const canvas = document.createElement('canvas');
    const chartId = 'chart_barrios_' + Date.now();
    canvas.id = chartId;

    div.innerHTML = `<h3 class="chart-title"><i class="bi bi-pie-chart-fill"></i> ${titulo}</h3>`;
    div.appendChild(canvas);
    container.appendChild(div);

    const labels = datos.map(d => d.nombarrio);
    const values = datos.map(d => parseInt(d.total_actividades) || 0);

    const colores = [
        'rgba(22, 163, 74, 0.8)',
        'rgba(59, 130, 246, 0.8)',
        'rgba(234, 179, 8, 0.8)',
        'rgba(239, 68, 68, 0.8)',
        'rgba(168, 85, 247, 0.8)',
        'rgba(20, 184, 166, 0.8)',
        'rgba(236, 72, 153, 0.8)',
        'rgba(251, 146, 60, 0.8)',
        'rgba(34, 197, 94, 0.8)',
        'rgba(14, 165, 233, 0.8)'
    ];

    const ctx = canvas.getContext('2d');
    chartInstances[chartId] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colores,
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        },
                        color: '#64748b'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 15,
                    cornerRadius: 10
                }
            }
        }
    });
}

// ==========================================
// CREAR GRÁFICA DE TENDENCIAS
// ==========================================
function crearGraficaTendencias(container, titulo, datos) {
    if (!datos || datos.length === 0) return;

    const div = document.createElement('div');
    div.className = 'chart-card';
    div.style.gridColumn = '1 / -1';

    const canvas = document.createElement('canvas');
    const chartId = 'chart_tendencias_' + Date.now();
    canvas.id = chartId;

    div.innerHTML = `<h3 class="chart-title"><i class="bi bi-graph-up"></i> ${titulo}</h3>`;
    div.appendChild(canvas);
    container.appendChild(div);

    const meses = [...new Set(datos.map(d => d.mes))].sort();
    const actividades = [...new Set(datos.map(d => d.nombre_actividad))];

    const coloresActividades = {
        'Siembra': 'rgba(22, 163, 74, 1)',
        'Inspección': 'rgba(59, 130, 246, 1)',
        'Resiembra': 'rgba(234, 179, 8, 1)',
        'Mantenimiento': 'rgba(168, 85, 247, 1)'
    };

    const datasets = actividades.map(actividad => {
        const data = meses.map(mes => {
            const registro = datos.find(d => d.mes === mes && d.nombre_actividad === actividad);
            return registro ? parseInt(registro.total) : 0;
        });

        const color = coloresActividades[actividad] || 'rgba(99, 102, 241, 1)';

        return {
            label: actividad,
            data: data,
            borderColor: color,
            backgroundColor: color.replace('1)', '0.1)'),
            tension: 0.4,
            borderWidth: 3,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: color,
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        };
    });

    const ctx = canvas.getContext('2d');
    chartInstances[chartId] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: meses,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        font: {
                            size: 13
                        },
                        color: '#64748b',
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 15,
                    cornerRadius: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#64748b'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#64748b'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// ==========================================
// CREAR GRÁFICA DE ANULADAS
// ==========================================
function crearGraficaAnuladas(container, titulo, datos) {
    if (!datos || datos.length === 0) return;

    const div = document.createElement('div');
    div.className = 'chart-card';

    const canvas = document.createElement('canvas');
    const chartId = 'chart_anuladas_' + Date.now();
    canvas.id = chartId;

    div.innerHTML = `<h3 class="chart-title"><i class="bi bi-x-circle"></i> ${titulo}</h3>`;
    div.appendChild(canvas);
    container.appendChild(div);

    const meses = [...new Set(datos.map(d => d.mes))].sort();
    const values = meses.map(mes => {
        return datos.filter(d => d.mes === mes)
            .reduce((sum, d) => sum + parseInt(d.total_anuladas), 0);
    });

    const ctx = canvas.getContext('2d');
    chartInstances[chartId] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Actividades Anuladas',
                data: values,
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 2,
                borderRadius: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(239, 68, 68, 0.9)',
                    padding: 15,
                    cornerRadius: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#64748b'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        color: '#64748b'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// ==========================================
// EXPORTAR A PDF
// ==========================================
async function exportarPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');

    mostrarLoading(true);

    try {
        const cardsElement = document.getElementById('cards-resumen');
        const cardsCanvas = await html2canvas(cardsElement, { scale: 2 });
        const cardsImg = cardsCanvas.toDataURL('image/png');

        pdf.setFillColor(22, 163, 74);
        pdf.rect(0, 0, 210, 30, 'F');
        pdf.setTextColor(255, 255, 255);
        pdf.setFontSize(20);
        pdf.text('Estadísticas - Control Biológico', 15, 18);

        pdf.addImage(cardsImg, 'PNG', 10, 35, 190, 40);

        let yPosition = 80;

        const graficas = document.querySelectorAll('.chart-card');
        for (let i = 0; i < graficas.length; i++) {
            if (yPosition > 230) {
                pdf.addPage();
                yPosition = 15;
            }

            const canvas = await html2canvas(graficas[i], { scale: 2 });
            const imgData = canvas.toDataURL('image/png');
            pdf.addImage(imgData, 'PNG', 10, yPosition, 190, 80);
            yPosition += 90;
        }

        pdf.save('estadisticas_control_biologico.pdf');
    } catch (error) {
        console.error('Error generando PDF:', error);
        alert('Error al generar el PDF');
    } finally {
        mostrarLoading(false);
    }
}

// ==========================================
// EXPORTAR A EXCEL
// ==========================================
async function exportarExcel() {
    mostrarLoading(true);

    try {
        const formData = new FormData();
        formData.append('accion', 'exportar_excel');
        formData.append('fecha_inicio', document.getElementById('fecha_inicio').value);
        formData.append('fecha_fin', document.getElementById('fecha_fin').value);
        formData.append('sitio', document.getElementById('sitio').value);
        formData.append('tipo_actividad', document.getElementById('tipo_actividad').value);
        formData.append('usuario', document.getElementById('usuario').value);

        const response = await fetch('../controller/estadisticascontroler.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success && result.data && result.data.length > 0) {
            const ws = XLSX.utils.aoa_to_sheet(result.data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Actividades");
            XLSX.writeFile(wb, "estadisticas_control_biologico.xlsx");
        } else {
            alert(result.error || 'No hay datos para exportar');
        }
    } catch (error) {
        console.error('Error exportando a Excel:', error);
        alert('Error al exportar a Excel');
    } finally {
        mostrarLoading(false);
    }
}