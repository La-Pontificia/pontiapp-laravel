@extends('layouts.sidebar')

@section('content-sidebar')
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
                    <td>{{ $acceso->modulo }}</td>
                    <td>
                        <button class="btn disable-access {{ $acceso->acceso == 1 ? 'btn-success' : 'btn-default' }}"
                            data-id="{{ $acceso->id }}">
                            {{ $acceso->acceso == 1 ? 'Y' : 'N' }}
                        </button>
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
@endsection
