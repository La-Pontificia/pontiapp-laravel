@extends('modules.edas.+layout')

@section('title', 'Gestión de Edas')

@php
    $items = [
        [
            'href' => '/edas/collaborators',
            'text' => 'Colaboradores',
            'active' => request()->is('edas/collaborators'),
        ],
        [
            'href' => '/edas',
            'text' => 'Edas',
            'active' => request()->is('edas'),
        ],
    ];
@endphp

@section('layout.edas')
    <div class="w-full mx-auto overflow-y-auto flex flex-col">
        <header class="pb-3">
            <div class="py-1 px-2">
                <h2 class="text-base">Gestión de edas.</h2>
                <p class="text-sm opacity-70">
                    Administración de los edas de los usuarios. Puedes ver los edas de los usuarios, así como los objetivos
                    de
                    cada uno de ellos.
                </p>
            </div>

            <div class="border-b flex items-center gap-2">
                @foreach ($items as $item)
                    <a {{ $item['active'] ? 'data-active' : '' }} href="{{ $item['href'] }}"
                        class="py-2 block hover:text-neutral-700 text-neutral-500 data-[active]:text-black px-4 font-semibold text-sm border-b data-[active]:border-black border-transparent">
                        {{ $item['text'] }}
                    </a>
                @endforeach
            </div>
        </header>
        @yield('layout.group.edas')
    </div>
@endsection
