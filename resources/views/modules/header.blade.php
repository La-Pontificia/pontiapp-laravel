<nav class="bg-white shadow-md shadow-black/20 text-blue-700 h-14 w-full z-30">
    <div class="flex w-full gap-5 items-center h-full px-3">
        <div class="flex-grow flex ml-14 max-lg:ml-0 text-neutral-800 items-center gap-3">
            <button class="lg:hidden block" id="sidebar-button">
                @svg('bx-menu', 'w-8 h-8')
            </button>
            <a href="/" class="px-2 flex items-center gap-2 text-blue-600 font-semibold tracking-tight text-base">
                <img src="/elp.webp" class="w-20" />
                <span class="max-sm:hidden">
                    Edas y Asistencias
                </span>
            </a>
        </div>
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bell">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
            </svg>
        </button>
        <button type="button" class="flex items-center gap-2" id="user-menu-button" aria-expanded="false"
            data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
            <div class="text-sm text-right flex flex-col overflow-hidden max-w-[150px]">
                <p class="line-clamp-1 leading-4 text-ellipsis max-md:hidden">
                    {{ $cuser->first_name }}
                    {{ $cuser->last_name }}</p>
            </div>
            @include('commons.avatar', [
                'src' => $cuser->profile,
                'className' => 'w-8',
                'alt' => $cuser->first_name . ' ' . $cuser->last_name,
                'altClass' => 'text-sm',
            ])
        </button>
        <div class="z-50 w-[320px] hidden text-black bg-white overflow-hidden pointer-events-auto border text-sm list-none shadow-2xl"
            id="user-dropdown">
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
                    'alt' => $cuser->first_name . ' ' . $cuser->last_name,
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
