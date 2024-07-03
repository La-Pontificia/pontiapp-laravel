@extends('layouts.app')

@section('title', 'Gestión de Edas')

@php
    $id_year = request()->route('year');
@endphp

@section('content')
    <div class="text-black h-full py-2 w-full flex-grow flex flex-col overflow-y-auto">
        <header class="space-y-4">
            <nav class="border-b flex [&>a]:font-medium [&>a]:text-sm text-neutral-700">
                <a {{ request()->is('edas') ? 'data-state=open' : '' }} href="{{ route('edas') }}"
                    class="p-3 px-6 data-[state=open]:text-[#5b5fc7] data-[state=open]:font-medium rounded-sm relative hover:bg-neutral-200">
                    Colaboradores
                    <span {{ request()->is('edas') ? 'data-state=open' : '' }}
                        class="absolute hidden data-[state=open]:block left-0 bottom-0 inset-x-0 border-b-2 border-[#5b5fc7]"></span>
                </a>
                <a {{ request()->is('edas/surveys') ? 'data-state=open' : '' }} href="{{ route('edas.surveys') }}"
                    class="p-3 px-6 data-[state=open]:text-[#5b5fc7] data-[state=open]:font-medium rounded-sm relative hover:bg-neutral-200">
                    Cuestionarios
                    <span {{ request()->is('edas/surveys') ? 'data-state=open' : '' }}
                        class="absolute hidden data-[state=open]:block left-0 bottom-0 inset-x-0 border-b-2 border-[#5b5fc7]"></span>
                </a>
            </nav>
        </header>
        <div class="h-full pt-4 overflow-y-auto">
            @yield('content-eda')
        </div>
    </div>
@endsection
