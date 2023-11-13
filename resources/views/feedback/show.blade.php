@extends('layouts.app')

@section('template_title')
    {{ $feedback->name ?? "{{ __('Show') Feedback" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Feedback</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('feedback.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Emisor:</strong>
                            {{ $feedback->id_emisor }}
                        </div>
                        <div class="form-group">
                            <strong>Id Evaluacion:</strong>
                            {{ $feedback->id_evaluacion }}
                        </div>
                        <div class="form-group">
                            <strong>Feedback:</strong>
                            {{ $feedback->feedback }}
                        </div>
                        <div class="form-group">
                            <strong>Calificacion:</strong>
                            {{ $feedback->calificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Recibido:</strong>
                            {{ $feedback->recibido }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Recibido:</strong>
                            {{ $feedback->fecha_recibido }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
