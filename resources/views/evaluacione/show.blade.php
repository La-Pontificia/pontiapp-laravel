@extends('layouts.app')

@section('template_title')
    {{ $evaluacione->name ?? "{{ __('Show') Evaluacione" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Evaluacione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('evaluaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Promedio:</strong>
                            {{ $evaluacione->promedio }}
                        </div>
                        <div class="form-group">
                            <strong>Autocalificacion:</strong>
                            {{ $evaluacione->autocalificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Cerrado:</strong>
                            {{ $evaluacione->cerrado }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Promedio:</strong>
                            {{ $evaluacione->fecha_promedio }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Autocalificacion:</strong>
                            {{ $evaluacione->fecha_autocalificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Cerrado:</strong>
                            {{ $evaluacione->fecha_cerrado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
