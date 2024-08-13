@php
    $items = [
        [
            'icon' => 'bx-buildings',
            'text' => 'Areas',
            'href' => '/settings',
            'active' => request()->is('settings'),
            'active-icon' => 'bxs-buildings',
        ],
        [
            'icon' => 'bx-building-house',
            'text' => 'Departamentos',
            'href' => '/settings/departments',
            'active' => request()->is('settings/departments*'),
            'active-icon' => 'bxs-building-house',
        ],
        [
            'icon' => 'bx-briefcase-alt-2',
            'text' => 'Puestos',
            'href' => '/settings/job-positions',
            'active' => request()->is('settings/job-positions*'),
            'active-icon' => 'bxs-briefcase-alt-2',
        ],
        [
            'icon' => 'bx-briefcase-alt-2',
            'text' => 'Cargos',
            'href' => '/settings/roles',
            'active' => request()->is('settings/roles*'),
            'active-icon' => 'bxs-briefcase-alt-2',
        ],
        [
            'icon' => 'bx-map',
            'text' => 'Sedes',
            'href' => '/settings/branches',
            'active' => request()->is('settings/branches*'),
            'active-icon' => 'bxs-map',
        ],
        [
            'icon' => 'bx-building',
            'text' => 'Unidad de negocios',
            'href' => '/settings/business-units',
            'active' => request()->is('settings/business-units*'),
            'active-icon' => 'bxs-building',
        ],
    ];
@endphp
{{-- <div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-4">
        <a href="/" class="flex gap-2 font-medium items-center text-gray-900 ">
            @svg('heroicon-o-arrow-left', [
                'class' => 'w-5 h-5',
            ])
            <span class="max-xl:hidden">Ajustes del sistema</span>
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
</div> --}}

<div class="border-b pb-3">
    <a href="/" class="flex items-center gap-2 group p-2 px-4 pb-0">
        @svg('bx-arrow-back', [
            'class' => 'w-7 h-7 rounded-full p-1 group-hover:bg-neutral-200',
        ])
        <span>Ajustes del sistema</span>
    </a>
</div>
<nav class="py-3 ">
    @foreach ($items as $item)
        <a title="{{ $item['text'] }}" {{ $item['active'] ? 'data-active' : '' }}
            class="flex group relative items-center data-[active]:font-medium data-[active]:bg-[#e8f0fe] data-[active]:text-[#1967da] gap-3 p-2 px-5 text-[#202124] hover:bg-[#e8eaed] rounded-r-full"
            href="{{ $item['href'] }}">
            @svg($item['active'] ? $item['active-icon'] : $item['icon'], [
                'class' => 'w-5 h-5 m-0.5',
                'stroke-width' => 1.4,
            ])
            <span class="text-nowrap">{{ $item['text'] }}</span>
        </a>
    @endforeach
</nav>
