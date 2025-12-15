document.addEventListener('DOMContentLoaded', () => {
    const selectRealizo = document.getElementById('selectRealizo');
    const selectTipoFocoReg = document.getElementById('selectTipoFoco');
    // const selectTipoFocoEdi = document.getElementById('selectTipoFocoEdi')
    const focoDescription = document.getElementById('focoDescription');
    const focoDescriptionText = document.getElementById('focoDescriptionText');
    //const focoDescriptionEdi = document.getElementById('focoDescriptionEdi');
    //const focoDescriptionTextEdi = document.getElementById('focoDescriptionTextEdi');
    const formRegistrarFoco = document.getElementById('formRegistrarFoco')
    const formEditarFoco = document.getElementById('formEditarFoco')

    const cod_controlactividadeco = document.getElementById('cod_controlactividadeco')


    formRegistrarFoco.addEventListener('submit', (e) => {
        e.preventDefault()
        const form = new FormData(formRegistrarFoco)
        RegistrarFocoPotencial(form)
    })


    function GetInvolucrados(quien, cod_territorio) {
        // quien = participantes
        // quien = usuarios_eco
        const form = new FormData();
        form.append('cod_territorio', cod_territorio);
        fetch(`../backend/api.php?accion=traer_${quien}`, {
            method: 'POST',
            body: form
        })
            .then(respuesta => respuesta.json())
            .then(involucrados => {
                involucrados.forEach((inv) => {
                    const option = document.createElement('option');
                    option.value = inv.nombre; // aqui iba con id
                    option.textContent = inv.nombre;
                    selectRealizo.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function GetFocosPotenciales() {
        fetch('../backend/api.php?ajax=traer_tiposfocos')
            .then(respuesta => respuesta.json())
            .then(tiposfocos => {
                selectTipoFoco.innerHTML = '';
                tiposfocos.forEach((foco) => {
                    const option = document.createElement('option');
                    option.value = foco.cod_tipo_foc;
                    option.textContent = foco.nombre_foco;
                    option.dataset.descripcion = foco.descripcion_foco || 'Sin descripción disponible';
                    selectTipoFoco.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    async function RegistrarFocoPotencial(form) {
        const solicito = await fetch('../backend/api.php?accion=registrar', {
            method: 'POST',
            body: form
        })

        const respuesta = await solicito.text();
        if (respuesta == 'exito') {
            alert('Exito')
            window.location.href = 'inicio.php'
        }
    }




    // Show description when tipo de foco changes
    selectTipoFocoReg.addEventListener('change', (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const descripcion = selectedOption.dataset.descripcion;

        if (descripcion && e.target.value) {
            focoDescriptionText.textContent = descripcion;
            focoDescription.classList.remove('hidden');
        } else {
            focoDescription.classList.add('hidden');
        }
    });
    /*
    selectTipoFocoEdi.addEventListener('change', (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const descripcion = selectedOption.dataset.descripcion;

        if (descripcion && e.target.value) {
            focoDescriptionTextEdi.textContent = descripcion;
            focoDescriptionEdi.classList.remove('hidden');
        } else {
            focoDescriptionEdi.classList.add('hidden');
        }
    });
    */

    // Add subtle animation to inputs on focus
    const allInputs = document.querySelectorAll('input[type="text"], select');
    allInputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.style.transform = 'scale(1.01)';
        });

        input.addEventListener('blur', function () {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    GetInvolucrados('usuarios_eco', 3);
    GetFocosPotenciales();

});