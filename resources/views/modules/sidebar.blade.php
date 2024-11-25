@php

    $userItems = [
        [
            'icon' => 'fluentui-home-48-o',
            'imageURL' => $cuser->profile,
            'active-icon' => 'fluentui-home-48',
            'text' => $cuser->names(),
            'href' => '/users/' . $cuser->id,
            'active' => request()->is('users/' . $cuser->id . '*'),
        ],
        // [
        //     'icon' => 'fluentui-folder-person-20-o',
        //     'active-icon' => 'fluentui-folder-person-20',
        //     'text' => 'Mis edas',
        //     'href' => '/edas/me',
        //     'active' => request()->is('edas/' . $cuser->id . '*'),
        // ],
        [
            'icon' => 'fluentui-calendar-person-20-o',
            'active-icon' => 'fluentui-calendar-person-20',
            'text' => 'Mis horarios',
            'href' => '/users/' . $cuser->id . '/schedules',
            'active' => request()->is('users/' . $cuser->id . '/schedules'),
        ],
        [
            'icon' => 'fluentui-person-clock-20-o',
            'active-icon' => 'fluentui-person-clock-20',
            'text' => 'Mis asistencias',
            'href' => '/users/' . $cuser->id . '/assists',
            'active' => request()->is('users/' . $cuser->id . '/assists'),
        ],
    ];

    $otherItems = [
        [
            'icon' => 'fluentui-people-20-o',
            'text' => 'Gestión Usuarios',
            'href' => '/users',
            'active' => request()->is('users*') && !request()->is('users/' . $cuser->id . '*'),
            'enable' => $cuser->hasGroup('users') || $cuser->isDev(),
            'active-icon' => 'fluentui-people-20',
            'subItems' => [
                [
                    'icon' => 'fluentui-people-20-o',
                    'text' => 'Usuarios',
                    'href' => '/users',
                    'active' =>
                        (request()->is('users') || request()->is('users/create')) &&
                        !request()->is('users/' . $cuser->id . '*'),
                    'active-icon' => 'fluentui-people-20',
                    'enable' => $cuser->has('users:create') || $cuser->has('users:show') || $cuser->isDev(),
                ],
                [
                    'icon' => 'fluentui-people-toolbox-20-o',
                    'text' => 'Roles y permisos',
                    'href' => '/users/user-roles',
                    'active' => request()->is('users/user-roles*'),
                    'active-icon' => 'fluentui-people-toolbox-20',
                    'enable' =>
                        $cuser->has('users:user-roles:create') ||
                        $cuser->has('users:user-roles:show') ||
                        $cuser->isDev(),
                ],
            ],
        ],
        [
            'icon' => 'fluentui-folder-people-20-o',
            'text' => 'Gestión Edas',
            'href' => '/edas/collaborators',
            'active' => request()->is('edas*'),
            'active-icon' => 'fluentui-folder-people-20',
            'enable' => $cuser->hasGroup('edas') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'fluentui-folder-person-20-o',
                    'text' => 'Mis edas',
                    'href' => '/edas/me',
                    'active' => request()->is('edas' . '/' . $cuser->id . '*'),
                    'active-icon' => 'fluentui-folder-person-20',
                    'enable' => true,
                ],
                [
                    'icon' => 'fluentui-people-community-20-o',
                    'text' => 'Colaboradores',
                    'href' => '/edas/collaborators',
                    'active' => request()->is('edas/collaborators'),
                    'active-icon' => 'fluentui-people-community-20',
                    'enable' => true,
                ],
                [
                    'icon' => 'fluentui-folder-open-vertical-20-o',
                    'text' => 'Edas',
                    'href' => '/edas',
                    'active' =>
                        (request()->is('edas*') || request()->is('edas*')) &&
                        !request()->is('edas' . '/' . $cuser->id . '*') &&
                        !request()->is('edas/years') &&
                        !request()->is('edas/collaborators') &&
                        !request()->is('edas/questionnaire-templates*'),
                    'active-icon' => 'fluentui-folder-open-vertical-20',
                    'enable' => true,
                ],
                [
                    'icon' => 'fluentui-document-link-20-o',
                    'text' => 'Lista de años',
                    'href' => '/edas/years',
                    'active' => request()->is('edas/years*'),
                    'active-icon' => 'fluentui-document-link-20',
                    'enable' => $cuser->has('edas:years:show') || $cuser->has('edas:years:create') || $cuser->isDev(),
                ],
                [
                    'icon' => 'fluentui-book-template-20-o',
                    'text' => 'Plantilla de cuestionarios',
                    'href' => '/edas/questionnaire-templates',
                    'active' => request()->is('edas/questionnaire-templates*'),
                    'active-icon' => 'fluentui-book-template-20',
                    'enable' =>
                        $cuser->has('edas:questionnaire-templates:show') ||
                        $cuser->has('edas:questionnaire-templates:create') ||
                        $cuser->isDev(),
                ],
            ],
        ],
        [
            'icon' => 'fluentui-text-bullet-list-square-clock-20-o',
            'text' => 'Gestión Asistencias',
            'href' => '/assists',
            'active' => request()->is('assists*'),
            'active-icon' => 'fluentui-text-bullet-list-square-clock-20',
            'enable' => $cuser->hasGroup('assists') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'fluentui-document-text-clock-24-o',
                    'text' => 'Centralizadas',
                    'href' => '/assists',
                    'active' => request()->is('assists'),
                    'enable' => $cuser->has('assists:centralized') || $cuser->isDev(),
                    'active-icon' => 'fluentui-document-text-clock-24',
                ],
                [
                    'icon' => 'fluentui-calculator-arrow-clockwise-20-o',
                    'text' => 'Centralizadas (Sin calc)',
                    'enable' => $cuser->has('assists:centralized-without-calculating') || $cuser->isDev(),
                    'href' => '/assists/centralized-without-calculating',
                    'active' => request()->is('assists/centralized-without-calculating*'),
                    'active-icon' => 'fluentui-calculator-arrow-clockwise-20',
                ],
                [
                    'icon' => 'fluentui-calculator-arrow-clockwise-20-o',
                    'text' => 'Sin calc',
                    'enable' => $cuser->has('assists:without-calculating') || $cuser->isDev(),
                    'href' => '/assists/without-calculating',
                    'active' => request()->is('assists/without-calculating*'),
                    'active-icon' => 'fluentui-calculator-arrow-clockwise-20',
                ],
                [
                    'icon' => 'fluentui-calendar-data-bar-20-o',
                    'text' => 'Resumen único de fechas',
                    'href' => '/assists/single-summary',
                    'enable' => $cuser->has('assists:single-summary') || $cuser->isDev(),
                    'active' => request()->is('assists/single-summary*'),
                    'active-icon' => 'fluentui-calendar-data-bar-20',
                ],
                [
                    'icon' => 'fluentui-calculator-multiple-20-o',
                    'text' => 'Terminales (Biometricos)',
                    'enable' => $cuser->has('assists:terminals:show') || $cuser->isDev(),
                    'href' => '/assists/terminals',
                    'active' => request()->is('assists/terminals*'),
                    'active-icon' => 'fluentui-calculator-multiple-20',
                ],
            ],
        ],
        [
            'icon' => 'fluentui-calendar-data-bar-20-o',
            'text' => 'Gestión Eventos',
            'href' => '/events',
            'active' => request()->is('events*'),
            'active-icon' => 'fluentui-calendar-data-bar-20',
            'enable' => $cuser->hasGroup('events') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'fluentui-megaphone-loud-20-o',
                    'text' => 'Eventos',
                    'href' => '/events',
                    'enable' => $cuser->has('events:show') || $cuser->isDev(),
                    'active' => request()->is('events'),
                    'active-icon' => 'fluentui-megaphone-loud-20',
                ],
                [
                    'icon' => 'fluentui-text-bullet-list-square-person-20-o',
                    'text' => 'Asistencias a eventos',
                    'href' => '/events/assists?selectEvent=true',
                    'enable' => $cuser->has('events:assists:show') || $cuser->isDev(),
                    'active' => request()->is('events/assists'),
                    'active-icon' => 'fluentui-text-bullet-list-square-person-20',
                ],
            ],
        ],
        // [
        //     'icon' => 'fluentui-ticket-diagonal-20-O',
        //     'text' => 'Gestión Tickets',
        //     'href' => '/tickets',
        //     'badge' => 'New',
        //     'active' => request()->is('tickets*'),
        //     'active-icon' => 'fluentui-ticket-diagonal-20',
        //     'enable' => $cuser->hasGroup('tickets') || $cuser->isDev(),
        //     'subItems' => [
        //         [
        //             'icon' => 'fluentui-add-circle-20-o',
        //             'text' => 'Registro de ticket',
        //             'href' => '/tickets/create',
        //             'enable' => $cuser->has('tickets:create') || $cuser->isDev(),
        //             'active' => request()->is('tickets/create'),
        //             'active-icon' => 'fluentui-add-circle-20',
        //         ],
        //         [
        //             'icon' => 'fluentui-ticket-horizontal-20-o',
        //             'text' => 'Tickets',
        //             'href' => '/tickets',
        //             'enable' => $cuser->has('tickets:show') || $cuser->isDev(),
        //             'active' => request()->is('tickets'),
        //             'active-icon' => 'fluentui-ticket-horizontal-20',
        //         ],
        //         [
        //             'icon' => 'fluentui-tv-20-o',
        //             'text' => 'Pantalla de tickets',
        //             'href' => '/tickets/screen',
        //             'enable' => $cuser->has('tickets:screen') || $cuser->isDev(),
        //             'active' => request()->is('tickets/screen*'),
        //             'active-icon' => 'fluentui-tv-20',
        //         ],
        //         [
        //             'icon' => 'fluentui-checkbox-person-20-o',
        //             'text' => 'Atenciones',
        //             'href' => '/tickets/attentions',
        //             'enable' => $cuser->has('tickets:attentions:show') || $cuser->isDev(),
        //             'active' => request()->is('tickets/attentions*'),
        //             'active-icon' => 'fluentui-checkbox-person-20',
        //         ],
        //         [
        //             'icon' => 'fluentui-settings-20-o',
        //             'text' => 'Ajustes',
        //             'href' => '/tickets/settings',
        //             'enable' => $cuser->has('tickets:settings') || $cuser->isDev(),
        //             'active' => request()->is('tickets/settings*'),
        //             'active-icon' => 'fluentui-settings-20',
        //         ],
        //     ],
        // ],
        [
            'icon' => 'fluentui-shield-person-20-o',
            'text' => 'Gestión auditoria',
            'href' => '/audit',
            'active' => request()->is('audit*'),
            'active-icon' => 'fluentui-shield-person-20',
            'enable' => $cuser->hasGroup('audit') || $cuser->isDev(),
        ],
        [
            'icon' => 'fluentui-data-bar-vertical-add-20-o',
            'text' => 'Gestión Reportes',
            'href' => '/reports',
            'active' => request()->is('reports*'),
            'active-icon' => 'fluentui-data-bar-vertical-add-20',
            'enable' => $cuser->hasGroup('reports') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'fluentui-folder-20-o',
                    'text' => 'Archivos',
                    'href' => '/reports/files',
                    'active' => request()->is('reports/files'),
                    'active-icon' => 'fluentui-folder-20',
                ],
            ],
        ],
        [
            'icon' => 'fluentui-apps-16-o',
            'text' => 'Ajustes',
            'href' => '/settings',
            'active' => request()->is('settings*'),
            'active-icon' => 'fluentui-apps-16',
            'enable' => $cuser->hasGroup('settings') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'fluentui-edit-settings-20-o',
                    'text' => 'Areas',
                    'href' => '/settings',
                    'active' => request()->is('settings'),
                    'active-icon' => 'fluentui-edit-settings-20',
                ],
                [
                    'icon' => 'fluentui-edit-settings-20-o',
                    'text' => 'Departamentos',
                    'href' => '/settings/departments',
                    'active' => request()->is('settings/departments*'),
                    'active-icon' => 'fluentui-edit-settings-20',
                ],
                [
                    'icon' => 'fluentui-edit-settings-20-o',
                    'text' => 'Puestos',
                    'href' => '/settings/job-positions',
                    'active' => request()->is('settings/job-positions*'),
                    'active-icon' => 'fluentui-edit-settings-20',
                ],
                [
                    'icon' => 'fluentui-edit-settings-20-o',
                    'text' => 'Cargos',
                    'href' => '/settings/roles',
                    'active' => request()->is('settings/roles*'),
                    'active-icon' => 'fluentui-edit-settings-20',
                ],
                [
                    'icon' => 'fluentui-location-20-o',
                    'text' => 'Sedes',
                    'href' => '/settings/branches',
                    'active' => request()->is('settings/branches*'),
                    'active-icon' => 'fluentui-location-20',
                ],
                [
                    'icon' => 'fluentui-building-multiple-20-o',
                    'text' => 'Unidad de negocios',
                    'href' => '/settings/business-units',
                    'active' => request()->is('settings/business-units*'),
                    'active-icon' => 'fluentui-building-multiple-20',
                ],
                [
                    'icon' => 'fluentui-handshake-20-o',
                    'text' => 'Tipos de contrato',
                    'href' => '/settings/contract_types',
                    'active' => request()->is('settings/contract_types*'),
                    'active-icon' => 'fluentui-handshake-20',
                ],
            ],
        ],
    ];

    $userBirthday = request()->attributes->get('birthdayUsers') ?? [];
