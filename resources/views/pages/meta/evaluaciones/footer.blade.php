@php
    $hasAuto = in_array('autocalificar', $colaborador_actual->privilegios);
    $hasClose = in_array('cerrar_eva', $colaborador_actual->privilegios);
    $hasOpen = $colaborador_actual->rol == 2 && $evaluacion->cerrado;

@endphp


<div class="flex items-center text-sm gap-2">
    {{-- btn abrir --}}
    @if ($hasOpen)
        <button id="abrir-evaluacion" data-id="{{ $evaluacion->id }}"
            class="flex line-clamp-1 text-sm font-semibold text-white bg-green-500 rounded-lg items-center justify-center gap-2 p-2">
            <svg class="w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M20.5 10.19H17.61C15.24 10.19 13.31 8.26 13.31 5.89V3C13.31 2.45 12.86 2 12.31 2H8.07C4.99 2 2.5 4 2.5 7.57V16.43C2.5 20 4.99 22 8.07 22H15.93C19.01 22 21.5 20 21.5 16.43V11.19C21.5 10.64 21.05 10.19 20.5 10.19ZM11.53 13.53C11.38 13.68 11.19 13.75 11 13.75C10.81 13.75 10.62 13.68 10.47 13.53L9.75 12.81V17C9.75 17.41 9.41 17.75 9 17.75C8.59 17.75 8.25 17.41 8.25 17V12.81L7.53 13.53C7.24 13.82 6.76 13.82 6.47 13.53C6.18 13.24 6.18 12.76 6.47 12.47L8.47 10.47C8.54 10.41 8.61 10.36 8.69 10.32C8.71 10.31 8.74 10.3 8.76 10.29C8.82 10.27 8.88 10.26 8.95 10.25C8.98 10.25 9 10.25 9.03 10.25C9.11 10.25 9.19 10.27 9.27 10.3C9.28 10.3 9.28 10.3 9.29 10.3C9.37 10.33 9.45 10.39 9.51 10.45C9.52 10.46 9.53 10.46 9.53 10.47L11.53 12.47C11.82 12.76 11.82 13.24 11.53 13.53Z"
                    fill="currentColor"></path>
                <path
                    d="M17.4297 8.81048C18.3797 8.82048 19.6997 8.82048 20.8297 8.82048C21.3997 8.82048 21.6997 8.15048 21.2997 7.75048C19.8597 6.30048 17.2797 3.69048 15.7997 2.21048C15.3897 1.80048 14.6797 2.08048 14.6797 2.65048V6.14048C14.6797 7.60048 15.9197 8.81048 17.4297 8.81048Z"
                    fill="currentColor"></path>
            </svg>
            Abrir evaluación
        </button>
    @endif
    {{-- btn feedback --}}
    @if ($eva_cerrada && $suSupervisor)
        <button type="button" data-modal-target="feedback-modal" data-modal-toggle="feedback-modal"
            class="text-white gap-3 bg-[#050708] hover:bg-[#050708]/80 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
            <span>{{ $feedback ? 'Feedback enviado' : 'Enviar feedback' }}</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.5 6.5h.01m4.49 0h.01m4.49 0h.01M18 1H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
        </button>
    @endif
    {{-- btn calificar --}}
    @if (!$evaluacion->cerrado && $suSupervisor)
        <button data-id="{{ $edaSeleccionado->id }}" data-modal-target="calificar-objs"
            data-modal-toggle="calificar-objs" type="button"
            class="text-white flex justify-center gap-2 bg-[#009c46] hover:bg-[#009c46]/90 focus:outline-none font-medium rounded-lg px-5 py-2 text-center items-center">
            <svg class="w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M21 22H3C2.59 22 2.25 21.66 2.25 21.25C2.25 20.84 2.59 20.5 3 20.5H21C21.41 20.5 21.75 20.84 21.75 21.25C21.75 21.66 21.41 22 21 22Z"
                    fill="currentColor"></path>
                <path
                    d="M19.0206 3.48162C17.0806 1.54162 15.1806 1.49162 13.1906 3.48162L11.9806 4.69162C11.8806 4.79162 11.8406 4.95162 11.8806 5.09162C12.6406 7.74162 14.7606 9.86162 17.4106 10.6216C17.4506 10.6316 17.4906 10.6416 17.5306 10.6416C17.6406 10.6416 17.7406 10.6016 17.8206 10.5216L19.0206 9.31162C20.0106 8.33162 20.4906 7.38162 20.4906 6.42162C20.5006 5.43162 20.0206 4.47162 19.0206 3.48162Z"
                    fill="currentColor"></path>
                <path
                    d="M15.6103 11.5308C15.3203 11.3908 15.0403 11.2508 14.7703 11.0908C14.5503 10.9608 14.3403 10.8208 14.1303 10.6708C13.9603 10.5608 13.7603 10.4008 13.5703 10.2408C13.5503 10.2308 13.4803 10.1708 13.4003 10.0908C13.0703 9.81078 12.7003 9.45078 12.3703 9.05078C12.3403 9.03078 12.2903 8.96078 12.2203 8.87078C12.1203 8.75078 11.9503 8.55078 11.8003 8.32078C11.6803 8.17078 11.5403 7.95078 11.4103 7.73078C11.2503 7.46078 11.1103 7.19078 10.9703 6.91078C10.9491 6.86539 10.9286 6.82022 10.9088 6.77532C10.7612 6.442 10.3265 6.34455 10.0688 6.60231L4.34032 12.3308C4.21032 12.4608 4.09032 12.7108 4.06032 12.8808L3.52032 16.7108C3.42032 17.3908 3.61032 18.0308 4.03032 18.4608C4.39032 18.8108 4.89032 19.0008 5.43032 19.0008C5.55032 19.0008 5.67032 18.9908 5.79032 18.9708L9.63032 18.4308C9.81032 18.4008 10.0603 18.2808 10.1803 18.1508L15.9016 12.4295C16.1612 12.1699 16.0633 11.7245 15.7257 11.5804C15.6877 11.5642 15.6492 11.5476 15.6103 11.5308Z"
                    fill="currentColor"></path>
            </svg>
            Calificar objetivos
        </button>
    @endif
    {{-- btn calificar --}}
    @if (!$evaluacion->cerrado && $miPerfil && $hasAuto)
        <button data-id="{{ $edaSeleccionado->id }}" data-modal-target="autocalificar-objs"
            data-modal-toggle="autocalificar-objs" type="button"
            class="text-white bg-[#009c46] hover:bg-[#009c46]/90 focus:outline-none font-medium rounded-lg px-5 py-2 text-center items-center">
            Autocalificar objetivos
        </button>
    @endif
    {{-- btn cerrar --}}
    @if ($calificacionterminada && $suSupervisor && !$eva_cerrada && $hasClose)
        <button id="btn-cerrar-eva" data-eda="{{ $id_eda }}" data-neva="{{ $n_eva }}"
            data-id="{{ $id_evaluacion }}"
            class="gap-2text-center bg-red-700 flex justify-center gap-2 items-center p-2 px-3 font-medium rounded-lg  text-white">
            <svg class="w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM15.36 14.3C15.65 14.59 15.65 15.07 15.36 15.36C15.21 15.51 15.02 15.58 14.83 15.58C14.64 15.58 14.45 15.51 14.3 15.36L12 13.06L9.7 15.36C9.55 15.51 9.36 15.58 9.17 15.58C8.98 15.58 8.79 15.51 8.64 15.36C8.35 15.07 8.35 14.59 8.64 14.3L10.94 12L8.64 9.7C8.35 9.41 8.35 8.93 8.64 8.64C8.93 8.35 9.41 8.35 9.7 8.64L12 10.94L14.3 8.64C14.59 8.35 15.07 8.35 15.36 8.64C15.65 8.93 15.65 9.41 15.36 9.7L13.06 12L15.36 14.3Z"
                    fill="currentColor"></path>
            </svg>
            Cerrar {{ $n_eva == 1 ? '1ra' : '2da' }} evaluación
        </button>
    @endif
