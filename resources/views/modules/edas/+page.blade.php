@extends('modules.edas.+layout')

@section('title', 'Gestión de Edas')

@section('layout.edas')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        <nav class="flex p-1 flex-grow gap-3 items-center">

            <label class="relative">
                <div class="absolute z-[1] inset-y-0 flex items-center pl-2 opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </div>
                <input value="{{ request()->query('q') }}" type="search" class="dinamic-search" placeholder="Filtrar"
                    style="padding-left: 40px;">
            </label>

            <div>
                <select class="dinamic-select" name="job_position">
                    <option value="0">Todos los puestos</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">
                            {{ $job->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select class="dinamic-select" name="role">
                    <option value="0">Todos los cargos</option>
                    @foreach ($roles as $role)
                        <option {{ request()->query('role') === $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                            {{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

        </nav>

        <h2 class="py-3 pb-0 font-semibold tracking-tight text-lg px-2">
            Usuarios bajo tu supervisión
        </h2>

        @if ($cuser->has('edas:show') || $cuser->has('edas:show-all') || $cuser->isDev())
            <div class="overflow-auto flex-grow h-full pt-0">
                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-3">
                            <th>Usuario</th>
                            <th>Bajo supervisor de</th>
                            <th class="text-center">Edas</th>
                            <th class="text-center">Objetivos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($users->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay nada por aquí
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($users as $user)
                                <tr
                                    class="[&>td]:py-2 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                    <td>
                                        <div class="flex p-2 items-center gap-3">
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-12',
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-lg',
                                            ])
                                            <div>
                                                <p class="font-medium text-nowrap">
                                                    {{ $user->last_name }}, {{ $user->first_name }}
                                                </p>
                                                <p class="text-sm font-normal text-nowrap">
                                                    {{ $user->role_position->job_position->name }},
                                                    {{ $user->role_position->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="edas/{{ $user->id }}/eda" class="absolute inset-0 block"></a>
                                    </td>
                                    <td>
                                        @if ($user->supervisor)
                                            <button
                                                class="p-2 flex text-left items-center gap-1 rounded-xl px-3 bg-white shadow-lg font-semibold text-sm">
                                                @include('commons.avatar', [
                                                    'src' => $user->supervisor->profile,
                                                    'className' => 'w-8',
                                                    'alt' =>
                                                        $user->supervisor->first_name .
                                                        ' ' .
                                                        $user->supervisor->last_name,
                                                    'altClass' => 'text-md',
                                                ])
                                                <div>
                                                    <p class="font-medium text-nowrap">
                                                        {{ $user->supervisor->last_name }},
                                                        {{ $user->supervisor->first_name }}
                                                    </p>
                                                    <p class="text-sm font-normal text-nowrap">
                                                        {{ $user->supervisor->role_position->job_position->name }},
                                                        {{ $user->supervisor->role_position->name }}
                                                    </p>
                                                </div>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <p class="group-hover:underline text-blue-600">
                                            {{ $user->edas->count() }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="group-hover:underline text-blue-600">
                                            @php
                                                $totalGoals = $user->edas->sum(function ($eda) {
                                                    return $eda->goals->count();
                                                });
                                            @endphp
                                            {{ $totalGoals }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="opacity-70">
                                            {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('LL') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <footer class="px-5 pt-4">
                {!! $users->links() !!}
            </footer>
        @else
            @include('+403', [
                'message' => 'No tienes permisos para ver los usuarios de los edas.',
            ])
        @endif
    </div>
@endsection
