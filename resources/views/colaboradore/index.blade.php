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

                            <span id="card_title">
                                {{ __('Lista de colaboradores') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('colaboradores.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
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
                                            <td>{{ $colaboradore->estado }}</td>
                                            <td>{{ $colaboradore->cargo->nombre_cargo }}</td>
                                            <td>{{ $colaboradore->puesto->nombre_puesto }}</td>
                                            <td>{{ $colaboradore->user->email }}</td>

                                            <td>
                                                <form action="{{ route('colaboradores.destroy', $colaboradore->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('colaboradores.show', $colaboradore->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('colaboradores.edit', $colaboradore->id) }}"><i
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
                {!! $colaboradores->links() !!}
            </div>
        </div>
    </div>
@endsection
