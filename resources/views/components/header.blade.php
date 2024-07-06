<nav class=" bg-white border-b h-14 w-full z-30">
    <div class="flex w-full gap-5 items-center h-full px-3">
        <div class="flex-grow flex gap-2 items-center">
            <button id="toogle-sidebar" class="p-1 rounded-lg text-[#2e60eb]">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    class="icon-xl-heavy">
                    <path fill="currentColor" class="opacity-50" fill-rule="evenodd"
                        d="M8.857 3h6.286c1.084 0 1.958 0 2.666.058.729.06 1.369.185 1.961.487a5 5 0 0 1 2.185 2.185c.302.592.428 1.233.487 1.961.058.708.058 1.582.058 2.666v3.286c0 1.084 0 1.958-.058 2.666-.06.729-.185 1.369-.487 1.961a5 5 0 0 1-2.185 2.185c-.592.302-1.232.428-1.961.487C17.1 21 16.227 21 15.143 21H8.857c-1.084 0-1.958 0-2.666-.058-.728-.06-1.369-.185-1.96-.487a5 5 0 0 1-2.186-2.185c-.302-.592-.428-1.232-.487-1.961C1.5 15.6 1.5 14.727 1.5 13.643v-3.286c0-1.084 0-1.958.058-2.666.06-.728.185-1.369.487-1.96A5 5 0 0 1 4.23 3.544c.592-.302 1.233-.428 1.961-.487C6.9 3 7.773 3 8.857 3M6.354 5.051c-.605.05-.953.142-1.216.276a3 3 0 0 0-1.311 1.311c-.134.263-.226.611-.276 1.216-.05.617-.051 1.41-.051 2.546v3.2c0 1.137 0 1.929.051 2.546.05.605.142.953.276 1.216a3 3 0 0 0 1.311 1.311c.263.134.611.226 1.216.276.617.05 1.41.051 2.546.051h.6V5h-.6c-1.137 0-1.929 0-2.546.051M11.5 5v14h3.6c1.137 0 1.929 0 2.546-.051.605-.05.953-.142 1.216-.276a3 3 0 0 0 1.311-1.311c.134-.263.226-.611.276-1.216.05-.617.051-1.41.051-2.546v-3.2c0-1.137 0-1.929-.051-2.546-.05-.605-.142-.953-.276-1.216a3 3 0 0 0-1.311-1.311c-.263-.134-.611-.226-1.216-.276C17.029 5.001 16.236 5 15.1 5zM5 8.5a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1M5 12a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1"
                        clip-rule="evenodd"></path>
                </svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-grip">
                    <circle cx="12" cy="5" r="1" />
                    <circle cx="19" cy="5" r="1" />
                    <circle cx="5" cy="5" r="1" />
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="19" cy="12" r="1" />
                    <circle cx="5" cy="12" r="1" />
                    <circle cx="12" cy="19" r="1" />
                    <circle cx="19" cy="19" r="1" />
                    <circle cx="5" cy="19" r="1" />
                </svg>
            </button>
            <img src="/elp.webp" class="w-20" />
        </div>
        <button class="text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-settings">
                <path
                    d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
        </button>
        <button class="text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bell">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
            </svg>
        </button>
        <button type="button" class="flex items-center gap-2" id="user-menu-button" aria-expanded="false"
            data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
            <p class="line-clamp-1 max-w-[15ch] max-md:hidden">{{ $current_user->first_name }}
                {{ $current_user->last_name }}</p>
            @include('commons.avatar', [
                'src' => $current_user->profile,
                'className' => 'w-8',
                'alt' => $current_user->first_name . ' ' . $current_user->last_name,
                'altClass' => 'text-sm',
            ])
        </button>
        <div class="z-50 w-[320px] hidden bg-white overflow-hidden pointer-events-auto border text-sm list-none shadow-2xl"
            id="user-dropdown">
            <div class="flex p-3 pb-0 items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="/elp.webp" class="w-10" />
                    <p class="line-clamp-1">
                        ESCUELA SUPERIOR LA PONTIFICIA
                    </p>
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
                    'src' => $current_user->profile,
                    'className' => 'w-28',
                    'alt' => $current_user->first_name . ' ' . $current_user->last_name,
                    'altClass' => 'text-3xl',
                ])
                <div>
                    <p class="line-clamp-1 font-semibold text-xl tracking-tight">
                        {{ $current_user->first_name }}
                        {{ $current_user->last_name }}</p>
                    <p class="line-clamp-1 opacity-70 text-sm">{{ $current_user->email() }}</p>
                    <p>
                        <a class="text-blue-600 hover:underline" href="/account">Mi cuenta</a>
                    </p>
                </div>
            </div>
            <div
                class="bg-neutral-100 border-t hover:[&>a]:underline hover:[&>a]:bg-neutral-200 [&>a]:flex [&>a>div]:p-2 [&>a>div]:text-neutral-600 [&>a>div]:border [&>a>div]:rounded-full [&>a>div]:border-neutral-400 [&>a]:items-center [&>a]:gap-2">
                <a href="/edas/{{ $current_user->id }}" class="block px-4 w-full py-2 text-gray-700 hover:bg-gray-100">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-notebook">
                            <path d="M2 6h4" />
                            <path d="M2 10h4" />
                            <path d="M2 14h4" />
                            <path d="M2 18h4" />
                            <rect width="16" height="20" x="4" y="2" rx="2" />
                            <path d="M16 2v20" />
                        </svg>
                    </div>
                    Mis edas
                </a>
                <a href="/edas/{{ $current_user->id }}"
                    class="block px-4 w-full py-2 text-gray-700 hover:bg-gray-100">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-clock">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    Mi asistencia
                </a>
            </div>
        </div>
    </div>
</nav>
