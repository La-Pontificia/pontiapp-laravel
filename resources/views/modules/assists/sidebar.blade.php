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
            Gestión de asistencias
        </button>
    </div>
    <div
        class="flex-grow overflow-y-auto p-2
                [&>a]:p-3 [&>a]:flex [&>a>svg]:w-[20px] [&>a]:items-center [&>a]:group [&>a]:rounded-xl [&>a]:gap-2 [&>a]:font-semibold [&>a]:text-[15px]
                hover:[&>a]:scale-[1.05]
                data-[active]:[&>a]:bg-white data-[active]:[&>a]:shadow-sm data-[active]:[&>a]:text-blue-700">
        <a href="/assists" {{ request()->is('assists') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-table">
                <path d="M12 3v18" />
                <rect width="18" height="18" x="3" y="3" rx="2" />
                <path d="M3 9h18" />
                <path d="M3 15h18" />
            </svg>
            <p>Asistencias</p>
        </a>
        {{-- <a href="/years" {{ request()->is('edas/years*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-calendar-days">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
                <path d="M8 14h.01" />
                <path d="M12 14h.01" />
                <path d="M16 14h.01" />
                <path d="M8 18h.01" />
                <path d="M12 18h.01" />
                <path d="M16 18h.01" />
            </svg>
            <p>Años</p>
        </a>
        <a href="/years/questionnaires" {{ request()->is('edas/questionnaires*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notepad-text">
                <path d="M8 2v4" />
                <path d="M12 2v4" />
                <path d="M16 2v4" />
                <rect width="16" height="18" x="4" y="4" rx="2" />
                <path d="M8 10h6" />
                <path d="M8 14h8" />
                <path d="M8 18h5" />
            </svg>
            <p>Cuestionarios</p>
        </a> --}}
    </div>
</div>
