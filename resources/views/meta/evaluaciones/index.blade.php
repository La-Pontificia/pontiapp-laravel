@extends('layouts.meta')

@section('content-meta')
    @include('meta.listaEdas', ['eda' => $edaSeleccionado, 'id_colab' => $id_colab, 'id_eda' => $id_eda])
    @include('meta.objetivos.header', ['enviado' => $edaSeleccionado->enviado == true])

    @php
        $edicion = $edaSeleccionado->enviado == true && $edaSeleccionado->aprobado == false && $edaSeleccionado->cerrado == false;
        $aprobado = $edaSeleccionado->aprobado;
    @endphp

    <header class="pb-4 text-center">
        @if ($edicion)
            @if ($miPerfil)
                @if ($objetivos->sum('porcentaje') == 100)
                    <h1 class=" text-xl max-w-[35ch] mx-auto font-medium">
                        🎉 Objetivos enviados para su aprobación
                    </h1>
                @else
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
            @else
                @if ($objetivos->sum('porcentaje') == 100)
                    <button id="aprobar-eda-btn" data-id="{{ $id_eda }}" t autocalifype="button"
                        class="text-white ml-auto bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-md text-sm px-5 py-2.5 text-center mr-2 ">Aprobar
                        EDA</button>
                @else
                    <div class="rounded-xl border-yellow-700 w-[500px] mx-auto bg-yellow-200/30">
                        El porcentaje total no llega a 100%
                    </div>
                @endif
            @endif
        @endif
        @if ($aprobado)
            <h1 class="p-5 rounded-xl text-green-600 border-green-500 bg-green-400/20 max-w-max mx-auto font-semibold">
                🎉 Objetivos aprobados
            </h1>
        @endif
    </header>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
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
                        %
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
@endsection


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
                <span class="sr-only">Close modal</span>
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
