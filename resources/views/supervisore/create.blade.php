@extends('layouts.sidebar')
@section('content-sidebar')
    <section class="content  container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')
                <form method="POST" action="{{ route('supervisores.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    @include('supervisore.form')
                </form>
            </div>
        </div>
    </section>
@endsection
