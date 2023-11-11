@extends('layouts.meta')

@section('content-meta')
    @include('meta.listaEdas', ['eda' => $edaSeleccionado, 'id_colab' => $id_colab, 'id_eda' => $id_eda])
    @php
        $edicion = $edaSeleccionado->enviado == true && $edaSeleccionado->aprobado == false && $edaSeleccionado->cerrado == false;
        $aprobado = $edaSeleccionado->aprobado;
    @endphp
    <header class="p-2">
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
                    <th scope="col" class="px-4 text-center py-3">
                        Nota Autocalificada
                    </th>
                </tr>
            </thead>
            @include('meta.evaluaciones.tableBody', ['enviado' => $edaSeleccionado->enviado == true])
        </table>
    </div>
@endsection
