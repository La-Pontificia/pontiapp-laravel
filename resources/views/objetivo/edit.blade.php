{{-- @extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Objetivo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Objetivo</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('objetivos.update', $objetivo->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('objetivo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection --}}

<section class="content container-fluid">
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ __('Update') }} Objetivo</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('objetivos.update', $objetivo->id) }}" role="form"
                        enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('objetivo.form')
                        <div
                            class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save
                                all</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
