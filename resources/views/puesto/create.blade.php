@extends('layouts.maintenance')

@section('template_title')
    {{ __('Create') }} Puesto
@endsection

@section('content-2')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Puesto</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('puestos.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('puesto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
