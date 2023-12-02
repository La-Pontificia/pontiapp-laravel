@php
    $ocultarCuestionario = ($miPerfil && $cuestionarioColab) || ($suSupervisor && $cuestionarioSuper);
    $mostrarPreview = ($miPerfil && $cuestionarioColab) || ($suSupervisor && $cuestionarioSuper);

@endphp
@if ($cerrado)
    @if (!$ocultarCuestionario)
        @include('meta.cuestionario.modal')
        <button data-modal-target="cuestionario-modal" data-modal-toggle="cuestionario-modal"
            class="p-3 border rounded-xl flex gap-2 hover:bg-neutral-100">
            <div class="flex gap-3 items-center w-full">
                <div class="bg-violet-500 p-4 text-white rounded-xl">
                    <svg class="w-[24px]" class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 16 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 1v4a1 1 0 0 1-1 1H1m4 10v-2m3 2v-6m3 6v-4m4-10v16a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-neutral-800 text-lg font-medium">Cuestionario anual</h1>
                </div>
            </div>
        </button>
    @endif
    @if ($mostrarPreview)
        <button data-modal-target="cuestionario-modal-preview-{{ $miPerfil ? 'at' : 'me' }}"
            data-modal-toggle="cuestionario-modal-preview-{{ $miPerfil ? 'at' : 'me' }}"
            class="p-3 border rounded-xl flex gap-2 hover:bg-neutral-100">
            <div class="flex gap-3 items-center w-full">
                <div class="bg-violet-500 p-4 text-white rounded-xl">
                    <svg class="w-[24px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 14">
                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z" />
                        </g>
                    </svg>
                </div>
                <div>
                    <h1 class="text-neutral-800 text-lg font-medium">Mi cuestionario
                </div>
            </div>
        </button>
        <button data-modal-target="cuestionario-modal-preview-{{ $miPerfil ? 'me' : 'at' }}"
            data-modal-toggle="cuestionario-modal-preview-{{ $miPerfil ? 'me' : 'at' }}"
            class="p-3 border rounded-xl flex gap-2 hover:bg-neutral-100">
            <div class="flex gap-3 items-center w-full">
                <div class="bg-violet-500 p-4 text-white rounded-xl">
                    <svg class="w-[24px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 14">
                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z" />
                        </g>
                    </svg>
                </div>
                <div>
                    <h1 class="text-neutral-800 text-lg font-medium">Cuestionario del
                        {{ $miPerfil ? 'supervisor' : 'colaborador' }}</h1>
                </div>
            </div>
        </button>
    @endif
@endif

@if ($cuestionarioSuper)
    @include('meta.cuestionario.modalpreview', [
        'cuestionario' => $cuestionarioSuper,
        'id' => '-me',
        'titulo' => 'Cuestionario del supervisor',
    ])
@endif

@if ($cuestionarioColab)
    @include('meta.cuestionario.modalpreview', [
        'cuestionario' => $cuestionarioColab,
        'id' => '-at',
        'titulo' => 'Cuestionario del colaborador',
    ])
@endif
