<div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-2">
        <button onclick="window.history.back()" class="flex gap-2 items-center font-semibold text-gray-900 ">
            <div class="p-1 rounded-full bg-white w-8">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </div>
            Gestión de usuarios
        </button>
    </div>
    <div
        class="flex-grow overflow-y-auto p-2
                [&>a]:p-3 [&>a]:flex [&>a>svg]:w-[20px] [&>a]:items-center [&>a]:group [&>a]:rounded-xl [&>a]:gap-2 [&>a]:font-semibold [&>a]:text-[15px]
                hover:[&>a]:scale-[1.05]
                data-[active]:[&>a]:bg-white data-[active]:[&>a]:shadow-sm data-[active]:[&>a]:text-blue-700">

        <a href="{{ route('users') }}"
            {{ request()->is('users') || request()->is('users/create') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round">
                <path d="M18 20a6 6 0 0 0-12 0" />
                <circle cx="12" cy="10" r="4" />
                <circle cx="12" cy="12" r="10" />
            </svg>
            <p>Usuarios</p>
        </a>
        <a href="/users/user-roles" {{ request()->is('users/user-roles*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-sliders">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M8 12h8" />
                <path d="M10 11v2" />
                <path d="M8 17h8" />
                <path d="M14 16v2" />
            </svg>
            <p>Roles</p>
        </a>
        <a href="{{ route('users.schedules') }}" {{ request()->is('users/schedules*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-range">
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M16 2v4" />
                <path d="M3 10h18" />
                <path d="M8 2v4" />
                <path d="M17 14h-6" />
                <path d="M13 18H7" />
                <path d="M7 14h.01" />
                <path d="M17 18h.01" />
            </svg>
            <p>Horarios</p>
        </a>
        <a href="{{ route('users.emails') }}" {{ request()->is('users/emails*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-at-sign">
                <circle cx="12" cy="12" r="4" />
                <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
            </svg>
            <p>Emails</p>
        </a>
        {{-- <a href="{{ route('users.domains') }}" {{ request()->is('users/domains*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                <path d="M2 12h20" />
            </svg>
            <p>Dominios</p>
        </a> --}}
        {{-- <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-plus">
                <path
                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                <path d="M9 12h6" />
                <path d="M12 9v6" />
            </svg>
            <p>Sesiones</p>
        </a> --}}
        {{-- <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-bar-chart">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M8 18v-2" />
                <path d="M12 18v-4" />
                <path d="M16 18v-6" />
            </svg>
            <p>Reporte</p>
        </a> --}}
        {{-- <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M12 18v-6" />
                <path d="m9 15 3 3 3-3" />
            </svg>
            <p>Importar</p>
        </a>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-up">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M12 12v6" />
                <path d="m15 15-3-3-3 3" />
            </svg>
            <p>Exportar</p>
        </a> --}}
        <p class="p-2 pb-0 font-semibold text-sm tracking-tight opacity-60">Configuraciones</p>
        <a href="/users/job-positions" {{ request()->is('users/job-positions*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-contact-round">
                <path d="M16 18a4 4 0 0 0-8 0" />
                <circle cx="12" cy="11" r="3" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <line x1="8" x2="8" y1="2" y2="4" />
                <line x1="16" x2="16" y1="2" y2="4" />
            </svg>
            Puestos
        </a>
        <a href="/users/roles" {{ request()->is('users/roles*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-contact-round">
                <path d="M16 18a4 4 0 0 0-8 0" />
                <circle cx="12" cy="11" r="3" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <line x1="8" x2="8" y1="2" y2="4" />
                <line x1="16" x2="16" y1="2" y2="4" />
            </svg>
            <p>Cargos</p>
        </a>
    </div>
</div>
