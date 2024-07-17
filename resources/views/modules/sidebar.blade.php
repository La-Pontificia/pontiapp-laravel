<nav
    class="flex-grow text-black flex flex-col p-3 pr-2 font-semibold tracking-tight [&>a]:flex [&>a]:items-center [&>a]:gap-2 [&>a]:p-2 [&>a]:rounded-lg hover:[&>a]:text-[#0c5ce6] [&>a]:transition-colors [&>a>svg]:w-[20px] [&>a>svg]:min-w-[20px] aria-selected:[&>a]:font-semibold aria-selected:[&>a]:text-[#0c5ce6] [&>a>svg]:transition-transform">
    <a class="group" href="{{ route('modules') }}" {{ request()->is('/') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
        </svg>
        <span>Inicio</span>
    </a>
    <a class="group" href="{{ route('users') }}" {{ request()->is('users*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Usuarios</p>
            <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Registro, edicion reportes y auditoria de usuarios
            </p>
        </div>
    </a>
    <a class="group" href="{{ route('edas') }}"
        {{ request()->is('edas*') && !request()->is('edas/' . $current_user->id . '*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Edas</p>
            <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Objetivos, Cuestionarios, y más.
            </p>
        </div>
    </a>
    <a class="group" href="{{ route('assists') }}" {{ request()->is('assists*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Asistencias</p>
            <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Asistencias en tiempo real, y reportes.
            </p>
        </div>
    </a>
    <a class="group" href="{{ route('audit') }}" {{ request()->is('audit*') ? 'aria-selected=true' : '' }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <div class="overflow-hidden">
            <p>Gestión de Auditoria</p>
            <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Auditoria de usuarios y actividades.
            </p>
        </div>
    </a>
    <a href="/">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <div class="overflow-hidden">
            <p>Mantenimiento</p>
            <p class="text-xs text-stone-500 text-nowrap text-ellipsis overflow-hidden">
                Configuración del sistema y datos.
            </p>
        </div>
    </a>
</nav>
