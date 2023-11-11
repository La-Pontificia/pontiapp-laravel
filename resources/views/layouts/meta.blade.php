@extends('layouts.sidebar')

@section('content-sidebar')
    <div class="pb-3 bg-white z-30">
        <div class="flex items-center w-full">
            <div class="p-4 flex">
                <div class="relative">
                    <img alt="{{ $colaborador->nombres }}" src="/profile-user.png"
                        class="shadow-xl rounded-full w-[8rem] h-[8rem] min-w-[8rem] border-none">
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex gap-2 px-2 items-center justify-start">
                    <h3 class="text-2xl font-bold text-gray-700">
                        {{ $colaborador->nombres }}
                        {{ $colaborador->apellidos }}
                    </h3>
                </div>
                <div class="text-gray-500 capitalize flex gap-1 px-3">
                    <svg viewBox="0 0 24 24" class="w-5 text-gray-500 " fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.052 1.25H11.948C11.0495 1.24997 10.3003 1.24995 9.70552 1.32991C9.07773 1.41432 8.51093 1.59999 8.05546 2.05546C7.59999 2.51093 7.41432 3.07773 7.32991 3.70552C7.24995 4.3003 7.24997 5.04951 7.25 5.94799V6.02572C5.22882 6.09185 4.01511 6.32803 3.17157 7.17157C2 8.34315 2 10.2288 2 14C2 17.7712 2 19.6569 3.17157 20.8284C4.34315 22 6.22876 22 10 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14C22 10.2288 22 8.34315 20.8284 7.17157C19.9849 6.32803 18.7712 6.09185 16.75 6.02572V5.94801C16.75 5.04954 16.7501 4.3003 16.6701 3.70552C16.5857 3.07773 16.4 2.51093 15.9445 2.05546C15.4891 1.59999 14.9223 1.41432 14.2945 1.32991C13.6997 1.24995 12.9505 1.24997 12.052 1.25ZM15.25 6.00189V6C15.25 5.03599 15.2484 4.38843 15.1835 3.9054C15.1214 3.44393 15.0142 3.24644 14.8839 3.11612C14.7536 2.9858 14.5561 2.87858 14.0946 2.81654C13.6116 2.7516 12.964 2.75 12 2.75C11.036 2.75 10.3884 2.7516 9.90539 2.81654C9.44393 2.87858 9.24644 2.9858 9.11612 3.11612C8.9858 3.24644 8.87858 3.44393 8.81654 3.9054C8.7516 4.38843 8.75 5.03599 8.75 6V6.00189C9.14203 6 9.55807 6 10 6H14C14.4419 6 14.858 6 15.25 6.00189ZM17 9C17 9.55229 16.5523 10 16 10C15.4477 10 15 9.55229 15 9C15 8.44772 15.4477 8 16 8C16.5523 8 17 8.44772 17 9ZM8 10C8.55228 10 9 9.55229 9 9C9 8.44772 8.55228 8 8 8C7.44772 8 7 8.44772 7 9C7 9.55229 7.44772 10 8 10Z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                    {{ mb_strtolower($colaborador->puesto->nombre_puesto, 'UTF-8') }}
                    -
                    {{ mb_strtolower($colaborador->puesto->departamento->area->nombre_area, 'UTF-8') }}
                </div>
                <div class="text-gray-600">
                    <i class="fas fa-university mr-2 text-lg text-gray-400"></i>
                    Escuela Superior La pontificia
                </div>
            </div>
            @if (!$miPerfil)
                <div class="ml-auto p-5 flex gap-2 bg-green-100 rounded-xl font-semibold text-green-500">
                    <svg width='20' viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM15.7071 9.29289C16.0976 9.68342 16.0976 10.3166 15.7071 10.7071L12.0243 14.3899C11.4586 14.9556 10.5414 14.9556 9.97568 14.3899L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929C8.68342 10.9024 9.31658 10.9024 9.70711 11.2929L11 12.5858L14.2929 9.29289C14.6834 8.90237 15.3166 8.90237 15.7071 9.29289Z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                    <h2>Supervisas a este colaborador</h2>
                </div>
            @endif
        </div>
    </div>
    @yield('content-meta')
@endsection
