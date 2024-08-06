@php
    $items = [
        [
            'icon' => 'heroicon-o-users',
            'text' => 'Usuarios',
            'href' => '/users',
            'active' =>
                request()->is('users') || request()->is('users/create') || request()->is('users/' . $cuser->id . '*'),
            'active-icon' => 'heroicon-s-users',
        ],
        [
            'icon' => 'heroicon-o-wrench-screwdriver',
            'text' => 'Roles',
            'href' => '/users/user-roles',
            'active' => request()->is('users/user-roles*'),
            'active-icon' => 'heroicon-s-wrench-screwdriver',
        ],
        [
            'icon' => 'heroicon-o-calendar-days',
            'text' => 'Horarios',
            'href' => '/users/schedules',
            'active' => request()->is('users/schedules*'),
            'active-icon' => 'heroicon-s-calendar-days',
        ],
        [
            'icon' => 'heroicon-o-inbox-stack',
            'text' => 'Correos y accesos',
            'href' => '/users/emails',
            'active' => request()->is('users/emails*'),
            'active-icon' => 'heroicon-s-inbox-stack',
        ],
        [
            'icon' => 'heroicon-o-briefcase',
            'text' => 'Puestos',
            'href' => '/users/job-positions',
            'active' => request()->is('users/job-positions*'),
            'active-icon' => 'heroicon-s-briefcase',
        ],
        [
            'icon' => 'heroicon-o-briefcase',
            'text' => 'Cargos',
            'href' => '/users/roles',
            'active' => request()->is('users/roles*'),
            'active-icon' => 'heroicon-s-briefcase',
        ],
    ];
@endphp
<div class="flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between p-4">
        <a href="/" class="flex gap-2 font-medium items-center text-gray-900 ">
            @svg('heroicon-o-arrow-left', [
                'class' => 'w-5 h-5',
            ])
            <span class="max-md:hidden">Gestión de usuarios</span>
        </a>
    </div>
    <nav class="px-2 py-2 pt-0">
        @foreach ($items as $item)
            <a {{ $item['active'] ? 'data-active' : '' }} title="{{ $item['text'] }}"
                class="flex group relative data-[active]:font-medium gap-2 p-2 hover:bg-neutral-200 rounded-lg"
                href="{{ $item['href'] }}">
                @svg($item['active'] ? $item['active-icon'] : $item['icon'], [
                    'class' => 'w-5 h-5 max-md:w-6 max-md:h-6 max-md:mx-auto group-data-[active]:text-blue-800',
                ])
                <span class="max-md:hidden">{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
