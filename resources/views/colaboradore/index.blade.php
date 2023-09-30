@extends('layouts.sidebar')

@section('template_title')
    Colaboradores
@endsection

@section('content-sidebar')
    <div class="">
        @if ($message = Session::get('success'))
            <div id="alert-1"
                class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium">
                    {{ $message }}
                </div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-1" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
        {{-- <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title"
                                style="font-size: 16px; display: flex;font-weight: bold; align-items: center; gap: 7px;">
                                <i style="font-size: 30px" class="fa-solid fa-users"></i>
                                {{ __('Lista de colaboradores') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('colaboradores.create') }}" style="font-size: 16px;"
                                    class="btn btn-primary btn-sm float-right" data-placement="left">
                                    {{ __('Crea nuevo colaborador') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>DNI</th>
                                        <th>Apellidos</th>
                                        <th>Nombres</th>
                                        <th>Estado</th>
                                        <th>Cargo</th>
                                        <th>Puesto</th>
                                        <th>Usuario</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
        <div class="relative overflow-x-auto sm:rounded-lg">
            <header class="pb-2">
                {{-- <h1 class=" font-bold text-4xl tracking-tighter text-blue-700 pb-2">Colaboradores</h1> --}}
                <div class="pb-4  flex dark:bg-gray-900">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search"
                            class="block p-2 pl-10 text-base text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar colaborador">
                    </div>

                    <!-- Modal toggle -->
                    <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                        class="text-white ml-auto bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Agregar
                    </button>

                    <!-- Main modal -->
                    <div id="create-colab-modal" tabindex="-1" aria-hidden="true"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative max-w-lg w-full max-h-full">
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
                                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Registrar nuevo
                                        colaborador</h3>

                                    <form method="POST" class="space-y-6" action="{{ route('colaboradores.store') }}"
                                        role="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid gap-3 mb-6 md:grid-cols-2">
                                            <div>
                                                <label for="nombres"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
                                                {{ Form::text('nombres', $colaboradorForm->nombres, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('nombres') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'required' => 'required']) }}
                                                {!! $errors->first('nombres', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
                                            </div>
                                            <div>
                                                <label for="apellidos"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                                                {{ Form::text('apellidos', $colaboradorForm->apellidos, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('apellidos') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'required' => 'required']) }}
                                                {!! $errors->first('apellidos', '  <p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
                                            </div>
                                            <div>
                                                <label for="Dni"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dni</label>
                                                {{ Form::text('dni', $colaboradorForm->dni, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('dni') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'required' => 'required']) }}
                                                {!! $errors->first('dni', '  <p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Cargo') }}
                                                {{ Form::select('id_cargo', $cargos, $colaboradorForm->id_cargo, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('id_cargo') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'required' => 'required']) }}
                                                {!! $errors->first('id_cargo', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="col-span-2">
                                                {{ Form::label('Puesto') }}
                                                {{ Form::select('id_puesto', $puestos, $colaboradorForm->id_puesto, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('id_puesto') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'required' => 'required']) }}
                                                {!! $errors->first('id_puesto', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <span>
                        <select id="countries"
                            class="bg-gray-50 font-medium text-base border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Seleccionar un cargo</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>
                    </span>
                </div>
            </header>

            {{-- <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombres y apellidos
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DNI
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cargo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Puesto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Usuario
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colaboradores as $colaboradore)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $colaboradore->apellidos }} {{ $colaboradore->nombres }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $colaboradore->dni }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $colaboradore->cargo->nombre_cargo }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $colaboradore->user->email }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('colaboradores.destroy', $colaboradore->id) }}" method="POST">

                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('colaboradores.edit', $colaboradore->id) }}"><i
                                                class="fa fa-fw fa-edit"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa fa-fw fa-trash"></i></button>

                                        @if ($accesos->contains('modulo', 'Accesos'))
                                            <a title="Acessos" class="btn btn-sm"
                                                href="{{ route('colaborador.accesos', $colaboradore->id) }}">
                                                <i style="font-size: 30px" class="fa-solid fa-universal-access"></i></a>
                                        @endif

                                        @if ($accesos->contains('modulo', 'Supervisores'))
                                            <a title="Supervisor (Jefe imediato)" class="btn btn-sm "
                                                href="{{ route('colaborador.supervisor', $colaboradore->id) }}"><i
                                                    style="font-size: 30px" class="fa-solid fa-user-tie"></i></a>
                                        @endif


                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>

        {{-- <div class="flex gap-2 flex-wrap">
            @foreach ($colaboradores as $colaboradore)
                <div class="w-72 bg-white border border-gray-200 rounded-2xl dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-end px-2 pt-2">
                        <button id="dropdownButton" data-dropdown-toggle="dropdown"
                            class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                            type="button">
                            <span class="sr-only">Open dropdown</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 16 3">
                                <path
                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdown"
                            class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2" aria-labelledby="dropdownButton">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Ver
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('colaboradores.edit', $colaboradore->id) }}"
                                        class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editar</a>
                                </li>
                                @if ($accesos->contains('modulo', 'Accesos'))
                                    <li>
                                        <a href="{{ route('colaborador.accesos', $colaboradore->id) }}"
                                            class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Accesos
                                        </a>
                                    </li>
                                @endif
                                @if ($accesos->contains('modulo', 'Supervisores'))
                                    <li>
                                        <a href="{{ route('colaborador.supervisor', $colaboradore->id) }}"
                                            class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Jefe
                                            inmediato</a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('colaboradores.destroy', $colaboradore->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-1 text-base font-medium text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Eliminar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col items-center pb-5">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="/default-user.webp" alt="Bonnie image" />
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $colaboradore->apellidos }}
                            {{ $colaboradore->nombres }}</h5>
                        <span
                            class="text-sm text-gray-500 dark:text-gray-400">{{ $colaboradore->cargo->nombre_cargo }}</span>
                        <div class="flex mt-4 space-x-3 md:mt-6">
                            <a href="{{ route('colaboradores.edit', $colaboradore->id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Editar</a>
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">
                                Objetivos</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 min-w-[300px]">
                            Colaborador
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cargo
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-[250px]">
                            Puesto
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-[300px]">
                            Area
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-[250px]">
                            Fecha de registro
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colaboradores as $colaboradore)
                        {{-- <div class="w-72 bg-white border border-gray-200 rounded-2xl dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-end px-2 pt-2">
                                <button id="dropdownButton" data-dropdown-toggle="dropdown"
                                    class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                                    type="button">
                                    <span class="sr-only">Open dropdown</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 16 3">
                                        <path
                                            d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown"
                                    class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2" aria-labelledby="dropdownButton">
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Ver
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('colaboradores.edit', $colaboradore->id) }}"
                                                class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editar</a>
                                        </li>
                                        @if ($accesos->contains('modulo', 'Accesos'))
                                            <li>
                                                <a href="{{ route('colaborador.accesos', $colaboradore->id) }}"
                                                    class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Accesos
                                                </a>
                                            </li>
                                        @endif
                                        @if ($accesos->contains('modulo', 'Supervisores'))
                                            <li>
                                                <a href="{{ route('colaborador.supervisor', $colaboradore->id) }}"
                                                    class="block px-4 py-1 text-base font-medium text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Jefe
                                                    inmediato</a>
                                            </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('colaboradores.destroy', $colaboradore->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="block w-full text-left px-4 py-1 text-base font-medium text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Eliminar</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex flex-col items-center pb-5">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="/default-user.webp"
                                    alt="Bonnie image" />
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                    {{ $colaboradore->apellidos }}
                                    {{ $colaboradore->nombres }}</h5>
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400">{{ $colaboradore->cargo->nombre_cargo }}</span>
                                <div class="flex mt-4 space-x-3 md:mt-6">
                                    <a href="{{ route('colaboradores.edit', $colaboradore->id) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Editar</a>
                                    <a href="#"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">
                                        Objetivos</a>
                                </div>
                            </div>
                        </div> --}}
                        <tr
                            class="bg-white [&>td]:px-2 [&>td]:py-2 [&>th]:px-2 [&>th]:py-2 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="flex items-center  text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="/default-user.webp" alt="Jese image">
                                <div class="pl-3">
                                    <div class="text-lg font-semibold">
                                        {{ $colaboradore->apellidos }}
                                        {{ $colaboradore->nombres }}
                                    </div>
                                    <div class="font-normal text-gray-500">{{ $colaboradore->dni }}</div>
                                </div>
                            </th>
                            <td class=" capitalize text-red-600 font-medium">
                                {{ strtolower($colaboradore->cargo->nombre_cargo) }}
                            </td>
                            <td class=" capitalize text-yellow-600 font-medium">
                                {{ strtolower($colaboradore->puesto->nombre_puesto) }}
                            </td>
                            <td class=" capitalize text-sky-600 font-medium">
                                {{ strtolower($colaboradore->puesto->departamento->area->nombre_area) }}
                                <span class="block text-neutral-500 text-sm font-normal line-clamp-1"><span>Dep.</span>
                                    {{ strtolower($colaboradore->puesto->departamento->nombre_departamento) }}</span>
                            </td>
                            <td class="">
                                @if ($colaboradore->estado == 0)
                                    <span
                                        class="bg-red-100 text-red-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Inactivo</span>
                                @else
                                    <span
                                        class="bg-green-100 text-green-800 text-base font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Activo</span>
                                @endif
                            </td>
                            <td class="">
                                <div class="line-clamp-2">
                                    {{ \Carbon\Carbon::parse($colaboradore->created_at)->format('j \d\e F, Y') }}
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <button type="button" title="Editar"
                                        class="text-white gap-2 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z" />
                                        </svg>
                                    </button>
                                    <button type="button" title="Objetivos"
                                        class="text-white gap-2 bg-[#f44268] hover:bg-[#f57893] focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-full text-sm h-[40px] w-[40px] justify-center text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! $colaboradores->links() !!}
    </div>
@endsection
