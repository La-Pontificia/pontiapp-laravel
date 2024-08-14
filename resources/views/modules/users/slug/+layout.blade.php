@extends('modules.users.+layout')

@section('title', 'Usuario: ' . $user->first_name . ' ' . $user->last_name)

@php
    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;
@endphp

@section('layout.users')
    <div class="text-black px-5 pb-5 max-w-3xl max-lg:max-w-full mx-auto w-full flex-col flex-grow flex overflow-y-auto">
        <header class="mb-5">
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
                    <button onclick="document.getElementById('input-profile').click()" tip="Cambiar foto de perfil"
                        class="bg-[#ffffff] text-blue-500 shadow-md absolute bottom-2 right-2 rounded-full">
                        @svg('bx-refresh', 'h-6 w-6')
                    </button>
                </div>
                <div>
                    <h2 class="text-lg tracking-tight text-nowrap text-ellipsis font-medium">
                        {{ $user->last_name }}, {{ $user->first_name }}
                    </h2>
                    <p class="text-sm">
                        {{ $user->role_position->name }}, {{ $user->role_position->department->name }}
                    </p>
                </div>
            </div>
        </header>
        <div
            class="bg-white flex flex-col overflow-auto border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @yield('layout.users.slug')
        </div>
    </div>
@endsection
