@extends('layouts.app')

@section('template_title')
    Feedback
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Feedback') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('feedback.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Id Emisor</th>
										<th>Id Eda Colab</th>
										<th>Feedback</th>
										<th>Calificacion</th>
										<th>Recibido</th>
										<th>Fecha Recibido</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feedback as $feedback)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $feedback->id_emisor }}</td>
											<td>{{ $feedback->id_eda_colab }}</td>
											<td>{{ $feedback->feedback }}</td>
											<td>{{ $feedback->calificacion }}</td>
											<td>{{ $feedback->recibido }}</td>
											<td>{{ $feedback->fecha_recibido }}</td>

                                            <td>
                                                <form action="{{ route('feedback.destroy',$feedback->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('feedback.show',$feedback->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('feedback.edit',$feedback->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $feedback->links() !!}
            </div>
        </div>
    </div>
@endsection
