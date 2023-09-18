@extends('layouts.objetivo')
@section('content-objetivo')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex gap-3 items-center p-4 bg-white dark:bg-gray-800">
            <select id="countries"
                class="bg-gray-50 w-[200px] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Año de actividad</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
            <select id="countries"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[200px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Evaluación</option>
                <option value="eva_01">Evaluacion 01</option>
                <option value="eva_02">Evaluacion 02</option>
            </select>

            <div class="relative ml-auto">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block p-2 pl-10 text-base text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Buscar objetivo">
            </div>
            <div class="flex dark:bg-gray-900">
                <!-- Modal toggle -->
                <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                    class="text-white ml-auto bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Agregar
                </button>
                <!-- Main modal -->
                <div id="create-colab-modal" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative max-w-4xl w-full max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="create-colab-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            @includeif('partials.errors')
                            <div class="px-4 py-4">
                                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Agregar nuevo
                                    objetivo</h3>

                                <form method="POST" action="{{ route('objetivos.store') }}" role="form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @include('objetivo.form', ['objetivo' => $objetivoNewForm])
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
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 max-w-[250px]">
                        Colaborador y objetivo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripcion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Indicadores
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Notas
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        %
                    </th>
                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($objetivos as $objetivo)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                            <div class="pl-3">
                                <div class="text-base  font-semibold">
                                    {{ $objetivo->colaborador->nombres }}
                                    {{ $objetivo->colaborador->apellidos }}
                                </div>
                                <div class="font-normal max-w-[200px] truncate text-gray-500">
                                    {{ $objetivo->objetivo }}
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-4 ">
                            <div class="line-clamp-3 overflow-ellipsis overflow-hidden">
                                {{ $objetivo->descripcion }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="line-clamp-3 overflow-ellipsis overflow-hidden">
                                {{ $objetivo->indicadores }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div
                                class="line-clamp-2 flex gap-1 min-w-max items-center font-semibold overflow-ellipsis overflow-hidden">
                                <span
                                    class="bg-orange-500 rounded-lg flex text-white p-1 px-3">{{ $objetivo->nota_colab }}</span>
                                /
                                <span
                                    class="bg-green-500 rounded-lg flex text-white p-1 px-3">{{ $objetivo->nota_super }}</span>

                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">



                                @if ($objetivo->estado === 0)
                                    <span
                                        class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Desaprobado</span>
                                @elseif ($objetivo->estado === 1)
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                @else
                                    <span
                                        class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Aprobado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                {{ $objetivo->porcentaje }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if ($objetivo->estado !== 2)
                                <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                    data-modal-show="editObjModal{{ $objetivo->id }}" type="button"
                                    class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Editar</button>

                                <!-- Main modal -->
                                <div id="editObjModal{{ $objetivo->id }}" tabindex="-1" aria-hidden="true"
                                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative max-w-4xl w-full max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="editObjModal{{ $objetivo->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            @includeif('partials.errors')
                                            <div class="px-4 py-4">
                                                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                    Editar objetivo</h3>
                                                @includeif('partials.errors')
                                                <form method="POST"
                                                    action="{{ route('objetivos.update', $objetivo->id) }}"
                                                    role="form" enctype="multipart/form-data">
                                                    {{ method_field('PATCH') }}
                                                    @csrf
                                                    @include('objetivo.form', [
                                                        'objetivo' => $objetivo,
                                                    ])
                                                    <footer class="flex mt-4">

                                                        <a href="#"
                                                            class="text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                                            onclick="event.preventDefault(); confirm('¿Estás seguro de que deseas eliminar este registro?') && document.getElementById('delete-form-{{ $objetivo->id }}').submit();">
                                                            Eliminar
                                                        </a>
                                                        <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                                            type="button" type="button"
                                                            data-modal-toggle="editObjModal{{ $objetivo->id }}"
                                                            class="text-white ml-auto bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Cerrar</button>
                                                        <button
                                                            class="text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                            type="submit">
                                                            Actualizar objetivo
                                                        </button>
                                                    </footer>
                                                </form>
                                                <form id="delete-form-{{ $objetivo->id }}" class="hidden"
                                                    action="{{ route('objetivos.destroy', $objetivo->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <button type="button"
                                    class="text-gray-900 w-[80px] bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                    Ver</button>
                            @endif

                        </td>
                    </tr>
                @endforeach
                <tr>
                    @if (count($objetivos) < 1)
                        <td colspan="10">
                            <div class="h-[200px] grid place-content-center">
                                <span class="font-semibold text-xl">No hay ningun objetivos</span>
                            </div>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="p-2 font-bold text-xl px-4" colspan="3">{{ count($objetivos) }} Objetivos
                        totales</td>
                    <td class="p-2 font-bold text-xl" colspan="2">
                        <div class="p-2 rounded-xl w-[100px] text-center bg-green-500 text-white border">
                            {{ $totalNota }}
                        </div>
                    </td>
                    <td class="p-2 font-bold text-xl">
                        <div class="p-2 rounded-xl w-[100px] text-center bg-white border">
                            {{ $totalPorcentaje }} %
                        </div>
                    </td>
                    <td class="p-2 font-bold text-xl"></td>
                </tr>
            </tbody>
        </table>
    </div>
    {!! $objetivos->links() !!}
    {{-- <div class="fixed z-40 bg-neutral-500/40 inset-0 grid place-content-center">
            <div class="w-[600px] bg-white p-4 rounded-2xl">
                <header class="pb-1">
                    <h1 class="font-bold text-2xl">Detalles del objetivo</h1>
                    <p class="opacity-60">13 abril 2023</p>
                    <span
                        class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Aprobado</span>
                </header>
                <div class="flex pt-2 flex-col gap-2">
                    <div class="p-2 rounded-lg bg-neutral-100">
                        <span class="font-semibold">Objetivo:</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam, iste ducimus. Esse, optio.</p>
                    </div>
                    <div class="p-2 rounded-lg bg-neutral-100">
                        <span class="font-semibold">Descripción:</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam, iste ducimus. Esse, optio.</p>
                    </div>
                    <div class="p-2 rounded-lg bg-neutral-100">
                        <span class="font-semibold">Indicadores:</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam, iste ducimus. Esse, optio. <br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam, iste ducimus. Esse, optio.
                            <br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam, iste ducimus. Esse, optio.
                        </p>
                    </div>
                    <div class="p-2">
                        <span class="font-semibold">Nota:</span>
                        <p class="font-bold text-2xl">12</p>
                    </div>
                </div>
                <footer class="flex justify-end">
                    <button type="button"
                        class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-base px-5 py-2.5 text-center mr-2 mb-2">Aceptar</button>
                </footer>
            </div>
        </div> --}}
@endsection
