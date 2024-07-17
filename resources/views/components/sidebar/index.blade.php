<aside id="cta-sidebar"
    class="z-40 w-[300px] min-w-[300px] transition-all h-full max-sm:top-12 max-sm:bg-white max-sm:border-r overflow-y-auto max-sm:-translate-x-full max-sm:fixed"
    aria-label="Sidebar">
    <div class="h-full pr-0 flex flex-col">
        <div class="flex items-center p-2 px-3 text-sm gap-3 border-b">
            @include('commons.avatar', [
                'src' => $current_user->profile,
                'className' => 'w-10',
                'alt' => $current_user->first_name . ' ' . $current_user->last_name,
                'altClass' => 'text-sm',
            ])
            <div>
                <p class="line-clamp-1 leading-4 text-ellipsis overflow-hidden font-semibold">
                    {{ $current_user->first_name }} {{ $current_user->last_name }}
                </p>
            </div>
            <button class="hover:underline text-nowrap text-blue-500 tracking-tight font-semibold">
                Mi perfil
            </button>
        </div>
        @php
            $isAccess = $current_user->role === 'admin' || $current_user->role === 'dev';
        @endphp

        <nav
            class="flex-grow text-black flex flex-col p-3 pr-2 font-semibold tracking-tight [&>a]:flex [&>a]:items-center [&>a]:gap-2 [&>a]:p-2 [&>a]:rounded-lg hover:[&>a]:text-[#1679cf] [&>a]:transition-colors [&>a>svg]:w-[15px] aria-selected:[&>a]:font-semibold aria-selected:[&>a]:text-[#115ea3] [&>a>svg]:transition-transform 
    [&>button]:flex [&>button]:items-center [&>button]:text-left [&>button]:gap-2 [&>button]:p-2 [&>button]:rounded-lg hover:[&>button]:text-[#1679cf] [&>button]:transition-colors [&>button>svg]:w-[15px] aria-selected:[&>button]:text-[#115ea3] aria-selected:[&>button]:bg-white">
            <a class="group" href="{{ route('modules') }}" {{ request()->is('/') ? 'aria-selected=true' : '' }}>
                {{-- <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-home">
            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-right">
                </svg>
                <span>Inicio</span>
            </a>
            <a class="group" href="{{ route('edas.me') }}"
                {{ request()->is('edas/' . $current_user->id . '*') ? 'aria-selected=true' : '' }}>
                {{-- <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
        </svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-right">
                    {{-- <path d="m9 18 6-6-6-6" /> --}}
                </svg>
                <span>Mis edas</span>
            </a>
            @if ($isAccess)
                <a class="group" href="{{ route('users') }}" {{ request()->is('users*') ? 'aria-selected=true' : '' }}>
                    {{-- <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-circle-user">
            <circle cx="12" cy="12" r="10" />
            <circle cx="12" cy="10" r="3" />
            <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
        </svg> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span>Gestión de Usuarios</span>
                </a>
            @endif
            <a class="group" href="{{ route('edas') }}"
                {{ request()->is('edas*') && !request()->is('edas/' . $current_user->id . '*') ? 'aria-selected=true' : '' }}>
                {{-- <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
        </svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-right">
                    <path d="m9 18 6-6-6-6" />
                </svg>
                <span>Gestión de Edas</span>
            </a>
            @if ($isAccess)
                <a class="group" href="{{ route('assists') }}"
                    {{ request()->is('assists*') ? 'aria-selected=true' : '' }}>
                    {{-- <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-clock">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
        </svg> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span>Gestión de Asistencias</span>
                </a>
                <a class="group" href="{{ route('reports') }}"
                    {{ request()->is('reports*') ? 'aria-selected=true' : '' }}>
                    {{-- <svg class="group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bar-chart-big">
                <path d="M3 3v18h18" />
                <rect width="4" height="7" x="7" y="10" rx="1" />
                <rect width="4" height="12" x="15" y="5" rx="1" />
            </svg> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span>Gestión de Reportes</span>
                </a>
                <a class="group" href="{{ route('audit') }}"
                    {{ request()->is('audit*') ? 'aria-selected=true' : '' }}>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-ellipsis">
                <path
                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                <path d="M8 12h.01" />
                <path d="M12 12h.01" />
                <path d="M16 12h.01" />
            </svg> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    <span>Gestión de Auditoria</span>
                </a>
            @endif
            @if ($isAccess)
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    Mantenimiento
                </button>
                <div
                    class="pl-4 pt-2 flex flex-col border-l-2 border-stone-300 hover:[&>a]:text-[#1679cf] ml-4 gap-3 aria-selected:[&>a]:text-[#115ea3] aria-selected:[&>a]:font-semibold">
                    <a href="{{ route('areas') }}" {{ request()->is('areas*') ? 'aria-selected=true' : '' }}
                        class="group">
                        Áreas
                    </a>
                    <a href="{{ route('departments') }}"
                        {{ request()->is('departments*') ? 'aria-selected=true' : '' }} class="group">
                        Departamentos
                    </a>
                    <a href="{{ route('job-positions') }}"
                        {{ request()->is('job-positions*') ? 'aria-selected=true' : '' }} class="group">
                        Puestos
                    </a>
                    <a href="{{ route('roles') }}" {{ request()->is('roles*') ? 'aria-selected=true' : '' }}
                        class="group">
                        Cargos
                    </a>
                    <a href="{{ route('branches') }}" {{ request()->is('branches*') ? 'aria-selected=true' : '' }}
                        class="group">
                        Sedes
                    </a>
                    <a href="{{ route('templates') }}" {{ request()->is('templates*') ? 'aria-selected=true' : '' }}
                        class="group">
                        Plantillas de Encuestas
                    </a>
                    <a href="{{ route('years') }}" {{ request()->is('years*') ? 'aria-selected=true' : '' }}
                        class="group">
                        Edas (Años)
                    </a>
                </div>
            @endif
        </nav>

        {{-- @include('components.nav-sidebar') --}}
        <footer class="p-5 text-sm text-black opacity-60 text-center">
            La pontificia &copy; 2024
        </footer>
    </div>
</aside>
