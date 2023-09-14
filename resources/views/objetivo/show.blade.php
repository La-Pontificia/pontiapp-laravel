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
                            <strong>Id Colaborador:</strong>
                            {{ $objetivo->id_colaborador }}
                        </div>
                        <div class="form-group">
                            <strong>Id Supervisor:</strong>
                            {{ $objetivo->id_supervisor }}
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
                            <strong>Indicadores:</strong>
                            {{ $objetivo->indicadores }}
                        </div>
                        <div class="form-group">
                            <strong>Porcentaje:</strong>
                            {{ $objetivo->porcentaje }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $objetivo->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Estado Fecha:</strong>
                            {{ $objetivo->estado_fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Feedback:</strong>
                            {{ $objetivo->feedback }}
                        </div>
                        <div class="form-group">
                            <strong>Feedback Fecha:</strong>
                            {{ $objetivo->feedback_fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Nota Colab:</strong>
                            {{ $objetivo->nota_colab }}
                        </div>
                        <div class="form-group">
                            <strong>Nota Super:</strong>
                            {{ $objetivo->nota_super }}
                        </div>
                        <div class="form-group">
                            <strong>Nota Super Fecha:</strong>
                            {{ $objetivo->nota_super_fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Eva:</strong>
                            {{ $objetivo->eva }}
                        </div>
                        <div class="form-group">
                            <strong>Año:</strong>
                            {{ $objetivo->año }}
                        </div>
                        <div class="form-group">
                            <strong>Notify Super:</strong>
                            {{ $objetivo->notify_super }}
                        </div>
                        <div class="form-group">
                            <strong>Notify Colab:</strong>
                            {{ $objetivo->notify_colab }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
