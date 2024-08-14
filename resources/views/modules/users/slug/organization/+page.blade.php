@extends('modules.users.slug.+layout')

@section('title', 'Organización: ' . $user->first_name . ', ' . $user->last_name)

@php
    $hasEdit = $cuser->has('users:edit') || $cuser->isDev();
@endphp

@section('layout.users.slug')
    <div class="flex items-center gap-3 font-medium p-2">
        <a href="/users/{{ $user->id }}" class="text-neutral-800 flex p-1 hover:bg-neutral-200 rounded-full">
            @svg('bx-left-arrow-alt', 'w-6 h-6 opacity-70')
        </a>
        Organización
    </div>
    <div class="p-4 grid gap-7">
        <div class="grid grid-cols-2 gap-4">
            <label class="label">
                <span>
                    Puesto de Trabajo
                </span>
                @if ($hasEdit)
                    <select form="form-user" name="id_job_position" id="job-position-select" required>
                        @foreach ($job_positions as $item)
                            <option {{ $user && $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
                                value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <p class="font-semibold">
                        {{ $user->role_position->job_position->name }}
                    </p>
                @endif
            </label>
            <label class="label">
                <span>
                    Cargo
                </span>
                @if ($hasEdit)
                    <select form="form-user" name="id_role" id="role-select" required>
                        @foreach ($roles as $role)
                            <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
                                value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <p class="font-semibold">
                        {{ $user->role_position->name }}
                    </p>
                @endif
            </label>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <label class="label">
                <span>
                    Sede
                </span>

                @if ($hasEdit)
                    <select name="id_branch" required form="form-user">
                        @foreach ($branches as $branch)
                            <option {{ $user && $user->id_branch === $branch->id ? 'selected' : '' }}
                                value="{{ $branch->id }}">
                                {{ $branch->name }}</option>
                        @endforeach
                    </select>
                @else
                    <p class="font-semibold">
                        {{ $user->branch->name }}
                    </p>
                @endif
            </label>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="label">
                <span>
                    Bajo supervision de
                </span>
                @if ($cuser->has('users:asign-supervisor') || $cuser->isDev())
                    <button data-modal-target="dialog" data-modal-toggle="dialog" tip="Asignar o Editar supervisor"
                        class="text-left p-2 px-3 flex items-center gap-2 text-sm border bg-neutral-200 border-neutral-400 hover:border-neutral-500 rounded-lg">
                        @svg('bx-user-pin', 'w-6 h-6')
                        @if ($user->supervisor)
                            <div>
                                <p>
                                    {{ $user->supervisor->last_name }}, {{ $user->supervisor->first_name }}
                                </p>
                                <p class="text-xs text-neutral-700">
                                    {{ $user->supervisor->role_position->name }},
                                    {{ $user->supervisor->role_position->department->name }}
                                </p>
                            </div>
                        @else
                            Sin supervisor
                        @endif
                    </button>

                    <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                        <div class="content lg:max-w-lg max-w-full">
                            <header>
                                Asignar o cambiar supervisor
                            </header>
                            <div class="p-3 gap-4 overflow-y-auto flex flex-col">
                                @php
                                    $defaultvalue = $user->supervisor_id
                                        ? $user->supervisor->first_name . ' ' . $user->supervisor->last_name
                                        : null;
                                @endphp
                                <div class="grid gap-2">
                                    <label class="relative">
                                        <div class="absolute z-[1] inset-y-0 px-2 flex items-center">
                                            @svg('bx-search-alt-2', 'w-5 h-5 opacity-60')
                                        </div>
                                        <input value="{{ $defaultvalue }}" data-id="{{ $user->id }}" type="search"
                                            class="supervisor-input w-full" style="padding-left: 30px"
                                            placeholder="Correo, DNI, nombres...">
                                    </label>
                                    <div id="result-{{ $user->id }}" class="p-1 grid gap-2 text-center">
                                        <p class="p-10 text-neutral-500">
                                            No se encontraron resultados o no se ha realizado
                                            una
                                            búsqueda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <footer>
                                <button data-modal-hide="dialog" type="button">Cancelar</button>
                                @if ($user->supervisor_id)
                                    <button data-alertvariant="warning"
                                        data-param='/api/users/supervisor/remove/{{ $user->id }}'
                                        data-atitle='Remover supervisor'
                                        data-adescription='¿Estás seguro de que deseas remover el supervisor de este usuario?'
                                        type="button" class="secondary dinamic-alert">
                                        @svg('bx-user-minus', 'w-5 h-5')
                                        Remover supervisor
                                    </button>
                                @endif
                            </footer>
                        </div>
                    </div>
                @else
                    <p class="font-semibold">
                        {{ $user->supervisor ? $user->supervisor->last_name . ', ' . $user->supervisor->first_name : 'Sin supervisor' }}
                    </p>
                @endif
            </div>
        </div>
        <div class="text-sm">
            <p>
                Registrado el {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('LL') }} por
                {{ $user->createdBy->last_name }}, {{ $user->createdBy->first_name }}
            </p>
            @if ($user->updatedBy)
                <p>
                    Ultima actualización el {{ \Carbon\Carbon::parse($user->updated_at)->isoFormat('LL') }} por
                    {{ $user->updatedBy->last_name }}, {{ $user->updatedBy->first_name }}
                </p>
            @endif
        </div>
        @if ($hasEdit)
            <div class="flex items-center gap-2 border-t pt-4">
                <form method="POST" action="/api/users/organization/{{ $user->id }}" id="form-user"
                    class="dinamic-form">
                    <button type="submit" form="form-user" class="primary">
                        @svg('bxs-save', 'w-4 h-4')
                        Guardar cambios
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
