@php

@endphp

<nav
    class="flex-grow text-black flex flex-col p-3 pr-2 pt-0 text-sm [&>a]:flex [&>a]:items-center [&>a]:gap-2 [&>a]:p-2 [&>a]:rounded-lg hover:[&>a]:bg-white [&>a]:transition-colors [&>a>svg]:w-[26px] aria-selected:[&>a]:font-semibold aria-selected:[&>a]:text-indigo-600 [&>a>svg]:transition-transform 
    [&>button]:flex [&>button]:items-center [&>button]:text-left [&>button]:gap-2 [&>button]:p-2 [&>button]:rounded-lg hover:[&>button]:bg-white [&>button]:transition-colors [&>button>svg]:w-[26px] aria-selected:[&>button]:text-[#0b58ff] aria-selected:[&>button]:bg-white">
    <a class="group" href="{{ route('home') }}" {{ request()->is('/') ? 'aria-selected=true' : '' }}>
        <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-home">
            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        <span>Inicio</span>
    </a>
    <a class="group" href="{{ route('edas.me') }}"
        {{ request()->is('edas/' . $current_user->id . '*') ? 'aria-selected=true' : '' }}>
        <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-notebook-tabs">
            <path d="M2 6h4" />
            <path d="M2 10h4" />
            <path d="M2 14h4" />
            <path d="M2 18h4" />
            <rect width="16" height="20" x="4" y="2" rx="2" />
            <path d="M15 2v20" />
            <path d="M15 7h5" />
            <path d="M15 12h5" />
            <path d="M15 17h5" />
        </svg>
        <span>Mis edas</span>
    </a>
    <a class="group" href="{{ route('users') }}" {{ request()->is('users*') ? 'aria-selected=true' : '' }}>
        <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-circle-user">
            <circle cx="12" cy="12" r="10" />
            <circle cx="12" cy="10" r="3" />
            <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
        </svg>
        <span>Gestión de Usuarios</span>
    </a>
    <a class="group" href="{{ route('edas') }}"
        {{ request()->is('edas*') && !request()->is('edas/' . $current_user->id . '*') ? 'aria-selected=true' : '' }}>
        <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-notebook-tabs">
            <path d="M2 6h4" />
            <path d="M2 10h4" />
            <path d="M2 14h4" />
            <path d="M2 18h4" />
            <rect width="16" height="20" x="4" y="2" rx="2" />
            <path d="M15 2v20" />
            <path d="M15 7h5" />
            <path d="M15 12h5" />
            <path d="M15 17h5" />
        </svg>
        <span>Gestión de Edas</span>
    </a>
    <a class="group" href="{{ route('assists') }}" {{ request()->is('assists*') ? 'aria-selected=true' : '' }}>
        <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-clock">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
        </svg>
        <span>Gestión de Asistencias</span>
    </a>
    <a class="group" href="{{ route('reports') }}" {{ request()->is('reports*') ? 'aria-selected=true' : '' }}>
        <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-bar-chart-big">
            <path d="M3 3v18h18" />
            <rect width="4" height="7" x="7" y="10" rx="1" />
            <rect width="4" height="12" x="15" y="5" rx="1" />
        </svg>
        <span>Gestión de Reportes</span>
    </a>

    <div class="px-3 pt-5 pb-2 font-semibold text-neutral-400">
        Mantenimiento
    </div>
    <div
        class="pl-7 flex flex-col gap-3 text-neutral-600 hover:[&>a]:text-black aria-selected:[&>a]:text-indigo-500 aria-selected:[&>a]:font-semibold">
        <a href="{{ route('areas') }}" {{ request()->is('areas*') ? 'aria-selected=true' : '' }} class="group">
            Áreas
        </a>
        <a href="{{ route('departments') }}" {{ request()->is('departments*') ? 'aria-selected=true' : '' }}
            class="group">
            Departamentos
        </a>
        <a href="{{ route('job-positions') }}" {{ request()->is('job-positions*') ? 'aria-selected=true' : '' }}
            class="group">
            Puestos
        </a>
        <a href="{{ route('roles') }}" {{ request()->is('roles*') ? 'aria-selected=true' : '' }} class="group">
            Cargos
        </a>
        <a href="{{ route('branches') }}" {{ request()->is('branches*') ? 'aria-selected=true' : '' }} class="group">
            Sedes
        </a>
        <a href="{{ route('questionnaires') }}" {{ request()->is('questionnaires*') ? 'aria-selected=true' : '' }}
            class="group">
            Cuestionarios
        </a>
    </div>

</nav>
