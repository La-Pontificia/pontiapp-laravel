@extends('layouts.app')

@section('template_title')
    {{ $objetivo->name ?? "{{ __('Show') Objetivo" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Objetivo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('objetivos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong> Id Colaborador:</strong>
                            {{ $objetivo->id_colaborador }}
                        </div>
                        <div class="form-group">
                            <strong>Objetivo:</strong>
                            {{ $objetivo->objetivo }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $objetivo->descripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Porcentaje:</strong>
                            {{ $objetivo->porcentaje }}
                        </div>
                        <div class="form-group">
                            <strong>Indicadores:</strong>
                            {{ $objetivo->indicadores }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Vencimiento:</strong>
                            {{ $objetivo->fecha_vencimiento }}
                        </div>
                        <div class="form-group">
                            <strong>Puntaje 01:</strong>
                            {{ $objetivo->puntaje_01 }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Calificacion 1:</strong>
                            {{ $objetivo->fecha_calificacion_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Aprobacion 1:</strong>
                            {{ $objetivo->fecha_aprobacion_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Puntaje 02:</strong>
                            {{ $objetivo->puntaje_02 }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Calificacion 2:</strong>
                            {{ $objetivo->fecha_calificacion_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Aprobacion 2:</strong>
                            {{ $objetivo->fecha_aprobacion_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Aprobado:</strong>
                            {{ $objetivo->aprobado }}
                        </div>
                        <div class="form-group">
                            <strong>Aprovado Ev 1:</strong>
                            {{ $objetivo->aprovado_ev_1 }}
                        </div>
                        <div class="form-group">
                            <strong>Aprovado Ev 2:</strong>
                            {{ $objetivo->aprovado_ev_2 }}
                        </div>
                        <div class="form-group">
                            <strong>Año Actividad:</strong>
                            {{ $objetivo->año_actividad }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
