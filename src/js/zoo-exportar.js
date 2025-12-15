// ============================================================================
// EXPORTADOR DE PDF - ZOOCRIADERO
// ============================================================================

const ExportadorPDF = {
  elementos: {
    btnPDF: null,
    content: null,
    btnBack: null
  },

  codZoo: null,

  /**
   * Inicializa el módulo exportador
   */
  init() {
    this.elementos.btnPDF = document.querySelector('.btn-pdf');
    this.elementos.content = document.getElementById('pdfContent');
    this.elementos.btnBack = document.querySelector('.btn-back');

    // Obtener código del zoo desde data attribute o variable global
    this.codZoo = document.body.dataset.codZoo || window.COD_ZOO || 'SIN_CODIGO';

    this.initEventos();
  },

  /**
   * Inicializa los eventos
   */
  initEventos() {
    // Evento del botón PDF
    if (this.elementos.btnPDF) {
      this.elementos.btnPDF.addEventListener('click', () => this.generarPDF());
    }

    // Evento del botón volver
    if (this.elementos.btnBack) {
      this.elementos.btnBack.addEventListener('click', () => this.volver());
    }

    // Atajo de teclado Ctrl+P para imprimir
    document.addEventListener('keydown', (e) => this.manejarAtajos(e));

    // Atajo Ctrl+S para descargar PDF
    document.addEventListener('keydown', (e) => {
      if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        this.generarPDF();
      }
    });
  },

  /**
   * Maneja los atajos de teclado
   */
  manejarAtajos(e) {
    // Ctrl+P = Imprimir
    if (e.ctrlKey && e.key === 'p') {
      e.preventDefault();
      this.imprimir();
    }

    // Escape = Volver
    if (e.key === 'Escape') {
      this.volver();
    }
  },

  /**
   * Genera y descarga el PDF
   */
  async generarPDF() {
    // Verificar que jsPDF esté cargado
    if (!window.jspdf) {
      alert('Error: La librería jsPDF no está cargada correctamente.');
      return;
    }

    const { jsPDF } = window.jspdf;

    try {
      this.mostrarEstadoCarga(true);

      // Capturar el contenido como imagen
      const canvas = await html2canvas(this.elementos.content, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff',
        windowWidth: this.elementos.content.scrollWidth,
        windowHeight: this.elementos.content.scrollHeight
      });

      // Crear el PDF
      const pdf = await this.crearPDF(canvas);

      // Generar nombre del archivo
      const nombreArchivo = this.generarNombreArchivo();

      // Descargar
      pdf.save(nombreArchivo);

      this.mostrarEstadoCarga(false);
      this.mostrarMensajeExito();

    } catch (error) {
      console.error('Error al generar PDF:', error);
      this.mostrarEstadoCarga(false);
      this.mostrarMensajeError(error);
    }
  },

  /**
   * Crea el objeto PDF con las páginas necesarias
   */
  async crearPDF(canvas) {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');

    const imgData = canvas.toDataURL('image/png');
    
    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();
    const margin = 10;
    const imgWidth = pageWidth - (margin * 2);
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    let heightLeft = imgHeight;
    let position = margin;

    // Primera página
    pdf.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
    heightLeft -= (pageHeight - margin * 2);

    // Páginas adicionales si es necesario
    while (heightLeft > 0) {
      position = heightLeft - imgHeight + margin;
      pdf.addPage();
      pdf.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
      heightLeft -= (pageHeight - margin * 2);
    }

    return pdf;
  },

  /**
   * Genera el nombre del archivo PDF
   */
  generarNombreArchivo() {
    const fecha = new Date();
    const timestamp = fecha.getTime();
    const fechaFormato = fecha.toISOString().split('T')[0];
    
    return `Zoocriadero_${this.codZoo}_${fechaFormato}_${timestamp}.pdf`;
  },

  /**
   * Muestra u oculta el estado de carga
   */
  mostrarEstadoCarga(mostrar) {
    if (!this.elementos.btnPDF) return;

    if (mostrar) {
      this.elementos.btnPDF.dataset.originalText = this.elementos.btnPDF.innerHTML;
      this.elementos.btnPDF.innerHTML = '⏳ Generando PDF...';
      this.elementos.btnPDF.disabled = true;
      this.elementos.btnPDF.style.opacity = '0.7';
    } else {
      this.elementos.btnPDF.innerHTML = this.elementos.btnPDF.dataset.originalText || '📥 Descargar PDF';
      this.elementos.btnPDF.disabled = false;
      this.elementos.btnPDF.style.opacity = '1';
    }
  },

  /**
   * Muestra mensaje de éxito
   */
  mostrarMensajeExito() {
    // Usar notificación nativa del navegador si está disponible
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification('PDF Generado', {
        body: 'El PDF se ha descargado correctamente',
        icon: '📄'
      });
    } else {
      alert('✓ PDF generado correctamente');
    }
  },

  /**
   * Muestra mensaje de error
   */
  mostrarMensajeError(error) {
    const mensaje = error.message || 'Error desconocido';
    alert(`❌ Error al generar el PDF\n\nDetalle: ${mensaje}\n\nPor favor, intente nuevamente.`);
  },

  /**
   * Función para imprimir directamente
   */
  imprimir() {
    window.print();
  },

  /**
   * Volver a la página anterior
   */
  volver() {
    // Intentar cerrar la ventana (solo funciona si fue abierta por window.open)
    if (window.opener) {
      window.close();
    } else {
      // Si no se puede cerrar, volver atrás
      window.history.back();
    }
  },

  /**
   * Solicitar permisos de notificación (opcional)
   */
  solicitarPermisosNotificacion() {
    if ('Notification' in window && Notification.permission === 'default') {
      Notification.requestPermission();
    }
  }
};

// ============================================================================
// INICIALIZACIÓN
// ============================================================================

// Iniciar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    ExportadorPDF.init();
  });
} else {
  ExportadorPDF.init();
}

// Exponer globalmente para uso desde HTML si es necesario
window.generarPDF = () => ExportadorPDF.generarPDF();