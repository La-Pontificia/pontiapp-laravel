@extends('layouts.maintenance')

@section('template_title')
    {{ $puesto->name ?? "{{ __('Show') Puesto" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Puesto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('puestos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Codigo Puesto:</strong>
                            {{ $puesto->codigo_puesto }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre Puesto:</strong>
                            {{ $puesto->nombre_puesto }}
                        </div>
                        <div class="form-group">
                            <strong>Id Departamento:</strong>
                            {{ $puesto->id_departamento }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
