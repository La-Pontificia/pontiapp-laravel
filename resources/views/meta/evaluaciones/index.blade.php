@extends('layouts.meta')

@section('content-meta')

    @php

        // variables globales
        $edicion = $edaSeleccionado->enviado == true && $edaSeleccionado->aprobado == false && $edaSeleccionado->cerrado == false;
        $aprobado = $edaSeleccionado->aprobado;
        $totalporcentaje = $objetivos->sum('porcentaje');

        // variables de notas
        $totalautocalificacion = $n_eva == 1 ? $objetivos->sum('autocalificacion') : $objetivos->sum('autocalificacion_2');
        $totalpromedio = $n_eva == 1 ? $objetivos->sum('promedio') : $objetivos->sum('promedio_2');
        $autocalificacionterminada = $n_eva == 1 ? !$objetivos->contains('autocalificacion', 0) : !$objetivos->contains('autocalificacion_2', 0);

        $autocalificaciondeshabilitada = $totalpromedio != 0;
        $calificacionterminada = $n_eva == 1 ? !$objetivos->contains('promedio', 0) : !$objetivos->contains('promedio_2', 0);

        // evaluaciones
        $id_evaluacion = $n_eva == 1 ? $edaSeleccionado->id_evaluacion : $edaSeleccionado->id_evaluacion_2;
        $eva_cerrada = $n_eva == 1 ? $edaSeleccionado->evaluacion->cerrado : $edaSeleccionado->evaluacion2->cerrado;
        $evaluacion = $n_eva == 1 ? $edaSeleccionado->evaluacion : $edaSeleccionado->evaluacion2;

        $id_eda = $edaSeleccionado->id;

    @endphp

    @include('meta.evaluaciones.header')


    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr class="border-y text-sm divide-x border-gray-200 dark:border-gray-700">
                    <th scope="col" class="px-6 py-3 min-w-[300px] bg-gray-50 dark:bg-gray-800">
                        Objetivo
                    </th>
                    <th scope="col" class="px-6 min-w-[300px] py-3">
                        Descripción
                    </th>
                    <th scope="col" class="px-6 min-w-[300px] py-3 bg-gray-50 dark:bg-gray-800">
                        Indicadores
                    </th>
                    <th scope="col" class="px-4 text-center py-3">
                        <div>
                            <h1>Total</h1>
                            <span
                                class="bg-purple-100 text-purple-800 block rounded-full p-1">({{ $totalporcentaje }}%)</span>
                        </div>
                    </th>
                    <th scope="col" class="px-4 text-base text-center py-3">
                        <h1 class="min-w-max">NA</h1>
                        <div class="min-w-max font-semibold">
                            {{ $totalautocalificacion }}
                        </div>
                    </th>
                    <th scope="col" class="px-4 text-base text-center py-3">
                        <h1 class="min-w-max">PRO</h1>
                        <div class="min-w-max font-semibold">
                            {{ $totalpromedio }}
                        </div>
                    </th>
                </tr>
            </thead>
            @include('meta.evaluaciones.tableBody', ['enviado' => $edaSeleccionado->enviado == true])
        </table>
    </div>

    <footer class="p-10 grid place-content-center gap-4">
        @include('meta.evaluaciones.footer')
    </footer>
    {{-- modals --}}
    <div id="feedback-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative max-w-[400px] border rounded-xl shadow-xl bg-white w-full max-h-full">
            <!-- Modal content -->
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="feedback-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <header class="text-center p-6 pb-0">
                <h1 class="text-base font-semibold">
                    ¿Cuál es su opinión sobre el EDA del colaborador y su posible repercusión en su
                    rendimiento en la
                    empresa?
                </h1>
            </header>

            @if ($feedback)
                @php
                    $califacion = $feedback->calificacion;
                @endphp
                <div class="p-6">
                    <div
                        class="h-[70px] block hover:scale-125 transition-all w-[70px] mx-auto peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
                        @if ($califacion == 1)
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.003 512.003"
                                xml:space="preserve" fill="#000000">
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
                        @elseif($califacion == 2)
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
                        @elseif($califacion == 3)
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
                                        style="fill:#FCEB88;" cx="302.329" cy="81.817" rx="29.854"
                                        ry="53.46"></ellipse>
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
                        @elseif($califacion == 4)
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
                                        style="fill:#FCEB88;" cx="302.685" cy="71.177" rx="29.854"
                                        ry="53.46"></ellipse>
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
                                        style="fill:#FCEB88;" cx="292.913" cy="73.351" rx="29.854"
                                        ry="53.46"></ellipse>
                                </g>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium">{{ $feedback->feedback }}</p>
                        <span class="text-sm opacity-50">Enviado el
                            {{ $feedback->created_at->format('d \d\e F \d\e\l Y') }}</span>
                        @if ($feedback->recibido && $feedback->fecha_recibido)
                            <div class="text-sm opacity-50">Recibido el
                                {{ \Carbon\Carbon::parse($feedback->fecha_recibido)->format('d \d\e F \d\e\l Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <form data-id="{{ $id_evaluacion }}" id="form-feedback" class="p-6">
                    <div id="number" class="flex gap-2 [&>label>div]:border [&>label]:cursor-pointer justify-center">
                        <label for="calificacion-1">
                            <input type="radio" id="calificacion-1" name="calificacion" value="1"
                                class="hidden peer" required>
                            <div
                                class="h-[45px] block hover:scale-125 transition-all w-[45px] peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.003 512.003"
                                    xml:space="preserve" fill="#000000">
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
                                            style="fill:#FCEB88;" cx="282.569" cy="78.956" rx="29.854"
                                            ry="53.46">
                                        </ellipse>
                                    </g>
                                </svg>
                            </div>
                        </label>
                        <label for="calificacion-2">
                            <input type="radio" id="calificacion-2" name="calificacion" value="2"
                                class="hidden peer" required>
                            <div
                                class="h-[45px] block hover:scale-125 transition-all w-[45px] peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
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
                                            style="fill:#FCEB88;" cx="296.126" cy="71.193" rx="29.854"
                                            ry="53.46"></ellipse>
                                    </g>
                                </svg>
                            </div>
                        </label>
                        <label for="calificacion-3">
                            <input type="radio" checked id="calificacion-3" name="calificacion" value="3"
                                class="hidden peer" required>
                            <div
                                class="h-[45px] block hover:scale-125 transition-all w-[45px] peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
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
                                            style="fill:#FCEB88;" cx="302.329" cy="81.817" rx="29.854"
                                            ry="53.46"></ellipse>
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
                            </div>
                        </label>
                        <label for="calificacion-4">
                            <input type="radio" id="calificacion-4" name="calificacion" value="4"
                                class="hidden peer" required>
                            <div
                                class="h-[45px] block hover:scale-125 transition-all w-[45px] peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
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
                                            style="fill:#FCEB88;" cx="302.685" cy="71.177" rx="29.854"
                                            ry="53.46"></ellipse>
                                    </g>
                                </svg>
                            </div>
                        </label>
                        <label for="calificacion-5">
                            <input type="radio" id="calificacion-5" name="calificacion" value="5"
                                class="hidden peer" required>
                            <div
                                class="h-[45px] block hover:scale-125 transition-all w-[45px] peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
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
                                            style="fill:#FCEB88;" cx="292.913" cy="73.351" rx="29.854"
                                            ry="53.46"></ellipse>
                                    </g>
                                </svg>
                            </div>
                        </label>
                    </div>
                    <div class="mt-5">
                        <label for="feedback">¿Qué característica puede agregar para que mejore?</label>
                        <textarea id="feedback" name="feedback"
                            class="rounded-md resize-none text-base font-medium w-full border-neutral-300" name=""
                            placeholder="Nos encantaría escuchar tus sugerencias." rows="4"></textarea>
                    </div>
                    <footer>
                        <button class="w-full h-10 bg-blue-700 rounded-xl text-white font-medium">
                            Enviar feedback
                        </button>
                    </footer>
                </form>
            @endif

        </div>
    </div>

    <div id="feedback-preview" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative max-w-[400px] border rounded-xl shadow-xl bg-white w-full max-h-full">
            <!-- Modal content -->
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="feedback-preview">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            @if ($feedback)
                @php
                    $calificacion = $feedback->calificacion;
                @endphp
                <div class="p-6">
                    <h1 class="text-xl text-center font-semibold">Recibiste un feedback de tu supervisor</h1>
                    <div
                        class="h-[70px] block hover:scale-125 transition-all w-[70px] mx-auto peer-checked:bg-yellow-100 peer-checked:border-0 p-2 rounded-full">
                        @if ($calificacion == 1)
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.003 512.003"
                                xml:space="preserve" fill="#000000">
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
                                        style="fill:#FCEB88;" cx="282.569" cy="78.956" rx="29.854"
                                        ry="53.46">
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
                                        style="fill:#FCEB88;" cx="296.126" cy="71.193" rx="29.854"
                                        ry="53.46"></ellipse>
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
                                        style="fill:#FCEB88;" cx="302.329" cy="81.817" rx="29.854"
                                        ry="53.46"></ellipse>
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
                                        style="fill:#FCEB88;" cx="302.685" cy="71.177" rx="29.854"
                                        ry="53.46"></ellipse>
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
                                        style="fill:#FCEB88;" cx="292.913" cy="73.351" rx="29.854"
                                        ry="53.46"></ellipse>
                                </g>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium">{{ $feedback->feedback }}</p>
                        <span class="text-sm opacity-50">Enviado el
                            {{ $feedback->created_at->format('d \d\e F \d\e\l Y') }}</span>
                        @if ($feedback->recibido && $feedback->fecha_recibido)
                            <div class="text-sm opacity-50">Recibido el
                                {{ \Carbon\Carbon::parse($feedback->fecha_recibido)->format('d \d\e F \d\e\l Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (!$autocalificacionterminada && $miPerfil)
        @include('meta.evaluaciones.modalAutocalificacion')
    @endif

    @if ($autocalificacionterminada && $suSupervisor)
        @include('meta.evaluaciones.modalCalificacion')
    @endif

@endsection
