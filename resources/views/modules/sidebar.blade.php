<nav
    class="flex-grow gap-2 text-black flex flex-col p-3 pr-2 font-semibold tracking-tight [&>a]:flex [&>a]:items-center [&>a]:gap-2 [&>a]:p-2 [&>a]:rounded-lg hover:[&>a]:text-[#0c5ce6] [&>a]:transition-colors [&>a>svg]:w-[23px] [&>a>svg]:min-w-[23px] aria-selected:[&>a]:font-semibold aria-selected:[&>a]:text-[#0c5ce6] [&>a>svg]:transition-transform">
    <a class="group" href="{{ route('modules') }}" {{ request()->is('/') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
            <path
                d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
        </svg>
        <span>Inicio</span>
    </a>
    <a class="group" href="{{ route('users') }}" {{ request()->is('users*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round">
            <path d="M18 20a6 6 0 0 0-12 0" />
            <circle cx="12" cy="10" r="4" />
            <circle cx="12" cy="12" r="10" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Usuarios</p>
            {{-- <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Usuarios, roles, horarios, correos y más.
            </p> --}}
        </div>
    </a>
    <a class="group" href="/edas"
        {{ request()->is('edas*') && !request()->is('edas/' . $current_user->id . '*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-audio">
            <path d="M12 6v7" />
            <path d="M16 8v3" />
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
            <path d="M8 8v3" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Edas</p>
            {{-- <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Objetivos, Cuestionarios, y más.
            </p> --}}
        </div>
    </a>
    <a class="group" href="/assists" {{ request()->is('assists*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-9">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 7.5 12" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Asistencias</p>
            {{-- <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Asistencias en tiempo real, y reportes.
            </p> --}}
        </div>
    </a>
    <a class="group" href="/audit" {{ request()->is('audit*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield">
            <path
                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Auditoria</p>
            {{-- <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Auditoria de usuarios y actividades.
            </p> --}}
        </div>
    </a>
    <a href="/maintenance">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings">
            <path
                d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
            <circle cx="12" cy="12" r="3" />
        </svg>
        <div class="overflow-hidden">
            <p>Mantenimiento</p>
            {{-- <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Configuración del sistema y datos.
            </p> --}}
        </div>
    </a>
</nav>
