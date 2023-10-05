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
                                        
										<th>Id Supervisor</th>
										<th>Id Eda Colab</th>
										<th>Objetivo</th>
										<th>Descripcion</th>
										<th>Indicadores</th>
										<th>Porcentaje</th>
										<th>Autoevaluacion</th>
										<th>Nota</th>
										<th>Editado</th>
										<th>Nota Fecha</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objetivos as $objetivo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $objetivo->id_supervisor }}</td>
											<td>{{ $objetivo->id_eda_colab }}</td>
											<td>{{ $objetivo->objetivo }}</td>
											<td>{{ $objetivo->descripcion }}</td>
											<td>{{ $objetivo->indicadores }}</td>
											<td>{{ $objetivo->porcentaje }}</td>
											<td>{{ $objetivo->autoevaluacion }}</td>
											<td>{{ $objetivo->nota }}</td>
											<td>{{ $objetivo->editado }}</td>
											<td>{{ $objetivo->nota_fecha }}</td>

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
