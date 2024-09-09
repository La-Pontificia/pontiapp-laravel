@extends('modules.users.slug.+layout')

@section('title', 'Detalles: ' . $user->first_name . ', ' . $user->last_name)

@php
    $hasEdit = $cuser->has('users:edit') || $cuser->isDev();
@endphp

@section('layout.users.slug')
    <div class="flex items-center gap-3 font-medium p-2">
        <a href="/users/{{ $user->id }}" class="text-neutral-800 flex p-1 hover:bg-neutral-200 rounded-full">
            svg'bx-left-arrow-alt', 'w-6 h-6 opacity-70')
        </a>
        Información personal
    </div>
    <div class="p-4 grid gap-7">
        <label class="label">
            <span>Rol</span>
            @if ($hasEdit)
                <select form="form-user" required name="id_role_user" class="w-[200px]">
                    @foreach ($user_roles as $role)
                        <option {{ $user && $user->id_role_user === $role->id ? 'selected' : '' }}
                            value="{{ $role->id }}">
                            {{ $role->title }}
                        </option>
                    @endforeach
                </select>
            @else
                <p class="font-semibold">
                    {{ $user->role->title }}
                </p>
            @endif
        </label>
        <div class="grid gap-2">
            <label class="label w-[200px]">
                <span>Documento de Identidad</span>
                @if ($hasEdit)
                    <input form="form-user" name="dni" id="dni-input" autocomplete="off"
                        value="{{ $user ? $user->dni : '' }}" required type="number">
                @else
                    <p class="font-semibold">
                        {{ $user->dni }}
                    </p>
                @endif
            </label>
            <div class="grid grid-cols-2 gap-4">
                <label class="label">
                    <span>Apellidos</span>
                    @if ($hasEdit)
                        <input form="form-user" autocomplete="off" value="{{ $user ? $user->last_name : '' }}"
                            name="last_name" id="last_name-input" required type="text">
                    @else
                        <p class="font-semibold">
                            {{ $user->last_name }}
                        </p>
                    @endif
                </label>
                <label class="label">
                    <span>Nombres</span>
                    @if ($hasEdit)
                        <input form="form-user" autocomplete="off" value="{{ $user ? $user->first_name : '' }}"
                            name="first_name" id="first_name-input" required type="text">
                    @else
                        <p class="font-semibold">
                            {{ $user->first_name }}
                        </p>
                    @endif
                </label>
            </div>
        </div>
        <label class="label pt-3">
            <span>Grupo de horario</span>
            @if ($hasEdit)
                <div class="relative">
                    svg'bx-calendar', 'absolute z-10 w-4 text-stone-500 top-0 left-3')
                    <select form="form-user" style="padding-left: 35px" name="group_schedule_id">
                        <option disabled selected>Grupo de horario</option>
                        @foreach ($group_schedules as $scheldule)
                            <option {{ $user && $user->group_schedule_id === $scheldule->id ? 'selected' : '' }}
                                value="{{ $scheldule->id }}">{{ $scheldule->name }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <p class="font-semibold">
                    {{ $user->groupSchedule ? $user->groupSchedule->name : 'Sin grupo de horario' }}
                </p>
            @endif
        </label>
        <div class="label">
            <span>
                Bajo supervisor de:
            </span>
            <p class="font-semibold">
                @if ($user->supervisor)
                    {{ $user->supervisor->last_name }}, {{ $user->supervisor->first_name }}
                @else
                    Sin supervisor
                @endif
                @if ($cuser->has('users:asign-supervisor') || $cuser->isDev())
                    <a class="hover:underline text-blue-600" href="/users/{{ $user->id }}/organization">Editar</a>
                @endif
            </p>
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
                <form method="POST" action="/api/users/update-details/{{ $user->id }}" id="form-user"
                    class="dinamic-form">
                    <button type="submit" form="form-user" class="primary">
                        svg'bxs-save', 'w-4 h-4')
                        Guardar cambios
                    </button>
                </form>
            </div>
        @endif
        {{-- <div class="grid grid-cols-2 gap-4">
            <label class="label">
                <span>
                    Puesto de Trabajo
                </span>
                <select name="id_job_position" id="job-position-select" required>
                    @foreach ($job_positions as $item)
                        <option {{ $user && $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
                            value="{{ $item->id }}">
                            Puesto: {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </label>
            <label class="label">
                <span>
                    Cargo
                </span>
                <select name="id_role" id="role-select" required>
                    @foreach ($roles as $role)
                        <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
                            value="{{ $role->id }}">
                            Cargo: {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div> --}}
    </div>
@endsection
