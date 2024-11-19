@extends('modules.users.+layout')

@section('title', 'Usuario: ' . $user->first_name . ' ' . $user->last_name)

@php
    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;

    $now = now();

    $items = [
        [
            'title' => 'Descripción general',
            'href' => '/users/' . $user->id,
            'active' => request()->is('users/' . $user->id),
            'enabled' => true,
        ],
        [
            'title' => 'Organización',
            'href' => '/users/' . $user->id . '/organization',
            'active' => request()->is('users/' . $user->id . '/organization'),
            'enabled' => true,
        ],
        [
            'title' => 'Horarios',
            'href' => '/users/' . $user->id . '/schedules',
            'active' => request()->is('users/' . $user->id . '/schedules'),
            'enabled' => true,
        ],
        [
            'title' => 'Asistencias',
            'href' =>
                '/assists?query=' .
                $user->dni .
                '&assist_terminals=' .
                ($user->schedules->isNotEmpty() ? $user->schedules->pluck('terminal_id')->join(',') : '') .
                '&start=' .
                $now->startOfMonth()->toDateString() .
                '&end=' .
                $now->endOfMonth()->toDateString(),
            'active' => request()->is('users/' . $user->id . '/assists'),
            'enabled' => $user->schedules->isNotEmpty(),
        ],
    ];

    $hasChangePhoto = $cuser->has('users:edit') || $cuser->id === $user->id || $cuser->isDev();
@endphp

@section('layout.users')
    <div class="text-black pt-4 pb-2 w-full flex-col flex-grow flex overflow-y-auto">
        <div class="w-full h-full flex-grow flex flex-col">
            <header class="p-3 rounded-xl max-w-7xl w-full mx-auto">
                <div class="flex gap-4 items-center overflow-hidden">
                    <div class="relative group w-fit overflow-hidden rounded-full">
                        <div class="flex items-center gap-4">
                            <div class="relative rounded-full overflow-hidden w-28 aspect-square">
                                <input data-notoutline-styles data-userid="{{ $user->id }}" class="hidden" type="file"
                                    name="profile" id="input-profile" accept="image/*">
                                <img id="preview-profile" class="w-full h-full object-cover" src={{ $profile }}
                                    alt="{{ $profile }}">
                            </div>
                        </div>
                        @if ($hasChangePhoto)
                            <button onclick="document.getElementById('input-profile').click()"
                                class="bg-white/80 hidden z-10 group-hover:grid place-content-center absolute inset-0">
                                @svg('fluentui-image-edit-24-o', 'w-6 h-6')
                            </button>
                        @endif
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <h2 class="text-2xl font-medium tracking-tight text-nowrap text-ellipsis">
                            {{ $user->names() }}
                        </h2>
                        <p class="text-sm opacity-70">
                            {{ $user->role_position->name }}
                            • {{ $user->department()->name }}
                        </p>

                        <a href="mailto:{{ $user->email }}" class="flex text-xs font-semibold items-center gap-2 w-fit">
                            @svg('fluentui-mail-20-o', 'w-5 h-5')
                        </a>
                    </div>
                </div>
                <nav class="border-b mt-2 text-sm flex items-center text-stone-700">
                    @foreach ($items as $item)
                        @if (!$item['enabled'])
                            @continue
                        @endif
                        <a href="{{ $item['href'] }}" {{ $item['active'] ? 'data-current="true"' : '' }}
                            class="p-2 hover:bg-neutral-100 hover:text-stone-800 data-[current]:font-semibold border-b-2 border-transparent data-[current]:border-blue-500">
                            {{ $item['title'] }}
                        </a>
                    @endforeach
                </nav>
            </header>
            <div class="flex h-full flex-grow flex-col rounded-xl">
                @yield('layout.users.slug')
            </div>
        </div>
    </div>
@endsection
