const loadings = document.querySelectorAll(".loading-form-colab")
function loadingActive() {
    loadings.forEach(loading => {
        loading.classList.add('grid');
        loading.classList.remove('hidden');
    })

}

function loadingRemove() {
    loadings.forEach(loading => {
        loading.classList.remove('grid');
        loading.classList.add('hidden');
    })
}


// selectPuesto.forEach(select => {
//     select.addEventListener('change', async function () {
//         const id_puesto = this.value;
//         const id = select.id;
//         const isCreateSelect = id === 'puesto_create'
//         const selectCargo = document.getElementById(`cargo-${select.id}`);
//         console.log(select.id)
//         // try {
//         //     loadingActive()
//         //     const response = await axios.get(`/cargos/json/${id_puesto}`)
//         //     selectCargo.innerHTML = '<option value="" selected >Selecciona un cargo</option>';
//         //     const cargos = response.data;
//         //     cargos.forEach(function (cargo) {
//         //         const option = document.createElement('option');
//         //         option.value = cargo.id;
//         //         option.textContent = cargo.nombre;
//         //         selectCargo.appendChild(option);
//         //     });

//         // } catch (error) {
//         //     console.log(error)
//         // } finally {
//         //     loadingRemove()
//         // }
//     });
// })


const selects = document.querySelectorAll('.puesto-fetch, .cargo-fetch');
selects.forEach(select => {
    select.addEventListener('change', async function (e) {
        const id_puesto = e.target.value;
        const selectHermano = this.parentElement.nextElementSibling.querySelector('select');
        try {
            loadingActive()
            const response = await axios.get(`/cargos/json/${id_puesto}`)
            selectHermano.innerHTML = '<option value="" selected >Selecciona un cargo</option>';
            const cargos = response.data;
            cargos.forEach(function (cargo) {
                const option = document.createElement('option');
                option.value = cargo.id;
                option.textContent = cargo.nombre;
                selectHermano.appendChild(option);
            });

        } catch (error) {
            console.log(error)
        } finally {
            loadingRemove()
        }
    });
});