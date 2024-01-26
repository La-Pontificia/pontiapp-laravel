@extends('layouts.sidebar')

@section('content-sidebar')
    @include('colaboradore.header')
    <div class="relative pt-3 min-h-[calc(100vh-300px)] shadow-md overflow-x-auto sm:rounded-lg">
        <table class="w-full text-base text-left text-gray-500 :text-gray-400">
            <thead class="text-base text-gray-700 bg-gray-50 :bg-gray-700 :text-gray-400">
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

    <div id="crear-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Registrar colaborador
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
                <form id="form" method="POST" action="{{ route('colaboradores.store') }}" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 md:p-5 space-y-4">
                        @include('colaboradore.form', [
                            'colaborador' => $colaboradorForm,
                            'isEdit' => false,
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
    @include('colaboradore.accesos')
@endsection


@section('script')
    <script>
        const form = document.getElementById("form")
        form.addEventListener('submit', async function(event) {
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
                    text: err.response.data.error,
                });
            }

        });
    </script>
@endsection
