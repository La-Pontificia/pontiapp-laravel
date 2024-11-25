<nav class="bg-[#f5f0f0] shadow-md shadow-black/20 text-blue-700 h-14 w-full z-30">
    <div class="flex w-full justify-between gap-5 items-center h-full px-3">
        <div class="flex-grow basis-0 flex ml-14 max-lg:ml-0 text-neutral-800 items-center gap-3">
            <button class="lg:hidden block" id="sidebar-button">
                @svg('fluentui-line-horizontal-3-20', 'w-6 h-6')
            </button>
            <a href="/" class="px-2 flex items-center gap-2 text-blue-600 font-semibold tracking-tight text-base">
                <img src="/lp.webp" class="w-28" />
                <span class="max-sm:hidden">
                    La Pontificia
                </span>
            </a>
        </div>
        @include('modules.search')
        <nav class="flex-grow basis-0 justify-end flex items-center gap-4">
            <button class="max-md:block hidden" id="search-button">
                @svg('fluentui-search-28-o', 'w-6 h-6')
            </button>
            {{-- <a title="Guía del usuario" href="/docs/user-guide"
                class="md:p-2 md:py-1 md:hover:bg-blue-500/10 font-semibold text-sm text-nowrap flex items-center gap-1 rounded-md border-blue-500 text-blue-600 md:border">
                @svg('fluentui-book-contacts-20-o', 'w-6 h-6')
                <p class="max-md:hidden">
                    Guia
                </p>
            </a> --}}
            <button title="Enviar bug o sugerencia">
                @svg('fluentui-person-feedback-20-o', 'w-6 h-6')
            </button>
            <button title="Notificaciones" id="user-notify-button" aria-expanded="false"
                data-dropdown-toggle="user-notify" data-dropdown-placement="bottom">
                @svg('fluentui-alert-28-o', 'w-6 h-6')
            </button>
            <div class="z-50 hidden p-2" id="user-notify">
                <div
                    class="p-5 rounded-lg h-[300px] w-[320px] text-black bg-white overflow-hidden pointer-events-auto text-sm  shadow-2xl">
                    <div class="h-full w-full grid place-content-center text-center">
                        <div class="text-sm">
                            @svg('fluentui-channel-alert-20', 'w-10 h-10 text-stone-200 mx-auto')
                            <p>
                                No tienes notificaciones
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="flex items-center gap-2" id="user-menu-button" aria-expanded="false"
                data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                @include('commons.avatar', [
                    'key' => $cuser->id,
                    'src' => $cuser->profile,
                    'className' => 'w-10',
                    'alt' => $cuser->names(),
                    'altClass' => 'text-sm',
                ])
            </button>
            <div class="z-50 hidden p-2" id="user-dropdown">
                <div
                    class="w-[320px] rounded-lg text-black bg-white overflow-hidden pointer-events-auto text-sm shadow-2xl">
                    <div class="flex p-3 pb-0 items-center ">
                        <div class="flex items-center flex-grow gap-2">
                            <img src="/lp.webp" class="w-20 " />
                        </div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="flex-none flex hover:underline">
                            Cerrar sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    <div class="flex items-center p-5 gap-4">
                        @include('commons.avatar', [
                            'src' => $cuser->profile,
                            'className' => 'w-28',
                            'alt' => $cuser->names(),
                            'altClass' => 'text-3xl',
                        ])
                        <div>
                            <p class="line-clamp-1 font-semibold text-xl tracking-tight">
                                {{ $cuser->first_name }}
                                {{ $cuser->last_name }}</p>
                            <p class="line-clamp-1 opacity-70 text-sm">{{ $cuser->email }}</p>
                            <p>
                                <a class="text-blue-600 hover:underline" href="/users/{{ $cuser->id }}">Mi cuenta</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</nav>
