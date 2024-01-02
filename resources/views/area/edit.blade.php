@extends('layouts.sidebar')

@section('content-sidebar')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Area</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('areas.update', $area->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('area.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