@endphp



<nav class="pb-2 transition-all">
    @foreach ($userItems as $item)
        <a title="{{ $item['text'] }}" {{ isset($item['active']) && $item['active'] ? 'data-active' : '' }}
            class="flex group relative transition-all items-center data-[active]:font-semibold gap-3 p-2 px-2 data-[active]:text-[#115ea3] text-black hover:bg-stone-200 rounded-lg"
            href="{{ $item['href'] }}">
            @if (isset($item['imageURL']))
                @include('commons.avatar', [
                    'src' => $item['imageURL'],
                    'className' => 'w-7',
                    'alt' => $item['text'],
                    'altClass' => 'text-xl',
                ])
            @else
                @svg($item['active'] ? $item['active-icon'] : $item['icon'], 'w-5 h-5 m-0.5 opacity-70 group-data-[active]:opacity-100 group-data-[active]:text-[#115ea3]')
            @endif
            <span class="text-nowrap">{{ $item['text'] }}</span>
        </a>
    @endforeach
</nav>

@if (
    $otherItems[0]['enable'] ||
        $otherItems[1]['enable'] ||
        $otherItems[2]['enable'] ||
        $otherItems[3]['enable'] ||
        $otherItems[4]['enable'] ||
        $otherItems[5]['enable'] ||
        $otherItems[6]['enable'] ||
        $otherItems[7]['enable'] ||
        $otherItems[8]['enable']
)
    <nav class="py-2 border-t border-neutral-300 transition-all">
        @foreach ($otherItems as $item)
            @if (!$item['enable'])
                @continue
            @endif
            @php
                $href = $item['href'] ?? null;
            @endphp
            <div class="sidebar-item group data-[expanded]:my-1 data-[expanded]:rounded-xl data-[expanded]:p-1 data-[expanded]:bg-white data-[expanded]:drop-shadow-[0px_2px_8px_rgba(0,_0,_0,_0.15)]"
                {{ $item['active'] ? 'data-expanded' : '' }}>
                <a href="{{ $href }}"
                    class="flex sidebar-item-button transition-all w-full text-left relative items-center group-data-[expanded]:font-semibold gap-3 p-2 px-2 text-black hover:bg-stone-200 rounded-lg">
                    @svg($item['active'] ? $item['active-icon'] : $item['icon'], 'w-5 h-5 m-0.5 group-data-[expanded]:text-[#115ea3]')
                    <span class="text-nowrap">{{ $item['text'] }}</span>
                    @if (isset($item['badge']))
                        <span
                            class="bg-[#115ea3] rounded-full px-1.5 font-medium text-[11px] text-white">{{ $item['badge'] }}</span>
                    @endif
                    @if (isset($item['subItems']))
                        @svg('fluentui-chevron-down-16', 'w-3 h-3 ml-auto group-data-[expanded]:rotate-0 -rotate-90 transition-all')
                    @endif
                </a>
                @if (isset($item['subItems']))
                    <div class="sidebar-item-content " {{ $item['active'] ? 'data-expanded' : '' }}>
                        @foreach ($item['subItems'] as $subItem)
                            @if (isset($subItem['enable']) && !$subItem['enable'])
                                @continue
                            @endif
                            <a {{ $subItem['active'] ? 'data-active' : '' }}
                                class="flex group relative transition-all items-center data-[active]:font-semibold gap-3 p-2 px-2 pl-5 text-black hover:bg-stone-200 rounded-lg"
                                href="{{ $subItem['href'] }}">
                                @svg($subItem['active'] ? $subItem['active-icon'] : $subItem['icon'], 'w-5 h-5 m-0.5 group-data-[active]:text-[#115ea3]')
                                <span class="text-nowrap">{{ $subItem['text'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>
@endif

@if (count($userBirthday) > 0)
    <div class="border-t border-neutral-30 px-3">
        <h1 class="text-xs font-semibold py-2">
            Cumpleaños
        </h1>
        <div class="flex gap-2 items-start">
            <img class="w-[25px]" src="/birthday-gift.webp" alt="birthday-gift">
            <p class="font-normal">
                @foreach ($userBirthday as $user)
                    <a class="font-semibold hover:underline" href="/users/{{ $user->id }}">
                        {{ $user->names() }}{{ !$loop->last ? ', ' : '' }}
                    </a>
                @endforeach
                {{ count($userBirthday) > 1 ? 'cumplen' : 'cumple' }}
                años hoy.
            </p>
        </div>
    </div>
@endif
