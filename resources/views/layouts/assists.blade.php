@extends('layouts.app')

@section('title', 'Gestión de Asistencias')

@php
    $items = [
        [
            'name' => 'En tiempo real',
            'link' => 'assists',
        ],
        ['name' => 'Horarios', 'link' => 'assists.schedules'],
    ];
@endphp

@section('content')
    <div class="flex flex-col h-full overflow-y-auto">
        <div class="pb-2">
            <h2 class="font-semibold tracking-tight text-lg opacity-70">Gestión de asistencias y horarios</h2>
        </div>
        <div class="flex mb-2 gap-2 pb-2">
            @foreach ($items as $item)
                <a {{ request()->is($item['link']) ? 'data-open' : '' }} href="{{ route($item['link']) }}"
                    class="rounded-full border-2 p-1.5 data-[open]:border-blue-600 data-[open]:bg-blue-500/5 font-semibold px-3 bg-white">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
        @yield('content.assists')
    </div>
@endsection
