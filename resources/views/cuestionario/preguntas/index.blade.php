@extends('cuestionario.layout')

@section('content-cuestionario')
    <header>
        <button data-modal-target="static-modal" data-modal-toggle="static-modal" type="button"
            class="text-white flex items-center gap-2 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 py-2.5 text-center">
            <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
            Agregar nueva pregunta
        </button>

        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Agregar pregunta
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="static-modal">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form action="/preguntas" id="form-pregunta">
                        <div class="p-4 md:p-5 space-y-4">
                            <textarea name="pregunta" rows="7"
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl"
                                placeholder="Ingresa la pregunta"></textarea>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="static-modal" type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Crear
                            </button>
                            <button data-modal-hide="static-modal" type="button"
                                class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </header>
    <div class="pt-3 max-w-3xl">
        <ul class="flex flex-col font-medium gap-3">

            @forelse ($preguntas as $pregunta)
                <li class="bg-white flex items-center group gap-3 p-4 rounded-2xl border max-w-max">
                    <button class="btn-eliminar" data-id="{{ $pregunta->id }}">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-neutral-700" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                        </svg>
                    </button>
                    <p class="">
                        {{ $pregunta->pregunta }} ·
                        <span
                            class="opacity-50 text-sm min-w-max pl-1">{{ $pregunta->created_at->format('d \d\e F \d\e\l Y') }}</span>
                    </p>
                </li>
            @empty
                <tr>
                    <td colspan="10">
                        <div class="p-10 grid place-content-center">
                            No hay colaboradores disponibles
                        </div>
                    </td>
                </tr>
            @endforelse
        </ul>
    </div>
@endsection

@section('script')
    <script>
        const formcrear = document.getElementById('form-pregunta');
        const btnEliminar = document.querySelectorAll('.btn-eliminar');

        // crear pregunta
        formcrear.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            axios.post(this.action, formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pregunta creado correctamente!',
                    }).then(() => {
                        location.reload()
                    });
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al crear la Pregunta',
                        text: error.response.data.error,
                    });
                });
        });

        // eliminar pregunta
        if (btnEliminar) {
            btnEliminar.forEach(btn => {
                btn.addEventListener('click', () => {
                    Swal.fire({
                        title: '¿Estás seguro de eliminar la pregunta?',
                        text: 'No podrás deshacer esta acción.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const id = btn.dataset.id
                            axios.post(`/preguntas/${id}`).then(res => {
                                location.reload();
                            }).catch(err => {
                                console.log(err)
                            })
                        }
                    });
                })
            })
        }
    </script>
@endsection
