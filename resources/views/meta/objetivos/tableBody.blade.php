<?php
$animate_id = request()->query('animate');
?>

<style>
    .animate-bounce-bg {
        animation: bounceAnimation 2s ease-in-out;
    }

    @keyframes bounceAnimation {

        0%,
        20%,
        50%,
        80%,
        100% {
            background-color: inherit;
        }

        40% {
            background-color: #cacaca;
        }
    }
</style>
<tbody>
    @foreach ($objetivos as $objetivo)
        <tr
            class="{{ $animate_id == $objetivo->id ? 'animate-bounce-bg' : '' }} border-b border-gray-200 text-sm dark:border-gray-700">
            <th scope="row" class="px-6 py-4 text-sm font-semibold text-blue-900 ">
                <h3 class="">{{ $objetivo->objetivo }}</h3>
            </th>
            <td class="px-6 py-4">
                <div class=" text-sm overflow-ellipsis overflow-hidden">
                    {{ $objetivo->descripcion }}
                </div>
            </td>
            <td class="px-6 py-4 ">
                <div class=" text-sm overflow-ellipsis overflow-hidden">
                    {{ $objetivo->indicadores }}
                </div>
            </td>
            <td class="px-2 py-4">
                <div class="justify-center w-full flex">
                    <span
                        class="bg-purple-100 text-purple-800 p-1 px-3 text-sm font-medium mr-2 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $objetivo->porcentaje }}%</span>
                </div>
            </td>
            <td class="px-6 py-4 ">
                <div class="flex items-center">
                    @if ($objetivo->editado === 1)
                        <span
                            class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Editado</span>
                    @else
                        -
                    @endif
                </div>
            </td>
            <td class="px-2">
                <div class="flex gap-2">
                    @if ($btneditar)
                        <button data-modal-target="editObjModal{{ $objetivo->id }}"
                            data-modal-show="editObjModal{{ $objetivo->id }}" type="button"
                            class="focus:outline-none gap-2 rounded-md text-white bg-green-600 hover:bg-green-700 font-medium text-sm p-2 h-[35px] flex items-center justify-center ">
                            <svg class="w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 21 21">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                            </svg>
                            Editar
                        </button>
                        {{-- MODAL EDIT  --}}
                        <div id="editObjModal{{ $objetivo->id }}" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative max-w-3xl w-full max-h-full">
                                <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
                                    <button type="button"
                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="editObjModal{{ $objetivo->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                    @includeif('partials.errors')
                                    <div class="px-4 py-4">
                                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                            Editar objetivo</h3>
                                        @includeif('partials.errors')
                                        <form class="form-update-obj" method="POST"
                                            action="/meta/{{ $id_colab }}/eda/{{ $id_eda }}/objetivos/{{ $objetivo->id }}"
                                            role="form" enctype="multipart/form-data">
                                            @csrf
                                            @include('meta.objetivos.form', [
                                                'objetivo' => $objetivo,
                                            ])

                                            <footer class="flex justify-end gap-2 mt-2 items-center">
                                                <input type="number" required name="porcentaje"
                                                    value="{{ $objetivo->porcentaje }}" placeholder="Porcentaje %"
                                                    class="w-[150px] border rounded-xl focus:outline-2 transition-all focus:outline-blue-600">
                                                @if ($miPerfil)
                                                    <button data-id="{{ $objetivo->id }}" type="button"
                                                        class="focus:outline-none delete-objetivo rounded-md text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 h-[35px] flex items-center justify-center ">
                                                        <svg class="w-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 18 20">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                                        </svg>
                                                        Eliminar
                                                    </button>
                                                @endif
                                                <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                                    type="button" type="button"
                                                    data-modal-toggle="editObjModal{{ $objetivo->id }}"
                                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-sm px-5 h-[35px]">Cerrar</button>
                                                <button
                                                    class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-10 h-[35px] text-center"
                                                    type="submit">
                                                    Actualizar objetivo
                                                </button>
                                            </footer>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($btneliminar)
                        <button data-id="{{ $objetivo->id }}"
                            class="focus:outline-none delete-objetivo rounded-md text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-sm p-2 h-[35px] flex items-center justify-center ">
                            <svg class="w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                            </svg>
                            Eliminar
                        </button>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
