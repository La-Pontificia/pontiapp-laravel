@extends('layouts.meta')

@section('content-meta')
    @include('meta.listaEdas', ['eda' => $edaSeleccionado, 'id_colab' => $id_colab, 'id_eda' => $id_eda])
    @include('meta.objetivos.header', ['enviado' => $edaSeleccionado->enviado])

    @php
        $enviado = $edaSeleccionado->enviado;
        $edicion = !$edaSeleccionado->enviado && !$edaSeleccionado->aprobado && !$edaSeleccionado->cerrado;
        $aprobado = $edaSeleccionado->aprobado;

        $btneditar = (!$edaSeleccionado->enviado && $miPerfil) || ($edaSeleccionado->enviado && $suSupervisor && !$aprobado);
        $btneliminar = !$edaSeleccionado->enviado && $miPerfil;

        $totalporcentaje = $objetivos->sum('porcentaje');

        $enviarobjetivosbtn = $objetivos->sum('porcentaje') == 100 && !$edaSeleccionado->enviado && $miPerfil;
        $aprobarobjetivos = $objetivos->sum('porcentaje') == 100 && $edaSeleccionado->enviado && !$aprobado && $suSupervisor;

    @endphp

    @if ($enviado || $miPerfil)
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr class="border-y text-sm border-gray-200 dark:border-gray-700">
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Objetivo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripción
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Indicadores
                        </th>
                        <th scope="col" class="px-4 text-center py-3">
                            <div>
                                <h1>Total</h1>
                                <span
                                    class="bg-purple-100 text-purple-800 block rounded-full p-1">({{ $totalporcentaje }}%)</span>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Editado
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        </th>
                    </tr>
                </thead>
                @include('meta.objetivos.tableBody', ['enviado' => $edaSeleccionado->enviado == true])
            </table>
        </div>
    @endif

    <footer class="pb-4 text-center mt-10">
        @if ($enviado && $miPerfil)
            @if (!$aprobado)
                <h1 class=" text-xl max-w-[35ch] mx-auto font-medium p-5">
                    🎉 Objetivos enviados para su aprobación
                </h1>
            @endif
            @if ($enviado && $totalporcentaje != 100)
                <div id="alert-additional-content-2"
                    class="p-4 mb-4 max-w-max mx-auto text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-200/30"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <h3 class="text-2xl font-medium">Opps</h3>
                    </div>
                    <div class="mt-2 mb-4 text-base max-w-[800px]">
                        <p>Lo sentimos tu supervisor modificó el porcentaje de algunos de tus objetivos. Por favor
                            agrega mas
                            objetivos para llegar a 100% de percentaje de la EDA</p>
                        <b>Porcentaje faltante ({{ 100 - $objetivos->sum('porcentaje') }}%)</b>
                    </div>
                </div>
            @endif
        @endif
        @if ($aprobarobjetivos)
            <button id="aprobar-eda-btn" data-id="{{ $id_eda }}" t autocalifype="button"
                class="text-white ml-auto mt-10 bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-md text-sm px-5 py-2.5 text-center mr-2 ">Aprobar
                EDA</button>
        @endif
        @if ($enviado && $totalporcentaje != 100 && $suSupervisor)
            <div class="rounded-xl border-yellow-700 p-5 mt-5 w-[500px] mx-auto bg-yellow-200/30">
                El porcentaje total aun no llega a 100%
            </div>
        @endif
        @if ($aprobado)
            <h1 class="p-5 rounded-xl text-green-600 border-green-500 bg-green-400/20 max-w-max mx-auto font-semibold">
                🎉 Objetivos aprobados
                <div class="text-sm opacity-70">
                    {{ \Carbon\Carbon::parse($edaSeleccionado->fecha_aprobacion)->format('d \d\e F \d\e\l Y') }}
                </div>
            </h1>
        @endif

        {{-- // MI PERFIL --}}
        <nav class="flex justify-center mt-10 gap-2">
            @if ($enviarobjetivosbtn)
                <button data-id="{{ $id_eda }}" id="enviar-eda-btn"
                    class="text-white w-[200px] flex justify-center gap-2 items-center bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2 text-center "
                    type="button">
                    <svg width="20" viewBox="0 0 24 24" fill="none">
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg>
                    Enviar objetivos
                </button>
            @endif
            @if ($objetivos->sum('porcentaje') != 100 && $miPerfil)
                @if (count($objetivos) > 0)
                    <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                        class="text-white w-[200px] bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-base px-5 py-2 text-center "
                        type="button">
                        Agregar objetivo
                    </button>
                @else
                    <button data-modal-target="form-multiple-objetivos" data-modal-toggle="form-multiple-objetivos"
                        class="text-white w-[200px] bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-base px-5 py-2 text-center "
                        type="button">
                        Agregar objetivo
                    </button>
                @endif
            @endif
        </nav>
    </footer>

    @include('meta.objetivos.formmultiple')


    {{-- GLOBALS MODALS --}}
    <!-- CREATE -->
    <div id="create-colab-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative max-w-3xl w-full max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="create-colab-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
                @includeif('partials.errors')
                <div class="px-4 py-4">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                        Agregar
                        nuevo
                        objetivo</h3>

                    <form method="POST" id="form-store-obj" class=""
                        action="/meta/{{ $id_colab }}/eda/{{ $id_eda }}/objetivos" role="form"
                        style="margin: 0" class="mb-0" enctype="multipart/form-data">
                        @csrf
                        @include('meta.objetivos.form', [
                            'objetivo' => $objetivoNewForm,
                        ])
                        <footer class="flex justify-end gap-2 mt-2 items-center">
                            <input type="number" required name="porcentaje" value="{{ $objetivoNewForm->porcentaje }}"
                                placeholder="Porcentaje %"
                                class="w-[150px] border rounded-xl focus:outline-2 transition-all focus:outline-blue-600">
                            <button data-modal-target="create-colab-modal" type="button" type="button"
                                data-modal-toggle="create-colab-modal"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-sm px-5 py-2.5">Cerrar</button>
                            <button
                                class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-10 py-2.5 text-center"
                                type="submit">
                                Entregar objetivo
                            </button>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
