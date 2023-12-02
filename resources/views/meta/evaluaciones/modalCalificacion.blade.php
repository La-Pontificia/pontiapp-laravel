<div id="calificar-objs" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)]">
    <div class="relative max-w-screen-xl flex flex-col border rounded-xl overflow-y-auto shadow-xl bg-white w-full">
        <!-- Modal content -->
        <button type="button"
            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="calificar-objs">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
        <header class="text-center p-6 ">
            <h1 class="text-lg font-semibold">
                Calificar objetivos
            </h1>
        </header>
        <div>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr class="border-y text-sm divide-x border-gray-200 dark:border-gray-700">
                        <th scope="col" class="px-3 py-2 bg-gray-50 dark:bg-gray-800">
                            Objetivo
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Descripción
                        </th>
                        <th scope="col" class="px-3 py-2 bg-gray-50 dark:bg-gray-800">
                            Indicadores
                        </th>
                        <th scope="col" class="px-3 w-[70px] text-center text-sm py-2">
                            <div>
                                <h1>Total</h1>
                                <span
                                    class="bg-purple-100 text-purple-800 block rounded-full p-1">({{ $totalporcentaje }}%)</span>
                            </div>
                        </th>
                        <th scope="col" class="px-3 w-[70px] text-center text-sm py-2">
                            <h1>NA</h1>
                        </th>
                        <th scope="col" class="px-3 w-[200px] text-center py-2">
                            Promedio
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body-list" class="divide-y">
                    @foreach ($objetivos as $objetivo)
                        @php
                            $autocalificacion = $n_eva == 1 ? $objetivo->autocalificacion : $objetivo->autocalificacion_2;
                        @endphp
                        <tr class="border-b border-gray-200 divide-x text-sm ">
                            <th scope="row" class="px-4 py-2 text-sm font-semibold text-blue-900 bg-gray-50 ">
                                <h3 class="">{{ $objetivo->objetivo }}</h3>
                            </th>
                            <td class="px-4 py-2">
                                <div class=" text-sm overflow-ellipsis overflow-hidden">
                                    {{ $objetivo->descripcion }}
                                </div>
                            </td>
                            <td class="px-4 py-2 bg-gray-50 dark:bg-gray-800">
                                <div class=" text-sm overflow-ellipsis overflow-hidden">
                                    {{ $objetivo->indicadores }}
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="justify-center w-full flex">
                                    <span
                                        class="bg-purple-100 text-purple-800 p-1 px-3 text-sm font-medium mr-2 rounded-full">{{ $objetivo->porcentaje }}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-2 bg-gray-50 ">
                                <div class=" text-base font-semibold text-center overflow-ellipsis overflow-hidden">
                                    {{ $autocalificacion }}
                                </div>
                            </td>
                            <td class="px-3 py-2 bg-gray-50 dark:bg-gray-800">
                                <select name="nota" data-id="{{ $objetivo->id }}" required id="nota"
                                    class=" bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected value="">
                                        Seleccionar
                                    </option>
                                    <option value="1">1
                                    </option>
                                    <option value="2">2
                                    </option>
                                    <option value="3">3
                                    </option>
                                    <option value="4">4
                                    </option>
                                    <option value="5">5
                                    </option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="p-3 flex justify-end">
            <button id="guardar-autocalificacion" data-id="{{ $id_eda }}" data-eva="{{ $n_eva }}"
                class="bg-red-700 flex items-center gap-2 p-2 px-6 rounded-md text-white">
                <svg class="w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15.3431C16.1606 3 16.5694 3 16.9369 3.15224C17.3045 3.30448 17.5935 3.59351 18.1716 4.17157L19.8284 5.82843C20.4065 6.40649 20.6955 6.69552 20.8478 7.06306C21 7.4306 21 7.83935 21 8.65685V15C21 17.8284 21 19.2426 20.1213 20.1213C19.48 20.7626 18.5534 20.9359 17 20.9827V18L17 17.9384C17.0001 17.2843 17.0001 16.6965 16.9362 16.2208C16.8663 15.7015 16.7042 15.1687 16.2678 14.7322C15.8313 14.2958 15.2985 14.1337 14.7792 14.0638C14.3034 13.9999 13.7157 13.9999 13.0616 14L13 14H10L9.93839 14C9.28427 13.9999 8.69655 13.9999 8.22084 14.0638C7.70149 14.1337 7.16867 14.2958 6.73223 14.7322C6.29579 15.1687 6.13366 15.7015 6.06383 16.2208C5.99988 16.6965 5.99993 17.2843 6 17.9384L6 18V20.9239C5.02491 20.828 4.36857 20.6112 3.87868 20.1213C3 19.2426 3 17.8284 3 15V9ZM15 18V21H9C8.64496 21 8.31221 21 8 20.9983V18C8 17.2646 8.00212 16.8137 8.046 16.4873C8.08457 16.2005 8.13942 16.1526 8.14592 16.1469L8.14645 16.1464L8.14692 16.1459C8.1526 16.1394 8.20049 16.0846 8.48734 16.046C8.81369 16.0021 9.26462 16 10 16H13C13.7354 16 14.1863 16.0021 14.5127 16.046C14.7995 16.0846 14.8474 16.1394 14.8531 16.1459L14.8536 16.1464L14.8541 16.1469C14.8606 16.1526 14.9154 16.2005 14.954 16.4873C14.9979 16.8137 15 17.2646 15 18ZM7 7C6.44772 7 6 7.44772 6 8C6 8.55228 6.44772 9 7 9H12C12.5523 9 13 8.55228 13 8C13 7.44772 12.5523 7 12 7H7Z"
                            fill="currentColor"></path>
                    </g>
                </svg>
                Guardar calificaciones
            </button>
        </footer>
    </div>
</div>

@section('script')
    <script>
        const guardarCalificacion = document.getElementById('guardar-autocalificacion')
        const tableListBody = document.getElementById('table-body-list')

        guardarCalificacion.addEventListener('click', () => {
            const tableRows = document.querySelectorAll('#table-body-list tr');
            let allSelectsSelected = true;

            tableRows.forEach(row => {
                const selectElement = row.querySelector('select[name="nota"]');
                const autocalificacion = selectElement.value;
                if (autocalificacion === "") allSelectsSelected = false
            });

            if (allSelectsSelected) {
                const califacionArray = [];
                tableRows.forEach(row => {
                    const selectElement = row.querySelector('select[name="nota"]');
                    const objetivoId = selectElement.dataset.id;
                    const autocalificacion = selectElement.value;
                    califacionArray.push({
                        id: objetivoId,
                        autocalificacion: autocalificacion
                    });
                });

                const idEda = guardarCalificacion.dataset.id;
                const n_eva = guardarCalificacion.dataset.eva;

                Swal.fire({
                    title: '¿Estás seguro de guardar las notas calificadas?',
                    text: 'No podrás deshacer esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/objetivos/calificar`, {
                            califacionArray,
                            n_eva
                        }).then((res) => {
                            window.location.reload()
                        }).catch((error) => {
                            alert(error)
                        })
                    }
                });


            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Calificación incompleta',
                    text: 'Todos los objetivos tienen que estar calificados, por favor vuelve a intentarlo.',
                })
            }
        })
    </script>
@endsection
