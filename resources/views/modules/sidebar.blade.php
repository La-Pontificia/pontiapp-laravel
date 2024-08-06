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
        ],
        [
            'icon' => 'heroicon-o-inbox',
            'text' => 'Gestión de Edas',
            'href' => '/edas',
        ],
        [
            'icon' => 'heroicon-o-calendar',
            'text' => 'Gestión de Asistencias',
            'href' => '/assists',
        ],
        [
            'icon' => 'heroicon-o-shield-check',
            'text' => 'Gestión de Auditoria',
            'href' => '/audit',
        ],
        [
            'icon' => 'heroicon-o-cog',
            'text' => 'Ajustes del sistema',
            'href' => '/settings',
        ],
    ];
@endphp

<nav class="p-4 max-md:p-2">
    <p class="font-medium px-3 max-md:hidden flex-grow text-ellipsis">
        {{ $cuser->first_name }} {{ $cuser->last_name }}
    </p>
    <div class="max-md:flex hidden justify-center">
        @include('commons.avatar', [
            'src' => $cuser->profile,
            'className' => 'w-7',
            'alt' => $cuser->first_name . ' ' . $cuser->last_name,
            'altClass' => 'text-sm',
        ])
    </div>
    <nav class="px-2 py-2">
        @foreach ($userItems as $item)
            <a title="{{ $item['text'] }}" class="flex relative gap-2 p-2 hover:bg-neutral-200 rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['icon'], [
                    'class' => 'w-5 h-5 max-md:w-6 max-md:mx-auto',
                ])
                <span class="max-md:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
</nav>
<nav class="p-4 max-md:p-2 pt-3">
    <p class="font-medium px-3 max-md:hidden flex-grow text-ellipsis">
        Administración
    </p>
    <nav class="px-2 py-2">
        @foreach ($otherItems as $item)
            <a title="{{ $item['text'] }}" class="flex relative gap-2 p-2 hover:bg-neutral-200 rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['icon'], [
                    'class' => 'w-5 h-5 max-md:w-6 max-md:mx-auto',
                ])
                <span class="max-md:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
</nav>
