@extends('layouts.app')

@section('content')
    <div class="overflow-auto bg-white rounded-2xl flex flex-col">
        <table class="w-full relative overflow-x-auto">
            <thead class="border-b sticky divide-y top-0 z-10 bg-white">
                <tr class="text-left [&>th]:px-3 [&>th]:py-3 [&>th]:font-medium">
                    <th>N°</th>
                    <th class="w-full">Usuario</th>
                    <th>Sede</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assists as $assist)
                    @php
                        $user = $assist->getUserFromMysql();
                    @endphp

                    <tr class="border-b group [&>td]:px-3 [&>td]:py-3">
                        <td>
                            <p class="text-sm font-semibold opacity-60">
                                N°{{ $assist->id }}
                            </p>
                        </td>
                        <td>
                            @if ($user)
                                <div class="flex items-center gap-3">
                                    @include('commons.avatar', [
                                        'src' => $user->profile,
                                        'className' => 'w-12',
                                        'alt' => $user->first_name . ' ' . $user->last_name,
                                        'altClass' => 'text-lg',
                                    ])
                                    <div class="flex-grow">
                                        <a href="/profile/{{ $user->id }}"
                                            title="Ver perfil de {{ $user->last_name }}, {{ $user->first_name }}"
                                            class="hover:underline font-medium text-blue-700 text-nowrap">
                                            {{ $user->last_name ?? '-' }}, {{ $user->first_name ?? '-' }}
                                        </a>
                                        <p class="text-sm font-normal text-nowrap">
                                            {{ $user->role_position->job_position->name }},
                                            {{ $user->role_position->name }},
                                            {{ $user->role_position->department->area->name }}
                                        </p>
                                    </div>
                                    <a href="{{ route('assists.user', ['id_user' => $user->id]) }}"
                                        class="group-hover:opacity-100 text-nowrap opacity-0 gap-2 flex items-center border p-1.5 rounded-xl hover:border-stone-400 px-2"
                                        title="Ver asistencias y horarios de {{ $user->last_name }}, {{ $user->first_name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-square-arrow-up-right opacity-60">
                                            <rect width="18" height="18" x="3" y="3" rx="2" />
                                            <path d="M8 8h8v8" />
                                            <path d="m8 16 8-8" />
                                        </svg>
                                        Ver asistencias y horarios
                                    </a>
                                </div>
                            @else
                            @endif
                            {{-- <p class="font-semibold text-nowrap text-sm opacity-60">
                                {{ $assist->employee->first_name }}, {{ $assist->employee->last_name }} |
                                {{ $assist->emp_code }}
                            </p> --}}
                        </td>
                        <td>
                            <p class="text-nowrap font-semibold">
                                {{ $assist->employee->department->dept_name }}
                            </p>
                        </td>
                        <td>
                            <p class="flex items-center text-nowrap gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide opacity-50 lucide-calendar-days">
                                    <path d="M8 2v4" />
                                    <path d="M16 2v4" />
                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                    <path d="M3 10h18" />
                                    <path d="M8 14h.01" />
                                    <path d="M12 14h.01" />
                                    <path d="M16 14h.01" />
                                    <path d="M8 18h.01" />
                                    <path d="M12 18h.01" />
                                    <path d="M16 18h.01" />
                                </svg>
                                {{ date('d/m/Y', strtotime($assist->punch_time)) }}
                            </p>
                        </td>
                        <td>
                            <p class="text-nowrap items-center flex gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide opacity-50 lucide-clock">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                @if ($assist->punch_time)
                                    {{ date('h:i:s A', strtotime($assist->punch_time)) }}
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
@endsection
