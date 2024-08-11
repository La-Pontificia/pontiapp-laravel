@extends('layouts.headers')

@section('title', 'Dashboard')

@section('app')
    <div id="app" class="h-svh flex flex-col overflow-y-auto ">
        @guest
            @if (Route::has('login'))
                <main class="min-h-screen">
                    @yield('content')
                </main>
            @endif
        @else
            <div id="app" class="flex flex-col h-full flex-grow overflow-y-auto">
                @include('modules.header')
                <main class="flex h-full overflow-auto">
                    <aside id="sidebar"
                        class="flex peer flex-col max-lg:top-0 bg-white min-w-[300px] text-sm font-medium max-lg:-translate-x-full max-lg:shadow-lg max-lg:absolute z-40 transition-all h-full overflow-y-auto">
                        <div class="p-5 pb-3 lg:hidden block">
                            <a href="/"><img src="/lp.webp" class="w-24" /></a>
                        </div>
                        <div class="flex-grow overflow-y-auto">
                            @if (request()->is('/'))
                                @include('modules.sidebar')
                            @elseif(request()->is('users*'))
                                @include('modules.users.sidebar')
                            @elseif(request()->is('edas*'))
                                @include('modules.edas.sidebar')
                            @elseif(request()->is('assists*'))
                                @include('modules.assists.sidebar')
                            @elseif(request()->is('settings*'))
                                @include('modules.settings.sidebar')
                            @endif
                        </div>
                        <footer class="p-5 font-normal max-w-[300px] hover:[&>a]:underline text-xs text-black text-center">
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
                    </aside>
                    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 hidden z-30"></div>
                    <div class="overflow-auto w-full flex-grow p-2 pt-0 max-md:p-4 flex flex-col h-full">
                        @yield('content')
                    </div>
                </main>
            </div>
        @endguest
    </div>
@endsection
