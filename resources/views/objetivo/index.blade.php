@extends('layouts.app')

@section('template_title')
    Objetivo
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Objetivo') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('objetivos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Id Colaborador</th>
										<th>Objetivo</th>
										<th>Descripcion</th>
										<th>Porcentaje</th>
										<th>Indicadores</th>
										<th>Fecha Vencimiento</th>
										<th>Puntaje 01</th>
										<th>Fecha Calificacion 1</th>
										<th>Fecha Aprobacion 1</th>
										<th>Puntaje 02</th>
										<th>Fecha Calificacion 2</th>
										<th>Fecha Aprobacion 2</th>
										<th>Aprobado</th>
										<th>Aprovado Ev 1</th>
										<th>Aprovado Ev 2</th>
										<th>Año Actividad</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objetivos as $objetivo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $objetivo->id_colaborador }}</td>
											<td>{{ $objetivo->objetivo }}</td>
											<td>{{ $objetivo->descripcion }}</td>
											<td>{{ $objetivo->porcentaje }}</td>
											<td>{{ $objetivo->indicadores }}</td>
											<td>{{ $objetivo->fecha_vencimiento }}</td>
											<td>{{ $objetivo->puntaje_01 }}</td>
											<td>{{ $objetivo->fecha_calificacion_1 }}</td>
											<td>{{ $objetivo->fecha_aprobacion_1 }}</td>
											<td>{{ $objetivo->puntaje_02 }}</td>
											<td>{{ $objetivo->fecha_calificacion_2 }}</td>
											<td>{{ $objetivo->fecha_aprobacion_2 }}</td>
											<td>{{ $objetivo->aprobado }}</td>
											<td>{{ $objetivo->aprovado_ev_1 }}</td>
											<td>{{ $objetivo->aprovado_ev_2 }}</td>
											<td>{{ $objetivo->año_actividad }}</td>

                                            <td>
                                                <form action="{{ route('objetivos.destroy',$objetivo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('objetivos.show',$objetivo->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('objetivos.edit',$objetivo->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $objetivos->links() !!}
            </div>
        </div>
    </div>
@endsection
