<button {{ !$cerrado ? 'disabled' : '' }} data-modal-target="cuestionario-modal-super"
    data-modal-toggle="cuestionario-modal-super"
    class="disabled:grayscale p-3 border rounded-2xl text-left flex gap-2 hover:bg-neutral-100">
    <div class="flex gap-3 items-center w-full">
        <div class="bg-yellow-400 p-4 text-white rounded-xl">
            <svg class="w-[24px]" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.4 3h15.2A3.4 3.4 0 0 1 23 6.4v11.2a3.4 3.4 0 0 1-3.4 3.4H4.4A3.4 3.4 0 0 1 1 17.6V6.4A3.4 3.4 0 0 1 4.4 3ZM7 9a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Zm1 2a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Zm-1 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-neutral-800 text-base font-medium">Supervisor</h1>
            <span class="text-blue-500">Tarea 04</span>
        </div>
        @if ($cuestionarioSuper)
            <h1
                class="p-1 px-2 min-w-max ml-auto flex items-center gap-2 text-sm rounded-2xl text-white bg-green-400 font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="-4 0 32 32" version="1.1">
                    <path d="M19.375 5.063l-9.5 13.625-6.563-4.875-3.313 4.594 11.188 8.531 12.813-18.375z">
                    </path>
                </svg> Hecho
            </h1>
        @endif
    </div>
</button>

@if ($suSupervisor || $cuestionarioSuper)
    <!-- CREATE -->
    <div id="cuestionario-modal-super" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative max-w-xl w-full max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow :bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center :hover:bg-gray-600 :hover:text-white"
                    data-modal-hide="cuestionario-modal-super">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
                <header class="py-5 border-b text-center text-lg font-semibold">
                    Cuestionario del Supervisor
                </header>
                <div class="px-4 py-4">
                    @if ($cuestionarioSuper)
                        <div class="flex flex-col divide-y">
                            @foreach ($cuestionarioSuper->cuestionarioPreguntas as $index => $item)
                                <div class="py-3">
                                    <h1 class="font-semibold flex items-center gap-2"><span
                                            class="h-[30px] w-[30px] min-w-[30px] grid place-content-center bg-neutral-300 rounded-full p-1">{{ $index + 1 }}</span>
                                        {{ $item->pregunta->pregunta }}
                                    </h1>
                                    <p class="pl-10">{{ $item->respuesta }}</p>
                                </div>
                            @endforEach
                        </div>
                    @elseif($suSupervisor && !$cuestionarioSuper)
                        <h3 class="mb-4 text-xl font-medium text-gray-900 :text-white">
                            Completa el cuestionario</h3>
                        <div id="list-question-super" class="flex flex-col divide-y ">
                            @foreach ($plantillaSuper->plantillaPreguntas as $item)
                                <label for="{{ $item->pregunta->id }}">
                                    <p class="p-1 font-medium">{{ $item->pregunta->pregunta }}</p>
                                    <textarea data-id="{{ $item->pregunta->id }}" rows="4"
                                        class="outline-none question-input border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl"
                                        placeholder="Ingrese tu respuesta" type="text"></textarea>
                                </label>
                            @endforEach
                        </div>
                        <footer>
                            <button id="submit-btn-super" type="button" data-id="{{ $edaSeleccionado->id }}"
                                class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center gap-2">
                                <svg class="w-6 h-6 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9" />
                                </svg>
                                Enviar cuestionario
                            </button>
                        </footer>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    var respuestas = [];
    document.getElementById('submit-btn-super').addEventListener('click', function() {
        var textareas = document.querySelectorAll('#list-question-super textarea');
        var todasRespuestasLlenas = true;
        const id_eda = this.dataset.id;
        respuestas = [];
        textareas.forEach(function(textarea) {
            if (textarea.value.trim() === '') {
                todasRespuestasLlenas = false;
                return;
            }
            respuestas.push({
                id_pregunta: textarea.dataset.id,
                respuesta: textarea.value.trim()
            });
        });

        if (todasRespuestasLlenas) {
            Swal.fire({
                title: '¿Estas seguro de enviar el cuestionario?',
                text: 'No podras deshacer esta acción',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: `Sí, enviar`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/cuestionario/eda`, {
                        respuestas,
                        id_eda,
                        isColab: false
                    }).then(res => {
                        location.reload()
                    }).catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'OPS, ocurrio algo inesperado',
                        }).then(() => {
                            todasRespuestasLlenas = false
                        })
                    })
                }
            });

        } else {
            Swal.fire({
                icon: 'info',
                title: 'Incompleto',
                text: 'Por favor responde todas las preguntas',
            }).then(() => {
                todasRespuestasLlenas = false
            })
        }
    });
</script>
