@extends('layouts.app')

@section('template_title')
    {{ $notificacione->name ?? "{{ __('Show') Notificacione" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Notificacione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('notificaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Colaborador:</strong>
                            {{ $notificacione->id_colaborador }}
                        </div>
                        <div class="form-group">
                            <strong>Id Objetivo:</strong>
                            {{ $notificacione->id_objetivo }}
                        </div>
                        <div class="form-group">
                            <strong>Mensaje:</strong>
                            {{ $notificacione->mensaje }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
