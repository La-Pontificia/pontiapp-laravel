@php

    $userItems = [
        [
            'icon' => 'bx-home-smile',
            'text' => $cuser->first_name,
            'href' => '/users/' . $cuser->id,
        ],
        [
            'icon' => 'bx-folder',
            'text' => 'Mis edas',
            'href' => 'edas/me',
        ],
        [
            'icon' => 'bx-calendar-event',
            'text' => 'Mis horarios',
            'href' => 'users/' . $cuser->id . '/schedules',
        ],
        [
            'icon' => 'bx-calendar-check',
            'text' => 'Mis asistencias',
            'href' => 'users/' . $cuser->id . '/assists',
        ],
    ];

    $otherItems = [
        [
            'icon' => 'bx-group',
            'text' => 'Gestión de Usuarios',
            'href' => '/users',
            'enable' => $cuser->hasGroup('users') || $cuser->isDev(),
        ],
        [
            'icon' => 'bx-folder',
            'text' => 'Gestión de Edas',
            'href' => '/edas/collaborators',
            'enable' => $cuser->hasGroup('edas') || $cuser->isDev(),
        ],
        [
            'icon' => 'bx-calendar',
            'text' => 'Gestión de Asistencias',
            'href' => '/assists',
            'enable' => $cuser->hasGroup('assists') || $cuser->isDev(),
        ],
        // [
        //     'icon' => 'bx-bar-chart-alt-2',
        //     'text' => 'Gestión de Auditoria',
        //     'href' => '/audit',
        //     'enable' => $cuser->hasGroup('audit') || $cuser->isDev(),
        // ],
        [
            'icon' => 'bx-cog',
            'text' => 'Ajustes',
            'href' => '/settings',
            'enable' => $cuser->hasGroup('settings') || $cuser->isDev(),
        ],
    ];
@endphp



<nav class="pb-3">
    @foreach ($userItems as $item)
        <a title="{{ $item['text'] }}"
            class="flex group relative items-center data-[active]:font-medium gap-3 p-2 px-5 text-[#202124] hover:bg-[#e8eaed] rounded-r-full"
            href="{{ $item['href'] }}">
            @svg($item['icon'], [
                'class' => 'w-5 h-5 m-0.5',
            ])
            <span class="text-nowrap">{{ $item['text'] }}</span>
        </a>
    @endforeach
</nav>

{{-- // $otherItems[4]['enable'] --}}

@if ($otherItems[0]['enable'] && $otherItems[1]['enable'] && $otherItems[2]['enable'] && $otherItems[3]['enable'])
    <nav class="py-3 border-t border-neutral-300 ">
        <p class="font-medium text-xs opacity-50 px-5  flex-grow text-ellipsis">
            Administración
        </p>
        @foreach ($otherItems as $item)
            @if (!$item['enable'])
                @continue
            @endif

            <a title="{{ $item['text'] }}"
                class="flex group relative items-center data-[active]:font-medium gap-3 p-2 px-5 text-[#202124] hover:bg-[#e8eaed] rounded-r-full"
                href="{{ $item['href'] }}">
                @svg($item['icon'], [
                    'class' => 'w-5 h-5 m-0.5',
                ])
                <span class="text-nowrap">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
@endif
