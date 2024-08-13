@php
    $items = [
        [
            'icon' => 'bx-folder',
            'text' => 'Mis edas',
            'href' => '/edas/me',
            'active' => request()->is('edas' . '/' . $cuser->id . '*'),
            'active-icon' => 'bxs-folder-open',
            'enable' => true,
        ],
        [
            'icon' => 'bx-group',
            'text' => 'Colaboradores y edas',
            'href' => '/edas/collaborators',
            'active' =>
                (request()->is('edas/collaborators*') || request()->is('edas*')) &&
                !request()->is('edas' . '/' . $cuser->id . '*') &&
                !request()->is('edas/years*') &&
                !request()->is('edas/questionnaire-templates*'),
            'active-icon' => 'bxs-group',
            'enable' => true,
        ],
        // [
        //     'icon' => 'bx-bar-chart-alt-2',
        //     'text' => 'Reporte y estadísticas',
        //     'href' => '/edas/reports',
        //     'active' => request()->is('edas/reports*'),
        //     'active-icon' => 'bxs-bar-chart-alt-2',
        //     'enable' => $cuser->has('edas:reports:show') || $cuser->isDev(),
        // ],
        [
            'icon' => 'bx-notification',
            'text' => 'Años',
            'href' => '/edas/years',
            'active' => request()->is('edas/years*'),
            'active-icon' => 'bxs-notification',
            'enable' => $cuser->has('edas:years:show') || $cuser->has('edas:years:create') || $cuser->isDev(),
        ],
        [
            'icon' => 'bx-file-blank',
            'text' => 'Plantilla de cuestionarios',
            'href' => '/edas/questionnaire-templates',
            'active' => request()->is('edas/questionnaire-templates*'),
            'active-icon' => 'bxs-file-blank',
            'enable' =>
                $cuser->has('edas:questionnaire-templates:show') ||
                $cuser->has('edas:questionnaire-templates:create') ||
                $cuser->isDev(),
        ],
    ];
@endphp

<div class="border-b pb-3">
    <a href="/" class="flex items-center gap-2 group p-2 px-4 pb-0">
        @svg('bx-arrow-back', [
            'class' => 'w-7 h-7 rounded-full p-1 group-hover:bg-neutral-200',
        ])
        <span>Edas y colaboradores</span>
    </a>
</div>
<nav class="py-3 ">
    @foreach ($items as $item)
        @if (!$item['enable'])
            @continue
        @endif

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
