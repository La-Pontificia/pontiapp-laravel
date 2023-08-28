@extends('layouts.maintenance')

@section('template_title')
    Puesto
@endsection

@section('content-2')
    <div class="container-fluid">
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
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>N°</th>
                                        <th>Codigo </th>
                                        <th>Nombre </th>
                                        <th>Departamento</th>
                                        <th>Registro</th>
                                        <th>Actualización</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($puestos as $puesto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $puesto->codigo_puesto }}</td>
                                            <td>{{ $puesto->nombre_puesto }}</td>
                                            <td>{{ $puesto->departamento->nombre_departamento }}</td>
                                            <td>{{ $puesto->created_at }}</td>
                                            <td>{{ $puesto->updated_at }}</td>
                                            <td>
                                                <form action="{{ route('puestos.destroy', $puesto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('puestos.edit', $puesto->id) }}"><i
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
                </div>
                {!! $puestos->links() !!}
            </div>
        </div>
    </div>
@endsection
