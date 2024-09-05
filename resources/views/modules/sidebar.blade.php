@php

    $userItems = [
        [
            'icon' => 'bx-home-smile',
            'text' => $cuser->first_name,
            'href' => '/users/' . $cuser->id,
            'active' => request()->is('users/' . $cuser->id . '*'),
        ],
        [
            'icon' => 'bx-folder',
            'text' => 'Mis edas',
            'href' => '/edas/me',
        ],
        [
            'icon' => 'bx-calendar-event',
            'text' => 'Mis horarios',
            'href' => '/users/' . $cuser->id . '/schedules',
        ],
        [
            'icon' => 'bx-calendar-check',
            'text' => 'Mis asistencias',
            'href' => '/users/' . $cuser->id . '/assists',
        ],
    ];

    $otherItems = [
        [
            'icon' => 'bx-group',
            'text' => 'Gestión Usuarios',
            'href' => null,
            'active' => request()->is('users*') && !request()->is('users/' . $cuser->id . '*'),
            'enable' => $cuser->hasGroup('users') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'bx-user-circle',
                    'text' => 'Usuarios',
                    'href' => '/users',
                    'active' =>
                        (request()->is('users') || request()->is('users/create')) &&
                        !request()->is('users/' . $cuser->id . '*'),
                    'active-icon' => 'bxs-user-circle',
                    'enable' => $cuser->has('users:create') || $cuser->has('users:show') || $cuser->isDev(),
                ],
                [
                    'icon' => 'bx-wrench',
                    'text' => 'Roles y permisos',
                    'href' => '/users/user-roles',
                    'active' => request()->is('users/user-roles*'),
                    'active-icon' => 'bxs-wrench',
                    'enable' =>
                        $cuser->has('users:user-roles:create') ||
                        $cuser->has('users:user-roles:show') ||
                        $cuser->isDev(),
                ],
                [
                    'icon' => 'bx-calendar',
                    'text' => 'Horarios',
                    'href' => '/users/schedules',
                    'active' => request()->is('users/schedules*'),
                    'active-icon' => 'bxs-calendar',
                    'enable' =>
                        $cuser->has('users:schedules:create') || $cuser->has('users:schedules:show') || $cuser->isDev(),
                ],
                [
                    'icon' => 'bx-universal-access',
                    'text' => 'Correos y accesos',
                    'href' => '/users/emails-access',
                    'active' => request()->is('users/emails-access*'),
                    'active-icon' => 'bxs-universal-access',
                    'enable' =>
                        $cuser->has('users:emails-access:edit') ||
                        $cuser->has('users:emails-access:show') ||
                        $cuser->isDev(),
                ],
            ],
        ],
        [
            'icon' => 'bx-folder',
            'text' => 'Gestión Edas',
            'href' => '/edas/collaborators',
            'active' => request()->is('edas*'),
            'enable' => $cuser->hasGroup('edas') || $cuser->isDev(),
            'subItems' => [
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
            ],
        ],
        [
            'icon' => 'bx-calendar',
            'text' => 'Gestión Asistencias',
            'href' => '/assists',
            'active' => request()->is('assists*'),
            'enable' => $cuser->hasGroup('assists') || $cuser->isDev(),
            'subItems' => [
                [
                    'icon' => 'heroicon-o-clipboard-document-list',
                    'text' => 'Asistencias centralizadas',
                    'href' => '/assists',
                    'active' => request()->is('assists'),
                    'active-icon' => 'heroicon-s-clipboard-document-list',
                ],
                [
                    'icon' => 'bx-list-ul',
                    'text' => 'Asistencias sin horario',
                    'href' => '/assists/sn-schedules',
                    'active' => request()->is('assists/sn-schedules*'),
                    'active-icon' => 'bx-list-ul',
                ],
                [
                    'icon' => 'bx-list-ul',
                    'text' => 'Asistencias por horario',
                    'href' => '/assists/peer-schedule',
                    'active' => request()->is('assists/peer-schedule*'),
                    'active-icon' => 'bx-list-ul',
                ],
                [
                    'icon' => 'bx-list-ul',
                    'text' => 'Resumen único de fechas',
                    'href' => '/assists/single-summary',
                    'active' => request()->is('assists/single-summary*'),
                    'active-icon' => 'bx-list-ul',
                ],
                [
                    'icon' => 'heroicon-o-circle-stack',
                    'text' => 'Terminales',
                    'href' => '/assists/terminals',
                    'active' => request()->is('assists/terminals*'),
                    'active-icon' => 'heroicon-s-circle-stack',
                ],
            ],
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
            'active' => request()->is('settings*'),
            'enable' => $cuser->hasGroup('settings') || $cuser->isDev(),
            'subItems' => [
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
            ],
        ],
    ];
@endphp



<nav class="pb-2 transition-all">
    @foreach ($userItems as $item)
        <a title="{{ $item['text'] }}" {{ isset($item['active']) && $item['active'] ? 'data-active' : '' }}
            class="flex group relative transition-all font-semibold items-center data-[active]:font-bold gap-3 p-2 px-5 data-[active]:text-[#1967da] text-black hover:bg-[#e8eaed] rounded-r-full"
            href="{{ $item['href'] }}">
            @svg($item['icon'], 'w-6 h-6 m-0.5 opacity-70 group-data-[active]:opacity-100 group-data-[active]:text-blue-600')
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
                <button
                    class="flex sidebar-item-button font-semibold group-data-[expanded]:bg-blue-50 transition-all w-full text-left relative items-center group-data-[expanded]:font-bold group-data-[expanded]:text-[#1967da] gap-3 p-2 px-5 text-black hover:bg-[#e8eaed] rounded-r-full">
                    @svg($item['icon'], 'w-6 h-6 m-0.5 opacity-70 group-data-[expanded]:text-blue-600 group-data-[expanded]:opacity-100')
                    <span class="text-nowrap">{{ $item['text'] }}</span>
                    @if (isset($item['subItems']))
                        @svg('bx-chevron-right', 'w-4 h-4 ml-auto group-data-[expanded]:rotate-90 transition-all')
                    @endif
                </button>
                @if (isset($item['subItems']))
                    <div class="sidebar-item-content" {{ $item['active'] ? 'data-expanded' : '' }}>
                        @foreach ($item['subItems'] as $subItem)
                            @if (isset($subItem['enable']) && !$subItem['enable'])
                                @continue
                            @endif
                            <a {{ $subItem['active'] ? 'data-active' : '' }}
                                class="flex group relative font-semibold transition-all items-center data-[active]:font-bold data-[active]:text-[#1967da] gap-3 p-2 px-5 pl-8 text-black hover:bg-[#f4f5f7] rounded-r-full"
                                href="{{ $subItem['href'] }}">
                                @svg($subItem['active'] ? $subItem['active-icon'] : $subItem['icon'], 'w-6 h-6 m-0.5 opacity-70 group-data-[active]:opacity-100 group-data-[active]:text-blue-600')
                                <span class="text-nowrap">{{ $subItem['text'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>
@endif
