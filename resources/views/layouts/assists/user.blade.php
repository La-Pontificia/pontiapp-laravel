@extends('layouts.app')

@section('title', 'Gestión de Asistencias: ' . $user->last_name . ' ' . $user->first_name)

@php
    $items = [
        [
            'name' => 'Asistencias',
            'link' => route('assists.user', ['id_user' => $user->id]),
            'active' => request()->is('assists/' . $user->id),
        ],
        [
            'name' => 'Horarios',
            'link' => route('assists.user.schedules', ['id_user' => $user->id]),
            'active' => request()->is('assists/' . $user->id . '/schedules'),
        ],
        // ['name' => 'Por usuario', 'link' => 'assists.schedules'],
    ];
@endphp

@section('content')
    <div class="flex flex-col h-full overflow-y-auto">
        {{-- @include('components.users.card', ['user' => $user]) --}}
        <div class="flex gap-2 pb-2 mt-3">
            @foreach ($items as $item)
                <a {{ $item['active'] ? 'data-open' : '' }} href="{{ $item['link'] }}"
                    class="rounded-full border-2 p-1.5 hover:bg-blue-50 data-[open]:border-blue-600 data-[open]:bg-blue-500/5 font-semibold px-3 bg-white">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
        @yield('content.assists.user')
    </div>
@endsection
