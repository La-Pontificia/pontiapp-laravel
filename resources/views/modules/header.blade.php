<nav class="bg-[#f2f2f2] shadow-md shadow-black/20 text-blue-700 h-14 w-full z-30">
    <div class="flex w-full gap-5 items-center h-full px-3">
        <div class="flex-grow flex ml-14 max-lg:ml-0 text-neutral-800 items-center gap-3">
            <button class="lg:hidden block" id="sidebar-button">
                @svg('fluentui-line-horizontal-3-20', 'w-6 h-6')
            </button>
            <a href="/" class="px-2 flex items-center gap-2 text-blue-600 font-semibold tracking-tight text-base">
                <img src="/elp.webp" class="w-20" />
                <span class="max-sm:hidden">
                    Edas y Asistencias
                </span>
            </a>
        </div>
        <button>
            @svg('fluentui-settings-20-o', 'w-6 h-6')
        </button>
        <button>
            @svg('fluentui-alert-28-o', 'w-6 h-6')
        </button>
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
        <div class="z-50 w-[320px] hidden text-black bg-white overflow-hidden pointer-events-auto border text-sm list-none shadow-2xl"
            id="user-dropdown">
            <div class="flex p-3 pb-0 items-center ">
                <div class="flex items-center flex-grow gap-2">
                    <img src="/elp.webp" class="w-20 " />
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
