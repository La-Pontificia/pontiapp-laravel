@extends('layouts.sidebar')

@section('content-sidebar')
    <section class="relative block h-[200px]">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="
        background-image: url('https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2710&amp;q=80');
      ">
            <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black/50"></span>
        </div>
    </section>
    <div class="px-6 bg-white sticky top-16 z-30 py-2">
        <div class="flex items-center w-full">
            <div class="p-3 flex">
                <div class="relative">
                    <img alt="..." src="https://cataas.com/cat?type=sq"
                        class="shadow-xl rounded-full w-[11rem] h-[11rem] min-w-[11rem] border-none">
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex gap-2 items-center justify-start">
                    <h3 class="text-4xl font-bold leading-normal text-gray-700">
                        {{ $colaborador->nombres }}
                        {{ $colaborador->apellidos }}
                    </h3>
                    @if ($isMyprofile)
                        <button title="Editar nombre">
                            <svg class="w-6 h-6 text-gray-600 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                            </svg>
                        </button>
                    @endif
                </div>
                <div class="text-gray-600 capitalize">
                    <i class="fas fa-briefcase mr-2 text-lg text-gray-400"></i>
                    {{ mb_strtolower($colaborador->puesto->nombre_puesto, 'UTF-8') }}
                    -
                    {{ mb_strtolower($colaborador->puesto->departamento->area->nombre_area, 'UTF-8') }}
                </div>
                <div class="text-gray-600">
                    <i class="fas fa-university mr-2 text-lg text-gray-400"></i>
                    Escuela Superior La pontificia
                </div>
                <div>
                    @if (!$isMyprofile)
                        <button type="button"
                            class="text-blue-700 gap-2 max-w-max mt-2 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 18">
                                <path
                                    d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z" />
                            </svg>
                            <span>Enviar feedback</span>
                        </button>
                    @else
                        <button type="button"
                            class="text-blue-700 gap-2 max-w-max mt-2 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 21 21">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                            </svg>
                            <span>Editar perfil</span>
                        </button>
                    @endif
                    @if ($youSupervise)
                        <button type="button"
                            class="text-green-700 ml-2 gap-1 max-w-max mt-2 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 19">
                                <path
                                    d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" />
                            </svg>
                            <span>Supervisas esta cuenta</span>
                        </button>
                    @endif
                </div>
            </div>
            <div class="px-4 ml-auto">
                <div class="flex justify-center py-4 gap-3 lg:pt-4 pt-8">
                    @if ($isMyprofile)
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
                    @endif
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

        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                @if ($youSupervise || $isMyprofile)
                    {{-- <li class="mr-2">
                            <a href="/profile/{{ $colaborador->id }}/goals"
                                class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg group {{ request()->is('me') || request()->is('*/goals') ? 'text-blue-600 border-b-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}">
                                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>Mis Objetivos
                            </a>
                        </li> --}}
                    <li class="mr-2">
                        <a href="/profile/{{ $colaborador->id }}/eda"
                            class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg dark:hover:text-gray-300 group {{ request()->is('me') || request()->is('*/eda') ? 'text-blue-600 border-b-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}">
                            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>EDA {{ $currentColabEda->eda->year }}-{{ $currentColabEda->eda->n_evaluacion }}
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="/profile/{{ $colaborador->id }}/history"
                            class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg group {{ request()->is('*/history') ? 'text-blue-600 border-b-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}"
                            aria-current="page">
                            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6v4l3.276 3.276M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>Historial
                        </a>
                    </li>
                @endif
                <li class="mr-2">
                    <a href="/profile/{{ $colaborador->id }}/setting"
                        class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg group {{ request()->is('*/setting') ? 'text-blue-600 border-b-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}">
                        <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5 11.424V1a1 1 0 1 0-2 0v10.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.228 3.228 0 0 0 0-6.152ZM19.25 14.5A3.243 3.243 0 0 0 17 11.424V1a1 1 0 0 0-2 0v10.424a3.227 3.227 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.243 3.243 0 0 0 2.25-3.076Zm-6-9A3.243 3.243 0 0 0 11 2.424V1a1 1 0 0 0-2 0v1.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0V8.576A3.243 3.243 0 0 0 13.25 5.5Z" />
                        </svg>Configuraciónes
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @yield('content-profile')
@endsection
