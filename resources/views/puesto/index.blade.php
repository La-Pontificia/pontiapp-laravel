@extends('layouts.sidebar')


@section('content-sidebar')
    <div class="max-w-3xl mx-auto w-full">
        <div class="py-3">
            <h1 class="font-semibold text-3xl">Gestión de puestos</h1>
            <button data-modal-target="crear-modal" data-modal-toggle="crear-modal"
                class="flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                type="button">
                <svg class="w-4" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
                Agregar nuevo puesto
            </button>
        </div>
        <div id="authentication-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    @includeif('partials.errors')
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Registrar Puestos</h3>
                        <form action="" method="POST">
                            @csrf


                            <div>
                                <label for="cargo"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                                <select name="id_cargo" id="cargo"
                                    class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div>
                                <label for="departamento"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                <select name="id_departamento" id="departamento"
                                    class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div>
                                <label for="puesto"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Puesto</label>
                                <input name="nombre_puesto" type="text" id="puesto"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="" required>
                            </div>


                            <footer class="pt-4">
                                <button type="submit"
                                    class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Registrar</button>

                            </footer>


                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table w-full text-gray-600 table-striped table-hover">
                    <thead class="thead text-left">
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Puesto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($puestos as $puesto)
                            <tr
                                class="border-b even:bg-gray-100 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium  whitespace-nowrap dark:text-white">
                                    {{ $puesto->codigo }}</td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                                    {{ $puesto->nombre }}</td>
                                <td class="px6 -py-4">
                                    <button data-modal-target="{{ $puesto->id }}-editar"
                                        data-modal-toggle="{{ $puesto->id }}-editar"
                                        class="flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                        type="button">
                                        <svg class="w-4" aria-hidden="true" fill="none" viewBox="0 0 21 21">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                        </svg>
                                        Editar
                                    </button>
                                    <div id="{{ $puesto->id }}-editar" data-modal-backdrop="static" tabindex="-1"
                                        aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-xl max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900 ">
                                                        Editar puesto
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="{{ $puesto->id }}-editar">
                                                        <svg class="w-3 h-3" aria-hidden="true" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form method="POST" action="{{ route('puestos.update', $puesto->id) }}"
                                                    role="form" class="edit-form" enctype="multipart/form-data">
                                                    <div class="p-4 md:p-5 space-y-4">
                                                        {{ method_field('PATCH') }}
                                                        @csrf
                                                        @include('puesto.form', [
                                                            'enableCode' => true,
                                                        ])
                                                    </div>
                                                    <div
                                                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                        <button data-modal-hide="static-modal" type="submit"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center ">
                                                            Editar
                                                        </button>
                                                        <button data-modal-hide="{{ $puesto->id }}-editar"
                                                            type="button"
                                                            class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $puestos->links() !!}
    </div>

    {{-- modals --}}
    <div id="crear-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Agregar puesto
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="crear-modal">
                        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form class="create-form" method="POST" action="{{ route('puestos.store') }}" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 md:p-5 space-y-4">
                        @include('puesto.form', [
                            'enableCode' => false,
                            'puesto' => $puestoForm,
                        ])
                    </div>

                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                        <button data-modal-hide="static-modal" type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center ">
                            Crear
                        </button>
                        <button data-modal-hide="crear-modal" type="button"
                            class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        const formsEdit = document.querySelectorAll('.edit-form');
        formsEdit.forEach((form) => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                axios.post(this.action, formData)
                    .then(function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro actualizado correctamente!',
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    })
                    .catch(function(error) {
                        console.log(error)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al actualizar el Registro',
                            text: error.response.data.error,
                        });
                    });
            });
        });
    </script>
@endsection
