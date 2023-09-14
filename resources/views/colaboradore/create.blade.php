@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Colaboradore
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Registro de colaboradores') }} </span>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
