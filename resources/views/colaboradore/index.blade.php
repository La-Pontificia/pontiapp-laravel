@extends('layouts.sidebar')

@section('template_title')
    Colaboradores
@endsection

@section('content-sidebar')
    <div class="p-3">
        @if ($message = Session::get('success'))
            <div id="alert-1"
                class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium">
                    {{ $message }}
                </div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-1" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
        <div class="relative sm:rounded-lg">
            <header class="pb-2">
                <div class="grid grid-cols-10 items-end gap-3 bg-white p-2 rounded-xl">
                    <span class="col-span-1 hidden">
                        <label for="area">Area</label>
                        <select id="area"
                            class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                            <option selected value="">Todos</option>
                            @foreach ($areas as $area)
                                <option {{ $id_area == $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                                    {{ $area->nombre_area }}
                                </option>
                            @endforeach
                        </select>

                    </span>
                    <span class="col-span-1 hidden">
                        <label for="departamento">Departamento</label>
                        <select id="departamento"
                            class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                            <option selected value="">Todos</option>
                            @foreach ($departamentos as $departamento)
                                <option {{ $id_departamento == $departamento->id ? 'selected' : '' }}
                                    value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}
                                </option>
                            @endforeach
                        </select>
                    </span>
                    <span class="col-span-2">
                        <label for="cargo">Cargo</label>
                        <select id="cargo"
                            class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                            <option selected value="">Todos</option>
                            @foreach ($cargos as $cargo)
                                <option {{ $id_cargo == $cargo->id ? 'selected' : '' }} value="{{ $cargo->id }}">
                                    {{ $cargo->nombre_cargo }}
                                </option>
                            @endforeach
                        </select>
                    </span>
                    <span class="col-span-2">
                        <label for="cargo">Puesto</label>
                        <select id="puesto"
                            class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                            <option selected value="">Todos</option>
                            @foreach ($puestos as $puesto)
                                <option {{ $id_puesto == $puesto->id ? 'selected' : '' }} value="{{ $puesto->id }}">
                                    {{ $puesto->nombre_puesto }}
                                </option>
                            @endforeach
                        </select>
                    </span>
                    <form class="relative p-0 m-0 col-span-6" action="/colaboradores">
                        <input name="search" type="search"
                            class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl"
                            placeholder="Buscar colaborador" value="{{ request('search') }}">
                    </form>
                </div>
                @if ($a_colaborador->crear)
                    <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                        class="text-white my-4 w-full h-10 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Agregar
                    </button>
                @endif

            </header>
            @if ($a_colaborador->leer == 1)
                <div class="relative  shadow-md sm:rounded-lg">
                    <table class="w-full text-base text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-base text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-3 min-w-[300px] w-full">
                                    Colaborador
                                </th>
                                <th scope="col" class="px-2 py-3 min-w-[300px] w-full">
                                    Supervisor
                                </th>
                                <th scope="col" class="px-2 py-3 ">
                                    Cargo
                                </th>
                                <th scope="col" class="px-2 py-3 ">
                                    Puesto
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Area
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Estado
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colaboradores as $colaborador)
                                @include('colaboradore.item', ['colaborador' => $colaborador])
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="p-10 grid place-content-center">
                                            No hay colaboradores disponibles
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <footer class="mt-4">
                    {!! $colaboradores->links() !!}
                </footer>
            @else
                @include('meta.commons.errorPageModular', [
                    'titulo' => '',
                    'descripcion' => 'No tienes acceso a ver las lista de colaboradores',
                ])
            @endif
        </div>

    </div>
    <script>
        function handleSelectChange(selectId, paramName) {
            var selectedValue = document.getElementById(selectId).value;
            var currentURL = window.location.href;
            var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
            if (regex.test(currentURL)) {
                currentURL = currentURL.replace(new RegExp("([?&])" + paramName + "=.*?(&|#|$)"), '$1' + paramName + '=' +
                    selectedValue + '$2');
            } else {
                currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' + selectedValue;
            }
            window.location.href = currentURL;
        }

        document.getElementById('area').addEventListener('change', function() {
            handleSelectChange('area', 'id_area');
        });

        document.getElementById('departamento').addEventListener('change', function() {
            handleSelectChange('departamento', 'id_departamento');
        });

        document.getElementById('cargo').addEventListener('change', function() {
            handleSelectChange('cargo', 'id_cargo');
        });

        document.getElementById('puesto').addEventListener('change', function() {
            handleSelectChange('puesto', 'id_puesto');
        });

        const selectPuesto = document.getElementById('puesto-form');
        /// AJAX CARGO & PUESTO
        document.getElementById('cargo-form').addEventListener('change', function() {
            const id_cargo = this.value;
            loadingActive()
            axios.get(`/get-puestos-by-area/${id_cargo}`)
                .then(function(response) {
                    selectPuesto.innerHTML = '<option value="" selected >Selecciona un cargo</option>';
                    const puestos = response.data;
                    puestos.forEach(function(area) {
                        const option = document.createElement('option');
                        option.value = area.id;
                        option.textContent = area.nombre_puesto;
                        selectPuesto.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error(error);
                }).finally(() => {
                    loadingRemove()
                });
        });














        /// FORMULARIO Y LOADING

        const loading = document.getElementById("loading")



        function loadingActive() {
            loading.classList.add('grid');
            loading.classList.remove('hidden');
        }

        function loadingRemove() {
            loading.classList.add('hidden');
            loading.classList.remove('grid');
        }

        const $formColaborador = document.getElementById("formColaborador")

        // STORE 
        $formColaborador.addEventListener('submit', function(event) {
            event.preventDefault();
            loadingActive();
            const formData = new FormData(this);
            axios.post(this.action, formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Colaborador creado correctamente!',
                    }).then(() => {
                        window.location.href = window.location.href;
                    });
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al crear el colaborador',
                        text: error.response.data.error,
                    });
                    console.log(error)
                }).finally(() => {
                    loadingRemove()
                });
        });










        //////// MODULO COLABORADORES



        const btn_accesos = document.querySelectorAll('.btn-accesos');
        const inputCrearColab = document.getElementById('crear-colab');
        const inputVerColab = document.getElementById('ver-colab');
        const inputElminarColab = document.getElementById('eliminar-colab');
        const inputActualizarColab = document.getElementById('actualizar-colab');

        const updateAccess = (metodo, e) => {
            const id = inputCrearColab.getAttribute('data-id');
            const modulo = 'colaboradores';

            axios.post('/accesos/update', {
                    id_colab: id,
                    modulo,
                    metodo,
                    value: e.target.checked
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        };

        const updateCheckbox = (checkbox, acceso) => {
            if (acceso) {
                checkbox.setAttribute('checked', 'checked');
            } else {
                checkbox.removeAttribute('checked');
            }
        };

        btn_accesos.forEach(btn => {
            btn.addEventListener('click', e => {
                loadingActive();
                const data_id = btn.getAttribute('data-id');
                axios.get(`/accesos/colaborador/${data_id}`)
                    .then(response => {
                        const accesos = response.data.data;
                        const accesoColab = accesos.find(item => item.modulo === 'colaboradores');

                        inputCrearColab.setAttribute('data-id', data_id);
                        inputVerColab.setAttribute('data-id', data_id);
                        inputElminarColab.setAttribute('data-id', data_id);
                        inputActualizarColab.setAttribute('data-id', data_id);

                        updateCheckbox(inputCrearColab, accesoColab.crear);
                        updateCheckbox(inputVerColab, accesoColab.leer);
                        updateCheckbox(inputElminarColab, accesoColab.eliminar);
                        updateCheckbox(inputActualizarColab, accesoColab.actualizar);
                    })
                    .catch(error => {
                        console.error(error);
                    })
                    .finally(() => {
                        loadingRemove();
                    });
            });
        });

        inputCrearColab.addEventListener('change', e => updateAccess('crear', e));
        inputVerColab.addEventListener('change', e => updateAccess('ver', e));
        inputElminarColab.addEventListener('change', e => updateAccess('eliminar', e));
        inputActualizarColab.addEventListener('change', e => updateAccess('editar', e));


        // ACCESO MODAL
    </script>
@endsection



<!-- Modal agregar -->

<div id="create-colab-modal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative max-w-lg w-full max-h-full">
        <div class="relative bg-white rounded-xl shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="create-colab-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
            <div class="px-4 py-4">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Registrar nuevo
                    colaborador</h3>
                <form method="POST" id="formColaborador" class="space-y-6 relative"
                    action="{{ route('colaboradores.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-3 mb-6 md:grid-cols-2">
                        <div>
                            <label>Nombres</label>
                            <input type="text" required name="nombres" placeholder="Ingrese los nombres"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                        </div>
                        <div>
                            <label>Apellidos</label>
                            <input type="text" required name="apellidos" placeholder="Ingrese los apellidos"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                        </div>
                        <div>
                            <label>DNI</label>
                            <input type="text" required name="dni" placeholder="Ingrese el DNI"
                                pattern="[0-9]{8}" title="Ingresa un DNI válido de 8 dígitos"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                        </div>
                        <div class="form-group">
                            <label>Cargo</label>
                            <select name="id_cargo" required id="cargo-form"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                                <option selected value="">Selecciona un cargo</option>
                                @foreach ($cargos as $cargo)
                                    <option {{ $colaboradorForm->id_cargo == $cargo->id ? 'selected' : '' }}
                                        value="{{ $cargo->id }}">
                                        {{ $cargo->nombre_cargo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="id_puesto">Puesto</label>
                            <select required name="id_puesto" id="puesto-form"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                                <option value="" selected>Selecciona un puesto</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="id_sede">Sede</label>
                            <select required name="id_sede"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                                <option selected value="">Selecciona un sede</option>
                                @foreach ($sedes as $sede)
                                    <option {{ $colaboradorForm->id_sede == $sede->id ? 'selected' : '' }}
                                        value="{{ $sede->id }}">
                                        {{ $sede->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="role" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Administrador
                                </span>
                            </label>

                        </div>
                    </div>

                    {{-- ETIQUETA LOADING --}}
                    <div id="loading" class="absolute hidden inset-0  place-content-center bg-white/70">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                        </div>
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
