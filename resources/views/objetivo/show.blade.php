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
                            <strong>Id Supervisor:</strong>
                            {{ $objetivo->id_supervisor }}
                        </div>
                        <div class="form-group">
                            <strong>Id Eda Colab:</strong>
                            {{ $objetivo->id_eda_colab }}
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
                            <strong>Autoevaluacion:</strong>
                            {{ $objetivo->autoevaluacion }}
                        </div>
                        <div class="form-group">
                            <strong>Nota:</strong>
                            {{ $objetivo->nota }}
                        </div>
                        <div class="form-group">
                            <strong>Editado:</strong>
                            {{ $objetivo->editado }}
                        </div>
                        <div class="form-group">
                            <strong>Nota Fecha:</strong>
                            {{ $objetivo->nota_fecha }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
