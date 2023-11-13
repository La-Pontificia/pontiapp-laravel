<header class="p-2 sticky flex items-center gap-3 top-16 z-10 bg-gray-50">
    <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}"
        class="flex items-center gap-2 hover:bg-neutral-200 text-neutral-500 max-w-max px-3 rounded-xl">
        <svg width="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_iconCarrier">
                <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </g>
        </svg>
        <h2 class="text-xl p-2 font-semibold">{{ $n_eva == 1 ? '1ra Evaluación' : '2da Evaluación' }}</h2>
    </a>
    @if ($calificacionterminada && $suSupervisor)
        <button type="button" data-modal-target="feedback-modal" data-modal-toggle="feedback-modal"
            class="text-white ml-auto gap-3 bg-[#050708] hover:bg-[#050708]/80 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
            <span>{{ $feedback ? 'Feedback enviado' : 'Enviar feedback' }}</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.5 6.5h.01m4.49 0h.01m4.49 0h.01M18 1H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
        </button>
        @if (!$eva_cerrada)
            <button id="btn-cerrar-eva" data-eda="{{ $id_eda }}" data-neva="{{ $n_eva }}"
                data-id="{{ $id_evaluacion }}" class="bg-red-500 p-2 px-3 font-medium rounded-xl text-white">
                Cerrar evaluación
            </button>
        @endif
    @endif
    @if ($feedback && $miPerfil)
        @php
            $calificacion = $feedback->calificacion;
        @endphp
        <div class="flex items-center px-3 bg-neutral-200 rounded-xl ml-auto">
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
    @if ($eva_cerrada)
        <div class="text-center text-red-600">
            <h1 class="font-medium">
                Evaluacion cerrada
            </h1>
            <div class="text-sm opacity-70">
                {{ \Carbon\Carbon::parse($evaluacion->fecha_cerrado)->format('d \d\e F \d\e\l Y') }}
            </div>
        </div>
    @endif
</header>
