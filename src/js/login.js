// login.js - validaciones cliente (acepta solo números en documento) y límite máximo de 11 dígitos
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formLogin");
  const documentoInput = document.getElementById("documento");
  const passwordInput = document.getElementById("password");

  if (typeof iziToast !== "undefined") {
    iziToast.settings({
      position: 'topRight', // 'bottomRight' o 'topRight' si prefieres arriba
      timeout: 5000,
      close: true,
      transitionIn: 'fadeInDown',
      transitionOut: 'fadeOutUp'
    });
  }

  const MAX_DIGITS = 10;

  // Evitar que se escriban caracteres no numéricos y limitar a MAX_DIGITS
  documentoInput.addEventListener("input", (e) => {
    // quitar todo lo que no sea dígito
    let onlyDigits = e.target.value.replace(/\D+/g, "");
    // truncar a MAX_DIGITS
    if (onlyDigits.length > MAX_DIGITS) {
      onlyDigits = onlyDigits.slice(0, MAX_DIGITS);
    }
    // reasignar siempre el valor limpio/truncado
    if (e.target.value !== onlyDigits) {
      e.target.value = onlyDigits;
    }
  });

  // Controlar pegado para filtrar dígitos y limitar la longitud
  documentoInput.addEventListener("paste", (e) => {
    const paste = (e.clipboardData || window.clipboardData).getData("text");
    const filtered = paste.replace(/\D+/g, "");
    if (!filtered) {
      e.preventDefault();
      return;
    }
    e.preventDefault();
    const start = documentoInput.selectionStart ?? documentoInput.value.length;
    const end = documentoInput.selectionEnd ?? start;
    const before = documentoInput.value.slice(0, start);
    const after = documentoInput.value.slice(end);
    const spaceLeft = MAX_DIGITS - (before.length + after.length);
    const toInsert = filtered.slice(0, Math.max(0, spaceLeft));
    documentoInput.value = (before + toInsert + after).slice(0, MAX_DIGITS);
    const cursorPos = before.length + toInsert.length;
    documentoInput.setSelectionRange(cursorPos, cursorPos);
  });

  // Evitar teclear más dígitos cuando ya se alcanzó el máximo (mejora UX)
  documentoInput.addEventListener("keydown", (e) => {
    // permitir teclas de control: backspace, delete, arrows, tab, ctrl/cmd, home/end
    const controlKeys = ['Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Tab','Home','End'];
    if (controlKeys.includes(e.key) || e.ctrlKey || e.metaKey) return;
    // si no es dígito, prevenir
    if (!/^\d$/.test(e.key)) {
      e.preventDefault();
      return;
    }
    // si ya alcanzó el máximo, prevenir entrada de más dígitos
    // permitir escribir si hay selección (se reemplaza)
    const selStart = documentoInput.selectionStart ?? documentoInput.value.length;
    const selEnd = documentoInput.selectionEnd ?? selStart;
    const currentLength = documentoInput.value.length - (selEnd - selStart);
    if (currentLength >= MAX_DIGITS) {
      e.preventDefault();
    }
  });

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    let documento = documentoInput.value.trim();
    let password = passwordInput.value.trim();

    if (!documento || !password) {
      iziToast.error({ title: "Error", message: "Todos los campos son obligatorios" });
      return;
    }

    // Validación que documento contenga sólo dígitos y no exceda MAX_DIGITS
    if (!/^\d+$/.test(documento) || documento.length > MAX_DIGITS) {
      iziToast.error({ title: "Error", message: `El documento debe contener solo números (máx. ${MAX_DIGITS} dígitos)` });
      return;
    }

    // (Opcional) validar longitud mínima
    if (documento.length < 6) {
      iziToast.error({ title: "Error", message: "El documento es demasiado corto" });
      return;
    }

    let datos = new FormData();
    datos.append("documento", documento);
    datos.append("password", password);

    try {
      let res = await fetch("./backend/apilogin.php", {
        method: "POST",
        body: datos
      });

      let data;
      try {
        data = await res.json();
      } catch (err) {
        iziToast.error({ title: "Error", message: "Credenciales incorrectas" });
        return;
      }

      if (data.mensaje === "exito") {
        iziToast.success({ title: "Bienvenido", message: "Inicio de sesión exitoso" });
        setTimeout(() => {
          window.location.href = "../../app/principal/index.php";
        }, 1200);
      } else {
        iziToast.error({ title: "Error", message: data.mensaje || "Credenciales incorrectas" });
      }
    } catch (err) {
      iziToast.error({ title: "Error", message: "No se pudo conectar con el servidor" });
      console.error(err);
    }
  });
});