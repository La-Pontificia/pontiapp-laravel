<tr
    class="bg-white [&>td]:px-2 [&>td]:py-2 [&>th]:px-2 [&>th]:py-2 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
    <th scope="row" class="flex items-center  text-gray-900 whitespace-nowrap dark:text-white">
        <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
        <div class="pl-3">
            <div class="text-lg font-semibold">
                {{ $colaborador->apellidos }}
                {{ $colaborador->nombres }}
            </div>
            <div class="font-normal text-gray-500">{{ $colaborador->dni }}</div>
        </div>
    </th>
    <td class=" capitalize text-red-600 font-medium">
        {{ strtolower($colaborador->cargo->nombre_cargo) }}
    </td>
    <td class=" capitalize text-yellow-600 font-medium">
        {{ strtolower($colaborador->puesto->nombre_puesto) }}
    </td>
    <td class=" capitalize text-sky-600 font-medium">
        {{ strtolower($colaborador->puesto->departamento->area->nombre_area) }}
        <span class="block text-neutral-500 text-sm font-normal line-clamp-1"><span>Dep.</span>
            {{ strtolower($colaborador->puesto->departamento->nombre_departamento) }}</span>
    </td>
    <td class="">
        @if ($colaborador->estado == 0)
            <span
                class="bg-red-100 text-red-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Inactivo</span>
        @else
            <span
                class="bg-green-100 text-green-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Activo</span>
        @endif
    </td>
    <td class="">
        <div class="line-clamp-2">
            {{ \Carbon\Carbon::parse($colaborador->created_at)->format('j \d\e F, Y') }}
        </div>
    </td>
    <td>
        <div class="flex gap-1">
            <button type="button" title="Editar"
                class="text-white gap-2 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z" />
                </svg>
            </button>
            <a href="/profile/{{ $colaborador->id }}/eda" title="Objetivos"
                class="text-white gap-2 bg-[#f44268] hover:bg-[#f57893] focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] px-3 justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 18 20">
                    <path
                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                </svg>
                Perfil
            </a>
            <button type="button" data-modal-target="modal-add-supervisor-{{ $colaborador->id }}"
                data-modal-toggle="modal-add-supervisor-{{ $colaborador->id }}"
                class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                Supervisor
            </button>
        </div>

        <!-- Main modal -->
        <div id="modal-add-supervisor-{{ $colaborador->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-lg max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-add-supervisor-{{ $colaborador->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                    <!-- Modal header -->
                    <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                            Asignar supervisor
                        </h3>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4">
                        <p class="text-sm mb-4 font-normal text-gray-500 dark:text-gray-400">
                            Asigna un supervisor de la Eda Actual a este colaborador</p>

                        <div class="relative w-full block">
                            <span class="absolute top-[50%] left-2 translate-y-[-50%]">
                                <svg class="w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <input type="text" data-id='{{ $colaborador->id }}'
                                class="w-full block query-colab rounded-full bg-gray-100 border p-2 px-4 pl-10"
                                placeholder="Buscar colaborador por nombres o dni">
                        </div>
                        <ul data-id='{{ $colaborador->id }}' class="flex colabs-q flex-col gap-1 pt-2">
                            <div class="h-[100px] grid place-content-center">
                                <h2 class="text-center text-neutral-500 text-lg">Busca un colaborador y luego asigna
                                    como supervisor
                                </h2>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>


@section('script')
    <script>
        const $busquedaInputs = document.querySelectorAll('.query-colab');
        const $ul_results = document.querySelectorAll('.colabs-q');

        const initialHtml = `<div class="h-[100px] grid place-content-center">
                                <h2 class="text-center text-neutral-500 text-lg">Busca un colaborador y luego asigna
                                    como supervisor
                                </h2>
                            </div>`

        $busquedaInputs.forEach((input) => {
            input.addEventListener('input', function() {
                const q = this.value;
                const id_colab = this.getAttribute('data-id');
                if (q === '') {
                    $ul_results.forEach((ul) => {
                        ul.innerHTML = initialHtml;
                    });
                    return;
                }
                axios.get(`/search-colaboradores?q=${q}`)
                    .then(function(response) {
                        const colaboradores = response.data;
                        $ul_results.forEach((ul) => {
                            ul.innerHTML = '';
                        });
                        colaboradores.forEach(function(colaborador) {
                            const li = document.createElement('li');
                            li.innerHTML =
                                `
                                <li class="flex items-center gap-2">
                                    <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                                    <h4>${colaborador.apellidos},${colaborador.nombres}</h4>
                                    <span class="font-semibold">${colaborador.dni}</span>
                                    <button data-id-colab=${id_colab} data-id-super=${colaborador.id} type="button"
                                        class="text-gray-900 ml-auto bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        Asignar
                                    </button>
                                </li>
                                   `;
                            $ul_results.forEach((ul) => {
                                const data_id = ul.getAttribute('data-id');
                                if (data_id === id_colab) {
                                    ul.appendChild(li);
                                }
                            });
                        });
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
