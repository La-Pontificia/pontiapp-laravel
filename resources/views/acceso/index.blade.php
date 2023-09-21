@extends('layouts.sidebar')

@section('content-sidebar')
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
                                                <button
                                                    class="btn disable-access {{ $acceso->acceso == 1 ? 'btn-success' : 'btn-default' }}"
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
                        </div>
                    </div>
                </div>
                {!! $accesos->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.disable-access').on('click', function() {
                var button = $(this); // Captura el botón que se hizo clic
                var id = button.data('id');
                $.ajax({
                    url: `/accesos/${id}/disable`,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Actualiza el botón y su texto según el nuevo estado
                        if (response.acceso == 1) {
                            button.removeClass('btn-success').addClass('btn-default').text('N');
                        } else {
                            button.removeClass('btn-default').addClass('btn-success').text('Y');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
