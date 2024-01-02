@extends('layouts.sidebar')

@section('template_title')
    {{-- incio de comentario --}}




@section('content-sidebar')

    <!-- Modal toggle -->
    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Nuevo Puesto
    </button>

    {{-- <div class="container-fluid">
            <div class="row">
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Nuevo Puesto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="form-carg" action="{{ route('cargos.store') }}" role="form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @include('puesto.form')
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
    
                                <span id="card_title">
                                    {{ __('Puesto') }}
                                </span>
    
                                <button type="button" style="width: 200px;" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    Crear nuevo
                                </button>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif --}}

    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                @includeif('partials.errors')
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Registrar Puestos</h3>
                    <form action="" method="POST">
                        @csrf


                        <div>
                            <label for="cargo"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                            <select name="id_cargo" id="cargo"
                                class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($cargos as $cargo)
                                    <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div>
                            <label for="departamento"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                            <select name="id_departamento" id="departamento"
                                class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div>
                            <label for="puesto"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Puesto</label>
                            <input name="nombre_puesto" type="text" id="puesto"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="" required>
                        </div>


                        <footer class="pt-4">
                            <button type="submit"
                                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Registrar</button>

                        </footer>


                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- comentario --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table w-full text-gray-600 table-striped table-hover">
                <thead class="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">Codigo</th>
                        <th scope="col" class="px-6 py-3">Puesto</th>
                        <th scope="col" class="px-6 py-3">Departamento</th>
                        <th scope="col" class="px-6 py-3">Cargo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($puestos as $puesto)
                        <tr
                            class="border-b even:bg-gray-100 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium  whitespace-nowrap dark:text-white">
                                {{ $puesto->codigo_puesto }}</td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                                {{ $puesto->nombre_puesto }}</td>
                            <td class="px-6 py-4">{{ $puesto->departamento->nombre_departamento }}</td>
                            <td class="px-6 py-4">{{ $puesto->cargo->nombre_cargo }}</td>
                            <td class="px6 -py-4">
                                <form action="{{ route('puestos.destroy', $puesto->id) }}" method="POST">
                                    <a class="btn btn-sm btn-success" href="{{ route('puestos.edit', $puesto->id) }}"><i
                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                    @csrf
                                    
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $puestos->links() !!}

@endsection
