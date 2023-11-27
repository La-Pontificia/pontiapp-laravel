<div id="form-multiple-objetivos" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative max-w-7xl w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="form-multiple-objetivos">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            @includeif('partials.errors')
            <div class="">
                <header class="px-4 py-4">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                        Agregar
                        nuevo
                        objetivo</h3>

                </header>
                <div>

                    <div class="relative overflow-x-auto shadow-md">
                        <table class="w-full text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 min-w-[80px] py-3">
                                        Objetivo
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Descripcion
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Indicadores
                                    </th>
                                    <th scope="col" class="px-6 w-10 py-3">
                                        Porcentaje
                                    </th>
                                    <th scope="col" class="w-[40px]">

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="lista-objetivos-table" class="divide-y">
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between p-5">
                        <span class="flex flex-grow basis-0"></span>
                        <button id="add-objetivos" type="button"
                            class="text-white disabled:opacity-40 bg-red-700 hover:bg-red-600 flex items-center gap-2 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg px-5 py-2.5 text-center">
                            <svg class="w-5" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                            Agregar objetivos
                        </button>
                        <div class="flex flex-grow justify-end">
                            <p id="total_porcentaje" class="bg-white font-semibold p-3 px-5 rounded-xl">

                            </p>
                        </div>
                    </div>

                </div>
                <footer class="border-t p-2 flex justify-end">
                    <button type="button" data-id="{{ $id_eda }}" disabled id="send-objetivos"
                        class="text-white disabled:opacity-40 bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 shadow-lg shadow-purple-500/50 font-medium rounded-lg text-base px-5 py-2.5 text-center">
                        Enviar objetivos
                    </button>
                </footer>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        // variables globales
        let objetivos = []
        let totalPorcentaje = 0

        const tablalista = document.getElementById('lista-objetivos-table');
        const addButton = document.getElementById('add-objetivos');
        const setObjetivos = document.getElementById('send-objetivos');

        // Ejemplo de uso
        const svgString =
            `<svg class="w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>`;



        addButton.addEventListener('click', () => {
            objetivos.push({
                uid: crypto.randomUUID(),
                objetivo: '',
                descripcion: '',
                indicadores: '',
                porcentaje: 10
            })
            listObjetivosWithDom()
        })

        setObjetivos.addEventListener('click', () => {
            const id_eda = setObjetivos.dataset.id;
            let correcto = true
            if (totalPorcentaje !== 100) {
                Swal.fire({
                    icon: 'info',
                    title: 'Total de porcentaje exedido',
                    text: 'El total del porcentaje de tus objetivos exeden los 100, intenta cambiarlos.',
                })
                return
            }

            for (const e of objetivos) {
                const porcentaje = parseInt(e.porcentaje ?? '0');
                if (e.objetivo !== '' && e.descripcion !== '' && e.indicadores !== '' && porcentaje >= 1) {
                    continue;
                }
                correcto = false;
            }


            if (correcto) {
                Swal.fire({
                    title: '¿Estas seguro de enviar los objetivos?',
                    text: 'No podras deshacer esta acción',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: `Sí, enviar`,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/objetivos/${id_eda}`, {
                            objetivos
                        }).then(res => {
                            location.reload()
                        }).catch(err => {
                            console.log(err)
                        })
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Incompleto',
                    text: 'Los campos de los objetivos no pueden estar vacios y los porcentajes no pueden ser menor a 1, intentalo nuevamente.',
                })
            }
        })

        formsControl.forEach((control) => {
            control.addEventListener('change', (event) => {
                console.log(event.target.value);
            });
        });

        function listObjetivosWithDom() {
            tablalista.innerHTML = '';

            const classname =
                'outline-none text-black resize-none border-transparent w-full';

            objetivos.forEach(objetivo => {
                const row = tablalista.insertRow();
                const cell1 = row.insertCell(0);
                const cell2 = row.insertCell(1);
                const cell3 = row.insertCell(2);
                const cell4 = row.insertCell(3);
                const cell5 = row.insertCell(4);

                row.className = 'divide-x'
                cell2.className = ''
                cell3.className = ''
                cell4.className = ''
                cell5.className = ''

                const createTextarea = (value, dataId, dataName) => {
                    const textarea = document.createElement('textarea');
                    textarea.value = value;
                    textarea.className = `${classname} w-full`;
                    textarea.rows = 4;
                    textarea.addEventListener('input', (event) => {
                        const newValue = event.target.value
                        onChange(dataId, newValue, dataName)
                    });
                    return textarea;
                };

                const createNumberInput = (value, dataId, dataName) => {
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.value = value;
                    input.min = 0;
                    input.max = 100;
                    input.className = `${classname} py-4 h-full mx-auto px-2 text-center`;
                    input.addEventListener('input', (event) => {
                        const newValue = event.target.value
                        onChange(dataId, newValue, dataName)
                        calcularPorcentaje()
                    });
                    return input;
                };

                const createButtonDelete = (dataId) => {
                    const button = document.createElement('button');
                    button.className = 'w-[35px] h-[35px] rounded-full p-2';
                    const div = document.createElement('div');
                    div.innerHTML = svgString;
                    const svgElement = div.firstChild;
                    button.appendChild(svgElement);
                    button.addEventListener('click', (event) => {
                        eliminarItem(dataId)
                    });
                    return button;
                };

                const textarea1 = createTextarea(objetivo.objetivo, objetivo.uid, 'objetivo');
                cell1.appendChild(textarea1);

                const textarea2 = createTextarea(objetivo.descripcion, objetivo.uid, 'descripcion');
                cell2.appendChild(textarea2);

                const textarea3 = createTextarea(objetivo.indicadores, objetivo.uid, 'indicadores');
                cell3.appendChild(textarea3);

                const input4 = createNumberInput(objetivo.porcentaje, objetivo.uid, 'porcentaje');
                cell4.appendChild(input4);

                const buttonDelete = createButtonDelete(objetivo.uid);
                cell5.appendChild(buttonDelete);
                calcularPorcentaje()
            });
        }

        function eliminarItem(uid) {
            const newArray = objetivos.filter(e => e.uid !== uid)
            objetivos = newArray;
            listObjetivosWithDom()
        }

        function onChange(uid, value, dataName) {
            const newArray = objetivos.map(item => {
                if (item.uid === uid) {
                    return {
                        ...item,
                        [dataName]: value
                    }
                }
                return item
            })
            objetivos = newArray
        }

        function calcularPorcentaje() {
            totalPorcentaje = 0;
            objetivos.map((e) => {
                totalPorcentaje += parseInt(e.porcentaje)
            })
            const totalPorcentajeElement = document.getElementById('total_porcentaje');
            totalPorcentajeElement.textContent = `${totalPorcentaje}%`;

            if (totalPorcentaje >= 100) {
                setObjetivos.disabled = false
                addButton.disabled = true
            } else {
                setObjetivos.disabled = true
                addButton.disabled = false
            }
        }
    </script>
@endsection
