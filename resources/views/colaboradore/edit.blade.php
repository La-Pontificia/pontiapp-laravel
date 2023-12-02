@extends('layouts.sidebar')

@section('content-sidebar')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Colaboradore</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('colaboradores.update', $colaboradore->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('colaboradore.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
