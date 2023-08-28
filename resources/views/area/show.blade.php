@extends('layouts.maintenance')

@section('template_title')
    {{ $area->name ?? "{{ __('Show') Area" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Area</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('areas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Codigo Area:</strong>
                            {{ $area->codigo_area }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre Area:</strong>
                            {{ $area->nombre_area }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
