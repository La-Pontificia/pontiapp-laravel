@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)

@php
    $myaccount = $cuser->id == $user->id;
    $hasChangePassword = $myaccount || $cuser->has('users:reset-password');
    $hasEdit = $cuser->has('users:edit') || $cuser->isDev();

    $days = [
        [
            'name' => 'Lu',
            'value' => 'monday',
            'key' => 1,
            'short' => 'L',
        ],
        [
            'name' => 'Ma',
            'value' => 'tuesday',
            'key' => 2,
            'short' => 'M',
        ],
        [
            'name' => 'Mi',
            'value' => 'wednesday',
            'key' => 3,
            'short' => 'M',
        ],
        [
            'name' => 'Ju',
            'value' => 'thursday',
            'key' => 4,
            'short' => 'J',
        ],
        [
            'name' => 'Vi',
            'value' => 'friday',
            'key' => 5,
            'short' => 'V',
        ],
        [
            'name' => 'Sá',
            'value' => 'saturday',
            'key' => 6,
            'short' => 'S',
        ],
        [
            'name' => 'Do',
            'value' => 'sunday',
            'key' => 7,
            'short' => 'D',
        ],
    ];

@endphp


@section('layout.users.slug')
    <div class="max-w-2xl text-stone-700 h-full flex flex-col flex-grow mx-auto w-full">
        <div data-preview='user-details'>
            <div class="p-1 pt-2 flex flex-grow flex-col gap-4">
                @if (count($user->summarySchedules()) !== 0)
                    <div>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($user->summarySchedules() as $schedule)
                                @php
                                    $from = date('h:i A', strtotime($schedule->from));
                                    $to = date('h:i A', strtotime($schedule->to));
                                @endphp
                                <div class="flex shadow-sm border p-2 rounded-lg bg-white text-sm gap-2 items-center">
                                    @svg('fluentui-clock-16-o', 'w-5 h-5 opacity-60')
                                    <div class="label">
                                        <p class="font-semibold">
                                            {{ $from }} - {{ $to }}
                                        </p>
                                        <div class="flex ">
                                            @foreach ($days as $key => $day)
                                                @if (in_array($day['key'], $schedule->days))
                                                    <span class="text-xs text-stone-500">
                                                        {{ $day['name'] }}
                                                        {{ $key < count($schedule->days) - 1 ? ',' : '' }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-3">
                            <a class="font-semibold text-blue-600 hover:underline"
                                href="/users/{{ $user->id }}/schedules">
                                Ver todos los horarios
                            </a>
                        </div>
                    </div>
                @endif
                <div class="border-t pt-2 border-neutral-200">
                    <p class="pb-3 text-lg">
                        Información
                    </p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="mailto:{{ $user->email }}"
                            class="flex hover:bg-white p-1 rounded-lg text-sm font-semibold items-center gap-2 w-fit">
                            @svg('fluentui-mail-20-o', 'w-5 h-5')
                            <div class="label flex flex-col gap-0">
                                <span style="margin-bottom: 0px;">Email</span>
                                <p class="leading-4 text-blue-500">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </a>
                        <div class="flex p-1 rounded-lg text-sm font-semibold items-center gap-2 w-fit">
                            @svg('fluentui-person-16-o', 'w-5 h-5')
                            <div class="label flex flex-col gap-0">
                                <span style="margin-bottom: 0px;">Cargo</span>
                                <p class="leading-4">
                                    {{ $user->role_position->name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex p-1 rounded-lg text-sm font-semibold items-center gap-2 w-fit">
                            @svg('fluentui-person-16-o', 'w-5 h-5')
                            <div class="label flex flex-col gap-0">
                                <span style="margin-bottom: 0px;">Departamento</span>
                                <p class="leading-4">
                                    {{ $user->role_position->department->name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex p-1 rounded-lg text-sm font-semibold items-center gap-2 w-fit">
                            @svg('fluentui-location-28-o', 'w-5 h-5')
                            <div class="label flex flex-col gap-0">
                                <span style="margin-bottom: 0px;">Sede</span>
                                <p class="leading-4">
                                    {{ $user->branch->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t pt-2 border-neutral-200">
                    <p class="pb-3 text-lg">
                        Organización
                    </p>
                    <div class="flex gap-5">
                        @if ($user->supervisor)
                            <div class="label">
                                <span>
                                    Supervisor
                                </span>
                                <a class="hover:bg-white rounded-lg p-2 text-center shadow-md hover:shadow-lg]"
                                    href="/users/{{ $user->supervisor->id }}">

                                    <div class="py-2">
                                        @include('commons.avatar', [
                                            'src' => $user->supervisor->profile,
                                            'className' => 'w-16 mx-auto',
                                            'key' => $user->supervisor->id,
                                            'alt' =>
                                                $user->supervisor->first_name . ' ' . $user->supervisor->last_name,
                                            'altClass' => 'text-xl',
                                        ])
                                    </div>
                                    <p class="font-semibold text-sm">
                                        {{ $user->supervisor->names() }}
                                    </p>
                                    <p class="text-sm opacity-60 line-clamp-3 overflow-ellipsis">
                                        {{ $user->supervisor->role_position->name }}
                                    </p>
                                </a>
                            </div>
                        @endif
                        @if ($user->people->count() !== 0)
                            <div class="label">
                                <span>
                                    Personas bajo supervisión de {{ $user->names() }}
                                </span>
                                <div class="grid {{ $user->supervisor ? 'grid-cols-4' : 'grid-cols-5' }} gap-2">
                                    @foreach ($user->people as $person)
                                        <a class="hover:bg-white rounded-lg p-2 text-center shadow-md hover:shadow-lg]"
                                            href="/users/{{ $person->id }}">
                                            <div class="py-2">
                                                @include('commons.avatar', [
                                                    'src' => $person->profile,
                                                    'className' => 'w-16 mx-auto',
                                                    'key' => $person->id,
                                                    'alt' => $person->first_name . ' ' . $person->last_name,
                                                    'altClass' => 'text-xl',
                                                ])
                                            </div>
                                            <p class="font-semibold text-sm">
                                                {{ $person->names() }}
                                            </p>
                                            <p class="text-sm opacity-60 line-clamp-3 overflow-ellipsis">
                                                {{ $person->role_position->name }}
                                            </p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="pt-3">
                        <a class="font-semibold text-blue-600 hover:underline"
                            href="/users/{{ $user->id }}/organization">
                            Ver toda la organización
                        </a>
                    </div>
                </div>
                <div class="border-t pt-2 border-neutral-200">
                    @if ($hasEdit)
                        <button data-switch='user-details'
                            class="gap-2 dinamic-switch-form-preview font-semibold text-blue-600 hover:underline flex">
                            @svg('fluentui-person-edit-20-o', 'w-5 h-5')
                            <span>
                                Editar usuario
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @if ($hasEdit)
            <div data-form='user-details' class="hidden">
                <div class="grid gap-4">
                    <div class="border-t pt-2 text-lg">
                        <p>
                            Detalles del usuario
                        </p>
                    </div>
                    <div class="grid gap-2">
                        <label class="label w-[200px]">
                            <span>Documento de Identidad</span>
                            <input form="form-user" class="bg-white" name="dni" id="dni-input" autocomplete="off"
                                value="{{ $user ? $user->dni : '' }}" required type="number">
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="label">
                                <span>Apellidos</span>
                                <input form="form-user" autocomplete="off" value="{{ $user ? $user->last_name : '' }}"
                                    name="last_name" class="bg-white" id="last_name-input" required type="text">
                            </label>
                            <label class="label">
                                <span>Nombres</span>
                                <input form="form-user" class="bg-white" autocomplete="off"
                                    value="{{ $user ? $user->first_name : '' }}" name="first_name" id="first_name-input"
                                    required type="text">
                            </label>
                        </div>
                    </div>
                    <label class="label w-[300px]">
                        <span>Grupo de horario</span>
                        <div class="relative">
                            <div class="absolute top-0 z-10 inset-y-0 grid place-content-center left-3">
                                @svg('fluentui-calendar-ltr-24-o', 'w-4 text-stone-500')
                            </div>
                            <select form="form-user" class="bg-white w-full" style="padding-left: 35px"
                                name="group_schedule_id">
                                <option disabled selected>Grupo de horario</option>
                                @foreach ($group_schedules as $scheldule)
                                    <option {{ $user && $user->group_schedule_id === $scheldule->id ? 'selected' : '' }}
                                        value="{{ $scheldule->id }}">{{ $scheldule->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </label>
                    <div class="border-t pt-2 text-lg">
                        <p>
                            Organización
                        </p>
                    </div>
                    <label class="label">
                        <span>
                            Puesto de Trabajo
                        </span>
                        <select form="form-user" name="id_job_position" id="job-position-select" class="bg-white" required>
                            @foreach ($job_positions as $item)
                                <option
                                    {{ $user && $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="label">
                        <span>
                            Cargo
                        </span>
                        <select class="bg-white" form="form-user" name="id_role" id="role-select" required>
                            @foreach ($roles as $role)
                                <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
                                    value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="label">
                        <span>
                            Sede
                        </span>

                        @if ($hasEdit)
                            <select class="bg-white" name="id_branch" required form="form-user">
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
                    <div class="grid grid-cols-2 gap-4">
                        <div class="label">
                            <span>
                                Bajo supervision de
                            </span>
                            @if ($cuser->has('users:asign-supervisor') || $cuser->isDev())
                                @if ($user->supervisor)
                                    <a class="hover:underline" href="/users/{{ $user->supervisor->id }}">
                                        {{ $user->supervisor->names() }}
                                    </a>
                                @else
                                    Sin supervisor
                                @endif
                                <button data-modal-target="dialog" data-modal-toggle="dialog"
                                    class="hover:underline mt-2 flex flex-col items-center w-fit font-medium text-sm text-blue-600">
                                    @svg('fluentui-person-edit-20-o', 'w-5 h-5')
                                    Editar</button>

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
                                                        @svg('fluentui-search-28-o', 'w-5 h-5 opacity-60')
                                                    </div>
                                                    <input value="{{ $defaultvalue }}" data-id="{{ $user->id }}"
                                                        type="search" class="supervisor-input w-full"
                                                        style="padding-left: 30px" placeholder="Correo, DNI, nombres...">
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
                                                    @svg('fluentui-person-delete-24-o', 'w-5 h-5')
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
                    <div class="border-t pt-2 text-lg">
                        <p>
                            Rol y privilegios
                        </p>
                    </div>
                    <label class="label w-[200px]">
                        <span>Rol</span>
                        @if ($hasEdit)
                            <select form="form-user" required name="id_role_user" class="bg-white">
                                @foreach ($user_roles as $role)
                                    <option {{ $user && $user->id_role_user === $role->id ? 'selected' : '' }}
                                        value="{{ $role->id }}">
                                        {{ $role->title }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <p class="">
                                {{ $user->role->title }}
                            </p>
                        @endif
                    </label>
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
                    <div class="flex items-center gap-2 border-t pt-2">
                        <form method="POST" action="/api/users/update-details/{{ $user->id }}" id="form-user"
                            class="dinamic-form flex items-center gap-2">
                            <button form="form-user" class="primary gap-2 flex">
                                @svg('fluentui-person-edit-20-o', 'w-5 h-5')
                                <span>
                                    Guardar cambios
                                </span>
                            </button>
                            <button type="button" data-switch='user-details'
                                class="gap-2 dinamic-switch-form-preview font-semibold text-blue-600 hover:underline flex">
                                @svg('fluentui-person-edit-20-o', 'w-5 h-5')
                                <span>
                                    Cancelar
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
