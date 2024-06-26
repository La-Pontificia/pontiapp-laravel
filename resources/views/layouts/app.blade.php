@extends('layouts.headers')

@section('title', 'Dashboard')

@section('app')
    <div id="app" class="h-svh flex flex-col overflow-y-auto ">
        @guest
            @if (Route::has('login'))
                <main class="min-h-screen bg-[#fffdfc]">
                    @yield('content')
                </main>
            @endif
        @else
            <div id="app" class="flex flex-col h-full flex-grow overflow-y-auto">
                @include('components.header')
                <main class="flex h-full overflow-auto">
                    @include('components.sidebar')
                    <div class="overflow-auto w-full flex-grow p-2 flex flex-col h-full">
                        @yield('content')
                    </div>
                </main>

            </div>
        @endguest
    </div>
@endsection
