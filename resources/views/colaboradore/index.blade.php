@extends('layouts.sidebar')

@section('template_title')
    Colaboradores
@endsection

@section('content-sidebar')
    <div class="p-3">
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
                <div class="grid grid-cols-5 items-end gap-3  bg-white">
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
                    {{-- <span>
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
                    </div> --}}
                    <!-- Modal toggle -->
                    <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                        class="text-white ml-auto h-10 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
                                    <span class="sr-only">Cerrar modal</span>
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
            </header>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 min-w-[300px]">
                                Colaborador
                            </th>
                            <th scope="col" class="px-6 py-3 min-w-[200px]">
                                Cargo
                            </th>

                            <th scope="col" class="px-6 py-3 min-w-[200px]">
                                Area
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            {{-- <th scope="col" class="px-6 py-3 min-w-[250px]">
                            Fecha de registro
                        </th> --}}
                            <th>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colaboradores as $colaboradore)
                            @include('colaboradore.item', ['colaborador' => $colaboradore])
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- {!! $colaboradores->links() !!} --}}

        </div>
    @endsection
