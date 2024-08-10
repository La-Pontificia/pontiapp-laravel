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
                    <aside class="flex flex-col min-w-[60px] transition-all h-full overflow-y-auto" aria-label="Sidebar">
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
                        <footer class="p-5 max-xl:hidden max-w-[300px] hover:[&>a]:underline text-xs text-black text-center">
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
                    <div class="overflow-auto w-full flex-grow p-2 max-xl:pl-0 flex flex-col h-full">
                        @yield('content')
                    </div>
                </main>
            </div>
        @endguest
    </div>
@endsection
