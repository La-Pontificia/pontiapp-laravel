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
                <div id="sidebar-overlay" class="fixed data-[expanded]:block z-40 inset-0 bg-black/40 hidden">
                </div>
                <main class="flex h-full relative overflow-auto">
                    <aside id="sidebar"
                        class="flex peer flex-col max-lg:bg-[#fcfcfc] pt-2 max-lg:top-0 max-lg:pt-0 min-w-[300px] text-sm font-medium max-lg:-translate-x-full data-[expanded]:translate-x-0 max-lg:shadow-lg max-lg:fixed z-40 transition-all h-full overflow-y-auto">
                        <div class="p-5 pb-3 lg:hidden block">
                            <a href="/"><img src="/lp.webp" class="w-24" /></a>
                        </div>
                        <div class="flex-grow px-2 overflow-y-auto transition-all">
                            @include('modules.sidebar')
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
                    <div class="overflow-auto w-full p-2 pl-0 flex-grow flex flex-col h-full">
                        @yield('content')
                    </div>
                </main>
            </div>
        @endguest
    </div>

    <template id="item-supervisor-template">
        <button title="Seleccionar supervisor"
            class="flex w-full disabled:opacity-50 disabled:pointer-events-none text-left items-center gap-2 p-2 rounded-lg hover:bg-neutral-200">
            <div class="bg-neutral-300 overflow-hidden rounded-full w-8 h-8 aspect-square">
                <img src="" class="object-cover w-full h-full" alt="">
            </div>
            <div class="text-sm">
                <p class="result-title"></p>
                <p class="text-xs result-email"></p>
            </div>
        </button>
    </template>
@endsection
