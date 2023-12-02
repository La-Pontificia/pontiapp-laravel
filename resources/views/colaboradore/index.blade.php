@extends('layouts.sidebar')

@section('content-sidebar')
    <div class="p-3">
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
                        class="text-white w-[200px] my-4 h-10 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-base px-5 text-center"
                        type="button">
                        Agregar
                    </button>
                @endif

            </header>
            @if ($a_colaborador->leer)
                <div class="relative min-h-[calc(100vh-300px)] shadow-md overflow-x-auto sm:rounded-lg">
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
                        @include('colaboradore.form')
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        const selectPuesto = document.getElementById('selectPuesto');
        const formColaborador = document.getElementById("formColaborador")


        // STORE 
        formColaborador.addEventListener('submit', async function(event) {
            event.preventDefault();
            try {
                const formData = new FormData(this);
                const response = await axios.post(this.action, formData);
                Swal.fire({
                    icon: 'success',
                    title: 'Colaborador creado correctamente!',
                }).then(() => {
                    window.location.href = window.location.href;
                });
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al crear el colaborador',
                    text: error.message,
                });
            }

        });



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
    </script>
@endsection
