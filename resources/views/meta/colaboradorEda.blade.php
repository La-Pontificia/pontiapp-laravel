@extends('layouts.meta')

@section('content-meta')
    @include('meta.listaEdas', ['eda' => $edaSeleccionado, 'eda' => $id_colab, 'id_eda' => $id_eda])
    <div class="mt-4 flex p-5">
        <div class="flex w-[450px] flex-col gap-2">
            <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}/objetivos" class="group">
                <div class="p-3 border rounded-xl flex gap-2 group-hover:bg-neutral-100">
                    <div class="flex gap-3 items-center w-full">
                        <div class="bg-pink-600 p-4 text-white rounded-xl">
                            <svg viewBox="0 0 24 24" width="24px" height="24px" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.17157 3.17157C3 4.34315 3 6.22876 3 10V14C3 17.7712 3 19.6569 4.17157 20.8284C5.34315 22 7.22876 22 11 22H13C16.7712 22 18.6569 22 19.8284 20.8284C21 19.6569 21 17.7712 21 14V10C21 6.22876 21 4.34315 19.8284 3.17157C18.6569 2 16.7712 2 13 2H11C7.22876 2 5.34315 2 4.17157 3.17157ZM7.25 8C7.25 7.58579 7.58579 7.25 8 7.25H16C16.4142 7.25 16.75 7.58579 16.75 8C16.75 8.41421 16.4142 8.75 16 8.75H8C7.58579 8.75 7.25 8.41421 7.25 8ZM7.25 12C7.25 11.5858 7.58579 11.25 8 11.25H16C16.4142 11.25 16.75 11.5858 16.75 12C16.75 12.4142 16.4142 12.75 16 12.75H8C7.58579 12.75 7.25 12.4142 7.25 12ZM8 15.25C7.58579 15.25 7.25 15.5858 7.25 16C7.25 16.4142 7.58579 16.75 8 16.75H13C13.4142 16.75 13.75 16.4142 13.75 16C13.75 15.5858 13.4142 15.25 13 15.25H8Z"
                                        fill="currentColor"></path>
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-neutral-800 text-lg font-medium">Objetivos</h1>
                            <p class="text-sm">
                                @if ($edaSeleccionado->cerrado)
                                    <span class="text-red-500">
                                        Evaluacion cerrada
                                    </span>
                                @else
                                    <span class="text-green-500">
                                        {{ $edaSeleccionado->enviado ? 'Ya puedes aprobar sus objetivos' : 'Puedes agregar tus objetivos' }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <div class="w-full border-b my-5"></div>
            <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}/{{ $edaSeleccionado->evaluacion->id }}"
                class="group">
                <div class="p-3 border rounded-xl flex gap-2 group-hover:bg-neutral-100">
                    <div class="flex gap-3 items-center w-full">
                        <div class="bg-blue-500 p-4 text-white rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" version="1.1"
                                id="Layer_1" x="0px" y="0px" viewBox="0 0 74.4 74.4" fill='currentColor'
                                style="enable-background:new 0 0 74.4 74.4;" xml:space="preserve"
                                preserveAspectRatio="xMinYMid meet">
                                <g>
                                    <path
                                        d="M66.5,15.1L52.4,1c-0.7-0.7-1.6-1-2.6-1H10.3C8.2,0,6.6,1.6,6.6,3.7l0,0v67c0,2.1,1.6,3.7,3.7,3.7l0,0H64   c2.1,0,3.7-1.6,3.7-3.7l0,0V17.8C67.5,16.8,67.2,15.8,66.5,15.1z M48.4,6.7l12.5,12.5H48.4V6.7z M11.9,69.2V5h30.9v15.6   c0,2.2,1.7,3.8,3.8,3.8h15.6v44.7L11.9,69.2L11.9,69.2z" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-neutral-800 text-lg font-medium">1ra Evaluacion</h1>
                            <p class="font-medium text-sm">
                                @if ($edaSeleccionado->evaluacion->cerrado)
                                    <span class="text-red-500">
                                        Evaluacion cerrada
                                    </span>
                                @else
                                    <span class="text-green-500">
                                        Evaluacion disponible
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}/{{ $edaSeleccionado->evaluacion2->id }}"
                class="group">
                <div class="p-3 border rounded-xl flex gap-2 group-hover:bg-neutral-100">
                    <div class="flex gap-3 items-center w-full">
                        <div class="bg-blue-500 p-4 text-white rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" version="1.1"
                                id="Layer_1" x="0px" y="0px" viewBox="0 0 74.4 74.4" fill='currentColor'
                                style="enable-background:new 0 0 74.4 74.4;" xml:space="preserve"
                                preserveAspectRatio="xMinYMid meet">
                                <g>
                                    <path
                                        d="M66.5,15.1L52.4,1c-0.7-0.7-1.6-1-2.6-1H10.3C8.2,0,6.6,1.6,6.6,3.7l0,0v67c0,2.1,1.6,3.7,3.7,3.7l0,0H64   c2.1,0,3.7-1.6,3.7-3.7l0,0V17.8C67.5,16.8,67.2,15.8,66.5,15.1z M48.4,6.7l12.5,12.5H48.4V6.7z M11.9,69.2V5h30.9v15.6   c0,2.2,1.7,3.8,3.8,3.8h15.6v44.7L11.9,69.2L11.9,69.2z" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-neutral-800 text-lg font-medium">2da Evaluacion</h1>
                            <p class="font-medium text-sm">
                                @if ($edaSeleccionado->evaluacion2->cerrado)
                                    <span class="text-red-500">
                                        Evaluacion cerrada
                                    </span>
                                @else
                                    <span class="text-green-500">
                                        Evaluacion disponible
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="p-4 ml-auto">
            <h3 class="text-blue-600">Detalles del EDA</h3>
        </div>
    </div>
@endsection
