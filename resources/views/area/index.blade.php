@extends('layouts.sidebar')

@section('content-sidebar')
    <!-- Modal toggle -->
    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Nueva Area
    </button>

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
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Registrar Areas</h3>
                    {{-- <form action="" method="POST">
                        @csrf
                        
                    </form> --}}
                    <div class="card-body">
                        <form method="POST" action="{{ route('areas.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- @include('area.form') --}}
                            {{-- <div>
                                <label for="codigo"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo</label>
                                <input name="codigo_area" type="text" id="codigo"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="" required>
                            </div> --}}

                            <div>
                                <label for="nueva area"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nueva Area</label>
                                <input name="nombre_area" type="text" id="nueva area"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="" required>
                            </div>
                            <footer class="pt-4">
                                <button type="submit"
                                    class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Registrar</button>
                                {{-- <button type="button"
                                    class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Cerrar</button> --}}
                            </footer>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






    {{-- @section('content-sidebar')
    <div class="container-fluid">
        <div class="row">
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva area</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                           fdssd </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('areas.store') }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                @include('area.form')
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Areas') }}
                            </span>

                            <button type="button"
                                class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Crear
                                Nuevo
                            </button>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif --}}




    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs  uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Codigo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>


            <tbody>

                @foreach ($areas as $area)
                    <tr class="border-b even:bg-gray-100 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        {{-- <td>{{ ++$i }}</td> --}}
                        <td class="px-6 py-4 font-medium  whitespace-nowrap dark:text-white">
                            {{ $area->codigo_area }}</td>
                        <td class="px-6 py-4">
                            {{ $area->nombre_area }}</td>
                        {{-- <td class="px-6 py-4">{{ $area->created_at }}</td>
                                            <td class="px-6 py-4">{{ $area->updated_at }}</td> --}}
                        <td class="px-6 py-4">
                            <form action="{{ route('areas.destroy', $area->id) }}" method="POST">
                                <a class="btn btn-sm btn-success" href="{{ route('areas.edit', $area->id) }}"><i
                                        class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                @csrf
                                
                            </form>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>




    {!! $areas->links() !!}
@endsection
