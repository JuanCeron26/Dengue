window.addEventListener('load', () => {
    const btnAside = document.getElementById("btn-aside");
    const aside = document.getElementById("aside");

    btnAside.addEventListener('click', () => {
        aside.classList.toggle("-translate-x-full");
    });

    document.addEventListener('click', (e) => {
        if (!aside.contains(e.target) && !btnAside.contains(e.target)) {
            aside.classList.add("-translate-x-full");

        }
    })

})
