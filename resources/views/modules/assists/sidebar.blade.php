@php
    $items = [
        [
            'icon' => 'heroicon-o-clipboard-document-list',
            'text' => 'Asistencias',
            'href' => '/assists',
            'active' => request()->is('assists'),
            'active-icon' => 'heroicon-s-clipboard-document-list',
        ],
        [
            'icon' => 'heroicon-o-circle-stack',
            'text' => 'Terminales',
            'href' => '/assists/terminals',
            'active' => request()->is('assists/terminals*'),
            'active-icon' => 'heroicon-s-circle-stack',
        ],
    ];
@endphp
<div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-4">
        <a href="/" class="flex gap-2 font-medium items-center text-gray-900 ">
            @svg('heroicon-o-arrow-left', [
                'class' => 'w-5 h-5',
            ])
            <span class="max-xl:hidden">Gestión de asistencias</span>
        </a>
    </div>
    <nav class="px-2 py-3 max-xl:space-y-3">
        @foreach ($items as $item)
            <a {{ $item['active'] ? 'data-active' : '' }} title="{{ $item['text'] }}"
                class="flex group relative data-[active]:font-medium gap-2 p-2 hover:bg-white rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['active'] ? $item['active-icon'] : $item['icon'], [
                    'class' => 'w-5 h-5 max-xl:w-6 max-xl:h-6 max-xl:mx-auto group-data-[active]:text-blue-800',
                ])
                <span class="max-xl:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
</div>


{{-- <div class="flex flex-col overflow-y-auto">
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
        <a href="/assists/terminals" {{ request()->is('assists/terminals') ? 'data-active' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pc-case">
                <rect width="14" height="20" x="5" y="2" rx="2" />
                <path d="M15 14h.01" />
                <path d="M9 6h6" />
                <path d="M9 10h6" />
            </svg>
            <p>DB Terminales</p>
        </a>
    </div>
</div> --}}
