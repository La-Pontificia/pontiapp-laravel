@extends('layouts.app')

@section('template_title')
    Eda Colab
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Eda Colab') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('eda-colabs.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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
                                        
										<th>Id Eda</th>
										<th>Id Colaborador</th>
										<th>Estado</th>
										<th>Cant Obj</th>
										<th>Nota Final</th>
										<th>Wearing</th>
										<th>F Envio</th>
										<th>F Aprobacion</th>
										<th>F Cerrado</th>
										<th>Flimit Send Obj From</th>
										<th>Flimit Send Obj At</th>
										<th>Flimit White Autoeva From</th>
										<th>Flimit White Autoeva At</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($edaColabs as $edaColab)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $edaColab->id_eda }}</td>
											<td>{{ $edaColab->id_colaborador }}</td>
											<td>{{ $edaColab->estado }}</td>
											<td>{{ $edaColab->cant_obj }}</td>
											<td>{{ $edaColab->nota_final }}</td>
											<td>{{ $edaColab->wearing }}</td>
											<td>{{ $edaColab->f_envio }}</td>
											<td>{{ $edaColab->f_aprobacion }}</td>
											<td>{{ $edaColab->f_cerrado }}</td>
											<td>{{ $edaColab->flimit_send_obj_from }}</td>
											<td>{{ $edaColab->flimit_send_obj_at }}</td>
											<td>{{ $edaColab->flimit_white_autoeva_from }}</td>
											<td>{{ $edaColab->flimit_white_autoeva_at }}</td>

                                            <td>
                                                <form action="{{ route('eda-colabs.destroy',$edaColab->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('eda-colabs.show',$edaColab->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('eda-colabs.edit',$edaColab->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $edaColabs->links() !!}
            </div>
        </div>
    </div>
@endsection
