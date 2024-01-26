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


/// add providers


const btnToggleEstado = document.querySelectorAll('.toggle-estado')
const changePasswordForm = document.querySelectorAll('.change-password')
// STORE 

changePasswordForm.forEach(form => {
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        try {
            const formData = new FormData(this);
            const response = await axios.post(this.action, formData);
            Swal.fire({
                icon: 'success',
                title: 'Contraseña actualizado correctamente!',
            }).then(() => {
                location.reload()
            });
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Error al actualizar lac contraseña',
                text: err.message,
            });
        }

    });
})

btnToggleEstado.forEach((btn) => {
    btn.addEventListener('click', async function () {
        const id = btn.dataset.id
        try {
            await axios.post(`/colaboradores/cambiar-estado/${id}`)
            Swal.fire({
                icon: 'success',
                title: 'Estado cambiado correctamente',
            }).then(() => {
                location.reload()
            });

        } catch (error) {
            console.log(error);
        }
    })
})

const busquedaInputs = document.querySelectorAll('.query-colab');
const ul_results = document.querySelectorAll('.colabs-q');
const btnSupers = document.querySelectorAll('.btn-super-colab');
const initialHtml = `<div class="h-[100px] grid place-content-center">
                                <h2 class="text-center text-neutral-500 text-lg">Busca un colaborador y luego asigna
                                    como supervisor
                                </h2>
                            </div>`



busquedaInputs.forEach((input) => {
    input.addEventListener('input', async function () {
        const q = this.value;
        const id_colab = this.getAttribute('data-id');
        if (q === '') {
            ul_results.forEach((ul) => {
                ul.innerHTML = initialHtml;
            });
            return;
        }
        const response = await axios.get(`/search-colaboradores?q=${q}`)

        ul_results.forEach((ul) => {
            ul.innerHTML = '';
        });

        response.data.forEach(function (colaborador) {
            const li = document.createElement('li');
            li.innerHTML =
                `<div class='flex item-center gap-2'>
                     <span class="w-10 h-10 rounded-full overflow-hidden">
                         <img class="w-full h-full object-cover" src="${colaborador.perfil ?? '/default-user.webp'}" alt="Jese image">
                     </span>
                     <h4>${colaborador.apellidos},${colaborador.nombres}</h4>
                     <span class="font-semibold">${colaborador.dni}</span>
                     <button id_colab='${id_colab}' id_super='${colaborador.id}' type="button"
                         class="btn-super-colab text-gray-900 ml-auto bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center :focus:ring-gray-600 :bg-gray-800 :border-gray-700 :text-white :hover:bg-gray-700">
                         <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                             </path>
                         </svg>
                         Asignar
                     </button>
                  </div>
                 `;

            ul_results.forEach((ul) => {
                const data_id = ul.getAttribute('data-id');
                if (data_id === id_colab) {
                    ul.appendChild(li);
                }
            });

            const btnSupers = li.querySelector('.btn-super-colab');
            btnSupers.addEventListener('click', async function () {
                const idColab = this.getAttribute("id_colab");
                const idSuper = this.getAttribute("id_super");
                try {
                    await axios.post(
                        '/colaboradores/update-supervisor', {
                        id_colab: idColab,
                        id_super: idSuper
                    })
                    location.reload()
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al crear el objetivo',
                        text: error.message,
                    });
                }
            });
        });
    });
});