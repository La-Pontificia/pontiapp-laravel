@extends('layouts.app')

@section('template_title')
    {{ $calificacione->name ?? "{{ __('Show') Calificacione" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Calificacione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('calificaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Objetivo:</strong>
                            {{ $calificacione->id_objetivo }}
                        </div>
                        <div class="form-group">
                            <strong>Id Supervisor:</strong>
                            {{ $calificacione->id_supervisor }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Aprobacion:</strong>
                            {{ $calificacione->fecha_aprobacion }}
                        </div>
                        <div class="form-group">
                            <strong>Aprobado:</strong>
                            {{ $calificacione->aprobado }}
                        </div>
                        <div class="form-group">
                            <strong>Pun 01:</strong>
                            {{ $calificacione->pun_01 }}
                        </div>
                        <div class="form-group">
                            <strong>Eva 01:</strong>
                            {{ $calificacione->eva_01 }}
                        </div>
                        <div class="form-group">
                            <strong>Apr 01:</strong>
                            {{ $calificacione->apr_01 }}
                        </div>
                        <div class="form-group">
                            <strong>F Apr 01:</strong>
                            {{ $calificacione->f_apr_01 }}
                        </div>
                        <div class="form-group">
                            <strong>F Eva 01:</strong>
                            {{ $calificacione->f_eva_01 }}
                        </div>
                        <div class="form-group">
                            <strong>C 01:</strong>
                            {{ $calificacione->c_01 }}
                        </div>
                        <div class="form-group">
                            <strong>Pun 02:</strong>
                            {{ $calificacione->pun_02 }}
                        </div>
                        <div class="form-group">
                            <strong>Eva 02:</strong>
                            {{ $calificacione->eva_02 }}
                        </div>
                        <div class="form-group">
                            <strong>Apr 02:</strong>
                            {{ $calificacione->apr_02 }}
                        </div>
                        <div class="form-group">
                            <strong>F Apr 02:</strong>
                            {{ $calificacione->f_apr_02 }}
                        </div>
                        <div class="form-group">
                            <strong>F Eva 02:</strong>
                            {{ $calificacione->f_eva_02 }}
                        </div>
                        <div class="form-group">
                            <strong>C 02:</strong>
                            {{ $calificacione->c_02 }}
                        </div>
                        <div class="form-group">
                            <strong>C Eda:</strong>
                            {{ $calificacione->c_eda }}
                        </div>
                        <div class="form-group">
                            <strong>C F Eda:</strong>
                            {{ $calificacione->c_f_eda }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
