@extends('layouts.sidebar')

@section('content-sidebar')
    <!-- component -->
    {{-- <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css"> --}}
    <section class="relative block h-[200px]">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="
            background-image: url('https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2710&amp;q=80');
          ">
            <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black/50"></span>
        </div>
    </section>
    <section class="relative ">
        <div class="mx-auto">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white mb-2 shadow-xl shadow-neutral-500/10 rounded-lg ">
                <div class="px-6">
                    <div class="flex flex-wrap justify-center">
                        <div class="w-full -mt-24 lg:w-3/12 px-4 lg:order-2 flex justify-center">
                            <div class="relative">
                                <img alt="..." src="https://cataas.com/cat?type=sq"
                                    class="shadow-xl rounded-full w-52 h-52 align-middle border-none">
                            </div>
                        </div>
                        <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                            <div class="py-6 px-3 mt-32 sm:mt-0">
                                <button type="button"
                                    class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 18 18">
                                        <path
                                            d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="w-full lg:w-4/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 gap-3 lg:pt-4 pt-8">
                                <div class="p-2 text-center">
                                    <span class="text-xl relative font-bold block uppercase tracking-wide text-gray-600">
                                        <svg class="w-8 mx-auto text-neutral-600" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12 1.25C7.71983 1.25 4.25004 4.71979 4.25004 9V9.7041C4.25004 10.401 4.04375 11.0824 3.65717 11.6622L2.50856 13.3851C1.17547 15.3848 2.19318 18.1028 4.51177 18.7351C5.26738 18.9412 6.02937 19.1155 6.79578 19.2581L6.79768 19.2632C7.56667 21.3151 9.62198 22.75 12 22.75C14.378 22.75 16.4333 21.3151 17.2023 19.2632L17.2042 19.2581C17.9706 19.1155 18.7327 18.9412 19.4883 18.7351C21.8069 18.1028 22.8246 15.3848 21.4915 13.3851L20.3429 11.6622C19.9563 11.0824 19.75 10.401 19.75 9.7041V9C19.75 4.71979 16.2802 1.25 12 1.25ZM15.3764 19.537C13.1335 19.805 10.8664 19.8049 8.62349 19.5369C9.33444 20.5585 10.571 21.25 12 21.25C13.4289 21.25 14.6655 20.5585 15.3764 19.537ZM5.75004 9C5.75004 5.54822 8.54826 2.75 12 2.75C15.4518 2.75 18.25 5.54822 18.25 9V9.7041C18.25 10.6972 18.544 11.668 19.0948 12.4943L20.2434 14.2172C21.0086 15.3649 20.4245 16.925 19.0936 17.288C14.4494 18.5546 9.5507 18.5546 4.90644 17.288C3.57561 16.925 2.99147 15.3649 3.75664 14.2172L4.90524 12.4943C5.45609 11.668 5.75004 10.6972 5.75004 9.7041V9Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="w-[10px] h-[10px] rounded-full bg-red-500 absolute top-2 right-2">

                                        </span>
                                    </span>
                                    <span class="text-sm text-gray-400">Feedbacks</span>
                                </div>
                                <div class="p-1 text-center">
                                    <span class="text-3xl font-bold block uppercase tracking-wide text-gray-600">
                                        {{ count($objetivos) }}
                                    </span>
                                    <span class="text-sm text-gray-400">Objetivos</span>
                                </div>
                                <div class="p-1 text-center">
                                    <span class="text-3xl font-bold block tracking-tighter uppercase text-gray-600">
                                        {{ $totalPorcentaje }}%
                                    </span>
                                    <span class="text-sm text-gray-400">Porcentaje</span>
                                </div>
                                <div class="p-1 text-center">
                                    <span class="text-3xl font-bold block tracking-tighter uppercase text-gray-600">
                                        {{ $totalNota }}
                                    </span>
                                    <span class="text-sm text-gray-400">Nota</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-4xl font-bold leading-normal text-gray-700 mb-2">
                            {{ $colaborador->nombres }}
                            {{ $colaborador->apellidos }}
                        </h3>
                        {{-- <div class="text-sm leading-normal mt-0 mb-2 text-gray-400 font-bold uppercase">
                            <i class="fas fa-map-marker-alt mr-2 text-lg text-gray-400"></i>
                            Los Angeles, California
                        </div> --}}
                        <div class="text-gray-600 capitalize mt-2">
                            <i class="fas fa-briefcase mr-2 text-lg text-gray-400"></i>
                            {{ mb_strtolower($colaborador->puesto->nombre_puesto, 'UTF-8') }}
                            -
                            {{ mb_strtolower($colaborador->puesto->departamento->area->nombre_area, 'UTF-8') }}
                        </div>
                        <div class="mb-5 text-gray-600">
                            <i class="fas fa-university mr-2 text-lg text-gray-400"></i>
                            Escuela Superior La pontificia
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2 px-4">
        <div class="relative overflow-x-auto bg-white shadow-xl rounded-2xl border">
            <header class="p-2 py-2 flex items-center gap-2">
                <form>
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative w-[500px] max-w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block w-full p-2 pl-10 text-base font-medium text-gray-900 border border-gray-300 rounded-full bg-gray-200 focus:ring-4 focus:ring-blue-500/40 focus:border-blue-500 "
                            placeholder="Buscar objetivo" required>
                        <button type="submit"
                            class="text-white absolute right-1 top-[3px] bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-4 py-2">Buscar</button>
                    </div>
                </form>
                <select id="countries"
                    class="bg-gray-200 text-base font-medium w-[200px] rounded-full border border-gray-300 text-gray-900 focus:ring-4 focus:ring-blue-500/40 focus:border-blue-500 block p-2 px-3">
                    <option selected>Año</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                </select>
                <div class="ml-auto bg-gray-100 rounded-full p-2 pl-3 flex gap-4 pr-2 items-center">
                    <span class="font-bold tracking-tight">Evaluacion</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div
                            class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">1°</span>
                    </label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div
                            class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">2°</span>
                    </label>
                </div>
                <button {{ $totalPorcentaje != 100 ? 'disabled' : '' }} type="button"
                    class="text-white {{ $totalPorcentaje != 100 ? 'opacity-50 cursor-not-allowed select-none' : '' }} bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 ">Aprobar
                    EDA</button>
            </header>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 max-w-[250px]">
                                Objetivo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descripcion
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Notas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Editado
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
                                    <div class="font-normal max-w-[200px] truncate text-gray-500">
                                        {{ $objetivo->objetivo }}
                                    </div>
                                </th>
                                <td class="px-6 py-4 ">
                                    <div class="line-clamp-3 overflow-ellipsis overflow-hidden">
                                        {{ $objetivo->descripcion }}
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
                                                class="bg-red-100 text-red-800 group block text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                Desaprobado

                                            </span>
                                        @elseif ($objetivo->estado === 1)
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                        @else
                                            <span
                                                class="bg-green-100 text-green-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Aprobado</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <span
                                            class="bg-purple-100 text-purple-800 p-1 px-3 text-base font-medium mr-2 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $objetivo->porcentaje }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button" data-modal-target="editObjModal{{ $objetivo->id }}"
                                        data-modal-show="editObjModal{{ $objetivo->id }}"
                                        class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Calificar</button>
                                    <!-- MODAL CALIFICATE -->
                                    <div id="editObjModal{{ $objetivo->id }}" tabindex="-1" aria-hidden="true"
                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative max-w-lg w-full max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button"
                                                    class="absolute top-3 z-[1] right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="editObjModal{{ $objetivo->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                </button>
                                                @includeif('partials.errors')
                                                <div class="px-4 py-4">
                                                    <header class="border-b">
                                                        <h3
                                                            class="mb-4 text-center text-xl opacity-70 font-medium text-gray-900 dark:text-white">
                                                            Calificar objetivo</h3>
                                                    </header>
                                                    @includeif('partials.errors')
                                                    <form method="POST"
                                                        action="{{ route('objetivos.update', $objetivo->id) }}"
                                                        role="form" enctype="multipart/form-data">
                                                        {{ method_field('PATCH') }}
                                                        @csrf
                                                        @include('objetivo.form-calificar', [
                                                            'objetivo' => $objetivo,
                                                        ])
                                                        <footer class="flex mt-4">
                                                            <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                                                type="button" type="button"
                                                                data-modal-toggle="editObjModal{{ $objetivo->id }}"
                                                                class="text-white mr-auto bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-base px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Cerrar</button>
                                                            @if ($objetivo->estado != 0)
                                                                <button
                                                                    data-modal-target="modal-feddback{{ $objetivo->id }}"
                                                                    data-modal-toggle="modal-feddback{{ $objetivo->id }}"
                                                                    type="button"
                                                                    class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-base px-5 py-2.5 text-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Desaprobar</button>
                                                                <button type="button"
                                                                    class="text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-base px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Aprobar</button>
                                                            @endif
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

                                    <!-- MODAL FEEDBACK -->
                                    @if ($objetivo->estado != 0)
                                        <div id="modal-feddback{{ $objetivo->id }}" tabindex="-1" aria-hidden="true"
                                            class="fixed top-0 left-0 right-0 z-[60] bg-black/50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0  max-h-full">
                                            <div class="relative max-w-lg w-full max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <button type="button"
                                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="modal-feddback{{ $objetivo->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                    @includeif('partials.errors')
                                                    <div class="px-4 py-4">
                                                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                            Feedback</h3>
                                                        <div>
                                                            <form method="POST"
                                                                action="{{ route('objetivo.desaprobar') }}">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $objetivo->id }}">
                                                                <textarea autofocus name="feedback" id="feedback" rows="6"
                                                                    class="block p-2.5 w-full text-base font-medium text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    placeholder="Escribe un poco de tu opinion de este objetivo (Opcional)"></textarea>
                                                                <footer class="pt-4 flex justify-end">
                                                                    <button type="submit"
                                                                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-base px-5 py-2.5 text-center">Desaprobar
                                                                        y enviar feedback</button>
                                                                </footer>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if (count($objetivos) === 0)
                            <tr>
                                <td colspan="10">
                                    <div
                                        class=" h-[200px] w-full grid place-content-center text-lg font-semibold text-gray-600">
                                        No se encontro objetivos de este colaborador
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
