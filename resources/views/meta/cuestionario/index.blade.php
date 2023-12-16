@php
    $ocultarCuestionario = ($miPerfil && $cuestionarioColab) || ($suSupervisor && $cuestionarioSuper);
    $mostrarPreview = ($miPerfil && $cuestionarioColab) || ($suSupervisor && $cuestionarioSuper);

    // $mostrarPreviewColab = $cuestionarioColab
    $mostrarPreviewSuper = ($miPerfil && $cuestionarioColab) || ($suSupervisor && $cuestionarioSuper);

@endphp

@include('meta.cuestionario.modal')
<div class="w-full border-b my-1"></div>
<div class="flex flex-col gap-2 {{ !$cerrado ? 'opacity-50 pointer-events-none select-none' : '' }}">
    <button data-modal-target="cuestionario-modal" data-modal-toggle="cuestionario-modal"
        class="{{ !$cerrado ? 'grayscale' : '' }}">
        <div class="p-3 border rounded-md text-left flex gap-2 group-hover:bg-neutral-100">
            <div class="flex gap-3 items-center w-full">
                <div class="bg-yellow-400 p-4 text-white rounded-xl">
                    <svg class="w-[24px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.4 3h15.2A3.4 3.4 0 0 1 23 6.4v11.2a3.4 3.4 0 0 1-3.4 3.4H4.4A3.4 3.4 0 0 1 1 17.6V6.4A3.4 3.4 0 0 1 4.4 3ZM7 9a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Zm1 2a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Zm-1 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                </div>
                <div>
                    <h1 class="text-neutral-800 text-base font-medium">Cuestionario anual para colaboradores</h1>
                    <span class="text-blue-500">Tarea 04</span>
                </div>
                {{-- @if ($eva_2->cerrado)
                        <h1
                            class="p-1 px-2 min-w-max ml-auto flex items-center gap-2 text-sm rounded-md text-white bg-green-400 font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="-4 0 32 32" version="1.1">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M19.375 5.063l-9.5 13.625-6.563-4.875-3.313 4.594 11.188 8.531 12.813-18.375z">
                                    </path>
                                </g>
                            </svg> Hecho
                        </h1>
                    @endif --}}
            </div>
        </div>
    </button>
    <button data-modal-target="cuestionario-modal-preview-{{ $miPerfil ? 'at' : 'me' }}"
        data-modal-toggle="cuestionario-modal-preview-{{ $miPerfil ? 'at' : 'me' }}"
        class="{{ !$cerrado ? 'grayscale' : '' }}">
        <div class="p-3 border rounded-md text-left flex gap-2 group-hover:bg-neutral-100">
            <div class="flex gap-3 items-center w-full">
                <div class="bg-yellow-400 p-4 text-white rounded-xl">
                    <svg class="w-[24px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.4 3h15.2A3.4 3.4 0 0 1 23 6.4v11.2a3.4 3.4 0 0 1-3.4 3.4H4.4A3.4 3.4 0 0 1 1 17.6V6.4A3.4 3.4 0 0 1 4.4 3ZM7 9a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Zm1 2a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Zm-1 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                </div>
                <div>
                    <h1 class="text-neutral-800 text-base font-medium">Cuestionario anual para supervisores</h1>
                    <span class="text-blue-500">Tarea 04</span>
                </div>
                {{-- @if ($eva_2->cerrado)
                    <h1
                        class="p-1 px-2 min-w-max ml-auto flex items-center gap-2 text-sm rounded-md text-white bg-green-400 font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="-4 0 32 32" version="1.1">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M19.375 5.063l-9.5 13.625-6.563-4.875-3.313 4.594 11.188 8.531 12.813-18.375z">
                                </path>
                            </g>
                        </svg> Hecho
                    </h1>
                @endif --}}
            </div>
        </div>
    </button>
</div>

{{-- @include('meta.cuestionario.modalpreview', [
    'cuestionario' => $cuestionarioSuper,
    'id' => '-me',
    'titulo' => 'Cuestionario del supervisor',
]) --}}

{{-- @include('meta.cuestionario.modalpreview', [
    'cuestionario' => $cuestionarioColab,
    'id' => '-at',
    'titulo' => 'Cuestionario del colaborador',
]) --}}
