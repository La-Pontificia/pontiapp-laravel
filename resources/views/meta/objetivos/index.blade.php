@extends('layouts.meta')

@section('content-meta')
    @include('meta.listaEdas', ['eda' => $edaSeleccionado, 'id_colab' => $id_colab, 'id_eda' => $id_eda])
    <header class="p-4 bg-neutral-50">
        <div class="border-b mb-2 pb-2">
            <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}"
                class="flex items-center gap-2 hover:bg-neutral-200 text-neutral-500 max-w-max px-3 rounded-xl">
                <svg width="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_iconCarrier">
                        <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
                <h2 class="text-xl p-2 font-semibold">Objetivos</h2>
            </a>
        </div>
        <nav class="pt-2 flex gap-2">
            <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                class="text-white w-[200px] bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2 text-center "
                type="button">
                Agregar objetivo
            </button>
            <div class="bg-neutral-300 font-medium px-4 rounded-xl p-2">
                Total porcentaje {{ $objetivos->sum('porcentaje') }}%
            </div>
        </nav>
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
            @include('meta.objetivos.tableBody')
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
