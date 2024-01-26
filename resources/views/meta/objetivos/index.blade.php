@extends('layouts.meta')

@section('content-meta')
    @include('meta.header', ['title' => 'Objetivos'])
    @php
        $enviado = $edaSeleccionado->enviado;
        $edicion = !$edaSeleccionado->enviado && !$edaSeleccionado->aprobado && !$edaSeleccionado->cerrado;
        $aprobado = $edaSeleccionado->aprobado;
        $btneditar = (!$edaSeleccionado->enviado && $miPerfil) || ($edaSeleccionado->enviado && $suSupervisor && !$aprobado);
        $btneliminar = !$edaSeleccionado->enviado && $miPerfil;
        $totalporcentaje = $objetivos->sum('porcentaje');
        $enviarobjetivosbtn = $objetivos->sum('porcentaje') == 100 && !$edaSeleccionado->enviado && $miPerfil;
        $aprobarobjetivos = $objetivos->sum('porcentaje') == 100 && $edaSeleccionado->enviado && !$aprobado && $suSupervisor;
        $id_eda = $edaSeleccionado->id;

    @endphp

    @if ($enviado || $miPerfil)
        @if (count($objetivos) > 0)
            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr class="border-y text-sm border-gray-200 :border-gray-700">
                            <th scope="col" class="px-2 py-1 bg-gray-50 :bg-gray-800">
                                Objetivo
                            </th>
                            <th scope="col" class="px-2 min-w-[300px] w-[400px] py-1">
                                Descripción
                            </th>
                            <th scope="col" class="px-2 min-w-[300px] py-1 bg-gray-50 :bg-gray-800">
                                Indicadores
                            </th>
                            <th scope="col" class="px-4 text-center py-1">
                                <div>
                                    <h1>Total</h1>
                                    <span
                                        class="bg-purple-100 text-purple-800 block rounded-full p-1">({{ $totalporcentaje }}%)</span>
                                </div>
                            </th>

                            <th scope="col" class="px-2 py-1 bg-gray-50 :bg-gray-800">
                                Editado
                            </th>
                            <th scope="col" class="px-2 py-1 bg-gray-50 :bg-gray-800">
                            </th>
                        </tr>
                    </thead>
                    @include('meta.objetivos.tableBody', ['enviado' => $edaSeleccionado->enviado == true])
                </table>
            </div>
        @endif
    @endif

    @include('meta.objetivos.footer')
    @include('meta.objetivos.formmultiple')

    <!-- CREATE -->
    <div id="create-colab-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative max-w-3xl w-full max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow :bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center :hover:bg-gray-600 :hover:text-white"
                    data-modal-hide="create-colab-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
                @includeif('partials.errors')
                <div class="px-4 py-4">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 :text-white">
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
