@extends('layouts.headers')

@section('title', 'Docs')

@section('app')
    <div class="min-h-svh bg-stone-950 text-stone-100 flex flex-col overflow-y-auto ">
        @include('docs.header')
        <div class="max-w-7xl flex-grow mx-auto w-full">
            @yield('content')
        </div>
        @include('docs.footer')
    </div>
@endsection
