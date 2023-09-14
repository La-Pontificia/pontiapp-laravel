@extends('layouts.app')

@section('template_title')
    {{-- {{ $colaboradore->name ?? "{{ __('Show') Colaboradore" }} --}}
@endsection

@section('content')
    {{-- <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Colaboradore</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('colaboradores.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Dni:</strong>
                            {{ $colaboradore->dni }}
                        </div>
                        <div class="form-group">
                            <strong>Apellidos:</strong>
                            {{ $colaboradore->apellidos }}
                        </div>
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {{ $colaboradore->nombres }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $colaboradore->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Id Cargo:</strong>
                            {{ $colaboradore->id_cargo }}
                        </div>
                        <div class="form-group">
                            <strong>Id Puesto:</strong>
                            {{ $colaboradore->id_puesto }}
                        </div>
                        <div class="form-group">
                            <strong>Id Usuario:</strong>
                            {{ $colaboradore->id_usuario }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
