@php
    $items = [
        [
            'icon' => 'heroicon-o-building-office-2',
            'text' => 'Areas',
            'href' => '/settings',
            'active' => request()->is('settings'),
            'active-icon' => 'heroicon-s-building-office-2',
        ],
        [
            'icon' => 'heroicon-o-building-office',
            'text' => 'Departamentos',
            'href' => '/settings/departments',
            'active' => request()->is('settings/departments*'),
            'active-icon' => 'heroicon-s-building-office',
        ],
        [
            'icon' => 'heroicon-o-map-pin',
            'text' => 'Sedes',
            'href' => '/settings/branches',
            'active' => request()->is('settings/branches*'),
            'active-icon' => 'heroicon-s-map-pin',
        ],
        [
            'icon' => 'heroicon-o-home-modern',
            'text' => 'Unidad de negocios',
            'href' => '/settings/business-units',
            'active' => request()->is('settings/business-units*'),
            'active-icon' => 'heroicon-s-home-modern',
        ],
    ];
@endphp
<div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-4">
        <a href="/" class="flex gap-2 font-medium items-center text-gray-900 ">
            @svg('heroicon-o-arrow-left', [
                'class' => 'w-5 h-5',
            ])
            <span class="max-md:hidden">Ajustes del sistema</span>
        </a>
    </div>
    <nav class="px-2 py-2 pt-0">
        @foreach ($items as $item)
            <a {{ $item['active'] ? 'data-active' : '' }} title="{{ $item['text'] }}"
                class="flex group relative data-[active]:font-medium gap-2 p-2 hover:bg-neutral-200 rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['active'] ? $item['active-icon'] : $item['icon'], [
                    'class' => 'w-5 h-5 max-md:w-6 max-md:h-6 max-md:mx-auto group-data-[active]:text-blue-800',
                ])
                <span class="max-md:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
