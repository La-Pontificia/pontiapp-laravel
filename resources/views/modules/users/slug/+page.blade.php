@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)

@php
    $myaccount = $cuser->id == $user->id;
    $hasChangePassword = $myaccount || $cuser->has('users:reset-password');
    $hasEdit = ($cuser->has('users:edit') && !$user->isDev()) || $cuser->isDev();

    $daysMatch = [
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

    $days = range(1, 31);
    $months = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre',
    ];
    $years = range(date('Y'), date('Y') - 100);

    $userYear = $user->date_of_birth ? date('Y', strtotime($user->date_of_birth)) : null;
    $userMonth = $user->date_of_birth ? date('m', strtotime($user->date_of_birth)) : null;
    $userDay = $user->date_of_birth ? date('d', strtotime($user->date_of_birth)) : null;

    $domains = ['lapontificia.edu.pe', 'ilp.edu.pe', 'elp.edu.pe', 'ec.edu.pe', 'idiomas.edu.pe'];

    $isEdit = request()->query('view') === 'edit';
@endphp


@section('layout.users.slug')

    <div class="max-w-2xl p-2 text-stone-700 h-full flex flex-col flex-grow mx-auto w-full">
        @if (!$isEdit)
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
                                            @foreach ($daysMatch as $key => $day)
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
                                    {{ $user->department()->name }}
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
                            <div class="label min-w-[130px]">
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
                                            'alt' => $user->supervisor->names(),
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
                                <div class="grid {{ $user->supervisor ? 'grid-cols-3' : 'grid-cols-4' }} gap-2">
                                    @foreach ($user->people->take($user->supervisor ? 3 : 4) as $person)
                                        <a class="hover:bg-white rounded-lg p-2 text-center shadow-md hover:shadow-lg]"
                                            href="/users/{{ $person->id }}">
                                            <div class="py-2">
                                                @include('commons.avatar', [
                                                    'src' => $person->profile,
                                                    'className' => 'w-16 mx-auto',
                                                    'key' => $person->id,
                                                    'alt' => $person->names(),
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
                    <div class="flex gap-2 pb-4 pt-2 flex-wrap">
                        @foreach ($user->businessUnits as $unit)
                            @php
                                $hasHttps = strpos($unit->business->domain, 'https://') !== false;
                                $link = $hasHttps ? $unit->business->domain : 'https://' . $unit->business->domain;
                            @endphp
                            <a href="{{ $link }}" target="_blank" noreferrer
                                class="p-1 px-2 rounded-full bg-white border hover:underline hover:text-blue-500 text-sm font-medium">
                                {{ $unit->business->name }}
                            </a>
                        @endforeach
                    </div>
                    @if ($hasEdit)
                        <a href="/users/{{ $user->id }}?view=edit" class="secondary">
                            @svg('fluentui-person-edit-20-o', 'w-5 h-5')
                            <span>
                                Editar usuario
                            </span>
                        </a>
                    @endif
                    @if ($cuser->id === $user->id || $cuser->isDev())
                        <button data-modal-target="dialog" data-modal-toggle="dialog"
                            class="secondary w-fit mt-3 justify-center">
                            @svg('fluentui-person-key-20-o', 'w-5 h-5')
                            Cambiar contraseña
                        </button>

                        <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-md max-w-full">
                                <header>
                                    Cambiar contraseña
                                </header>
                                <form method="POST" id="form-change-password"
                                    action="/api/users/change-password/{{ $user->id }}"
                                    class="grid p-2 px-4 gap-3 max-w-md">
                                    <label class="label">
                                        <span class="font-semibold">Contraseña actual</span>
                                        <input autofocus type="password" required name="old_password">
                                    </label>
                                    <label class="label">
                                        <span class="font-semibold">Nueva contraseña</span>
                                        <input type="password" required name="new_password">
                                    </label>
                                    <label class="label">
                                        <span class="font-semibold">Confirmar contraseña</span>
                                        <input type="password" required name="new_password_confirmation">
                                    </label>
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog" type="button">Cancelar</button>
                                    <button form="form-change-password" type="submit" class="primary">Filtrar</button>
                                </footer>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if ($hasEdit && $isEdit)
            <div class="grid gap-4">
                <button onclick="window.history.back()" class="flex gap-2 items-center text-gray-900 ">
                    @svg('fluentui-arrow-left-20', 'w-5 h-5')
                    Atras
                </button>
                <div class="grid gap-4 w-full">
                    <div class="border-t pt-2 text-lg">
                        <p>
                            Detalles del usuario
                        </p>
                    </div>
                    <form method="POST" action="/api/users/{{ $user->id }}/details"
                        class="grid dinamic-form grid-cols-2 gap-4">
                        <div class="col-span-2 grid grid-cols-2">
                            <label class="label">
                                <span>Documento de Identidad</span>
                                <input pattern="[0-9]{8}" name="dni" id="dni-input" autocomplete="off"
                                    value="{{ $user->dni }}" required type="number">
                            </label>
                        </div>
                        <label class="label">
                            <span>Apellidos</span>
                            <input value="{{ $user->last_name }}" autocomplete="off" name="last_name"
                                id="last_name-input" required type="text">
                        </label>
                        <label class="label">
                            <span>Nombres</span>
                            <input value="{{ $user->first_name }}" autocomplete="off" value="" name="first_name"
                                id="first_name-input" required type="text">
                        </label>
                        <label class="label">
                            <span>Fecha de nacimiento</span>
                            <div class="w-full">
                                <select required name="date_of_birth_day">
                                    <option value="" selected disabled>
                                        Día
                                    </option>
                                    @foreach ($days as $day)
                                        <option {{ $userDay == $day ? 'selected' : '' }} value="{{ $day }}">
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>

                                <select required name="date_of_birth_month">
                                    <option value="" selected disabled>
                                        Mes
                                    </option>
                                    @foreach ($months as $key => $month)
                                        <option {{ $userMonth == $key + 1 ? 'selected' : '' }}
                                            value="{{ $key + 1 }}">
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>

                                <select required name="date_of_birth_year">
                                    <option value="" selected disabled>
                                        Año
                                    </option>
                                    @foreach ($years as $year)
                                        <option {{ $userYear == $year ? 'selected' : '' }} value="{{ $year }}">
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </label>
                        <div class="col-span-2">
                            <button class="primary gap-2 mt-1 flex">
                                Guardar
                            </button>
                        </div>
                    </form>
                    <div class="border-t pt-4 mt-7 text-lg">
                        <p>
                            Organización y horarios
                        </p>
                    </div>
                    <form method="POST" action="/api/users/{{ $user->id }}/organization"
                        class="grid dinamic-form grid-cols-2 gap-4">
                        <label class="label">
                            <span>
                                Puesto de Trabajo
                            </span>
                            <select name="id_job_position" id="job-position-select" required>
                                @foreach ($job_positions as $item)
                                    @if ($item->isDev() && !$cuser->isDev())
                                        @continue
                                    @endif
                                    <option {{ $user->role_position->id_job_position === $item->id ? 'selected' : '' }}
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
                            <select name="id_role" id="role-select" required>
                                @foreach ($roles as $role)
                                    @if ($role->isDev() && !$cuser->isDev())
                                        @continue
                                    @endif
                                    <option {{ $user->id_role === $role->id ? 'selected' : '' }}
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
                            <select name="id_branch" required>
                                @foreach ($branches as $branch)
                                    <option {{ $user->id_branch === $branch->id ? 'selected' : '' }}
                                        value="{{ $branch->id }}">
                                        {{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="label">
                            <span>Grupo de horario</span>
                            <div class="relative">
                                <div class="absolute top-0 z-10 inset-y-0 grid place-content-center left-3">
                                    @svg('fluentui-calendar-ltr-24-o', 'w-4 text-stone-500')
                                </div>
                                <select class="w-full" style="padding-left: 35px" name="group_schedule_id">
                                    <option selected value="" disabled>Grupo de horario</option>
                                    @foreach ($group_schedules as $scheldule)
                                        <option {{ $user->group_schedule_id === $scheldule->id ? 'selected' : '' }}
                                            value="{{ $scheldule->id }}">{{ $scheldule->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </label>
                        <div class="label col-span-2">
                            <span>
                                Terminales de asistencia
                            </span>
                            <div class="grid grid-cols-2 text-sm font-medium">
                                @foreach ($terminals as $terminal)
                                    @php
                                        $checked = $user->assistTerminals
                                            ->pluck('assist_terminal_id')
                                            ->contains($terminal->id);
                                    @endphp
                                    <label class="flex p-2 rounded-lg hover:bg-white items-center gap-2">
                                        <input {{ $checked ? 'checked' : '' }} type="checkbox" name="assist_terminals[]"
                                            value="{{ $terminal->id }}">
                                        <div>
                                            <span class="block"> {{ $terminal->name }} </span>
                                            <p class="flex items-center gap-2">
                                                @svg('fluentui-task-list-square-database-20-o', 'w-5 h-5 opacity-70')
                                                <span class="text-sm font-normal"> {{ $terminal->database_name }}
                                                </span>
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="flex gap-2 items-end">
                                <div class="grid grid-cols-2 gap-4 w-full">
                                    <label class="label">
                                        <span>Fecha de ingreso</span>
                                        <input value="{{ $user->entry_date ? $user->entry_date->format('d/m/Y') : '' }}"
                                            autocomplete="off" type="date" name="entry_date">
                                    </label>
                                    <label class="label">
                                        <span>Fecha de Cese</span>
                                        <input value="{{ $user->exit_date ? $user->exit_date->format('d/m/Y') : '' }}"
                                            autocomplete="off" type="date" name="exit_date">
                                    </label>
                                </div>
                                <button {{ !$user->entry_date || !$user->exit_date ? 'disabled=true' : '' }}
                                    type="button" class="dinamic-alert secondary"
                                    data-atitle="Pasar las fechas actuales a historial"
                                    data-adescription="Al confirmar las fechas actuales se quitarán y pasarán a historial."
                                    data-param="/api/users/{{ $user->id }}/passed-entry-to-history">
                                    @svg('fluentui-arrow-circle-down-20-o', 'w-5 h-5')
                                    Historial
                                </button>
                            </div>
                            @if ($user->historyEntries->count() > 0)
                                <div class="label mt-3 bg-white shadow-md rounded-lg">
                                    <span class="p-2 block">
                                        Historial de fechas de ingreso y Cese
                                    </span>
                                    <table class="w-full">
                                        <thead class="border-y">
                                            <tr class="[&>th]:text-sm [&>th]:p-2 [&>th]:font-normal text-left">
                                                <th>
                                                    Ingreso
                                                </th>
                                                <th>
                                                    Cese
                                                </th>
                                                <th>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y">
                                            @foreach ($user->historyEntries as $index => $history)
                                                <tr class="text-sm font-semibold [&>td]:p-2">
                                                    <td>
                                                        {{ $history->entry_date->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        {{ $history->exit_date ? $history->exit_date->format('d/m/Y') : 'Actualidad' }}
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="rounded-full relative p-2 hover:bg-neutral-200 transition-colors"
                                                            data-dropdown-toggle="dropdown-{{ $history->id }}">
                                                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                                                        </button>
                                                        <div id="dropdown-{{ $history->id }}"
                                                            class="dropdown-content hidden">
                                                            <button type="button" data-atitle="Eliminar historial"
                                                                data-adescription="No podrás deshacer esta acción."
                                                                data-param="/api/users/history-entries/{{ $history->id }}"
                                                                class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10 {{ $user->status ? 'text-red-600' : 'text-green-600' }}">
                                                                Eliminar
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="col-span-2 grid label grid-cols-2">
                            <span>
                                Jefe inmediato (Supervisor)
                            </span>
                            <select name="supervisor_id" id="">
                                <option value="" selected>--</option>
                                @foreach ($users as $u)
                                    <option {{ $u->id === $user->supervisor_id ? 'selected' : '' }}
                                        value="{{ $u->id }}">
                                        {{ $u->last_name }} {{ $u->first_name }} •
                                        {{ $u->role_position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <button class="primary gap-2 mt-1 flex">
                                Guardar
                            </button>
                        </div>
                    </form>
                    <div class="border-t pt-4 mt-7 text-lg">
                        <p>
                            Rol y privilegios
                        </p>
                    </div>
                    <form method="POST" action="/api/users/{{ $user->id }}/rol-privileges"
                        class="grid dinamic-form grid-cols-2 gap-4">
                        <label class="label w-[200px]">
                            <span>Rol</span>
                            <select required name="id_role_user">
                                @foreach ($user_roles as $role)
                                    @if ($role->isDev() && !$cuser->isDev())
                                        @continue
                                    @endif
                                    <option {{ $user->id_role_user === $role->id ? 'selected' : '' }}
                                        value="{{ $role->id }}">
                                        {{ $role->title }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <div class="col-span-2">
                            <button class="primary gap-2 mt-1 flex">
                                Guardar
                            </button>
                        </div>
                    </form>
                    <div class="border-t pt-4 mt-7 text-lg">
                        <p>
                            Seguridad y accesos
                        </p>
                    </div>
                    <form method="POST" action="/api/users/{{ $user->id }}/segurity-access"
                        class="grid w-full dinamic-form pb-5 gap-3">
                        <div class="label col-span-2">
                            <span>
                                Unidad de negocio
                            </span>
                            <div class="grid grid-cols-2 text-sm font-medium">
                                @foreach ($business_units as $business)
                                    @php
                                        $checked = $user->businessUnits
                                            ->pluck('business_unit_id')
                                            ->contains($business->id);
                                    @endphp
                                    <label class="flex p-2 rounded-lg hover:bg-white items-center gap-2">
                                        <input {{ $checked ? 'checked' : '' }} type="checkbox" name="business_units[]"
                                            value="{{ $business->id }}">
                                        <div>
                                            <span class="block"> {{ $business->name }} </span>
                                            <p class="flex items-center gap-2">
                                                @svg('fluentui-globe-20-o', 'w-5 h-5 opacity-70')
                                                <span class="text-sm font-normal"> {{ $business->domain }} </span>
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="label w-full col-span-2">
                            <span>Correo institucional</span>
                            <div class="relative w-full">
                                <div class="absolute z-10 inset-y-0 flex items-center left-3">
                                    @svg('fluentui-mail-20-o', 'w-5 h-5 opacity-50')
                                </div>
                                <input pattern="^[a-zA-Z0-9_]*$" value="{{ explode('@', $user->email)[0] }}" required
                                    type="text" name="username" class="w-full pl-10" placeholder="Nombre de usuario">
                                <div class="absolute inset-y-0 flex gap-1 items-center right-2">
                                    <div class="opacity-50">
                                        @
                                    </div>
                                    <div class="label">
                                        <select style="background-color: transparent; border: 0px; padding: 0px;" required
                                            name="domain">
                                            @foreach ($domains as $domain)
                                                <option {{ explode('@', $user->email)[1] === $domain ? 'selected' : '' }}
                                                    value="{{ $domain }}">
                                                    {{ $domain }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <button class="primary gap-2 mt-1 flex">
                                Guardar
                            </button>
                        </div>
                        <div class="grid grid-cols-2 col-span-2 gap-4">
                            @if (($cuser->has('users:reset-password') && !$user->has('development')) || $cuser->isDev())
                                <label class="label w-full">
                                    <span>
                                        Restablecer contraseña
                                    </span>
                                    <button type="button" data-atitle="Restablecer contraseña"
                                        data-adescription="Al confimar la contraseña se restablecerá al DNI del usuario: {{ $user->dni }}. ¿Desea continuar?"
                                        data-param="/api/users/reset-password/{{ $user->id }}" style="width: 100%;"
                                        class="dinamic-alert secondary justify-center">
                                        @svg('fluentui-person-key-20-o', 'w-5 h-5')
                                        Restablecer contraseña
                                    </button>
                                </label>
                            @endif
                            @if ($cuser->has('users:toggle-disable') || $cuser->isDev())
                                <label class="label w-full">
                                    <span>Estado de la cuenta: {{ $user->status ? 'Activo' : 'Inactivo' }}</span>
                                    <button type="button" style="width: 100%;"
                                        data-atitle="{{ $user->status ? 'Desactivar' : 'Activar' }} usuario"
                                        data-adescription="No podrás deshacer esta acción."
                                        data-param="/api/users/toggle-status/{{ $user->id }}"
                                        class="secondary dinamic-alert w-full justify-center">
                                        @svg('fluentui-person-circle-20-o', 'w-5 h-5')
                                        {{ $user->status ? 'Desactivar' : 'Activar' }} usuario
                                    </button>
                                </label>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
