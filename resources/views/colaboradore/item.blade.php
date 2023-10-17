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
    <td class=" capitalize text-gray-600 font-medium">
        <span>
            {{ strtolower($colaborador->cargo->nombre_cargo) }}
        </span>
        <span class="block font-normal line-clamp-1">
            Puesto: {{ strtolower($colaborador->puesto->nombre_puesto) }}
        </span>
    </td>
    <td class=" capitalize text-gray-600 font-medium">
        {{ strtolower($colaborador->puesto->departamento->area->nombre_area) }}
        <span class="block text-neutral-500 text-sm font-normal">
            <div class="line-clamp-1">
                Dep: {{ strtolower($colaborador->puesto->departamento->nombre_departamento) }}
            </div>
        </span>
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
    <td>
        <div class="flex gap-1">
            <button type="button" data-modal-target="modal-add-supervisor-{{ $colaborador->id }}"
                data-modal-toggle="modal-add-supervisor-{{ $colaborador->id }}"
                class="{{ $colaborador->id_supervisor ? 'text-green-500 bg-green-500/10' : 'text-gray-900 bg-white hover:bg-gray-100' }} border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">

                @if ($colaborador->id_supervisor)
                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                @else
                    <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                @endif
                Supervisor
            </button>












            <button data-id='{{ $colaborador->id }}' data-modal-target="modal-accesos"
                data-modal-toggle="modal-accesos"
                class="text-black btn-accesos flex items-center gap-2 bg-white-700 border hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                type="button">
                <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 19">
                    <path
                        d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" />
                </svg>
                Accesos
            </button>

















            <a href="/profile/{{ $colaborador->id }}/eda" title="Objetivos"
                class="text-gray-900 gap-2 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 18 20">
                    <path
                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                </svg>
                Perfil
            </a>
            <button type="button" title="Editar"
                class="text-white gap-2 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z" />
                </svg>
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
                        @if ($colaborador->id_supervisor)
                            <div class='flex items-center gap-2 p-2 bg-neutral-100 rounded-xl'>
                                <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                                <div>
                                    <h4>{{ $colaborador->supervisor->nombres }}
                                        {{ $colaborador->supervisor->apellidos }}
                                    </h4>
                                    <span class="font-semibold">{{ $colaborador->supervisor->dni }}</span>
                                </div>
                                <div class="ml-auto">
                                    <span
                                        class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Supervisor
                                        actual</span>
                                </div>
                            </div>
                        @endif
                        <p class="text-sm mb-4 font-normal text-gray-500 dark:text-gray-400">
                            Asigna o actualiza el supervisor de este colaborador
                        </p>

                        <div class="relative w-full block">
                            <span class="absolute top-[50%] left-2 translate-y-[-50%]">
                                <svg class="w-6 h-6 text-gray-500" aria-hidden="true" fill="none"
                                    viewBox="0 0 20 20">
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
        // variables
        const $busquedaInputs = document.querySelectorAll('.query-colab');
        const $ul_results = document.querySelectorAll('.colabs-q');
        const btnSupers = document.querySelectorAll('.btn-super-colab');
        const initialHtml = `<div class="h-[100px] grid place-content-center">
                                <h2 class="text-center text-neutral-500 text-lg">Busca un colaborador y luego asigna
                                    como supervisor
                                </h2>
                            </div>`


        // modal search
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
                                    <div class='flex item-center gap-2'>
                                        <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                                    <h4>${colaborador.apellidos},${colaborador.nombres}</h4>
                                    <span class="font-semibold">${colaborador.dni}</span>
                                    <button id_colab='${id_colab}' id_super='${colaborador.id}' type="button"
                                        class="btn-super-colab text-gray-900 ml-auto bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        Asignar
                                    </button>
                                        </div>
                                   `;
                            $ul_results.forEach((ul) => {
                                const data_id = ul.getAttribute('data-id');
                                if (data_id === id_colab) {
                                    ul.appendChild(li);
                                }
                            });

                            // btns add super
                            const btnSupers = li.querySelector('.btn-super-colab');
                            btnSupers.addEventListener('click', function() {
                                const idColab = this.getAttribute("id_colab");
                                const idSuper = this.getAttribute("id_super");

                                axios.post('/colaboradores/update-supervisor', {
                                        id_colab: idColab,
                                        id_super: idSuper
                                    })
                                    .then(function(response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.data.success,
                                        }).then(() => {
                                            window.location.href = window
                                                .location.href;
                                        });
                                    })
                                    .catch(function(error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error al crear el objetivo',
                                            text: error.response.data,
                                        });
                                    });

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
