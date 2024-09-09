@php

    $userItems = [
        [
            'icon' => 'fluentui-home-48-o',
            'active-icon' => 'fluentui-home-48',
            'text' => $cuser->first_name,
            'href' => '/users/' . $cuser->id,
            'active' => request()->is('users/' . $cuser->id . '*'),
        ],
        [
            'icon' => 'fluentui-folder-person-20-o',
            'active-icon' => 'fluentui-folder-person-20',
            'text' => 'Mis edas',
            'href' => '/edas/me',
            'active' => request()->is('edas/' . $cuser->id . '*'),
        ],
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
                // [
                //     'icon' => 'fluentui-people-settings-20-o',
                //     'text' => 'Correos y accesos',
                //     'href' => '/users/emails-access',
                //     'active' => request()->is('users/emails-access*'),
                //     'active-icon' => 'fluentui-people-settings-20',
                //     'enable' =>
                //         $cuser->has('users:emails-access:edit') ||
                //         $cuser->has('users:emails-access:show') ||
                //         $cuser->isDev(),
                // ],
            ],
        ],
        [
            'icon' => 'fluentui-calendar-ltr-20-o',
            'text' => 'Gestión Horarios',
            'href' => '/schedules',
            'active' => request()->is('schedules*'),
            'active-icon' => 'fluentui-calendar-ltr-20',
            'enable' => $cuser->has('schedules:create') || $cuser->has('schedules:show') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'fluentui-calendar-ltr-20-o',
                    'text' => 'Horarios',
                    'href' => '/schedules',
                    'active' => request()->is('schedules*') && !request()->is('schedules/external*'),
                    'active-icon' => 'fluentui-calendar-ltr-20',
                    'enable' => $cuser->has('schedules:create') || $cuser->has('schedules:show') || $cuser->isDev(),
                ],
                [
                    'icon' => 'fluentui-calendar-toolbox-20-o',
                    'text' => 'Horarios externos',
                    'href' => '/schedules/external',
                    'active' => request()->is('schedules/external*'),
                    'active-icon' => 'fluentui-calendar-toolbox-20',
                    'enable' =>
                        $cuser->has('schedules:external:create') ||
                        $cuser->has('schedules:external:show') ||
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
                    'active-icon' => 'fluentui-document-text-clock-24',
                ],
                // [
                //     'icon' => 'fluentui-globe-clock-20-o',
                //     'text' => 'Externas',
                //     'href' => '/assists/external',
                //     'active' => request()->is('assists/external*'),
                //     'active-icon' => 'fluentui-globe-clock-20',
                // ],
                [
                    'icon' => 'fluentui-calculator-arrow-clockwise-20-o',
                    'text' => 'Sin calcular',
                    'href' => '/assists/sn-schedules',
                    'active' => request()->is('assists/sn-schedules*'),
                    'active-icon' => 'fluentui-calculator-arrow-clockwise-20',
                ],
                // [
                //     'icon' => 'fluentui-calculator-arrow-clockwise-20-o',
                //     'text' => 'Calcular por horario',
                //     'href' => '/assists/peer-schedule',
                //     'active' => request()->is('assists/peer-schedule*'),
                //     'active-icon' => 'fluentui-calculator-arrow-clockwise-20',
                // ],
                [
                    'icon' => 'fluentui-calendar-data-bar-20-o',
                    'text' => 'Resumen único de fechas',
                    'href' => '/assists/single-summary',
                    'active' => request()->is('assists/single-summary*'),
                    'active-icon' => 'fluentui-calendar-data-bar-20',
                ],
                [
                    'icon' => 'fluentui-calculator-multiple-20-o',
                    'text' => 'Terminales',
                    'href' => '/assists/terminals',
                    'active' => request()->is('assists/terminals*'),
                    'active-icon' => 'fluentui-calculator-multiple-20',
                ],
            ],
        ],
        [
            'icon' => 'fluentui-apps-16-o',
            'text' => 'Ajustes y mantenimiento',
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
            ],
        ],
    ];
@endphp



<nav class="pb-2 transition-all">
    @foreach ($userItems as $item)
        <a title="{{ $item['text'] }}" {{ isset($item['active']) && $item['active'] ? 'data-active' : '' }}
            class="flex group relative transition-all items-center data-[active]:font-semibold gap-3 p-2 px-5 data-[active]:text-[#1967da] text-black hover:bg-white rounded-lg"
            href="{{ $item['href'] }}">
            @svg($item['active'] ? $item['active-icon'] : $item['icon'], 'w-5 h-5 m-0.5 opacity-70 group-data-[active]:opacity-100 group-data-[active]:text-blue-600')
            <span class="text-nowrap">{{ $item['text'] }}</span>
        </a>
    @endforeach
</nav>

@if ($otherItems[0]['enable'] || $otherItems[1]['enable'] || $otherItems[2]['enable'] || $otherItems[3]['enable'])
    <nav class="py-2 border-t border-neutral-300 transition-all">
        @foreach ($otherItems as $item)
            @if (!$item['enable'])
                @continue
            @endif
            @php
                $href = $item['href'] ?? null;
            @endphp
            <div class="sidebar-item group" {{ $item['active'] ? 'data-expanded' : '' }}>
                <a href="{{ $href }}"
                    class="flex sidebar-item-button group-data-[expanded]:bg-white transition-all w-full text-left relative items-center group-data-[expanded]:font-semibold group-data-[expanded]:text-[#1967da] gap-3 p-2 px-5 text-black hover:bg-white rounded-lg">
                    @svg($item['active'] ? $item['active-icon'] : $item['icon'], 'w-5 h-5 m-0.5 group-data-[expanded]:text-blue-600')
                    <span class="text-nowrap">{{ $item['text'] }}</span>
                    @if (isset($item['subItems']))
                        @svg('fluentui-chevron-down-16', 'w-3 h-3 ml-auto group-data-[expanded]:rotate-0 -rotate-90 transition-all')
                    @endif
                </a>
                @if (isset($item['subItems']))
                    <div class="sidebar-item-content data-[expanded]:mb-3" {{ $item['active'] ? 'data-expanded' : '' }}>
                        @foreach ($item['subItems'] as $subItem)
                            @if (isset($subItem['enable']) && !$subItem['enable'])
                                @continue
                            @endif
                            <a {{ $subItem['active'] ? 'data-active' : '' }}
                                class="flex group relative transition-all items-center data-[active]:font-semibold data-[active]:text-[#1967da] gap-3 p-2 px-5 pl-8 text-black hover:bg-white rounded-lg"
                                href="{{ $subItem['href'] }}">
                                @svg($subItem['active'] ? $subItem['active-icon'] : $subItem['icon'], 'w-5 h-5 m-0.5 group-data-[active]:text-blue-600')
                                <span class="text-nowrap">{{ $subItem['text'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>
@endif
