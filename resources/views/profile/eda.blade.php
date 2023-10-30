@extends('layouts.eda')

@section('content-eda')
    <section class="p-2 pt-0 px-4">
        {{-- Si tiene un supervisor o es su perfil del colaborador actual --}}
        @if ($youSupervise || $isMyprofile)
            <div
                class="max-w-sm p-6 {{ ((($edaColab->estado == 0 ? 'bg-red-50' : $edaColab->estado == 1) ? 'bg-yellow-50' : $edaColab->estado == 2) ? 'bg-green-50' : $edaColab->estado == 3) ? 'bg-pink-50' : 'bg-black-50' }} border border-gray-200 rounded-lg shadow">
                <div class="flex pb-5 flex-col gap-1">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        @if ($edaColab->estado == 0)
                            <span class="text-red-100 mx-auto bg-red-800 mr-2 px-4 py-1 rounded-full ">
                                No enviado
                            </span>
                        @elseif($edaColab->estado == 1)
                            <span class="text-yellow-100 mx-auto bg-yellow-800 mr-2 px-4 py-1 rounded-full">
                                {{ $youSupervise ? 'Pendiente' : 'EDA Enviado' }}
                            </span>
                        @elseif($edaColab->estado == 2)
                            <span class="text-green-100 bg-green-800 mr-2 px-3 py-1 rounded-full">
                                {{ $youSupervise ? 'Aprobado' : 'Aprobado' }}
                            </span>
                        @elseif($edaColab->estado == 3)
                            <span class="text-pink-100 mx-auto bg-pink-800 mr-2 px-4 py-1 rounded-full">
                                Autocalificado
                            </span>
                        @else
                            Cerrado
                        @endif
                    </h5>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Porcentaje total %</span>
                        <h4 class="font-semibold">: {{ $totalPorcentaje }}%</h2>
                    </div>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Nota</span>
                        <h4 class="font-semibold">: {{ $totalNota }}</h2>
                    </div>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Nota autocalificada</span>
                        <h4 class="font-semibold">: {{ $totalNotalAutoevaluacion }}</h2>
                    </div>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Fecha envio</span>
                        @if ($edaColab->f_envio)
                            <h4 class="font-semibold">: {{ \Carbon\Carbon::parse($edaColab->f_envio)->format('d-m-Y') }}
                            </h4>
                        @else
                            : -
                        @endif
                    </div>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Fecha aprobado</span>
                        @if ($edaColab->f_aprobacion)
                            <h4 class="font-semibold">:
                                {{ \Carbon\Carbon::parse($edaColab->f_aprobacion)->format('d-m-Y') }}
                            </h4>
                        @else
                            : -
                        @endif
                    </div>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Fecha autoevaluacion</span>
                        @if ($edaColab->f_autocalificacion)
                            <h4 class="font-semibold">:
                                {{ \Carbon\Carbon::parse($edaColab->f_autocalificacion)->format('d-m-Y') }}
                            </h4>
                        @else
                            : -
                        @endif
                    </div>
                    <div class="flex text-xl">
                        <span class="w-[200px] block opacity-50">Fecha cerrado</span>
                        @if ($edaColab->f_cerrado)
                            <h4 class="font-semibold">: {{ \Carbon\Carbon::parse($edaColab->f_cerrado)->format('d-m-Y') }}
                            </h4>
                        @else
                            : -
                        @endif
                    </div>
                </div>
                @if ($edaColab->estado == 3 && $youSupervise && !$feedback)
                    <button type="button" data-modal-target="feedback-modal" data-modal-toggle="feedback-modal"
                        class="text-white gap-3 bg-[#050708] hover:bg-[#050708]/80 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#050708]/40 dark:focus:ring-gray-600 mr-2 mb-2">
                        <span>Enviar feedback</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.5 6.5h.01m4.49 0h.01m4.49 0h.01M18 1H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                        </svg>
                    </button>
                @endif
                @if ($edaColab->estado == 3 && $youSupervise && $feedback)
                    <button type="button"
                        class="text-white gap-3 bg-[#050708] hover:bg-[#050708]/80 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#050708]/40 dark:focus:ring-gray-600 mr-2 mb-2">
                        <span>Feedback enviado</span>
                    </button>
                @endif
                @if ($feedback && $isMyprofile)
                    <button type="button" data-modal-target="feedback-modal-info" data-modal-toggle="feedback-modal-info"
                        class="px-5 py-2.5 text-sm relative font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="animate-bounce w-5 text-white mr-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                            <path
                                d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                            <path
                                d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                        </svg>
                        Abrir feedback
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 animate-bounce -right-2 dark:border-gray-900">
                            1</div>
                    </button>
                @endif
            </div>
            <div class="relative mt-4 overflow-x-auto bg-white shadow-xl rounded-2xl border">
                {{-- Si tiene un supervisor --}}
                @if ($hasSupervisor)
                    <header class="p-2 py-2 flex items-center justify-end gap-2">
                        @if ($isMyprofile && $totalPorcentaje < 100)
                            @if ($wearingEda->id == $edaColab->id)
                                <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                                    class="text-white w-[200px] bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="button">
                                    Agregar objetivo
                                </button>
                            @endif
                        @endif
                        @if ($isMyprofile && $wearingEda->id == $edaColab->id)
                            {{-- SI ES MI PERFIL --}}
                            @if ($edaColab->estado == 0 && $totalPorcentaje == 100)
                                <button data-id="{{ $edaColab->id }}" id="enviar-eda-btn" type="button"
                                    class="text-white ml-auto hover:bg-purple-600 bg-purple-500 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-base px-5 py-2.5 text-center">Enviar
                                    EDA</button>
                            @endif
                            @if ($edaColab->estado == 2 && $autocalificado)
                                <button id="autocalificar-eda-btn" data-id="{{ $edaColab->id }}"
                                    {{ $totalPorcentaje != 100 ? 'disabled' : '' }} type="button"
                                    class="text-white ml-auto {{ $totalPorcentaje != 100 ? 'opacity-50 cursor-not-allowed select-none' : '' }} bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 ">Guardar
                                    objetivos autocalificados</button>
                            @endif

                            {{-- SI ERES EL SUPERVISOR --}}
                        @else
                            @if ($edaColab->estado == 1)
                                <button id="aprobar-eda-btn" data-id="{{ $edaColab->id }}"
                                    {{ $totalPorcentaje != 100 ? 'disabled' : '' }} type="button"
                                    class="text-white ml-auto {{ $totalPorcentaje != 100 ? 'opacity-50 cursor-not-allowed select-none' : '' }} bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 ">Aprobar
                                    EDA</button>
                            @endif
                        @endif
                    </header>
                    @if ($currentColabEda->estado === 0 && $youSupervise)
                        <div class="h-[200px] w-full grid place-content-center">
                            <h2 class="text-xl text-neutral-400 pb-2 text-center">El colaborador aun no envió su EDA</h2>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                    <tr class="border-y text-base border-gray-200 dark:border-gray-700">
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
                                        <th scope="col" class="px-6  py-3">
                                            <div class="min-w-max">
                                                NA - NF
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objetivos as $objetivo)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 text-lg font-semibold text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                                <h3>{{ $objetivo->objetivo }}</h3>
                                            </th>
                                            <td class="px-6 py-4">
                                                <div class="line-clamp-3 text-base overflow-ellipsis overflow-hidden">
                                                    {{ $objetivo->descripcion }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                                <div class="line-clamp-3 text-base overflow-ellipsis overflow-hidden">
                                                    {{ $objetivo->indicadores }}
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="justify-center w-full flex">
                                                    <span
                                                        class="bg-purple-100 text-purple-800 p-1 px-3 text-base font-medium mr-2 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $objetivo->porcentaje }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                                <div class="flex items-center">
                                                    @if ($objetivo->editado === 1)
                                                        <span
                                                            class="bg-green-100 text-green-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Editado</span>
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center">
                                                    <div
                                                        class="line-clamp-2 flex text-lg items-center font-semibold gap-1 min-w-max foverflow-ellipsis overflow-hidden">
                                                        <span class="">{{ $objetivo->autoevaluacion }}</span>
                                                        <span class="opacity-40">-</span>
                                                        <span class="">{{ $objetivo->nota }}</span>

                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 bg-gray-50 dark:bg-gray-800">
                                                <div class="flex gap-2">
                                                    @if ($wearingEda->id == $edaColab->id)
                                                        @if ($edaColab->estado == 0)
                                                            <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                                                data-modal-show="editObjModal{{ $objetivo->id }}"
                                                                type="button"
                                                                class="focus:outline-none rounded-full text-black bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 w-[40px] h-[40px] flex items-center justify-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                                <svg class="w-4" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 21 21">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                                                </svg>
                                                            </button>
                                                            <button data-id="{{ $objetivo->id }}"
                                                                class="focus:outline-none delete-objetivo rounded-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 w-[40px] h-[40px] flex items-center justify-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                                <svg class="w-4" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 18 20">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                                                </svg>
                                                            </button>
                                                        @endif

                                                        @if ($youSupervise && $edaColab->estado == 1)
                                                            <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                                                data-modal-show="editObjModal{{ $objetivo->id }}"
                                                                type="button"
                                                                class="focus:outline-none rounded-full text-black bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 w-[40px] h-[40px] flex items-center justify-center  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                                <svg class="w-4" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 21 21">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                                                </svg>
                                                            </button>
                                                        @endif

                                                        @if ($youSupervise && $edaColab->estado == 3)
                                                            <button data-modal-target="modal-nota-{{ $objetivo->id }}"
                                                                data-modal-show="modal-nota-{{ $objetivo->id }}"
                                                                type="button"
                                                                class="focus:outline-none rounded-full text-black bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 px-3 h-[40px] flex items-center gap-2 justify-center">
                                                                @if ($objetivo->nota > 0)
                                                                    <svg class="w-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 18 20">
                                                                        <path
                                                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 18 20">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 5h8m-1-3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1m6 0v3H6V2m6 0h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m0 9.464 2.025 1.965L12 9.571" />
                                                                    </svg>
                                                                @endif
                                                                <span>Calificar</span>
                                                            </button>
                                                        @endif

                                                        {{-- boton de autocalificar --}}
                                                        @if ($edaColab->estado == 2 && $isMyprofile)
                                                            <button
                                                                data-modal-toggle="autocalificar-obj{{ $objetivo->id }}"
                                                                data-modal-target="autocalificar-obj{{ $objetivo->id }}"
                                                                type="button" type="button"
                                                                class="text-white flex items-center gap-2 {{ $objetivo->autoevaluacion > 0 ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300' }} focus:outline-none focus:ring-4 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                                                                @if ($objetivo->autoevaluacion > 0)
                                                                    <span>
                                                                        <svg class="w-4 h-4" aria-hidden="true"
                                                                            fill="none" viewBox="0 0 21 21">
                                                                            <path stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                                                        </svg>
                                                                    </span>
                                                                @endif
                                                                {{ $objetivo->autoevaluacion > 0 ? 'Editar' : 'Autocalifar' }}
                                                            </button>
                                                        @endif

                                                        <!-- Main modal -->
                                                        <div id="autocalificar-obj{{ $objetivo->id }}"
                                                            data-modal-backdrop="static" tabindex="-1"
                                                            aria-hidden="true"
                                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                            <div class="relative w-full max-w-md max-h-full">
                                                                <!-- Modal content -->
                                                                <div
                                                                    class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                    <!-- Modal header -->
                                                                    <div
                                                                        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                                        <h3
                                                                            class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                            Autocalificar Objetivo
                                                                        </h3>
                                                                        <button type="button"
                                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                            data-modal-hide="autocalificar-obj{{ $objetivo->id }}">
                                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 14 14">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                            </svg>
                                                                            <span class="sr-only">Close modal</span>
                                                                        </button>
                                                                    </div>


                                                                    <form class="form-autocalificacion"
                                                                        data-id="{{ $objetivo->id }}">
                                                                        <div class="p-5">
                                                                            <div class="pb-2">
                                                                                <label for="nota"
                                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nota
                                                                                    autocalificada</label>
                                                                                <select name="nota" required
                                                                                    id="nota"
                                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                                    <option selected value="">
                                                                                        Selecciona una
                                                                                        nota
                                                                                    </option>
                                                                                    <option
                                                                                        {{ $objetivo->autoevaluacion == 1 ? 'selected' : '' }}
                                                                                        value="1">1</option>
                                                                                    <option
                                                                                        {{ $objetivo->autoevaluacion == 2 ? 'selected' : '' }}
                                                                                        value="2">2</option>
                                                                                    <option
                                                                                        {{ $objetivo->autoevaluacion == 3 ? 'selected' : '' }}
                                                                                        value="3">3</option>
                                                                                    <option
                                                                                        {{ $objetivo->autoevaluacion == 4 ? 'selected' : '' }}
                                                                                        value="4">4</option>
                                                                                    <option
                                                                                        {{ $objetivo->autoevaluacion == 5 ? 'selected' : '' }}
                                                                                        value="5">5</option>
                                                                                </select>
                                                                            </div>
                                                                            <button
                                                                                class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Guardar</button>
                                                                        </div>
                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="modal-nota-{{ $objetivo->id }}"
                                                            data-modal-backdrop="static" tabindex="-1"
                                                            aria-hidden="true"
                                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                            <div class="relative w-full max-w-md max-h-full">
                                                                <!-- Modal content -->
                                                                <div
                                                                    class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                    <!-- Modal header -->
                                                                    <div
                                                                        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                                        <h3
                                                                            class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                            Calificar objetivo
                                                                        </h3>
                                                                        <button type="button"
                                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                            data-modal-hide="modal-nota-{{ $objetivo->id }}">
                                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 14 14">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                            </svg>
                                                                        </button>
                                                                    </div>


                                                                    <form class="form-calificacion"
                                                                        data-id="{{ $objetivo->id }}">
                                                                        <div class="p-5">
                                                                            <div class="pb-2">
                                                                                <label for="nota"
                                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nota
                                                                                    autocalificada</label>
                                                                                <select name="nota" required
                                                                                    id="nota"
                                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                                    <option selected value="">
                                                                                        Selecciona una
                                                                                        nota
                                                                                    </option>
                                                                                    <option
                                                                                        {{ $objetivo->nota == 1 ? 'selected' : '' }}
                                                                                        value="1">1</option>
                                                                                    <option
                                                                                        {{ $objetivo->nota == 2 ? 'selected' : '' }}
                                                                                        value="2">2</option>
                                                                                    <option
                                                                                        {{ $objetivo->nota == 3 ? 'selected' : '' }}
                                                                                        value="3">3</option>
                                                                                    <option
                                                                                        {{ $objetivo->nota == 4 ? 'selected' : '' }}
                                                                                        value="4">4</option>
                                                                                    <option
                                                                                        {{ $objetivo->nota == 5 ? 'selected' : '' }}
                                                                                        value="5">5</option>
                                                                                </select>
                                                                            </div>
                                                                            <button
                                                                                class="text-white bg-gradient-to-br from-pink-500 to-orange-400 rounded-full hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2">Guardar</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <form id="delete-form-{{ $objetivo->id }}" class="hidden"
                                                            action="{{ route('objetivos.destroy', $objetivo->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <!-- Main modal -->
                                                        <div id="editObjModal{{ $objetivo->id }}" tabindex="-1"
                                                            aria-hidden="true"
                                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                            <div class="relative max-w-xl w-full max-h-full">
                                                                <!-- Modal content -->
                                                                <div
                                                                    class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                                                                    <button type="button"
                                                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        data-modal-hide="editObjModal{{ $objetivo->id }}">
                                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 14 14">
                                                                            <path stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                        </svg>
                                                                    </button>
                                                                    @includeif('partials.errors')
                                                                    <div class="px-4 py-4">
                                                                        <h3
                                                                            class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                                            Editar objetivo</h3>
                                                                        @includeif('partials.errors')
                                                                        <form class="form-update-obj" method="POST"
                                                                            action="{{ route('objetivos.update', $objetivo->id) }}"
                                                                            role="form" enctype="multipart/form-data">
                                                                            {{ method_field('PATCH') }}
                                                                            @csrf
                                                                            @include('objetivo.form', [
                                                                                'objetivo' => $objetivo,
                                                                            ])
                                                                            <footer class="flex mt-4">
                                                                                <button
                                                                                    class="text-white ml-auto bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                                                    type="submit">
                                                                                    Actualizar
                                                                                </button>
                                                                            </footer>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @else
                    <div class="h-[200px] w-full grid place-content-center">
                        <h2 class="text-xl text-neutral-400">No puedes registrar tus objetivos porque aun no tienes un
                            supervisor.</h2>
                        <p class="text-center text-blue-600">Comunicate con un administrador</p>
                    </div>
                @endif
            </div>
        @else
            <div class="h-[200px] w-full grid place-content-center">
                <h2 class="text-xl text-neutral-400">No tienes acceso a la EDA de este usuario</h2>
            </div>
        @endif

        {{-- GLOBALS MODALS --}}
        <!-- CREATE -->
        <div id="create-colab-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative max-w-xl w-full max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
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

                        <form method="POST" id="form-store-obj" action="{{ route('objetivos.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            @include('objetivo.form', [
                                'objetivo' => $objetivoNewForm,
                            ])
                            <footer class="flex justify-end mt-4">
                                <button data-modal-target="create-colab-modal" type="button" type="button"
                                    data-modal-toggle="create-colab-modal"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Cerrar</button>
                                <button
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="submit">
                                    Entregar objetivo
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FEEDBACK -->
        @if ($youSupervise && $edaColab->estado == 3)
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
                    <form data-id="{{ $edaColab->id }}" id="form-feedback" class="p-6">
                        <div id="number"
                            class="flex gap-2 [&>label>div]:border [&>label]:cursor-pointer justify-center">
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
                                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003"
                                        xml:space="preserve" fill="#000000">
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
                                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003"
                                        xml:space="preserve" fill="#000000">
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
                                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003"
                                        xml:space="preserve" fill="#000000">
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
                                    <svg version="1.1" id="Layer_1" viewBox="0 0 512.003 512.003"
                                        xml:space="preserve" fill="#000000">
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
                </div>
            </div>
        @endif

        <!-- FEEDBACK INFO -->
        @if ($isMyprofile && $edaColab->estado == 3 && $feedback)
            <div id="feedback-modal-info" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative max-w-[400px] border rounded-xl shadow-xl bg-white w-full max-h-full">
                    <!-- Modal content -->
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="feedback-modal-info">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <header class="text-center p-6 pb-0">
                        <h1 class="text-base font-semibold">
                            ¿Tu supervisor te envio un feedback?
                        </h1>
                    </header>
                    <div id="number" class="flex gap-2 justify-center">
                        <div class="h-[60px] block hover:scale-125 transition-all w-[60px] p-2 rounded-full">
                            @if ($feedback->calificacion == 1)
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
                            @elseif($feedback->calificacion == 2)
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
                            @elseif($feedback->calificacion == 3)
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
                            @elseif($feedback->calificacion == 4)
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

                    </div>
                    <div id="alert-additional-content-1"
                        class="p-4 m-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                        role="alert">
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <h3 class="text-lg font-medium">Feedback</h3>
                        </div>
                        <div class="mt-2 mb-4 text-base">
                            {{ $feedback->feedback }}
                        </div>
                        <span>
                            {{ $feedback->created_at }}
                        </span>
                    </div>
                    <footer>
                        <button class="w-full h-10 bg-blue-700 rounded-xl text-white font-medium">
                            Aceptar
                        </button>
                    </footer>
                </div>
            </div>
        @endif
    </section>

@endsection
