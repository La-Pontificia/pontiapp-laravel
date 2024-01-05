<div id="accesos" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Accesos del colaborador
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="accesos">
                    <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 flex flex-col gap-3">
                <div class="p-2 rounded-xl border border-dashed">
                    <h1 class="text-xs text-neutral-400 pb-2">ACCESOS DEL COLABORADOR</h1>
                    <div id="access-list" class="grid grid-cols-2 gap-4 text-sm font-medium ">
                    </div>
                    <div id="loading-svg" class="w-full h-full flex">
                        <div class="w-full h-full grid place-content-center p-10">
                            <svg aria-hidden="true" class="w-10 h-10 text-gray-200 animate-spin fill-blue-600"
                                viewBox="0 0 100 101" fill="none">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button data-modal-hide="static-modal" type="button" id="btn-submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center ">
                    Guardar
                </button>
                <button data-modal-hide="accesos" type="button"
                    class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const initialAccessSytem = ["mantenimiento", "reportes", "contraseña_colaborador", "crear_colaborador",
        "editar_colaborador", "accesos_colaborador", "estado_colaborador", "asignar_supervisor", "enviar_objetivos",
        "autocalificar", "calificar", "cerrar_eva", "cerrar_eda", "enviar_cuestionario", "ver_colaboradores",
        "ver_edas",
        "auditoria", "crear_eda"
    ]

    let accessColaborador = []

    const accessList = document.getElementById('access-list')
    const btnsOpen = document.querySelectorAll('.accesos-btn')
    const loadingsvg = document.getElementById('loading-svg')
    const btnSubmit = document.getElementById('btn-submit')

    const paintList = () => {
        initialAccessSytem.forEach((item) => {
            const label = document.createElement('label');
            const uuid = crypto.randomUUID()
            const isCheck = accessColaborador.includes(item)
            label.classList = 'relative w-full inline-flex items-center cursor-pointer';
            label.innerHTML = `
                    <input type="checkbox" ${isCheck ? 'checked' : ''} id="${uuid}" data-name="${item}" class="sr-only privilege peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium capitalize text-gray-900 dark:text-gray-300">${item.replace("_", ' ')}</span>
                `
            accessList.appendChild(label);

            const privilegeInput = document.getElementById(uuid)
            privilegeInput.addEventListener('change', (e) => {
                const name = privilegeInput.dataset.name
                if (accessColaborador.includes(name))
                    accessColaborador = accessColaborador.filter(i => i !== name)
                else accessColaborador.push(name)
            })
        });
    }

    btnSubmit.addEventListener('click', async () => {
        const id = btnSubmit.dataset.id;
        try {
            await axios.post('/colaborador/privilegios/update', {
                list: accessColaborador,
                id
            })
            Swal.fire({
                icon: 'success',
                title: 'Privilegios actualizados correctamente',
            }).then(() => {
                window.location.href = window.location.href;
            });

        } catch (error) {
            console.log(error)
        }
    })




    btnsOpen.forEach((btn) => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id
            loadingsvg.classList = 'flex'
            accessList.innerHTML = ''
            try {
                const res = await axios.get(`/colaborador/privilegios/${id}`)
                accessColaborador = res.data;
                btnSubmit.dataset.id = id
                paintList()
            } catch (error) {
                console.log(error)
            } finally {
                loadingsvg.classList = 'hidden'
            }
        })
    })
</script>
