@extends('cuestionario.layout')

@section('content-cuestionario')
    <header>
        <button data-modal-target="static-modal" data-modal-toggle="static-modal" type="button"
            class="text-white flex items-center gap-2 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 py-2.5 text-center">
            <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
            Crear nueva plantilla
        </button>

        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                    <form id="formcreate" method="post">

                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Crear nueva plantilla de preguntas
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="static-modal">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-3 flex gap-3">
                            <input name="nombre" placeholder="Ingresa el nombre de la plantilla" type="text" required
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                            <select name="para" required
                                class="outline-none border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl">
                                <option selected value="">Cuestionario para</option>
                                <option value="1">
                                    Supervisores
                                </option>
                                <option value="2">
                                    Colaboradores
                                </option>
                            </select>
                        </div>

                        <h1 class="p-4 px-7 pt-0 font-semibold text-lg">Selecciona las preguntas</h1>

                        <ul class="flex max-h-[500px] overflow-y-auto p-5 pt-0 flex-col font-medium gap-3">
                            @forelse ($preguntas as $pregunta)
                                <li class="bg-neutral-100 flex items-center group gap-3 p-4 rounded-2xl border">
                                    <p class="">
                                        {{ $pregunta->pregunta }} ·
                                        <span
                                            class="opacity-50 text-sm min-w-max pl-1">{{ $pregunta->created_at->format('d \d\e F \d\e\l Y') }}</span>
                                    </p>
                                    <button type="button" data-id="{{ $pregunta->id }}"
                                        class="btn-add p-3 ml-auto rounded-full bg-neutral-200"
                                        data-id="{{ $pregunta->id }}">
                                        <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
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

                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
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
    <div class="pt-0">
        <h4 class="p-2 text-xl font-medium">Plantilla de cuestionarios para supervisores</h4>
        <div class="rounded-2xl overflow-hidden border bg-white" data-accordion="collapse">
            @foreach ($supervisores as $index => $supervisor)
                <h2 class="relative flex" id="accordion-collapse-heading-{{ $supervisor->id }}">
                    @if ($supervisor->usando)
                        <div
                            class="absolute p-1 font-medium rounded-full px-3 bg-green-500/20 text-green-600 top-2 right-10">
                            Usando
                        </div>
                    @else
                        <button type="button" data-id="{{ $supervisor->id }}"
                            class="flex absolute btn-usar top-1 right-10 font-medium items-center gap-2 px-4 w-full text-left py-2 hover:bg-gray-200 bg-gray-100 text-neutral-700 rounded-xl max-w-max">
                            <span class="w-4 h-4 block">
                                <svg aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </span>
                            Usar
                        </button>
                    @endif
                    <button type="button"
                        class="flex items-center justify-between w-full p-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                        data-accordion-target="#accordion-collapse-body-{{ $supervisor->id }}" aria-expanded="true"
                        aria-controls="accordion-collapse-body-{{ $supervisor->id }}">
                        <span>{{ $index + 1 }}. {{ $supervisor->nombre }}</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $supervisor->id }}" class="hidden"
                    aria-labelledby="accordion-collapse-heading-{{ $supervisor->id }}">
                    <div class="p-5 border border-gray-200 dark:border-gray-700">
                        <ul class="flex pb-2 flex-col gap-2">
                            @foreach ($supervisor->plantillaPreguntas as $plantillaPregunta)
                                <li class="bg-white flex items-center group gap-3 p-4 rounded-2xl border max-w-max">
                                    <button class="btn-eliminar" data-id="{{ $plantillaPregunta->id }}">
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-neutral-700" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                        </svg>
                                    </button>
                                    <p class="">
                                        {{ $plantillaPregunta->pregunta->pregunta }} ·
                                        <span
                                            class="opacity-50 text-sm min-w-max pl-1">{{ $pregunta->created_at->format('d \d\e F \d\e\l Y') }}</span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>

                        <button data-modal-target="agregar-preguntas-{{ $supervisor->id }}"
                            data-modal-toggle="agregar-preguntas-{{ $supervisor->id }}" type="button"
                            class="flex font-medium items-center gap-2 px-4 w-full text-left py-2 hover:bg-gray-200 bg-gray-100 text-neutral-700 rounded-xl max-w-max">
                            <span class="w-4 h-4 block">
                                <svg aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </span>
                            Agregar
                        </button>

                        <div id="agregar-preguntas-{{ $supervisor->id }}" data-modal-backdrop="static" tabindex="-1"
                            aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            {{ $supervisor->nombre }}
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="agregar-preguntas-{{ $supervisor->id }}">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                        </button>
                                    </div>

                                    <h1 class="p-4 px-7 pt-0 font-semibold text-lg">Agrega una pregunta</h1>
                                    <ul class="flex max-h-[500px] overflow-y-auto p-5 pt-0 flex-col font-medium gap-3">
                                        @foreach ($preguntasNoAsociadas[$supervisor->id] as $pregunta)
                                            <button data-id="{{ $supervisor->id }}" data-pre="{{ $pregunta->id }}"
                                                class="bg-neutral-100 hover:bg-neutral-200 text-left btn-add-more flex items-center group gap-3 p-4 rounded-2xl border">
                                                <p class="">
                                                    {{ $pregunta->pregunta }}
                                                </p>
                                            </button>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
        const btns = document.querySelectorAll('.btn-add');
        const formcreate = document.getElementById('formcreate')
        const btnEliminar = document.querySelectorAll('.btn-eliminar')
        const btnAdd = document.querySelectorAll('.btn-add-more');
        const btnUsar = document.querySelectorAll('.btn-usar');

        let selectedIds = [];

        function toggleButtonState(btn, id) {
            const svgPath = btn.querySelector('path');
            btn.classList.toggle('bg-neutral-200');
            btn.classList.toggle('text-white');
            const isBlue = btn.classList.toggle('bg-blue-500');

            // Cambia el contenido del botón
            btn.innerHTML = isBlue ?
                `
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                ` :
                `
                <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M9 1v16M1 9h16" />
                </svg>
                `;

            const index = selectedIds.indexOf(id);
            if (index !== -1) {
                selectedIds.splice(index, 1);
            } else {
                selectedIds.push(id);
            }
        }

        function handleButtonClick(event) {
            const id = event.currentTarget.dataset.id;
            toggleButtonState(event.currentTarget, id);
        }

        btns.forEach(btn => {
            btn.addEventListener('click', handleButtonClick);
        });

        // create
        formcreate.addEventListener('submit', function(event) {
            event.preventDefault();
            const nombreInput = document.querySelector('input[name="nombre"]');
            const paraSelect = document.querySelector('select[name="para"]');

            const nombreValue = nombreInput.value;
            const paraValue = paraSelect.value;

            axios.post('/plantilla', {
                nombre: nombreValue,
                ids: selectedIds,
                para: paraValue
            }).then(res => {
                console.log(res.data)
            }).catch((err) => {
                console.log(err)
            })
        });

        // eliminar
        btnEliminar.forEach(btn => {
            btn.addEventListener("click", function() {
                let id = btn.getAttribute("data-id")
                Swal.fire({
                    title: '¿Estás seguro de eliminar esta pregunta de esta plantilla?',
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
                        axios.get(`/plantilla/pregunta/${id}`).then(res => {
                            location.reload();
                        }).catch(err => {
                            console.log(err)
                        })
                    }
                });
            })
        })

        // add
        btnAdd.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute("data-id")
                const idPregunta = btn.getAttribute("data-pre")
                axios.post(`/plantilla/pregunta/${id}`, {
                    id_pregunta: idPregunta
                }).then(res => {
                    location.reload();
                }).catch(err => {
                    console.log(err);
                })
            })
        })

        // usar 

        btnUsar.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute("data-id")
                axios.get(`/plantilla/usar/${id}`)
                    .then(res => {
                        location.reload();
                    }).catch(err => {
                        console.log(err);
                    })
            })
        })
    </script>
@endsection
