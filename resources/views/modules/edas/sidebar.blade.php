@php
    $items = [
        [
            'icon' => 'heroicon-o-clipboard-document-check',
            'text' => 'Mis edas',
            'href' => '/edas/me',
            'active' => request()->is('edas' . '/' . $cuser->id . '*'),
            'active-icon' => 'heroicon-s-clipboard-document-check',
        ],
        [
            'icon' => 'heroicon-o-user-group',
            'text' => 'Colaboradores',
            'href' => '/edas',
            'active' =>
                request()->is('edas*') &&
                !request()->is('edas/questionnaires-templates*') &&
                !request()->is('edas/years*') &&
                !request()->is('edas' . '/' . $cuser->id . '*'),
            'active-icon' => 'heroicon-s-user-group',
        ],
        [
            'icon' => 'heroicon-o-chart-bar',
            'text' => 'Reporte y estadísticas',
            'href' => '/edas/reports',
            'active' => request()->is('edas/reports*'),
            'active-icon' => 'heroicon-s-chart-bar',
        ],
        [
            'icon' => 'heroicon-o-stop',
            'text' => 'Años',
            'href' => '/edas/years',
            'active' => request()->is('edas/years*'),
            'active-icon' => 'heroicon-s-stop',
        ],
        [
            'icon' => 'heroicon-o-clipboard-document',
            'text' => 'Plantilla de cuestionarios',
            'href' => '/edas/questionnaires-templates',
            'active' => request()->is('edas/questionnaires-templates*'),
            'active-icon' => 'heroicon-s-clipboard-document',
        ],
    ];
@endphp
<div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-4">
        <a href="/" class="flex gap-2 font-medium items-center text-gray-900 ">
            @svg('heroicon-o-arrow-left', [
                'class' => 'w-5 h-5',
            ])
            <span class="max-lg:hidden">Gestión de edas</span>
        </a>
    </div>
    <nav class="px-2 py-2 pt-0">
        @foreach ($items as $item)
            <a {{ $item['active'] ? 'data-active' : '' }} title="{{ $item['text'] }}"
                class="flex group relative data-[active]:font-medium gap-2 p-2 hover:bg-neutral-200 rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['active'] ? $item['active-icon'] : $item['icon'], [
                    'class' => 'w-5 h-5 max-lg:w-6 max-lg:h-6 max-lg:mx-auto group-data-[active]:text-blue-800',
                ])
                <span class="max-lg:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
