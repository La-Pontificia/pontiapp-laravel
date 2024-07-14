@extends('layouts.app')

@section('title', 'Editar usuario: ' . $user->first_name . ' ' . $user->last_name)

@php
    $domains = ['elp.edu.pe', 'ilp.edu.pe', 'gmail.com'];
    $has_assign_email = $current_user->hasPrivilege('assign_email');

    $items = [
        [
            'name' => 'Usuario',
            'link' => route('assists.user', ['id_user' => $user->id]),
            'active' => request()->is('assists/' . $user->id),
        ],
        [
            'name' => 'Horarios',
            'link' => route('assists.user.schedules', ['id_user' => $user->id]),
            'active' => request()->is('assists/' . $user->id . '/schedules'),
        ],
    ];
@endphp

@section('content')

    <div class="text-black w-full flex-grow flex flex-col overflow-y-auto">
        <div class="flex items-center justify-between p-4">
            <button onclick="window.history.back()" class="text-lg flex gap-2 items-center font-semibold text-gray-900 ">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                {{ $user->last_name }}, {{ $user->first_name }}
            </button>
        </div>
        <div class="flex items-center [&>a]:p-2 border-b [&>a]:block">
            <a href="">Usuario</a>
            <a href="">Correos</a>
            <a href="">Horario laboral</a>
        </div>
        <div class="flex-grow h-full w-full">
            {{-- @yield('content.user.layout') --}}
        </div>
    </div>

@endsection
