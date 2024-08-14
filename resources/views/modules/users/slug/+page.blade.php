@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)

@php
    $myaccount = $cuser->id == $user->id;
    $hasChangePassword = $myaccount || $cuser->has('users:reset-password');
@endphp

@section('layout.users.slug')
    <div class="divide-y hover:[&>a]:bg-neutral-100">
        <a href="/users/{{ $user->id }}/details" class="flex items-center p-4 gap-3">
            @svg('bxs-user-badge', 'h-5 w-5 opacity-50')
            Información personal
            @svg('bxs-right-arrow', 'h-2 w-2 ml-auto')
        </a>
        <a href="/users/{{ $user->id }}/organization" class="flex items-center p-4 gap-3">
            @svg('bxs-building-house', 'h-5 w-5 opacity-50')
            Organización
            @svg('bxs-right-arrow', 'h-2 w-2 ml-auto')
        </a>
        <a href="/users/{{ $user->id }}/schedules" class="flex items-center p-4 gap-3">
            @svg('bxs-calendar', 'h-5 w-5 opacity-50')
            Horarios
            @svg('bxs-right-arrow', 'h-2 w-2 ml-auto')
        </a>
        <a href="/users/{{ $user->id }}/assists" class="flex items-center p-4 gap-3">
            @svg('bxs-time-five', 'h-5 w-5 opacity-50')
            Asistencias
            @svg('bxs-right-arrow', 'h-2 w-2 ml-auto')
        </a>
        <a href="/users/{{ $user->id }}/segurity-access" class="flex items-center p-4 gap-3">
            @svg('bx-shield-quarter', 'h-5 w-5 opacity-50')
            Seguridad y acceso
            @svg('bxs-right-arrow', 'h-2 w-2 ml-auto')
        </a>
    </div>
@endsection