</div>

<div class="p-3">
    @if (!$hasAuto)
        No tienes permiso para autocalificar
    @endif

    @if ($autocalificacionterminada && !$eva_cerrada)
        <h1 class="text-base bg-lime-300/20 rounded-xl max-w-[35ch] font-medium p-2">
            🎉 Autocalificado
        </h1>
    @endif
    @if ($eva_cerrada)
        <div class="py-3 px-2 text-red-600">
            <h1 class="font-medium">
                Evaluacion cerrada
            </h1>
            <div class="text-sm opacity-70">
                {{ \Carbon\Carbon::parse($evaluacion->fecha_cerrado)->format('d \d\e F \d\e\l Y') }}
            </div>
        </div>
    @endif
    {{-- FEEDBACK --}}
    @if ($feedback && $miPerfil)
        @php
            $calificacion = $feedback->calificacion;
        @endphp
        <div class="flex items-center px-3 bg-neutral-200 rounded-xl ">
            <p>Feedback</p>
            <div
                class="h-[50px] block hover:scale-125 transition-all w-[50px] mx-auto peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
                @if ($calificacion == 1)
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.003 512.003" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_iconCarrier">
                            <circle style="fill:#FDDF6D;" cx="256.001" cy="256.001" r="256.001">
                            </circle>
                            <path style="fill:#FCC56B;"
                                d="M310.859,474.208c-141.385,0-256-114.615-256-256c0-75.537,32.722-143.422,84.757-190.281 C56.738,70.303,0,156.525,0,256c0,141.385,114.615,256,256,256c65.849,0,125.883-24.87,171.243-65.718 C392.325,464.135,352.77,474.208,310.859,474.208z">
                            </path>
                            <g>
                                <circle style="fill:#7F184C;" cx="211.414" cy="176.754" r="31.243">
                                </circle>
                                <circle style="fill:#7F184C;" cx="387.321" cy="176.754" r="31.243">
                                </circle>
                            </g>
                            <g>
                                <path style="fill:#F9A880;"
                                    d="M145.987,240.152c-19.011,0-34.425,15.412-34.425,34.425h68.848 C180.41,255.564,164.998,240.152,145.987,240.152z">
                                </path>
                                <path style="fill:#F9A880;"
                                    d="M446.251,235.539c-19.011,0-34.425,15.412-34.425,34.425h68.848 C480.676,250.951,465.264,235.539,446.251,235.539z">
                                </path>
                            </g>
                            <path style="fill:#7F184C;"
                                d="M361.714,395.566c-3.656,0-7.203-1.929-9.108-5.349c-9.763-17.527-28.276-28.413-48.315-28.413 c-19.528,0-38.252,10.998-48.865,28.701c-2.959,4.932-9.354,6.535-14.287,3.577c-4.934-2.958-6.535-9.355-3.577-14.287 c14.357-23.945,39.926-38.821,66.73-38.821c27.589,0,53.075,14.986,66.51,39.108c2.799,5.025,0.996,11.367-4.03,14.166 C365.167,395.143,363.427,395.566,361.714,395.566z">
                            </path>
                            <ellipse transform="matrix(0.2723 -0.9622 0.9622 0.2723 129.6514 329.347)"
                                style="fill:#FCEB88;" cx="282.569" cy="78.956" rx="29.854" ry="53.46">
                            </ellipse>
                        </g>
                    </svg>
                @elseif($calificacion == 2)
                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_iconCarrier">
                            <circle style="fill:#FDDF6D;" cx="256.001" cy="256.001" r="256.001">
                            </circle>
                            <path style="fill:#FCC56B;"
                                d="M310.859,474.208c-141.385,0-256-114.615-256-256c0-75.537,32.722-143.422,84.757-190.281 C56.738,70.303,0,156.525,0,256c0,141.385,114.615,256,256,256c65.849,0,125.883-24.87,171.243-65.718 C392.325,464.135,352.77,474.208,310.859,474.208z">
                            </path>
                            <g>
                                <circle style="fill:#7F184C;" cx="211.691" cy="176.754" r="31.243">
                                </circle>
                                <circle style="fill:#7F184C;" cx="387.585" cy="176.754" r="31.243">
                                </circle>
                            </g>
                            <g>
                                <path style="fill:#F9A880;"
                                    d="M145.987,240.152c-19.011,0-34.425,15.412-34.425,34.423h68.848 C180.41,255.564,164.998,240.152,145.987,240.152z">
                                </path>
                                <path style="fill:#F9A880;"
                                    d="M446.251,235.539c-19.011,0-34.425,15.412-34.425,34.423h68.848 C480.676,250.951,465.264,235.539,446.251,235.539z">
                                </path>
                            </g>
                            <path style="fill:#7F184C;"
                                d="M303.907,395.565c-27.587,0-53.073-14.986-66.51-39.108c-2.799-5.025-0.996-11.367,4.03-14.166 c5.023-2.802,11.367-0.996,14.165,4.03c9.763,17.527,28.277,28.415,48.315,28.415c19.528,0,38.252-10.998,48.865-28.702 c2.959-4.932,9.351-6.536,14.287-3.577c4.934,2.958,6.535,9.354,3.577,14.287C356.28,380.69,330.712,395.565,303.907,395.565z">
                            </path>
                            <ellipse transform="matrix(0.2723 -0.9622 0.9622 0.2723 146.9873 336.7422)"
                                style="fill:#FCEB88;" cx="296.126" cy="71.193" rx="29.854" ry="53.46">
                            </ellipse>
                        </g>
                    </svg>
                @elseif($calificacion == 3)
                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_iconCarrier">
                            <circle style="fill:#FDDF6D;" cx="256.001" cy="256.001" r="256.001">
                            </circle>
                            <path style="fill:#FCC56B;"
                                d="M310.859,474.208c-141.385,0-256-114.615-256-256c0-75.537,32.722-143.422,84.757-190.281 C56.738,70.303,0,156.525,0,256c0,141.385,114.615,256,256,256c65.849,0,125.883-24.87,171.243-65.718 C392.325,464.135,352.77,474.208,310.859,474.208z">
                            </path>
                            <g>
                                <path style="fill:#7F184C;"
                                    d="M245.899,187.173c-5.752,0-10.414-4.663-10.414-10.414c0-13.433-10.93-24.362-24.362-24.362 s-24.362,10.93-24.362,24.362c0,5.752-4.663,10.414-10.414,10.414c-5.752,0-10.414-4.663-10.414-10.414 c0-24.918,20.272-45.19,45.19-45.19s45.19,20.272,45.19,45.19C256.314,182.51,251.651,187.173,245.899,187.173z">
                                </path>
                                <path style="fill:#7F184C;"
                                    d="M421.798,187.173c-5.752,0-10.414-4.663-10.414-10.414c0-13.433-10.93-24.362-24.362-24.362 s-24.362,10.93-24.362,24.362c0,5.752-4.663,10.414-10.414,10.414s-10.414-4.663-10.414-10.414c0-24.918,20.272-45.19,45.19-45.19 c24.918,0,45.19,20.272,45.19,45.19C432.213,182.51,427.55,187.173,421.798,187.173z">
                                </path>
                                <path style="fill:#7F184C;"
                                    d="M302.132,403.377c-27.589,0-53.075-14.986-66.511-39.108c-2.799-5.025-0.994-11.368,4.03-14.166 c5.024-2.799,11.367-0.994,14.166,4.03c9.763,17.528,28.276,28.415,48.315,28.415c19.528,0,38.252-10.998,48.865-28.702 c2.958-4.932,9.355-6.535,14.287-3.577c4.934,2.958,6.535,9.354,3.577,14.287C354.506,388.503,328.936,403.377,302.132,403.377z">
                                </path>
                            </g>
                            <ellipse transform="matrix(0.2723 -0.9622 0.9622 0.2723 141.2787 350.4419)"
                                style="fill:#FCEB88;" cx="302.329" cy="81.817" rx="29.854" ry="53.46">
                            </ellipse>
                            <g>
                                <path style="fill:#F9A880;"
                                    d="M145.987,240.152c-19.011,0-34.423,15.412-34.423,34.423h68.848 C180.41,255.564,164.998,240.152,145.987,240.152z">
                                </path>
                                <path style="fill:#F9A880;"
                                    d="M446.251,235.539c-19.011,0-34.425,15.412-34.425,34.423h68.848 C480.676,250.951,465.264,235.539,446.251,235.539z">
                                </path>
                            </g>
                        </g>
                    </svg>
                @elseif($calificacion == 4)
                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_iconCarrier">
                            <circle style="fill:#FDDF6D;" cx="256.001" cy="256.001" r="256.001">
                            </circle>
                            <path style="fill:#FCC56B;"
                                d="M310.859,474.208c-141.385,0-256-114.615-256-256c0-75.537,32.722-143.422,84.757-190.281 C56.738,70.303,0,156.525,0,256c0,141.385,114.615,256,256,256c65.849,0,125.883-24.87,171.243-65.718 C392.325,464.135,352.77,474.208,310.859,474.208z">
                            </path>
                            <g>
                                <path style="fill:#7F184C;"
                                    d="M293.248,427.894L293.248,427.894c-57.23,0-103.624-46.394-103.624-103.624l0,0h207.248l0,0 C396.872,381.5,350.477,427.894,293.248,427.894z">
                                </path>
                                <path style="fill:#7F184C;"
                                    d="M245.899,187.173c-5.752,0-10.414-4.663-10.414-10.414c0-13.433-10.928-24.362-24.362-24.362 c-13.433,0-24.362,10.93-24.362,24.362c0,5.752-4.663,10.414-10.414,10.414c-5.752,0-10.414-4.663-10.414-10.414 c0-24.918,20.273-45.19,45.19-45.19s45.19,20.272,45.19,45.19C256.314,182.51,251.651,187.173,245.899,187.173z">
                                </path>
                                <path style="fill:#7F184C;"
                                    d="M421.798,187.173c-5.752,0-10.414-4.663-10.414-10.414c0-13.433-10.928-24.362-24.362-24.362 s-24.362,10.93-24.362,24.362c0,5.752-4.663,10.414-10.414,10.414s-10.414-4.663-10.414-10.414c0-24.918,20.273-45.19,45.19-45.19 s45.19,20.272,45.19,45.19C432.213,182.51,427.55,187.173,421.798,187.173z">
                                </path>
                            </g>
                            <g>
                                <path style="fill:#F9A880;"
                                    d="M145.987,240.152c-19.011,0-34.423,15.412-34.423,34.423h68.848 C180.41,255.564,164.998,240.152,145.987,240.152z">
                                </path>
                                <path style="fill:#F9A880;"
                                    d="M446.251,235.539c-19.011,0-34.423,15.412-34.423,34.423h68.848 C480.676,250.951,465.264,235.539,446.251,235.539z">
                                </path>
                            </g>
                            <path style="fill:#F2F2F2;"
                                d="M214.907,324.27v16.176c0,6.821,5.529,12.349,12.349,12.349h131.982 c6.821,0,12.349-5.529,12.349-12.349V324.27H214.907z">
                            </path>
                            <path style="fill:#FC4C59;"
                                d="M295.422,384.903c-28.011-13.014-59.094-11.123-84.3,2.374c18.94,24.686,48.726,40.616,82.245,40.616 l0,0c14.772,0,28.809-3.112,41.526-8.682C325.564,404.777,312.187,392.692,295.422,384.903z">
                            </path>
                            <ellipse transform="matrix(0.2723 -0.9622 0.9622 0.2723 151.7762 343.0422)"
                                style="fill:#FCEB88;" cx="302.685" cy="71.177" rx="29.854" ry="53.46">
                            </ellipse>
                        </g>
                    </svg>
                @else
                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_iconCarrier">
                            <circle style="fill:#FDDF6D;" cx="256.001" cy="256.001" r="256.001">
                            </circle>
                            <path style="fill:#FCC56B;"
                                d="M310.859,474.208c-141.385,0-256-114.615-256-256c0-75.537,32.722-143.422,84.757-190.281 C56.738,70.303,0,156.525,0,256c0,141.385,114.615,256,256,256c65.849,0,125.883-24.87,171.243-65.718 C392.325,464.135,352.77,474.208,310.859,474.208z">
                            </path>
                            <g>
                                <path style="fill:#7F184C;"
                                    d="M245.899,187.172c-5.752,0-10.414-4.663-10.414-10.414c0-13.433-10.928-24.362-24.362-24.362 c-13.433,0-24.362,10.93-24.362,24.362c0,5.752-4.663,10.414-10.414,10.414c-5.752,0-10.414-4.663-10.414-10.414 c0-24.918,20.273-45.19,45.19-45.19s45.19,20.272,45.19,45.19C256.314,182.509,251.651,187.172,245.899,187.172z">
                                </path>
                                <path style="fill:#7F184C;"
                                    d="M421.798,187.172c-5.752,0-10.414-4.663-10.414-10.414c0-13.433-10.928-24.362-24.362-24.362 s-24.362,10.93-24.362,24.362c0,5.752-4.663,10.414-10.414,10.414s-10.414-4.663-10.414-10.414c0-24.918,20.273-45.19,45.19-45.19 s45.19,20.272,45.19,45.19C432.213,182.509,427.55,187.172,421.798,187.172z">
                                </path>
                            </g>
                            <path style="fill:#FFFFFF;"
                                d="M293.248,443.08L293.248,443.08c-74.004,0-133.995-59.991-133.995-133.995l0,0h267.991l0,0 C427.243,383.088,367.251,443.08,293.248,443.08z">
                            </path>
                            <path style="fill:#E6E6E6;"
                                d="M172.426,367.092c3.531,7.341,7.718,14.305,12.472,20.829h216.699 c4.755-6.524,8.941-13.487,12.472-20.829H172.426z">
                            </path>
                            <g>
                                <path style="fill:#F9A880;"
                                    d="M145.987,240.152c-19.011,0-34.423,15.412-34.423,34.423h68.848 C180.41,255.564,164.998,240.152,145.987,240.152z">
                                </path>
                                <path style="fill:#F9A880;"
                                    d="M446.251,240.152c-19.011,0-34.423,15.412-34.423,34.423h68.848 C480.676,255.564,465.264,240.152,446.251,240.152z">
                                </path>
                            </g>
                            <ellipse transform="matrix(0.2723 -0.9622 0.9622 0.2723 142.573 335.222)"
                                style="fill:#FCEB88;" cx="292.913" cy="73.351" rx="29.854" ry="53.46">
                            </ellipse>
                        </g>
                    </svg>
                @endif
            </div>
            <button id="{{ $feedback->recibido ? '' : 'btn-feedback-preview' }}" data-id="{{ $feedback->id }}"
                data-modal-target="feedback-preview" data-modal-toggle="feedback-preview"
                class="text-neutral-800 {{ $feedback->recibido ? '' : 'animate-bounce' }} px-2 relative">
                @if (!$feedback->recibido)
                    <span class="absolute w-[10px] h-[10px] block bg-red-600 rounded-full"></span>
                @endif
                <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.5 6.5h.01m4.49 0h.01m4.49 0h.01M18 1H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                </svg>
            </button>
        </div>
    @endif
</div>
