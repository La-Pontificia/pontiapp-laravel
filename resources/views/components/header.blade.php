<nav class=" bg-white border-b h-14 w-full z-30">
    <div class="flex w-full gap-5 items-center h-full px-3">
        <div class="flex-grow flex gap-2 items-center">
            <button id="toogle-sidebar" class="p-1 rounded-lg text-[#2e60eb]">
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
            <a href="/"><img src="/elp.webp" class="w-20" /></a>
        </div>
        <button class="text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-settings">
                <path
                    d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
        </button>
        <button class="text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-rectangle-ellipsis">
                            <rect width="20" height="12" x="2" y="6" rx="2" />
                            <path d="M12 12h.01" />
                            <path d="M17 12h.01" />
                            <path d="M7 12h.01" />
                        </svg>
                    </div>
                    Restablecer contraseña
                </a>
                <a href="/edas/{{ $current_user->id }}"
                    class="block px-4 w-full py-2 text-gray-700 hover:bg-gray-100">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
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
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
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
