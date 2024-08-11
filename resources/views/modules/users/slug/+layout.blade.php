@extends('modules.users.+layout')

@section('title', 'Usuario: ' . $user->first_name . ' ' . $user->last_name)

@php
    $items = [
        [
            'title' => 'Información general',
            'link' => '/users/' . $user->id,
            'active' => request()->is('users/' . $user->id),
        ],
        // [
        //     'title' => 'Organización',
        //     'link' => '/users/' . $user->id . '/organization',
        //     'active' => request()->is('users/' . $user->id . '/organization'),
        // ],
        [
            'title' => 'Horario',
            'link' => '/users/' . $user->id . '/schedules',
            'active' => request()->is('users/' . $user->id . '/schedules'),
        ],
        [
            'title' => 'Asistencia',
            'link' => '/users/' . $user->id . '/assists',
            'active' => request()->is('users/' . $user->id . '/assists'),
        ],
    ];

@endphp

@php
    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;
@endphp

@section('layout.users')
    <div class="text-black max-w-5xl mx-auto w-full flex-col flex-grow flex overflow-y-auto">
        <header class="border-b px-4 border-gray-300">
            <div class="pb-2 flex gap-4 items-center overflow-hidden">
                <div class="relative w-fit">
                    <div class="flex items-center gap-4">
                        <div class="relative rounded-full overflow-hidden w-24 border aspect-square">
                            <input data-notoutline-styles data-userid="{{ $user->id }}" class="hidden" type="file"
                                name="profile" id="input-profile" accept="image/*">
                            <img id="preview-profile" class="w-full h-full object-cover" src={{ $profile }}
                                alt="{{ $profile }}">
                        </div>
                    </div>
                    <button onclick="document.getElementById('input-profile').click()" title="Cambiar foto de perfil"
                        class="bg-[#f1f0f4] absolute bottom-3 right-2 rounded-full p-1.5 w-8">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-camera">
                            <path
                                d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                            <circle cx="12" cy="13" r="3" />
                        </svg>
                    </button>
                </div>
                <div>
                    <h2 class="text-2xl tracking-tight text-nowrap text-ellipsis font-medium">
                        {{ $user->last_name }}, {{ $user->first_name }}
                    </h2>
                    <div class="flex items-center gap-2">
                        <p>
                            {{ $user->role_position->name }}
                        </p>
                        {{-- · --}}
                    </div>
                </div>
            </div>
            <nav class="flex text-sm gap-2 pb-3 overflow-x-auto">
                @foreach ($items as $item)
                    <a href="{{ $item['link'] }}" {{ $item['active'] ? 'data-active' : '' }}
                        class="border-2 data-[active]:border-blue-600 hover:border-neutral-500 data-[active]:text-blue-700 data-[active]:bg-blue-500/10 rounded-full py-1.5 px-4">
                        {{ $item['title'] }}
                    </a>
                @endforeach
            </nav>
        </header>
        <div class="w-full flex h-full flex-col overflow-y-auto">
            @yield('layout.users.slug')
        </div>
    </div>
@endsection
