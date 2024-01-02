@extends('layouts.sidebar')

@section('content-sidebar')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')
                 
                <div class="card card-default">
                    
                    <div class="card-body">
                        <form class="w-[500px]" method="POST" action="{{ route('cargos.update', $cargo->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('cargo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
