@extends('layouts.app')

@section('template_title')
    {{ $eda->name ?? "{{ __('Show') Eda" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Eda</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('edas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Year:</strong>
                            {{ $eda->year }}
                        </div>
                        <div class="form-group">
                            <strong>N Evaluacion:</strong>
                            {{ $eda->n_evaluacion }}
                        </div>
                        <div class="form-group">
                            <strong>F Inicio:</strong>
                            {{ $eda->f_inicio }}
                        </div>
                        <div class="form-group">
                            <strong>F Fin:</strong>
                            {{ $eda->f_fin }}
                        </div>
                        <div class="form-group">
                            <strong>Wearing:</strong>
                            {{ $eda->wearing }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
