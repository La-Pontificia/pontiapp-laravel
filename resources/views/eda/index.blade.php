@extends('layouts.sidebar')

@section('content-sidebar')
    <div class="max-w-4xl mx-auto p-3">
        <header class="pb-3">
            <button type="button" data-modal-target="crypto-modal" data-modal-toggle="crypto-modal"
                class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                Crear EDA
            </button>

            <!-- Main modal -->
            <div id="crypto-modal" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="crypto-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                        <!-- Modal header -->
                        <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                                Crear nueva EDA
                            </h3>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6">
                            <p class="text-sm mb-4 font-normal text-gray-500 dark:text-gray-400">Recuerda que al crer una
                                eda y usarlo, todos los usuarios estaran relacionado a esa EDA.</p>
                            <form id="form-store-eda" method="POST" action="{{ route('edas.store') }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                @include('eda.form')
                                <div class="pt-2 w-full flex">
                                    <button type="submit"
                                        class="text-white ml-auto bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-[50px]">
                            Año
                        </th>
                        <th scope="col" class="px-3 w-[90px] py-3">
                            Evaluación
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fecha registro
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Usar
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($edas as $eda)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $eda->year }}</td>
                            <td class="px-6 py-4">{{ $eda->n_evaluacion }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($eda->created_at)->format('d F Y') }}</td>
                            <td class="px-6 py-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <button data-eda-id="{{ $eda->id }}" name="wearing" type="button"
                                        class="btn-wearing-eda flex gap-2 items-center font-medium {{ $eda->wearing ? 'text-green-500' : 'text-gray-300' }}">
                                        <svg class="w-7" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        {{ $eda->wearing ? 'Usando' : 'usar' }}
                                </label>
                            </td>
                            <td class="px-3">
                                <button data-eda-id="{{ $eda->id }}" type="submit"
                                    class="btn-delete-eda text-red-500"></i>
                                    Eliminar</button>
                                <form id="delete-eda-{{ $eda->id }}" action="{{ route('edas.destroy', $eda->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@section('script')
    <script>
        // STORE
        const $formedaustore = document.getElementById("form-store-eda")
        const deleteButtons = document.querySelectorAll('.btn-delete-eda');
        const changeWearing = document.querySelectorAll('.btn-wearing-eda');

        $formedaustore.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            axios.post(this.action, formData)
                .then(function(response) {
                    if (response.data.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la creación de la EDA',
                            text: response.data.message,
                        });
                    } else if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'EDA creado correctamente!',
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    }
                })
                .catch(function(error) {
                    console.log(error)
                });
        });

        deleteButtons.forEach((button) => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const edaId = this.getAttribute('data-eda-id');
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
                        const form = document.getElementById(`delete-eda-${edaId}`);
                        form.submit();
                    }
                });
            });
        });

        changeWearing.forEach((button) => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const edaId = this.getAttribute('data-eda-id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Usar el EDA seleccionado',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, usar EDA',
                    cancelButtonText: 'Cancelar'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const res = await axios.post(`/change-wearing/${edaId}`)
                            Swal.fire({
                                icon: 'success',
                                title: 'Se cambio correctamente',
                                text: res.data.message,
                            }).then(() => {
                                window.location.href = window.location.href
                            });

                        } catch (error) {
                            console.log(error)
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endsection
