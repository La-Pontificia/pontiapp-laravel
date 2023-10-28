@extends('layouts.eda')

@section('content-eda')
    <section class="p-2 pt-0 px-4">
        {{-- Si tiene un supervisor o es su perfil del colaborador actual --}}
        @if ($youSupervise || $isMyprofile)
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
                <div class="flex flex-col gap-1">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        @if ($edaColab->estado == 0)
                            <span class="bg-red-100 mx-auto text-red-800 mr-2 px-4 py-1 rounded-full ">
                                No enviado
                            </span>
                        @elseif($edaColab->estado == 1)
                            <span class="bg-yellow-100 mx-auto text-yellow-800 mr-2 px-4 py-1 rounded-full">
                                {{ $youSupervise ? 'Pendiente' : 'EDA Enviado' }}
                            </span>
                        @elseif($edaColab->estado == 2)
                            <span class="bg-green-100 text-green-800 mr-2 px-3 py-1 rounded-full">
                                {{ $youSupervise ? 'Aprobado' : 'Aprobado' }}
                            </span>
                        @elseif($edaColab->estado == 3)
                            <span class="bg-pink-100 mx-auto text-pink-800 mr-2 px-4 py-1 rounded-full">
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
    </section>

@endsection
