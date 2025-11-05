window.addEventListener('load', () => {
    const container = document.getElementById('split-container');
    const left = document.getElementById('modulo-izquierdo');
    const right = document.getElementById('modulo-derecho');

    left.addEventListener('mouseenter', () => {
        left.style.flex = '0.7';
        right.style.flex = '0.3';
    });

    right.addEventListener('mouseenter', () => {
        left.style.flex = '0.3';
        right.style.flex = '0.7';
    });

    container.addEventListener('mouseleave', () => {
        left.style.flex = '1';
        right.style.flex = '1';
    });
});