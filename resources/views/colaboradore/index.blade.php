@extends('layouts.app')

@section('template_title')
    Colaboradore
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
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
                                    @foreach ($colaboradores as $colaboradore)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $colaboradore->dni }}</td>
                                            <td>{{ $colaboradore->apellidos }}</td>
                                            <td>{{ $colaboradore->nombres }}</td>
                                            <td>
                                                @if ($colaboradore->estado == 1)
                                                    <span class="badge text-bg-success">Activo</span>
                                                @else
                                                    <span class="badge text-bg-secondary">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>{{ $colaboradore->cargo->nombre_cargo }}</td>
                                            <td>{{ $colaboradore->puesto->nombre_puesto }}</td>
                                            <td>{{ $colaboradore->user->email }}</td>
                                            <td>
                                                <form action="{{ route('colaboradores.destroy', $colaboradore->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('colaboradores.edit', $colaboradore->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                    <a class="btn btn-sm btn-black"
                                                        href="{{ route('colaboradores.edit', $colaboradore->id) }}"> <i
                                                            style="font-size: 30px"
                                                            class="fa-solid fa-universal-access"></i></a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $colaboradores->links() !!}
            </div>
        </div>
    </div>
@endsection
