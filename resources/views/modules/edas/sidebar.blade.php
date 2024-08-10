@php
    $items = [
        [
            'icon' => 'heroicon-o-clipboard-document-check',
            'text' => 'Mis edas',
            'href' => '/edas/me',
            'active' => request()->is('edas' . '/' . $cuser->id . '*'),
            'active-icon' => 'heroicon-s-clipboard-document-check',
            'enable' => true,
        ],
        [
            'icon' => 'heroicon-o-user-group',
            'text' => 'Colaboradores',
            'href' => '/edas',
            'active' =>
                request()->is('edas*') &&
                !request()->is('edas/questionnaire-templates*') &&
                !request()->is('edas/years*') &&
                !request()->is('edas/reports*') &&
                !request()->is('edas' . '/' . $cuser->id . '*'),
            'active-icon' => 'heroicon-s-user-group',
            'enable' => true,
        ],
        [
            'icon' => 'heroicon-o-chart-bar',
            'text' => 'Reporte y estadísticas',
            'href' => '/edas/reports',
            'active' => request()->is('edas/reports*'),
            'active-icon' => 'heroicon-s-chart-bar',
            'enable' => $cuser->has('edas:reports:show') || $cuser->isDev(),
        ],
        [
            'icon' => 'heroicon-o-stop',
            'text' => 'Años',
            'href' => '/edas/years',
            'active' => request()->is('edas/years*'),
            'active-icon' => 'heroicon-s-stop',
            'enable' => $cuser->has('edas:years:show') || $cuser->has('edas:years:create') || $cuser->isDev(),
        ],
        [
            'icon' => 'heroicon-o-clipboard-document',
            'text' => 'Plantilla de cuestionarios',
            'href' => '/edas/questionnaire-templates',
            'active' => request()->is('edas/questionnaire-templates*'),
            'active-icon' => 'heroicon-s-clipboard-document',
            'enable' =>
                $cuser->has('edas:questionnaire-templates:show') ||
                $cuser->has('edas:questionnaire-templates:create') ||
                $cuser->isDev(),
        ],
    ];
@endphp
<div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-4">
        <a href="/" class="flex gap-2 font-medium items-center text-gray-900 ">
            @svg('heroicon-o-arrow-left', [
                'class' => 'w-5 h-5',
            ])
            <span class="max-xl:hidden">Gestión de edas</span>
        </a>
    </div>
    <nav class="px-2 py-3 max-xl:space-y-3">
        @foreach ($items as $item)
            @if (!$item['enable'])
                @continue
            @endif

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
