@extends('layouts.app')

@section('title', 'Gestión de Edas: ' . $user->first_name . ' ' . $user->last_name)

@php
    $id_year = request()->route('year');
@endphp

@section('content')
    <div class="text-black h-full py-2 w-full flex-grow flex flex-col overflow-y-auto">
        <header class="space-y-4">
            <nav class="flex items-center gap-2 p-4 pb-0 hover:[&>a]:text-blue-600 hover:[&>a]:underline text-base">
                <div class="flex text-sm items-center gap-3">
                    <div class="w-28 rounded-full overflow-hidden border aspect-square">
                        <img src={{ $user->profile }} class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="text-xl font-bold tracking-wide">
                            <span>{{ ucfirst(strtolower(explode(' ', $user->first_name)[0])) }}</span>
                            <span>{{ ucfirst(strtolower(explode(' ', $user->last_name)[0])) }}</span>
                        </p>
                        <p class="font-normal text-neutral-600">
                            {{ $user->role_position->name }} • {{ $user->role_position->job_position->name }}

                        </p>

                        @if ($user->id_supervisor)
                            <p class="text-neutral-600 inline-flex items-center gap-2">
                                Supervisado por:
                                <a href="/profile/" class="text-indigo-700 inline-flex gap-1 items-center hover:underline">
                                    <span class="w-4 border inline-block rounded-xl overflow-hidden aspect-square">
                                        <img src={{ $user->supervisor->profile }} class="w-full h-full object-cover"
                                            alt="">
                                    </span>
                                    {{ $user->supervisor->last_name }},
                                    {{ $user->supervisor->first_name }}
                                </a>
                            </p>
                        @endif
                        <a href="" class="text-[#5b5fc7] text-sm hover:underline flex items-center gap-1">
                            Organización
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-network">
                                <rect x="16" y="16" width="6" height="6" rx="1" />
                                <rect x="2" y="16" width="6" height="6" rx="1" />
                                <rect x="9" y="2" width="6" height="6" rx="1" />
                                <path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3" />
                                <path d="M12 12V8" />
                            </svg>
                        </a>
                    </div>
                </div>
            </nav>
            <nav class="border-b flex text-neutral-700">
                @foreach ($years as $year)
                    <a {{ request()->is('edas/' . $user->id . '/eda/' . $year->id . '*') ? 'data-state=open' : '' }}
                        href="{{ route('edas.user.eda', ['id_user' => $user->id, 'year' => $year->id]) }}"
                        class="p-3 px-6 data-[state=open]:text-[#5b5fc7] data-[state=open]:font-medium rounded-sm relative hover:bg-neutral-200">
                        {{ $year->name }}
                        <span {{ request()->is('edas/' . $user->id . '/eda/' . $year->id . '*') ? 'data-state=open' : '' }}
                            class="absolute hidden data-[state=open]:block left-0 bottom-0 inset-x-0 border-b-2 border-[#5b5fc7]"></span>
                    </a>
                @endforeach
            </nav>
        </header>
        <div class="h-full pt-4 overflow-y-auto">
            @yield('content-eda-user')
        </div>
    </div>
@endsection
