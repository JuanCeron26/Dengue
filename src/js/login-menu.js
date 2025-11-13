window.addEventListener('load', () => {
    const container = document.getElementById('split-container');
    const left = document.getElementById('modulo-izquierdo');
    const right = document.getElementById('modulo-derecho');


    // acordarme del flex-1 que se divide 100 / 1
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