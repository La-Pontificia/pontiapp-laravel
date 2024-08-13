@php
    $items = [
        [
            'icon' => 'bx-user-circle',
            'text' => 'Usuarios',
            'href' => '/users',
            'active' =>
                request()->is('users') || request()->is('users/create') || request()->is('users/' . $cuser->id . '*'),
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
                $cuser->has('users:user-roles:create') || $cuser->has('users:user-roles:show') || $cuser->isDev(),
        ],
        [
            'icon' => 'bx-calendar',
            'text' => 'Horarios',
            'href' => '/users/schedules',
            'active' => request()->is('users/schedules*'),
            'active-icon' => 'bxs-calendar',
            'enable' => $cuser->has('users:schedules:create') || $cuser->has('users:schedules:show') || $cuser->isDev(),
        ],
        [
            'icon' => 'bx-universal-access',
            'text' => 'Correos y accesos',
            'href' => '/users/emails-access',
            'active' => request()->is('users/emails-access*'),
            'active-icon' => 'bxs-universal-access',
            'enable' =>
                $cuser->has('users:emails-access:edit') || $cuser->has('users:emails-access:show') || $cuser->isDev(),
        ],
        // [
        //     'icon' => 'bx-down-arrow-circle',
        //     'text' => 'Importar',
        //     'href' => '/users/import',
        //     'active' => request()->is('users/import*'),
        //     'active-icon' => 'bxs-down-arrow-circle',
        //     'enable' => $cuser->has('users:import') || $cuser->isDev(),
        // ],
        // [
        //     'icon' => 'bx-up-arrow-circle',
        //     'text' => 'Exportar',
        //     'href' => '/users/export',
        //     'active' => request()->is('users/export*'),
        //     'active-icon' => 'bxs-up-arrow-circle',
        //     'enable' => $cuser->has('users:export') || $cuser->isDev(),
        // ],
    ];
@endphp

<div class="border-b pb-3">
    <a href="/" class="flex items-center gap-2 group p-2 px-4 pb-0">
        @svg('bx-arrow-back', [
            'class' => 'w-7 h-7 rounded-full p-1 group-hover:bg-neutral-200',
        ])
        <span>Usuarios del sistema</span>
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
