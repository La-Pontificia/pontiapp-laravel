@extends('layouts.objetivo')
@section('content-objetivo')
    <div class="relative shadow-md sm:rounded-lg">
        @includeif('partials.errors')
        <div class="grid grid-cols-5 gap-3 p-4 bg-white">
            <span class="w-full block">
                <label for="area">Area</label>
                <select id="area"
                    class="bg-gray-50 w-full h-12 font-medium border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Todos</option>
                    @foreach ($areas as $area)
                        <option {{ $id_area == $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                            {{ $area->nombre_area }}
                        </option>
                    @endforeach
                </select>

            </span>
            <span>
                <label for="departamento">Departamento</label>
                <select id="departamento"
                    class="bg-gray-50 w-full font-medium border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Todos</option>
                    @foreach ($departamentos as $departamento)
                        <option {{ $id_departamento == $departamento->id ? 'selected' : '' }}
                            value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}
                        </option>
                    @endforeach
                </select>
            </span>
            <span>
                <label for="cargo">Cargo</label>
                <select id="cargo"
                    class="bg-gray-50 w-full font-medium border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Todos</option>
                    @foreach ($cargos as $cargo)
                        <option {{ $id_cargo == $cargo->id ? 'selected' : '' }} value="{{ $cargo->id }}">
                            {{ $cargo->nombre_cargo }}
                        </option>
                    @endforeach
                </select>
            </span>
            <span>
                <label for="cargo">Puesto</label>
                <select id="puesto"
                    class="bg-gray-50 w-full font-medium border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Todos</option>
                    @foreach ($puestos as $puesto)
                        <option {{ $id_puesto == $puesto->id ? 'selected' : '' }} value="{{ $puesto->id }}">
                            {{ $puesto->nombre_puesto }}
                        </option>
                    @endforeach
                </select>
            </span>
            <div class="relative">
                <input type="search"
                    class="block p-2 mt-6 h-12 font-medium w-full text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Buscar colaborador">
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-3 py-3 max-w-[250px]">
                        Colaborador
                    </th>
                    <th class="px-3 py-3">
                        Cargo
                    </th>
                    <th class="px-3 py-3">
                        Puesto
                    </th>
                    <th class="px-3 py-3">
                        Dep. & Area
                    </th>
                    <th class="px-3 py-3">
                        Estado
                    </th>
                    <th class="px-3 py-3">
                        F. Registro
                    </th>
                    <th class="px-3 py-3">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colaboradores_a_supervisar as $item)
                    <tr
                        class="bg-white even:bg-neutral-50 [&>td]:px-2 [&>td]:py-2 [&>th]:px-2 [&>th]:py-2 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center  text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                            <div class="pl-3">
                                <div class="text-lg font-semibold">
                                    {{ $item->colaboradore->nombres }}
                                    {{ $item->colaboradore->nombres }}
                                </div>
                                <div class="font-normal text-gray-500">{{ $item->colaboradore->dni }}</div>
                            </div>
                        </th>
                        <td class=" capitalize text-red-600 font-medium">
                            {{ strtolower($item->colaboradore->cargo->nombre_cargo) }}
                        </td>
                        <td class=" capitalize text-yellow-600 font-medium">
                            {{ strtolower($item->colaboradore->puesto->nombre_puesto) }}
                        </td>
                        <td class=" capitalize text-sky-600 font-medium">
                            {{ strtolower($item->colaboradore->puesto->departamento->area->nombre_area) }}
                            <span class="block text-neutral-500 text-sm font-normal line-clamp-1"><span>Dep.</span>
                                {{ strtolower($item->colaboradore->puesto->departamento->nombre_departamento) }}</span>
                        </td>
                        <td class="">
                            @if ($item->colaboradore->estado == 0)
                                <span
                                    class="bg-red-100 text-red-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Inactivo</span>
                            @else
                                <span
                                    class="bg-green-100 text-green-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Activo</span>
                            @endif
                        </td>
                        <td class="">
                            <div class="line-clamp-2">
                                {{ \Carbon\Carbon::parse($item->colaboradore->created_at)->format('j \d\e F, Y') }}
                            </div>
                        </td>
                        <td>
                            <button type="button"
                                class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center mr-2 mb-2">
                                <svg viewBox="0 0 24 24" fill="none" class="w-[25px]" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.4"
                                            d="M21.6602 10.44L20.6802 14.62C19.8402 18.23 18.1802 19.69 15.0602 19.39C14.5602 19.35 14.0202 19.26 13.4402 19.12L11.7602 18.72C7.59018 17.73 6.30018 15.67 7.28018 11.49L8.26018 7.30001C8.46018 6.45001 8.70018 5.71001 9.00018 5.10001C10.1702 2.68001 12.1602 2.03001 15.5002 2.82001L17.1702 3.21001C21.3602 4.19001 22.6402 6.26001 21.6602 10.44Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M15.0603 19.3901C14.4403 19.8101 13.6603 20.1601 12.7103 20.4701L11.1303 20.9901C7.16034 22.2701 5.07034 21.2001 3.78034 17.2301L2.50034 13.2801C1.22034 9.3101 2.28034 7.2101 6.25034 5.9301L7.83034 5.4101C8.24034 5.2801 8.63034 5.1701 9.00034 5.1001C8.70034 5.7101 8.46034 6.4501 8.26034 7.3001L7.28034 11.4901C6.30034 15.6701 7.59034 17.7301 11.7603 18.7201L13.4403 19.1201C14.0203 19.2601 14.5603 19.3501 15.0603 19.3901Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M17.4894 10.51C17.4294 10.51 17.3694 10.5 17.2994 10.49L12.4494 9.26002C12.0494 9.16002 11.8094 8.75002 11.9094 8.35002C12.0094 7.95002 12.4194 7.71002 12.8194 7.81002L17.6694 9.04002C18.0694 9.14002 18.3094 9.55002 18.2094 9.95002C18.1294 10.28 17.8194 10.51 17.4894 10.51Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M14.5592 13.8899C14.4992 13.8899 14.4392 13.8799 14.3692 13.8699L11.4592 13.1299C11.0592 13.0299 10.8192 12.6199 10.9192 12.2199C11.0192 11.8199 11.4292 11.5799 11.8292 11.6799L14.7392 12.4199C15.1392 12.5199 15.3792 12.9299 15.2792 13.3299C15.1992 13.6699 14.8992 13.8899 14.5592 13.8899Z"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>
                                Evaluar objetivos
                            </button>
                        </td>
                        {{-- <td>
                            <div class="flex gap-1">
                                <button type="button" title="Editar"
                                    class="text-white gap-2 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z" />
                                    </svg>
                                </button>
                                <button type="button" title="Objetivos"
                                    class="text-white gap-2 bg-[#f44268] hover:bg-[#f57893] focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="text-gray-900 gap-2 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50">
                                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                        <path
                                            d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" />
                                    </svg>
                                </button>
                            </div>
                        </td> --}}
                    </tr>
                @endforeach
                {{-- @foreach ($objetivos as $objetivo)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        @if ($idColaborador === null)
                            <th scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                                <div class="pl-3">
                                    <div
                                        class="text-base group relative hover:text-blue-600 hover:underline cursor-pointer font-semibold">
                                        {{ $objetivo->colaborador->nombres }}
                                        {{ $objetivo->colaborador->apellidos }}
                                        <div
                                            class="absolute bg-white z-40 p-2 shadow-xl rounded-xl group-hover:block hidden top-[100%]">
                                            <div class=" flex gap-2 items-center">
                                                <div>
                                                    <img class="w-10 h-10 rounded-full" src="/default-user.webp"
                                                        alt="Jese image">
                                                </div>
                                                <div class="flex flex-col">
                                                    <span>
                                                        {{ $objetivo->colaborador->nombres }}
                                                        {{ $objetivo->colaborador->apellidos }}
                                                    </span>
                                                    <span class="text-xs text-neutral-600 capitalize">
                                                        {{ mb_strtolower($objetivo->colaborador->puesto->nombre_puesto, 'UTF-8') }}
                                                        -
                                                        {{ mb_strtolower($objetivo->colaborador->puesto->departamento->area->nombre_area, 'UTF-8') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="font-normal max-w-[200px] truncate text-gray-500">
                                        {{ $objetivo->objetivo }}
                                    </div>
                                </div>
                            </th>
                        @endif
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
                                    class="bg-purple-100 text-purple-800 p-1 px-3 text-base font-medium mr-2 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $objetivo->porcentaje }}</span>
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
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                            <form method="POST" action="{{ route('objetivos.update', $objetivo->id) }}"
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
                                                        <button data-modal-target="modal-feddback{{ $objetivo->id }}"
                                                            data-modal-toggle="modal-feddback{{ $objetivo->id }}"
                                                            type="button"
                                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-base px-5 py-2.5 text-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Desaprobar</button>
                                                        <button type="button"
                                                            class="text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-base px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Aprobar</button>
                                                    @endif
                                                </footer>
                                            </form>
                                            <form id="delete-form-{{ $objetivo->id }}" class="hidden"
                                                action="{{ route('objetivos.destroy', $objetivo->id) }}" method="POST">
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
                                                    <form method="POST" action="{{ route('objetivo.desaprobar') }}">
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
                <tr>
                    <td class="p-2 font-bold text-xl px-4" colspan="2">{{ count($objetivos) }} Objetivos
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
                </tr> --}}
            </tbody>
        </table>
    </div>
    <script>
        function handleSelectChange(selectId, paramName) {
            var selectedValue = document.getElementById(selectId).value;
            var currentURL = window.location.href;
            var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
            if (regex.test(currentURL)) {
                currentURL = currentURL.replace(new RegExp("([?&])" + paramName + "=.*?(&|#|$)"), '$1' + paramName + '=' +
                    selectedValue + '$2');
            } else {
                currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' + selectedValue;
            }
            window.location.href = currentURL;
        }

        document.getElementById('area').addEventListener('change', function() {
            handleSelectChange('area', 'id_area');
        });

        document.getElementById('departamento').addEventListener('change', function() {
            handleSelectChange('departamento', 'id_departamento');
        });

        document.getElementById('cargo').addEventListener('change', function() {
            handleSelectChange('cargo', 'id_cargo');
        });

        document.getElementById('puesto').addEventListener('change', function() {
            handleSelectChange('puesto', 'id_puesto');
        });
    </script>
@endsection
