@extends('layouts.app')

@section('template_title')
    Objetivo
@endsection

@section('content')
    <div class="mx-auto w-full p-5">
        <header>
            <h1 class="text-4xl font-bold tracking-tighter">Objetivos</h1>
        </header>
        {{-- <div class="card">
                    <div class="card-header">
                        <div style="display:  flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Mis Objetivo') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('objetivos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Id Colaborador</th>
                                        <th>Id Supervisor</th>
                                        <th>Objetivo</th>
                                        <th>Descripcion</th>
                                        <th>Indicadores</th>
                                        <th>Porcentaje</th>
                                        <th>Estado</th>
                                        <th>Estado Fecha</th>
                                        <th>Feedback</th>
                                        <th>Feedback Fecha</th>
                                        <th>Nota Colab</th>
                                        <th>Nota Super</th>
                                        <th>Nota Super Fecha</th>
                                        <th>Eva</th>
                                        <th>Año</th>
                                        <th>Notify Super</th>
                                        <th>Notify Colab</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objetivos as $objetivo)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $objetivo->id_colaborador }}</td>
                                            <td>{{ $objetivo->id_supervisor }}</td>
                                            <td>{{ $objetivo->objetivo }}</td>
                                            <td>{{ $objetivo->descripcion }}</td>
                                            <td>{{ $objetivo->indicadores }}</td>
                                            <td>{{ $objetivo->porcentaje }}</td>
                                            <td>{{ $objetivo->estado }}</td>
                                            <td>{{ $objetivo->estado_fecha }}</td>
                                            <td>{{ $objetivo->feedback }}</td>
                                            <td>{{ $objetivo->feedback_fecha }}</td>
                                            <td>{{ $objetivo->nota_colab }}</td>
                                            <td>{{ $objetivo->nota_super }}</td>
                                            <td>{{ $objetivo->nota_super_fecha }}</td>
                                            <td>{{ $objetivo->eva }}</td>
                                            <td>{{ $objetivo->año }}</td>
                                            <td>{{ $objetivo->notify_super }}</td>
                                            <td>{{ $objetivo->notify_colab }}</td>

                                            <td>
                                                <form action="{{ route('objetivos.destroy', $objetivo->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('objetivos.show', $objetivo->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('objetivos.edit', $objetivo->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}







        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
                role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Mis Objetivos</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">Objetivos a calificar</button>
                </li>
                {{-- <li class="mr-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                        aria-controls="settings" aria-selected="false">Evaluacion N°2</button>
                </li> --}}
                <li class="ml-auto">
                    <div class="pb-4  flex dark:bg-gray-900">


                        <!-- Modal toggle -->
                        <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                            class="text-white ml-auto bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
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
                </li>
            </ul>
        </div>
        <div id="myTabContent">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800">
                        <div>
                            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Año actividad</span>
                                Año actividad
                                <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownAction"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownActionButton">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">2023</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">2024</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">2025
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="table-search"
                                class="block p-2 pl-10 text-base text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Buscar objetivo">
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
                                        <div class="line-clamp-2 overflow-ellipsis overflow-hidden">
                                            {{ $objetivo->descripcion }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="line-clamp-2 overflow-ellipsis overflow-hidden">
                                            {{ $objetivo->indicadores }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="line-clamp-2 font-semibold overflow-ellipsis overflow-hidden">
                                            {{ $objetivo->nota_colab }}
                                            /
                                            {{ $objetivo->nota_super }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($objetivo->estado === -1)
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Desaprobado</span>
                                            @endif
                                            @if ($objetivo->estado === 1)
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                            @else
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Aprobado</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            {{ $objetivo->porcentaje }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button data-modal-target="editObjModal{{ $objetivo->id }}"
                                            data-modal-show="editObjModal{{ $objetivo->id }}"
                                            class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                            <span
                                                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Editar
                                            </span>
                                        </button>

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
                                                                <button
                                                                    data-modal-target="editObjModal{{ $objetivo->id }}"
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                        class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>.
                    Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                    classes to control the content visibility and styling.</p>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                aria-labelledby="settings-tab">
                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                        class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>.
                    Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                    classes to control the content visibility and styling.</p>
            </div>
        </div>

        {!! $objetivos->links() !!}
    </div>
@endsection
