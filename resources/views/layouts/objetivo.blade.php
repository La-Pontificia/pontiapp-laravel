@extends('layouts.sidebar')

@section('content-sidebar')
    <div class="h-full flex flex-col w-full">
        <header>
            <h1 class="text-4xl font-bold tracking-tighter">Objetivos</h1>
        </header>
        <div class=" border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
                role="tablist">
                <li class="mr-2" role="presentation">
                    <a href="{{ route('objetivos.index') }}"
                        class="inline-block p-3 {{ request()->is('objetivos*') ? 'border-b-blue-500 text-blue-700 bg-blue-500/20' : '' }} border-b-2 rounded-t-lg"
                        id="profile-tab">Mis Objetivos</a>
                </li>
                <li class="mr-2" role="presentation">
                    <a href="/calificar"
                        class="inline-block p-3 {{ request()->is('calificar*') ? 'border-b-blue-500 text-blue-700 bg-blue-500/20' : '' }} border-b-2 rounded-t-lg"
                        id="profile-tab">Calificar objetivos</a>
                </li>
            </ul>
        </div>
        @yield('content-objetivo')
    </div>
@endsection
