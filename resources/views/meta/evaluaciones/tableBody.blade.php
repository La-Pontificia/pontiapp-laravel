<tbody>

    @foreach ($objetivos as $objetivo)
        <tr class="border-b border-gray-200 text-sm dark:border-gray-700">
            <th scope="row"
                class="px-6 py-4 text-sm font-semibold text-blue-900 bg-gray-50 dark:text-white dark:bg-gray-800">
                <h3 class="line-clamp-3">{{ $objetivo->objetivo }}</h3>
            </th>
            <td class="px-6 py-4">
                <div class="line-clamp-3 text-sm overflow-ellipsis overflow-hidden">
                    {{ $objetivo->descripcion }}
                </div>
            </td>
            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                <div class="line-clamp-3 text-sm overflow-ellipsis overflow-hidden">
                    {{ $objetivo->indicadores }}
                </div>
            </td>
            <td class="px-2 py-4">
                <div class="justify-center w-full flex">
                    <span
                        class="bg-purple-100 text-purple-800 p-1 px-3 text-sm font-medium mr-2 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $objetivo->porcentaje }}%</span>
                </div>
            </td>
            <td class="px-3 py-4 bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center justify-center gap-2">
                    <div
                        class="text-center font-medium w-8 h-8 grid place-content-center {{ !$objetivo->autocalificacion ? 'bg-[#2557D6]/20 text-blue-500' : 'bg-green-500/20 text-green-500' }} rounded-md">
                        {{ $objetivo->autocalificacion }}
                    </div>
                    <button data-modal-target="autocalificar-obj{{ $objetivo->id }}"
                        data-modal-toggle="autocalificar-obj{{ $objetivo->id }}" type="button"
                        class="text-white {{ !$objetivo->autocalificacion ? 'bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-[#2557D6]/50' : 'bg-[#25d675] hover:bg-[#25d675]/90 focus:ring-[#25d675]/50' }} focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        {{ $objetivo->autocalificacion ? 'Modificar' : 'Autocalificar' }}
                    </button>
                </div>
                <div id="autocalificar-obj{{ $objetivo->id }}" data-modal-backdrop="static" tabindex="-1"
                    aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Autocalificar Objetivo
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="autocalificar-obj{{ $objetivo->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <h1 class="p-3 text-center font-medium text-lg">{{ $objetivo->objetivo }}</h1>
                            <form class="form-autocalificacion" data-eva="{{ $n_eva }}"
                                data-id="{{ $objetivo->id }}">
                                <div class="p-5">
                                    <div class="pb-2">
                                        <label for="nota"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nota
                                            autocalificada</label>
                                        <select name="nota" required id="nota"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option selected value="">
                                                Selecciona una
                                                nota
                                            </option>
                                            @php
                                                $autocalificacion = $n_eva == 1 ? $objetivo->autocalificacion : $objetivo->autocalificacion_2;
                                            @endphp
                                            <option {{ $autocalificacion == 1 ? 'selected' : '' }} value="1">1
                                            </option>
                                            <option {{ $autocalificacion == 2 ? 'selected' : '' }} value="2">2
                                            </option>
                                            <option {{ $autocalificacion == 3 ? 'selected' : '' }} value="3">3
                                            </option>
                                            <option {{ $autocalificacion == 4 ? 'selected' : '' }} value="4">4
                                            </option>
                                            <option {{ $autocalificacion == 5 ? 'selected' : '' }} value="5">5
                                            </option>
                                        </select>
                                    </div>
                                    <button
                                        class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
