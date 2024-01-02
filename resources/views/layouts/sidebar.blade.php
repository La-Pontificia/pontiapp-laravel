@extends('layouts.app')

@section('content')
    <div class="w-full h-full pl-[250px] max-sm:pl-0 pt-[70px]">
        <section class="p-4 max-sm:p-2">
            @yield('content-sidebar')
        </section>
    </div>
@endsection
