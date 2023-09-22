@extends('layouts.sidebar')


@section('content-sidebar')
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
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('areas.store') }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                @include('area.form')
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Cerrar</button>
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
                    @endif


                    

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                        <tr class="border-b even:bg-gray-100
                                         bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            {{-- <td>{{ ++$i }}</td> --}}
                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $area->codigo_area }}</td>
                                            <td class="px-6 py-4">{{ $area->nombre_area }}</td>
                                            {{-- <td class="px-6 py-4">{{ $area->created_at }}</td>
                                            <td class="px-6 py-4">{{ $area->updated_at }}</td> --}}
                                            <td class="px-6 py-4">
                                                <form action="{{ route('areas.destroy', $area->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('areas.edit', $area->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                
                                
                            </tbody>
                        </table>
                    </div>


                    
                </div>
                {!! $areas->links() !!}
            </div>
        </div>
    </div>
@endsection
