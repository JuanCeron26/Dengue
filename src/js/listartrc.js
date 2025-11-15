// pp.js
document.addEventListener("DOMContentLoaded", () => {

  const tabla = document.getElementById("tabla-actividades");

  // --- FILTROS ---
  document.getElementById("btn-aplicar").addEventListener("click", () => {
    const fFecha = document.getElementById("filtro-fecha").value.trim().toLowerCase();
    const fComuna = document.getElementById("filtro-comuna").value.trim().toLowerCase();
    const fBarrio = document.getElementById("filtro-barrio").value.trim().toLowerCase();
    // const fSitio = document.getElementById("filtro-sitio").value.trim().toLowerCase(); // UI keeps filtro-sitio but table doesn't have sitio column
    const fTipo = document.getElementById("filtro-tipo").value.trim().toLowerCase();

    [...tabla.rows].forEach((row, index) => {
      if (index === 0) return; // Saltar header

      const tipo = row.cells[0].innerText.trim().toLowerCase();
      const fecha = row.cells[1].innerText.trim().toLowerCase();
      const comuna = row.cells[2].innerText.trim().toLowerCase();
      const barrio = row.cells[3].innerText.trim().toLowerCase();
      const responsable = row.cells[4].innerText.trim().toLowerCase();

      // Comparaciones normalizadas (case-insensitive, trimmed)
      const matchTipo = !fTipo || tipo === fTipo;
      const matchFecha = !fFecha || fecha === fFecha;
      const matchComuna = !fComuna || comuna === fComuna;
      const matchBarrio = !fBarrio || barrio === fBarrio;
      // No usamos sitio para comparar porque la tabla no tiene esa columna por ahora

      const mostrar = matchTipo && matchFecha && matchComuna && matchBarrio;
      row.style.display = mostrar ? "" : "none";
    });
  });

  document.getElementById("btn-borrar").addEventListener("click", () => {
    document.getElementById("filtro-fecha").value = "";
    document.getElementById("filtro-comuna").value = "";
    document.getElementById("filtro-barrio").value = "";
    document.getElementById("filtro-sitio").value = "";
    document.getElementById("filtro-tipo").value = "";
    [...tabla.rows].forEach((row, index) => { if(index!==0) row.style.display=""; });
  });

  // --- MODALES / ACCIONES ---
  let filaSeleccionada = null;

  const modalEditar = document.getElementById("modal-editar");
  const modalEliminar = document.getElementById("modal-eliminar");
  const modalVer = document.getElementById("modal-ver");
  const modalExportar = document.getElementById("modal-exportar");

  // Click handler delegado para acciones (imgs con data-action en la tabla)
  tabla.addEventListener("click", (e) => {
    const target = e.target;
    const action = target.dataset.action;
    if (!action) return;

    filaSeleccionada = target.closest("tr");
    if (!filaSeleccionada) return;

    const tipo = filaSeleccionada.cells[0].innerText.trim();
    const fecha = filaSeleccionada.cells[1].innerText.trim();
    const comuna = filaSeleccionada.cells[2].innerText.trim();
    const barrio = filaSeleccionada.cells[3].innerText.trim();
    const responsable = filaSeleccionada.cells[4].innerText.trim();

    switch (action) {
      case "ver":
        // Poblar modal ver con todos los detalles (incluye nueva línea formateada)
        const detalles = [
          `Tipo: ${tipo}`,
          `Fecha: ${fecha}`,
          `Comuna: ${comuna}`,
          `Barrio: ${barrio}`,
          `Responsable: ${responsable}`
        ].join("\n");
        document.getElementById("ver-contenido").innerText = detalles;
        modalVer.classList.remove("hidden");
        modalVer.classList.add("flex");
        break;

      case "editar":
        // Llenar inputs del modal editar
        document.getElementById("editar-tipo").value = tipo;
        document.getElementById("editar-fecha").value = fecha;
        document.getElementById("editar-comuna").value = comuna;
        document.getElementById("editar-barrio").value = barrio;
        // si no hay 'sitio' en la tabla, dejamos el select con su valor por defecto
        document.getElementById("editar-responsable").value = responsable;
        modalEditar.classList.remove("hidden");
        modalEditar.classList.add("flex");
        break;

      case "exportar":
        // Mostrar modal exportar y actualizar texto para la fila seleccionada
        document.getElementById("export-text").innerText = `Exportar actividad: ${tipo} (${fecha}) — Responsable: ${responsable}`;
        modalExportar.classList.remove("hidden");
        modalExportar.classList.add("flex");
        break;

      case "eliminar":
        document.getElementById("eliminar-text").innerText = `¿Desea anular la actividad: ${tipo} (${fecha})?`;
        modalEliminar.classList.remove("hidden");
        modalEliminar.classList.add("flex");
        break;

      default:
        break;
    }
  });

  // --- CERRAR MODALES (también disponible globalmente) ---
  window.cerrarModal = function(tipo) {
    const modal = document.getElementById("modal-" + tipo);
    if (modal) {
      modal.classList.add("hidden");
      modal.classList.remove("flex");
    }
  };

  // Guardar edición en la tabla
  document.getElementById("form-editar").addEventListener("submit", (e) => {
    e.preventDefault();
    if (!filaSeleccionada) return;
    filaSeleccionada.cells[0].innerText = document.getElementById("editar-tipo").value.trim();
    filaSeleccionada.cells[1].innerText = document.getElementById("editar-fecha").value.trim();
    filaSeleccionada.cells[2].innerText = document.getElementById("editar-comuna").value.trim();
    filaSeleccionada.cells[3].innerText = document.getElementById("editar-barrio").value.trim();
    filaSeleccionada.cells[4].innerText = document.getElementById("editar-responsable").value.trim();
    cerrarModal("editar");
  });

  // Confirmar eliminación
  document.getElementById("btn-confirmar-eliminar").addEventListener("click", () => {
    if (!filaSeleccionada) {
      cerrarModal("eliminar");
      return;
    }
    filaSeleccionada.remove();
    filaSeleccionada = null;
    cerrarModal("eliminar");
  });

  // Exportar: acciones simples (solo ejemplo, puedes conectar con backend)
  document.getElementById("export-pdf").addEventListener("click", () => {
    // ejemplo: obtener datos y preparar export
    if (!filaSeleccionada) {
      alert("Seleccione una actividad para exportar.");
      return;
    }
    alert("Exportando a PDF: " + filaSeleccionada.cells[0].innerText);
    cerrarModal("exportar");
  });

  document.getElementById("export-excel").addEventListener("click", () => {
    if (!filaSeleccionada) {
      alert("Seleccione una actividad para exportar.");
      return;
    }
    alert("Exportando a Excel: " + filaSeleccionada.cells[0].innerText);
    cerrarModal("exportar");
  });

  

});

