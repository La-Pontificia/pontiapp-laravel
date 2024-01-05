@extends('layouts.sidebar')

@section('content-sidebar')
    @php
        $hasAccess = in_array('mantenimiento', $colaborador_actual->privilegios);
    @endphp
    @if (!$hasAccess)
        <script>
            window.location = "/";
        </script>
    @else
        <div class="max-w-3xl mx-auto w-full">
            <div>
                <h1 class="font-semibold text-3xl">Gestión de Areas</h1>
                <button data-modal-target="area-crear-modal" data-modal-toggle="area-crear-modal"
                    class="flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    <svg class="w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                    Agregar nueva area
                </button>
            </div>
            <div id="area-crear-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900 ">
                                Agregar area
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="area-crear-modal">
                                <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                        <!-- Modal body -->


                        <form class="create-form" method="POST" action="{{ route('areas.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="p-4 md:p-5 space-y-4">
                                @include('area.form', ['enableCode' => false])
                            </div>

                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                <button data-modal-hide="static-modal" type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center ">
                                    Crear
                                </button>
                                <button data-modal-hide="static-modal" type="button"
                                    class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-base text-left text-gray-800">
                    <thead class="text-sm  uppercase bg-gray-50 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Codigo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($areas as $area)
                            <tr class="border-b even:bg-gray-100 bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium  whitespace-nowrap">
                                    {{ $area->codigo }}</td>
                                <td class="px-6 py-4 font-semibold">
                                    {{ $area->nombre }}</td>
                                <td class="px-6 py-4">
                                    <button data-modal-target="area-{{ $area->id }}-modal"
                                        data-modal-toggle="area-{{ $area->id }}-modal"
                                        class="flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                        type="button">
                                        <svg class="w-4" aria-hidden="true" fill="none" viewBox="0 0 21 21">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                        </svg>
                                        Editar
                                    </button>
                                    <div id="area-{{ $area->id }}-modal" data-modal-backdrop="static" tabindex="-1"
                                        aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-xl max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900 ">
                                                        Editar Area
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="area-{{ $area->id }}-modal">
                                                        <svg class="w-3 h-3" aria-hidden="true" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form method="POST" action="{{ route('areas.update', $area->id) }}"
                                                    role="form" class="edit-form" enctype="multipart/form-data">
                                                    <div class="p-4 md:p-5 space-y-4">
                                                        {{ method_field('PATCH') }}
                                                        @csrf
                                                        @include('area.form', ['enableCode' => true])
                                                    </div>
                                                    <div
                                                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                        <button data-modal-hide="static-modal" type="submit"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center ">
                                                            Editar
                                                        </button>
                                                        <button data-modal-hide="area-{{ $area->id }}-modal"
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
            {!! $areas->links() !!}
        </div>
    @endif
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
