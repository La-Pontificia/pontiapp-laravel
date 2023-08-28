@extends('layouts.maintenance')

@section('template_title')
    Acceso
@endsection

@section('content-2')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Accesos') }}
                            </span>
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
                                        <th>Modulo</th>
                                        <th>Acceso</th>
                                        <th>Colaborador</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accesos as $acceso)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $acceso->modulo }}</td>
                                            <td>
                                                @if ($acceso->acceso == 1)
                                                    <a style="font-size: 15px" class="badge btn text-bg-success"
                                                        href="{{ route('accesos.disable', $acceso->id) }}"
                                                        class="btn btn-primary">Y</a>
                                                @else
                                                    <a style="font-size: 15px" class="badge btn text-bg-light"
                                                        href="{{ route('accesos.disable', $acceso->id) }}"
                                                        class="btn btn-primary">N</a>
                                                @endif
                                            </td>
                                            <td>{{ $acceso->colaboradore->nombres }} {{ $acceso->colaboradore->apellidos }}
                                            </td>
                                            <td>
                                                {{-- <form action="{{ route('accesos.destroy', $acceso->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('accesos.edit', $acceso->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $accesos->links() !!}
            </div>
        </div>
    </div>
@endsection
