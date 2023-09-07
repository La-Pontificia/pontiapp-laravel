@extends('layouts.app')

@section('template_title')
    Calificacione
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Calificacione') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('calificaciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Id Objetivo</th>
										<th>Id Supervisor</th>
										<th>Fecha Aprobacion</th>
										<th>Aprobado</th>
										<th>Pun 01</th>
										<th>Eva 01</th>
										<th>Apr 01</th>
										<th>F Apr 01</th>
										<th>F Eva 01</th>
										<th>C 01</th>
										<th>Pun 02</th>
										<th>Eva 02</th>
										<th>Apr 02</th>
										<th>F Apr 02</th>
										<th>F Eva 02</th>
										<th>C 02</th>
										<th>C Eda</th>
										<th>C F Eda</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calificaciones as $calificacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $calificacione->id_objetivo }}</td>
											<td>{{ $calificacione->id_supervisor }}</td>
											<td>{{ $calificacione->fecha_aprobacion }}</td>
											<td>{{ $calificacione->aprobado }}</td>
											<td>{{ $calificacione->pun_01 }}</td>
											<td>{{ $calificacione->eva_01 }}</td>
											<td>{{ $calificacione->apr_01 }}</td>
											<td>{{ $calificacione->f_apr_01 }}</td>
											<td>{{ $calificacione->f_eva_01 }}</td>
											<td>{{ $calificacione->c_01 }}</td>
											<td>{{ $calificacione->pun_02 }}</td>
											<td>{{ $calificacione->eva_02 }}</td>
											<td>{{ $calificacione->apr_02 }}</td>
											<td>{{ $calificacione->f_apr_02 }}</td>
											<td>{{ $calificacione->f_eva_02 }}</td>
											<td>{{ $calificacione->c_02 }}</td>
											<td>{{ $calificacione->c_eda }}</td>
											<td>{{ $calificacione->c_f_eda }}</td>

                                            <td>
                                                <form action="{{ route('calificaciones.destroy',$calificacione->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('calificaciones.show',$calificacione->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('calificaciones.edit',$calificacione->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $calificaciones->links() !!}
            </div>
        </div>
    </div>
@endsection
