@php
    $prior_access = $colaborador_actual->rol == 1 || $colaborador_actual->rol == 2;
    $can_edit = $colaborador_actual->rol == 1 || $colaborador_actual->rol == 2 || $a_colaborador->actualizar;
    $is_dev = $colaborador->rol == 2;
@endphp
<tr
    class="bg-white [&>td]:px-2 [&>td]:py-2 [&>th]:px-2 [&>th]:py-2 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
    <th scope="row" class="flex items-center  text-gray-900 whitespace-nowrap dark:text-white">
        <span class="w-10 h-10 block overflow-hidden rounded-full">
            <img class="w-full h-full object-cover"
                src={{ $colaborador->perfil ? $colaborador->perfil : '/profile-user.png' }} alt="">
        </span>
        <div class="pl-3">
            <a href="/meta/{{ $colaborador->id }}" class="hover:underline">
                <div class="text-base font-semibold">
                    {{ $colaborador->apellidos }}
                    {{ $colaborador->nombres }}
                    @if ($colaborador->rol != 0)
                        <span class="p-2 py-1 rounded-lg font-normal bg-violet-600 text-sm text-white">
                            {{ $colaborador->rol == 1 ? 'Admin' : 'Developer' }}
                        </span>
                    @endif
                </div>
            </a>
            <div class="font-normal text-gray-500">{{ $colaborador->dni }}</div>
        </div>
    </th>
    <td class=" capitalize text-gray-600 font-medium">
        @if (!$is_dev)
            <button type="button" data-modal-target="modal-add-supervisor-{{ $colaborador->id }}"
                data-modal-toggle="modal-add-supervisor-{{ $colaborador->id }}"
                class="flex items-center text-sm gap-2 min-w-max line-clamp-1 px-4 w-full text-left py-2 hover:bg-gray-200 bg-gray-100 rounded-xl max-w-max">
                <span class="w-4 h-4 block">
                    @if ($colaborador->id_supervisor)
                        <svg aria-hidden="true" fill="none" viewBox="0 0 16 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d=" M11 10H1m0 0 3-3m-3 3 3 3m1-9h10m0 0-3 3m3-3-3-3" />
                        </svg>
                    @else
                        <svg aria-hidden="true" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 1v16M1 9h16" />
                        </svg>
                    @endif
                </span>
                @if ($colaborador->id_supervisor)
                    {{ $colaborador->supervisor->nombres }}
                    {{ $colaborador->supervisor->apellidos }}
                @elseif ($prior_access)
                    Asignar
                @endif
            </button>
        @endif
    </td>
    <td class=" capitalize text-gray-600 text-sm font-medium">
        <span>
            {{ mb_strtolower($colaborador->puesto->cargo->nombre_cargo) }}
        </span>
    </td>
    <td class=" capitalize text-gray-600 text-sm font-medium">
        <span class="line-clamp-1 min-w-max">
            {{ mb_strtolower($colaborador->puesto->nombre_puesto) }}
        </span>
    </td>
    <td class=" capitalize  text-gray-600 text-sm font-medium">
        <span class="line-clamp-1 min-w-max">
            {{ mb_strtolower($colaborador->puesto->departamento->area->nombre_area) }}
        </span>
    </td>
    <td class="">
        @if ($colaborador->estado == 0)
            <span
                class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Inactivo</span>
        @else
            <span
                class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Activo</span>
        @endif
    </td>
    <td>

        <button id="dropdownMenuIconButton-{{ $colaborador->id }}"
            data-dropdown-toggle="dropdownDots-{{ $colaborador->id }}"
            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            type="button">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 4 15">
                <path
                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
            </svg>
        </button>

        <!-- Dropdown menu -->
        <div id="dropdownDots-{{ $colaborador->id }}"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
            <ul class="py-2 text-sm font-medium text-gray-700"
                aria-labelledby="dropdownMenuIconButton-{{ $colaborador->id }}">
                @if ($can_edit)
                    <li>
                        <a href="/colaboradores/{{ $colaborador->id }}" class="block px-4 py-2 hover:bg-gray-100">
                            Editar
                        </a>
                    </li>
                @endif
                @if ($prior_access)
                    <li>
                        <button type="button" data-modal-target="contraseña-modal-{{ $colaborador->id }}"
                            data-modal-toggle="contraseña-modal-{{ $colaborador->id }}"
                            class="block px-4 py-2 hover:bg-gray-100">
                            Cambiar la contraseña
                        </button>
                    </li>
                    <li>
                        <a href="/colaboradores/accesos/{{ $colaborador->id }}"
                            class="block px-4 py-2 hover:bg-gray-100">Accesos</a>
                    </li>
                @endif
            </ul>
            @if ($prior_access)
                <button data-id="{{ $colaborador->id }}"
                    class="flex items-center w-full toggle-estado p-3 text-sm font-medium {{ $colaborador->estado ? 'text-red-600' : 'text-green-600' }} border-t border-gray-200 rounded-b-lg bg-gray-50 hover:bg-gray-100 hover:underline">
                    {{ $colaborador->estado ? 'Deshabilitar' : 'Habilitar' }}
                </button>
            @endif
        </div>

        @if ($prior_access)
            <div id="modal-add-supervisor-{{ $colaborador->id }}" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-lg max-h-full">
                    <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="modal-add-supervisor-{{ $colaborador->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                        <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                                Asignar supervisor
                            </h3>
                        </div>
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
                                    class="w-full block query-colab rounded-xl outline-none border-neutral-200 bg-gray-100 border p-2 px-4 pl-10"
                                    placeholder="Buscar colaborador por nombres o DNI">
                            </div>

                            <ul data-id='{{ $colaborador->id }}' class="flex colabs-q flex-col gap-1 pt-2">
                                <div class="h-[100px] grid place-content-center">
                                    <h2 class="text-center text-neutral-500 text-lg">Busca un colaborador y
                                        luego asigna
                                        como supervisor
                                    </h2>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('colaboradore.contraseña', ['colaborador' => $colaborador])
    </td>
</tr>


@section('script')
    <script>
        const btnToggleEstado = document.querySelectorAll('.toggle-estado')
        const changePasswordForm = document.querySelectorAll('.change-password')
        // STORE 

        changePasswordForm.forEach(form => {
            form.addEventListener('submit', async function(event) {
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
            btn.addEventListener('click', async function() {
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
            input.addEventListener('input', async function() {
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

                response.data.forEach(function(colaborador) {
                    const li = document.createElement('li');
                    li.innerHTML =
                        `<div class='flex item-center gap-2'>
                            <span class="w-10 h-10 rounded-full overflow-hidden">
                                <img class="w-full h-full object-cover" src="${colaborador.perfil ?? '/default-user.webp'}" alt="Jese image">
                            </span>
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

                    ul_results.forEach((ul) => {
                        const data_id = ul.getAttribute('data-id');
                        if (data_id === id_colab) {
                            ul.appendChild(li);
                        }
                    });

                    const btnSupers = li.querySelector('.btn-super-colab');
                    btnSupers.addEventListener('click', async function() {
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
    </script>
@endsection
