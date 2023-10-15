@extends('layouts.profile')

@section('content-profile')
    <section class="p-2 px-4">
        {{-- Si tiene un supervisor o es su perfil del colaborador actual --}}
        @if ($youSupervise || $isMyprofile)
            <ul class="flex items-center gap-1 h-[50px] pb-3">
                @foreach ($edas as $eda)
                    <li class="">
                        <button class="p-2 rounded-full font-semibold px-4 bg-neutral-200 hover:bg-neutral-100">
                            {{ $eda->year }}-{{ $eda->n_evaluacion }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="relative overflow-x-auto bg-white shadow-xl rounded-2xl border">
                {{-- Si tiene un supervisor --}}
                @if ($hasSupervisor)
                    <header class="p-2 py-2 flex items-center gap-2">
                        @if ($isMyprofile)
                            <button {{ $totalPorcentaje != 100 ? 'disabled' : '' }} type="button"
                                class="text-white ml-auto {{ $totalPorcentaje != 100 ? 'opacity-80 cursor-not-allowed select-none' : 'hover:bg-purple-600' }} bg-purple-500 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-base px-5 py-2.5 text-center">Enviar
                                EDA</button>
                        @else
                            <button {{ $totalPorcentaje != 100 ? 'disabled' : '' }} type="button"
                                class="text-white ml-auto {{ $totalPorcentaje != 100 ? 'opacity-50 cursor-not-allowed select-none' : '' }} bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 ">Aprobar
                                EDA</button>
                        @endif
                    </header>
                    @if ($currentColabEda->estado === 0 && $youSupervise)
                        <div class="h-[200px] w-full grid place-content-center">
                            <h2 class="text-xl text-neutral-400 pb-2 text-center">El colaborador aun no envió su EDA</h2>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                    <tr class="border-y border-gray-200 dark:border-gray-700">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                            Objetivo
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Descripción
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                            Indicadores
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Notas
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                        </th>
                                        <th scope="col" class="px-4 text-center py-3">
                                            %
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td class="p-2 font-bold text-xl px-4" colspan="3">{{ count($objetivos) }}
                                            Objetivos
                                            totales</td>
                                        <td class="p-2 font-bold text-xl" colspan="2">
                                            <div
                                                class="p-2 rounded-xl w-[100px] text-center bg-green-500 text-white border">
                                                {{ $totalNota }}
                                            </div>
                                        </td>
                                        <td class="p-2 font-bold text-xl">
                                            <div
                                                class="p-2 rounded-xl bg-purple-100 text-purple-800 w-[80px] text-center border border-purple-800/40">
                                                {{ $totalPorcentaje }} %
                                            </div>
                                        </td>
                                        <td class="p-2 font-bold text-xl">
                                            @if ($isMyprofile && $totalPorcentaje < 100)
                                                <button data-modal-target="create-colab-modal"
                                                    data-modal-toggle="create-colab-modal"
                                                    class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="button">
                                                    Agregar
                                                </button>
                                                <!-- Main modal -->
                                                <div id="create-colab-modal" tabindex="-1" aria-hidden="true"
                                                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative max-w-xl w-full max-h-full">
                                                        <!-- Modal content -->
                                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                            <button type="button"
                                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                data-modal-hide="create-colab-modal">
                                                                <svg class="w-3 h-3" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                            @includeif('partials.errors')
                                                            <div class="px-4 py-4">
                                                                <h3
                                                                    class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                                    Agregar
                                                                    nuevo
                                                                    objetivo</h3>

                                                                <form method="POST" id="form-store-obj"
                                                                    action="{{ route('objetivos.store') }}" role="form"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @include('objetivo.form', [
                                                                        'objetivo' => $objetivoNewForm,
                                                                    ])
                                                                    <footer class="flex justify-end mt-4">
                                                                        <button data-modal-target="create-colab-modal"
                                                                            type="button" type="button"
                                                                            data-modal-toggle="create-colab-modal"
                                                                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Cerrar</button>
                                                                        <button
                                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                                            type="submit">
                                                                            Entregar objetivo
                                                                        </button>
                                                                    </footer>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach ($objetivos as $objetivo)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                                <h3>{{ $objetivo->objetivo }}</h3>
                                            </th>
                                            <td class="px-6 py-4">
                                                <div class="line-clamp-3 overflow-ellipsis overflow-hidden">
                                                    {{ $objetivo->descripcion }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                                <div class="line-clamp-3 overflow-ellipsis overflow-hidden">
                                                    {{ $objetivo->indicadores }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div
                                                    class="line-clamp-2 flex gap-1 min-w-max items-center font-semibold overflow-ellipsis overflow-hidden">
                                                    <span
                                                        class="bg-orange-500 rounded-lg flex text-white p-1 px-3">{{ $objetivo->autoevaluacion }}</span>
                                                    /
                                                    <span
                                                        class="bg-green-500 rounded-lg flex text-white p-1 px-3">{{ $objetivo->nota_super }}</span>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                                <div class="flex items-center">
                                                    @if ($objetivo->editado === 1)
                                                        <span
                                                            class="bg-green-100 text-green-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Editado</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="justify-center w-full flex">
                                                    <span
                                                        class="bg-purple-100 text-purple-800 p-1 px-3 text-base font-medium mr-2 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $objetivo->porcentaje }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 bg-gray-50 dark:bg-gray-800">
                                                <div class="flex gap-2">

                                                    <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                                        data-modal-show="editObjModal{{ $objetivo->id }}" type="button"
                                                        class="focus:outline-none rounded-full text-black bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 w-[40px] h-[40px] flex items-center justify-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                        <svg class="w-4" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 21 21">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                                        </svg>
                                                    </button>

                                                    <a href="#"
                                                        class="focus:outline-none rounded-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 w-[40px] h-[40px] flex items-center justify-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                                        onclick="event.preventDefault(); 
                                                            Swal.fire({
                                                                title: '¿Estás seguro?',
                                                                text: 'No podrás deshacer esta acción.',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#d33',
                                                                cancelButtonColor: '#3085d6',
                                                                confirmButtonText: 'Sí, eliminar',
                                                                cancelButtonText: 'Cancelar'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    document.getElementById('delete-form-{{ $objetivo->id }}').submit();
                                                                }
                                                            });">
                                                        <svg class="w-4" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 18 20">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                                        </svg>
                                                    </a>

                                                    <form id="delete-form-{{ $objetivo->id }}" class="hidden"
                                                        action="{{ route('objetivos.destroy', $objetivo->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <!-- Main modal -->
                                                    <div id="editObjModal{{ $objetivo->id }}" tabindex="-1"
                                                        aria-hidden="true"
                                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                        <div class="relative max-w-xl w-full max-h-full">
                                                            <!-- Modal content -->
                                                            <div
                                                                class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                                                                <button type="button"
                                                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                    data-modal-hide="editObjModal{{ $objetivo->id }}">
                                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 14 14">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                    </svg>
                                                                </button>
                                                                @includeif('partials.errors')
                                                                <div class="px-4 py-4">
                                                                    <h3
                                                                        class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                                        Editar objetivo</h3>
                                                                    @includeif('partials.errors')
                                                                    <form class="form-update-obj" method="POST"
                                                                        action="{{ route('objetivos.update', $objetivo->id) }}"
                                                                        role="form" enctype="multipart/form-data">
                                                                        {{ method_field('PATCH') }}
                                                                        @csrf
                                                                        @include('objetivo.form', [
                                                                            'objetivo' => $objetivo,
                                                                        ])
                                                                        <footer class="flex mt-4">
                                                                            <a href="#"
                                                                                class="focus:outline-none rounded-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 w-[40px] h-[40px] flex items-center justify-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                                                                onclick="">
                                                                                <svg class="w-4" aria-hidden="true"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 18 20">
                                                                                    <path stroke="currentColor"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                                                                </svg>
                                                                            </a>
                                                                            <button
                                                                                class="text-white ml-auto bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                                                type="submit">
                                                                                Actualizar
                                                                            </button>
                                                                        </footer>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @else
                    <div class="h-[200px] w-full grid place-content-center">
                        <h2 class="text-xl text-neutral-400">No puedes registrar tus objetivos porque aun no tienes un
                            supervisor.</h2>
                        <p class="text-center text-blue-600">Comunicate con un administrador</p>
                    </div>
                @endif
            </div>
        @else
            <div class="h-[200px] w-full grid place-content-center">
                <h2 class="text-xl text-neutral-400">No tienes acceso a la EDA de este usuario</h2>
            </div>
        @endif
    </section>



    {{-- 
    <!-- Main modal -->
    <div id="limite-send-eda" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="limite-send-eda">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
                <!-- Modal header -->
                <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                        Actualizar fecha limite de envio
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-6">
                    <p class="text-sm mb-4 font-normal text-gray-500 dark:text-gray-400">
                        Actualizar fecha limite de envio de su EDA a este colaborador
                    </p>
                    <form id="form-limit-eda" method="POST" action="/define-f-limite-envio-eda-colab" role="form"
                        enctype="multipart/form-data">
                        @csrf
                        @include('profile.form-limite-eda')
                        <div class="pt-2 w-full flex">
                            <button type="submit"
                                class="text-white ml-auto bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

@section('script')
    <script>
        //CHANGE DATE LIMIT EDA SEND COLAB
        const $formlimit = document.getElementById("form-limit-eda")
        const $formeobjupdate = document.querySelectorAll(".form-update-obj");

        // Itera sobre cada formulario y agrega el evento a cada uno
        $formeobjupdate.forEach((form) => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                axios.post(this.action, formData)
                    .then(function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Objetivo actualizado correctamente!',
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    })
                    .catch(function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la actualización del objetivo',
                            text: error.response.data.error,
                        });
                    });
            });
        });


        $formlimit.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            axios.post(this.action, formData)
                .then(function(response) {
                    if (response.data.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al definir la fecha de limite',
                            text: response.data.message,
                        });
                    } else if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Fecha definido correctamente!',
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    }
                })
                .catch(function(error) {
                    console.log(error)
                });
        });
    </script>
@endsection
@endsection
