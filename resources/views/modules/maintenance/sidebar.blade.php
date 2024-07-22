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
            Mantenimiento del sistema
        </button>
    </div>
    <div
        class="flex-grow overflow-y-auto p-2
                [&>a]:p-3 [&>a]:flex [&>a>svg]:w-[20px] [&>a]:items-center [&>a]:group [&>a]:rounded-xl [&>a]:gap-2 [&>a]:font-semibold [&>a]:text-[15px]
                hover:[&>a]:scale-[1.05]
                data-[active]:[&>a]:bg-white data-[active]:[&>a]:shadow-sm data-[active]:[&>a]:text-blue-700">
        <a href="/maintenance" {{ request()->is('maintenance*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hotel">
                <path d="M10 22v-6.57" />
                <path d="M12 11h.01" />
                <path d="M12 7h.01" />
                <path d="M14 15.43V22" />
                <path d="M15 16a5 5 0 0 0-6 0" />
                <path d="M16 11h.01" />
                <path d="M16 7h.01" />
                <path d="M8 11h.01" />
                <path d="M8 7h.01" />
                <rect x="4" y="2" width="16" height="20" rx="2" />
            </svg>
            <p>Areas</p>
        </a>
        <a href="/maintenance/departments" {{ request()->is('maintenance/departments*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-door-open">
                <path d="M13 4h3a2 2 0 0 1 2 2v14" />
                <path d="M2 20h3" />
                <path d="M13 20h9" />
                <path d="M10 12v.01" />
                <path d="M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z" />
            </svg>
            <p>Departamentos</p>
        </a>
        <a href="/maintenance/branches" {{ request()->is('maintenance/branches*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            <p>Sedes</p>
        </a>
        <a href="/maintenance/business_unit" {{ request()->is('maintenance/business_unit*') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-factory">
                <path d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                <path d="M17 18h1" />
                <path d="M12 18h1" />
                <path d="M7 18h1" />
            </svg>
            <p>Unidad de negocios</p>
        </a>
    </div>
</div>
