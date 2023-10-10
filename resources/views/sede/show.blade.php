@extends('layouts.app')

@section('template_title')
    {{ $sede->name ?? "{{ __('Show') Sede" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Sede</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('sedes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $sede->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Direccion:</strong>
                            {{ $sede->direccion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
