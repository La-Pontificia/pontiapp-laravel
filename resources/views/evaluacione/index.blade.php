@extends('layouts.app')

@section('template_title')
    Evaluacione
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Evaluacione') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Promedio</th>
										<th>Autocalificacion</th>
										<th>Cerrado</th>
										<th>Fecha Promedio</th>
										<th>Fecha Autocalificacion</th>
										<th>Fecha Cerrado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($evaluaciones as $evaluacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $evaluacione->promedio }}</td>
											<td>{{ $evaluacione->autocalificacion }}</td>
											<td>{{ $evaluacione->cerrado }}</td>
											<td>{{ $evaluacione->fecha_promedio }}</td>
											<td>{{ $evaluacione->fecha_autocalificacion }}</td>
											<td>{{ $evaluacione->fecha_cerrado }}</td>

                                            <td>
                                                <form action="{{ route('evaluaciones.destroy',$evaluacione->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('evaluaciones.show',$evaluacione->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('evaluaciones.edit',$evaluacione->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $evaluaciones->links() !!}
            </div>
        </div>
    </div>
@endsection
