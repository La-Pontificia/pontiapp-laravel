@extends('layouts.app')

@section('title', 'Gestión de asistencias')

@section('content')
    <div class="w-full flex flex-col overflow-y-auto">
        <div
            class="border-b flex hover:[&>a]:bg-neutral-200 [&>a]:p-2 [&>a]:border-transparent [&>a]:px-4 font-medium text-sm [&>a]:block [&>a]:border-b-4 [&>a]:text-center aria-selected:[&>a]:border-indigo-600 aria-selected:[&>a]:text-indigo-700">
            <a href="" aria-selected="true">
                Real Time
            </a>
            <a href="">
                Individual
            </a>
        </div>
        <div class="p-2 overflow-auto">
            <table class="w-full overflow-x-auto">
                <thead class="border-b">
                    <tr class="text-left [&>th]:text-sm [&>th]:px-3 [&>th]:py-1 [&>th]:font-medium">
                        <th>N°</th>
                        <th class="w-full">Usuario</th>
                        <th>Sede</th>
                        <th>Fecha</th>
                        <th>H. Entrada</th>
                        <th>H. Salida</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assists as $assist)
                        @php
                            $user = $assist->getUserFromMysql();
                        @endphp

                        <tr class="border-b [&>td]:px-3 [&>td]:py-1">
                            <td>{{ $assist->id }}</td>
                            <td>
                                @if ($user)
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 rounded-xl overflow-hidden aspect-square">
                                            <img src={{ $user->profile }} class="w-full h-full object-cover" alt="">
                                        </div>
                                        <div>
                                            <a href="/profile/{{ $user->id }}"
                                                title="Ver perfil de {{ $user->last_name }}, {{ $user->first_name }}"
                                                class="hover:underline font-medium text-indigo-600 text-sm text-nowrap">
                                                {{ $user->last_name ?? '-' }}, {{ $user->first_name ?? '-' }}
                                            </a>
                                            <p class="text-sm font-normal text-nowrap">
                                                {{ $user->role_position->job_position->name }},
                                                {{ $user->role_position->name }},
                                                {{ $user->role_position->department->area->name }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="font-semibold text-sm opacity-60">
                                        {{ $assist->first_name }}, {{ $assist->last_name }} | {{ $assist->emp_code }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <p class="text-nowrap font-semibold">
                                    {{ $assist->dept_name }}
                                </p>
                            </td>
                            <td>
                                <p class="text-nowrap">
                                    {{ date('d/m/Y', strtotime($assist->created_at)) }}
                                </p>
                            </td>
                            <td>
                                <p class="text-nowrap">
                                    @if ($assist->punch_time)
                                        {{ date('h:i:s A', strtotime($assist->punch_time)) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </td>
                            <td>
                                <p class="text-nowrap">
                                    @if ($assist->upload_time)
                                        {{ date('h:i:s A', strtotime($assist->upload_time)) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="px-5 pt-4">
            {!! $assists->links() !!}
        </footer>
    </div>
@endsection
