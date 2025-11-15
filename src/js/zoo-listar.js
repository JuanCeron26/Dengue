window.addEventListener('load', () => {
    const tbody = document.getElementById("tbody");

    // Filtros
    const filterName = document.getElementById("filterName");
    const filterEncargado = document.getElementById("filterEncargado");
    const filterTipo = document.getElementById("filterTipo");
    const filterDireccion = document.getElementById("filterDireccion");
    const btnApplyFilters = document.getElementById("btnApplyFilters");
    const btnClearFilters = document.getElementById("btnClearFilters");

    // Modales
    const modalForm = document.getElementById("modalForm");
    const modalView = document.getElementById("modalView");
    const modalDelete = document.getElementById("modalDelete");
    const modalExport = document.getElementById("modalExport");

    // Botones modales
    const btnCancelForm = document.getElementById("btnCancelForm");
    const btnSubmitForm = document.getElementById("btnSubmitForm");
    const btnCloseView = document.getElementById("btnCloseView");
    const btnCancelDelete = document.getElementById("btnCancelDelete");
    const btnConfirmDelete = document.getElementById("btnConfirmDelete");
    const btnCloseExport = document.getElementById("btnCloseExport");

    // Detalle
    const detailContent = document.getElementById("detailContent");

    // Eliminación temporal
    let idToDelete = null;

    // =====================================================
    // FUNCIONES PARA MOSTRAR / OCULTAR MODALES
    // =====================================================
    function showModal(modal) {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function hideModal(modal) {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    // =====================================================
    // FUNCIÓN PARA ABRIR EL MODAL DE EDITAR
    // =====================================================
    function openEditModal(row) {
        const id = row.dataset.id;

        document.getElementById("editingId").value = id;
        document.getElementById("name").value = row.children[1].textContent.trim();
        document.getElementById("encargado").value = row.children[2].textContent.trim();
        document.getElementById("direccion").value = row.children[3].textContent.trim();
        document.getElementById("tipo").value = row.children[4].textContent.trim();
        document.getElementById("tanque").value = row.children[5].textContent.trim();

        document.getElementById("modalTitle").textContent = "Editar Zoocriadero";

        showModal(modalForm);
    }

    // =====================================================
    // GUARDAR SOLO EDICIÓN (REGISTRO ESTÁ ELIMINADO)
    // =====================================================
    btnSubmitForm.addEventListener("click", (e) => {
        e.preventDefault();

        const id = document.getElementById("editingId").value;
        if (!id) {
            alert("El registro está desactivado. Solo puedes editar.");
            return;
        }

        const row = tbody.querySelector(`tr[data-id="${id}"]`);

        row.children[1].textContent = document.getElementById("name").value;
        row.children[2].textContent = document.getElementById("encargado").value;
        row.children[3].textContent = document.getElementById("direccion").value;
        row.children[4].textContent = document.getElementById("tipo").value;
        row.children[5].textContent = document.getElementById("tanque").value;

        alert("Zoocriadero actualizado correctamente.");
        hideModal(modalForm);
    });

    // =====================================================
    // VER DETALLE
    // =====================================================
    function openViewModal(row) {
        detailContent.innerHTML = `
        <p><strong>ID:</strong> ${row.dataset.id}</p>
        <p><strong>Nombre:</strong> ${row.children[1].textContent}</p>
        <p><strong>Encargado:</strong> ${row.children[2].textContent}</p>
        <p><strong>Dirección:</strong> ${row.children[3].textContent}</p>
        <p><strong>Tipo:</strong> ${row.children[4].textContent}</p>
        <p><strong>Tanque:</strong> ${row.children[5].textContent}</p>
    `;
        showModal(modalView);
    }

    // =====================================================
    // ELIMINAR / ANULAR
    // =====================================================
    function openDeleteModal(row) {
        idToDelete = row.dataset.id;
        showModal(modalDelete);
    }

    btnConfirmDelete.addEventListener("click", () => {
        const row = tbody.querySelector(`tr[data-id="${idToDelete}"]`);
        if (row) row.remove();

        hideModal(modalDelete);
        alert("Zoocriadero anulado correctamente.");
    });

    // =====================================================
    // EXPORTAR
    // =====================================================
    function openExportModal(row) {
        const id = row.dataset.id;
        modalExport.dataset.id = id;
        showModal(modalExport);
    }

    document.getElementById("exportCSV").addEventListener("click", () => {
        const id = modalExport.dataset.id;
        alert("Descargando CSV del ID " + id);
    });

    document.getElementById("exportPDF").addEventListener("click", () => {
        window.print();
    });

    // =====================================================
    // CERRAR MODALES
    // =====================================================
    btnCancelForm.onclick = () => hideModal(modalForm);
    btnCloseView.onclick = () => hideModal(modalView);
    btnCancelDelete.onclick = () => hideModal(modalDelete);
    btnCloseExport.onclick = () => hideModal(modalExport);

    // =====================================================
    // FILTROS
    // =====================================================
    btnApplyFilters.addEventListener("click", () => {
        const name = filterName.value.trim().toLowerCase();
        const encargado = filterEncargado.value.trim().toLowerCase();
        const tipo = filterTipo.value.trim().toLowerCase();
        const direccion = filterDireccion.value.trim().toLowerCase();

        [...tbody.children].forEach(row => {
            const matches =
                (name === "" || row.children[1].textContent.toLowerCase() === name) &&
                (encargado === "" || row.children[2].textContent.toLowerCase() === encargado) &&
                (tipo === "" || row.children[4].textContent.toLowerCase() === tipo) &&
                (direccion === "" || row.children[3].textContent.toLowerCase().includes(direccion));

            row.style.display = matches ? "" : "none";
        });
    });

    btnClearFilters.addEventListener("click", () => {
        filterName.value = "";
        filterEncargado.value = "";
        filterTipo.value = "";
        filterDireccion.value = "";

        [...tbody.children].forEach(row => row.style.display = "");
    });

    // =====================================================
    // ASIGNAR EVENTOS A LOS ICONOS
    // =====================================================
    function attachRowEvents() {
        document.querySelectorAll(".btn-view").forEach(btn => {
            btn.onclick = () => openViewModal(btn.closest("tr"));
        });

        document.querySelectorAll(".btn-edit").forEach(btn => {
            btn.onclick = () => openEditModal(btn.closest("tr"));
        });

        document.querySelectorAll(".btn-delete").forEach(btn => {
            btn.onclick = () => openDeleteModal(btn.closest("tr"));
        });

        document.querySelectorAll(".btn-export").forEach(btn => {
            btn.onclick = () => openExportModal(btn.closest("tr"));
        });
    }

    attachRowEvents();
})
