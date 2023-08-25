@extends('layouts.app')

@section('template_title')
    {{ $acceso->name ?? "{{ __('Show') Acceso" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Acceso</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('accesos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Modulo:</strong>
                            {{ $acceso->modulo }}
                        </div>
                        <div class="form-group">
                            <strong>Acceso:</strong>
                            {{ $acceso->acceso }}
                        </div>
                        <div class="form-group">
                            <strong>Id Colaborador:</strong>
                            {{ $acceso->id_colaborador }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
