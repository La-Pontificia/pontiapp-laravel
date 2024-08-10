@php

    $userItems = [
        [
            'icon' => 'heroicon-o-clipboard-document-check',
            'text' => 'Mis edas',
            'href' => 'edas/me',
        ],
        [
            'icon' => 'heroicon-o-calendar-days',
            'text' => 'Mis horarios',
            'href' => 'users/' . $cuser->id . '/schedules',
        ],
        [
            'icon' => 'heroicon-o-clipboard-document-check',
            'text' => 'Mis asistencias',
            'href' => 'users/' . $cuser->id . '/assists',
        ],
    ];

    $otherItems = [
        [
            'icon' => 'heroicon-o-user-group',
            'text' => 'Gestión de Usuarios',
            'href' => '/users',
            'enable' => $cuser->hasGroup('users') || $cuser->isDev(),
        ],
        [
            'icon' => 'heroicon-o-inbox',
            'text' => 'Gestión de Edas',
            'href' => '/edas',
            'enable' => $cuser->hasGroup('edas') || $cuser->isDev(),
        ],
        [
            'icon' => 'heroicon-o-calendar',
            'text' => 'Gestión de Asistencias',
            'href' => '/assists',
            'enable' => $cuser->hasGroup('assists') || $cuser->isDev(),
        ],
        [
            'icon' => 'heroicon-o-shield-check',
            'text' => 'Gestión de Auditoria',
            'href' => '/audit',
            'enable' => $cuser->hasGroup('audit') || $cuser->isDev(),
        ],
        [
            'icon' => 'heroicon-o-cog',
            'text' => 'Ajustes del sistema',
            'href' => '/settings',
            'enable' => $cuser->hasGroup('settings') || $cuser->isDev(),
        ],
    ];
@endphp



<nav class="px-2 py-3 max-xl:space-y-3">
    <div class="max-xl:flex hidden justify-center">
        @include('commons.avatar', [
            'src' => $cuser->profile,
            'className' => 'w-7',
            'alt' => $cuser->first_name . ' ' . $cuser->last_name,
            'altClass' => 'text-sm',
        ])
    </div>
    <p class="font-medium text-xs opacity-50 px-3 max-xl:hidden flex-grow text-ellipsis">
        {{ $cuser->first_name }} {{ $cuser->last_name }}
    </p>
    @foreach ($userItems as $item)
        <a title="{{ $item['text'] }}"
            class="flex group relative data-[active]:font-medium gap-2 p-2 hover:bg-white rounded-lg"
            href="{{ $item['href'] }}">
            @svg($item['icon'], [
                'class' => 'w-5 h-5 max-xl:w-6 max-xl:h-6 max-xl:mx-auto',
            ])
            <span class="max-xl:hidden">{{ $item['text'] }}</span>
        </a>
    @endforeach
</nav>

@if (
    $otherItems[0]['enable'] &&
        $otherItems[1]['enable'] &&
        $otherItems[2]['enable'] &&
        $otherItems[3]['enable'] &&
        $otherItems[4]['enable']
)
    <nav class="px-2 py-3 border-t border-neutral-300 max-xl:space-y-3">
        <p class="font-medium text-xs opacity-50 px-3 max-xl:hidden flex-grow text-ellipsis">
            Administración
        </p>
        @foreach ($otherItems as $item)
            @if (!$item['enable'])
                @continue
            @endif

            <a title="{{ $item['text'] }}"
                class="flex group relative data-[active]:font-medium gap-2 p-2 hover:bg-white rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['icon'], [
                    'class' => 'w-5 h-5 max-xl:w-6 max-xl:h-6 max-xl:mx-auto',
                ])
                <span class="max-xl:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
@endif
