@extends('layouts.app')

@section('template_title')
    {{ $cargo->name ?? "{{ __('Show') Cargo" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Cargo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('cargos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Codigo Cargo:</strong>
                            {{ $cargo->codigo_cargo }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre Cargo:</strong>
                            {{ $cargo->nombre_cargo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
