@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Eda Colab
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Eda Colab</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('eda-colabs.update', $edaColab->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('eda-colab.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
