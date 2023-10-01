@extends('layouts.sidebar')

@section('template_title')
    Supervisore
@endsection

@section('content-sidebar')
    <div class="relative sm:rounded-lg">
        <h1 class="text-3xl pb-3 font-bold tracking-tight text-neutral-700">Administración de supervisores (Jefes inmediatos)
        </h1>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <header class="flex items-center gap-2">
            <nav class="flex gap-2 items-center bg-neutral-100 p-2 rounded-xl">
                <span class="">
                    <label for="colaboradores">Colaborador</label>
                    <select id="colaboradores"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-base font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[200px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Todos</option>
                        @foreach ($colaboradores as $item)
                            <option {{ $idColabSelected == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                {{ $item->nombres }}
                                {{ $item->apellidos }}</option>
                        @endforeach
                    </select>
                </span>
            </nav>
            <nav class="ml-auto">
                <!-- Modal toggle -->
                <button data-modal-target="create-super-modal" data-modal-toggle="create-super-modal"
                    class="text-white ml-auto bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-10 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    Asignar
                    jefe inmediato
                </button>

                <!-- Main modal -->
                <div id="create-super-modal" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative max-w-lg w-full max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="create-super-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            @includeif('partials.errors')
                            <div class="px-4 py-4">
                                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Registrar nuevo
                                    colaborador</h3>


                                @includeif('partials.errors')
                                <form method="POST" action="{{ route('supervisores.store') }}" role="form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @include('supervisore.form')
                                </form>

                                {{-- <form method="POST" class="space-y-6" action="{{ route('colaboradores.store') }}"
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
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </nav>
        </header>
        <div class="shadow-md relative">
            <table class="w-full text-sm  text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-[50px]">N°</th>
                        <th scope="col" class="px-6 py-3">Colaborador</th>
                        <th scope="col" class="px-6 py-3">Supervisor</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supervisores as $supervisore)
                        <tr class="bg-white border-b even:bg-neutral-100 dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4">{{ ++$i }}</td>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div clas>
                                    <h3>
                                        {{ $supervisore->colaboradore->nombres }}
                                        {{ $supervisore->colaboradore->apellidos }}
                                    </h3>
                                    <div>
                                        <span class="text-xs text-neutral-600 capitalize">
                                            {{ mb_strtolower($supervisore->colaboradore->puesto->nombre_puesto, 'UTF-8') }}
                                            -
                                            {{ mb_strtolower($supervisore->colaboradore->puesto->departamento->area->nombre_area, 'UTF-8') }}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <h3>
                                    {{ $supervisore->supervisores->nombres }}
                                    {{ $supervisore->supervisores->apellidos }}
                                </h3>
                                <span class="text-xs text-neutral-600 capitalize">
                                    {{ mb_strtolower($supervisore->supervisores->puesto->nombre_puesto, 'UTF-8') }}
                                    -
                                    {{ mb_strtolower($supervisore->supervisores->puesto->departamento->area->nombre_area, 'UTF-8') }}
                                </span>
                            </td>
                            <td>
                                <form class="flex gap-0" action="{{ route('supervisores.destroy', $supervisore->id) }}"
                                    method="POST">
                                    <a class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                        href="{{ route('supervisores.edit', $supervisore->id) }}"><i
                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                    @csrf
                                    @method('DELETE')
                                    <a href="#"
                                        class="text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-base px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                        onclick="event.preventDefault(); confirm('¿Estás seguro de que deseas eliminar este registro?') && document.getElementById('delete-form-{{ $supervisore->id }}').submit();">
                                        <i class="fa fa-fw fa-trash"></i>
                                        {{ __('Eliminar') }}
                                    </a>
                                </form>
                                <form id="delete-form-{{ $supervisore->id }}" class="hidden"
                                    action="{{ route('supervisores.destroy', $supervisore->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tbody>
                    <tr class="">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Silver
                        </td>
                        <td class="px-6 py-4">
                            Laptop
                        </td>
                        <td class="px-6 py-4">
                            $2999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Microsoft Surface Pro
                        </th>
                        <td class="px-6 py-4">
                            White
                        </td>
                        <td class="px-6 py-4">
                            Laptop PC
                        </td>
                        <td class="px-6 py-4">
                            $1999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Magic Mouse 2
                        </th>
                        <td class="px-6 py-4">
                            Black
                        </td>
                        <td class="px-6 py-4">
                            Accessories
                        </td>
                        <td class="px-6 py-4">
                            $99
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Google Pixel Phone
                        </th>
                        <td class="px-6 py-4">
                            Gray
                        </td>
                        <td class="px-6 py-4">
                            Phone
                        </td>
                        <td class="px-6 py-4">
                            $799
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple Watch 5
                        </th>
                        <td class="px-6 py-4">
                            Red
                        </td>
                        <td class="px-6 py-4">
                            Wearables
                        </td>
                        <td class="px-6 py-4">
                            $999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                </tbody> --}}
            </table>
        </div>
    </div>
    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Supervisores') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('supervisores.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Asignar nuevo jefe Imediate') }}
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
                                        <th>Colaborador</th>
                                        <th>Supervisor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supervisores as $supervisore)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $supervisore->colaboradore->nombres }}
                                                {{ $supervisore->colaboradore->apellidos }}
                                            </td>
                                            <td>{{ $supervisore->supervisores->nombres }}
                                                {{ $supervisore->supervisores->apellidos }}
                                            </td>

                                            <td>
                                                <form action="{{ route('supervisores.destroy', $supervisore->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('supervisores.edit', $supervisore->id) }}"><i
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
                </div>
                {!! $supervisores->links() !!}
            </div>
        </div>
    </div> --}}
@endsection
