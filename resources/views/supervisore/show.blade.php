@extends('layouts.app')

@section('template_title')
    {{ $supervisore->name ?? "{{ __('Show') Supervisore" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Supervisore</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('supervisores.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Colaborador:</strong>
                            {{ $supervisore->id_colaborador }}
                        </div>
                        <div class="form-group">
                            <strong>Id Supervisor:</strong>
                            {{ $supervisore->id_supervisor }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
