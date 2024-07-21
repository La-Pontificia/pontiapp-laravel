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
                @include('modules.header')
                <main class="flex h-full overflow-auto">
                    <aside id="cta-sidebar"
                        class="z-40 w-[270px] min-w-[270px] transition-all h-full max-md:top-12 max-md:bg-white max-md:border-r overflow-y-auto max-md:-translate-x-full max-md:fixed"
                        aria-label="Sidebar">
                        <div class="h-full pr-0 flex flex-col">
                            <div class="flex-grow">
                                @if (request()->is('/'))
                                    @include('modules.sidebar')
                                @elseif(request()->is('users*'))
                                    @include('modules.users.sidebar')
                                @elseif(request()->is('edas*'))
                                    @include('modules.edas.sidebar')
                                @elseif(request()->is('assists*'))
                                    @include('modules.assists.sidebar')
                                @endif
                            </div>
                            <footer class="p-5 hover:[&>a]:underline text-xs text-black text-center">
                                <a href="">
                                    Terminos y condiciones
                                </a>
                                ·
                                <a href="">
                                    Política de privacidad
                                </a>
                                ·
                                <a href="">
                                    Ayuda
                                </a>
                                ·
                                <a target="_blank" href="https://daustinn.com">
                                    Daustinn
                                </a>
                            </footer>
                        </div>
                    </aside>
                    <div class="overflow-auto w-full flex-grow p-2 flex flex-col h-full">
                        @yield('content')
                    </div>
                </main>
            </div>
        @endguest
    </div>
@endsection
