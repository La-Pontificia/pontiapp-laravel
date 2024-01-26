@extends('layouts.sidebar')

@section('content-sidebar')
    <div class="px-6 bg-white sticky top-16 z-30 py-2">
        <div class="flex items-center w-full">
            <div class="p-3 flex">
                <div class="relative">
                    <img alt="..." src="https://cataas.com/cat"
                        class="shadow-xl rounded-full w-[8rem] h-[8rem] min-w-[8rem] border-none">
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex gap-2 px-2 items-center justify-start">
                    <h3 class="text-3xl font-bold text-gray-700">
                        {{ $colaborador->nombres }}
                        {{ $colaborador->apellidos }}
                    </h3>
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
                    @if ($isMyprofile)
                        <button type="button"
                            class="text-blue-700 gap-2 max-w-max mt-2 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center :border-blue-500 :text-blue-500 :hover:text-white :focus:ring-blue-800 :hover:bg-blue-500">
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
                            class="text-green-700 ml-2 gap-1 max-w-max mt-2 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm text-center inline-flex items-center :border-blue-500 :text-blue-500 :hover:text-white :focus:ring-blue-800 :hover:bg-blue-500">
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
        </div>
    </div>
    @yield('content-profile')
@endsection
