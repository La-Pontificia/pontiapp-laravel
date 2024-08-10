@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)

@php
    $myaccount = $cuser->id == $user->id;
    $hasChangePassword = $myaccount || $cuser->has('users:reset-password');
@endphp

@section('layout.users.slug')
    <div class="p-4 space-y-2 flex h-full flex-col">
        <div class="flex-grow w-full overflow-y-auto">
            @if ($hasChangePassword)
                @if ($myaccount)
                    <button data-modal-target="dialog" data-modal-toggle="dialog"
                        class="bg-white hover:shadow-lg shadow-md p-2 font-medium text-sm rounded-lg px-4">
                        Cambiar contraseña
                    </button>

                    <div id="dialog" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-xl max-h-full">
                            <div class="relative bg-white rounded-2xl shadow">
                                <div class="flex items-center justify-between p-3 border-b rounded-t">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Cambiar contraseña
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                        data-modal-hide="dialog">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>
                                <form action="/api/users/change-password/{{ $user->id }}" method="POST"
                                    id="form-change-password" class="p-3 grid gap-4">
                                    <label class="text-sm">
                                        <span class="font-semibold">Contraseña actual</span>
                                        <input autofocus type="password" required name="old_password">
                                    </label>
                                    <label class="text-sm">
                                        <span class="font-semibold">Nueva contraseña</span>
                                        <input type="password" required name="new_password">
                                    </label>
                                    <label class="text-sm">
                                        <span class="font-semibold">Confirmar contraseña</span>
                                        <input type="password" required name="new_password_confirmation">
                                    </label>
                                </form>
                                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                    <button form="form-change-password" type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                        Cambiar contraseña
                                    </button>
                                    <button data-modal-hide="dialog" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <button data-param="/api/users/reset-password/{{ $user->id }}" data-atitle="Restablecer contraseña"
                        data-adescription="Al confimar la contraseña se restablecerá al DNI del usuario: {{ $user->dni }}. ¿Desea continuar?"
                        class="bg-white dinamic-alert hover:shadow-lg shadow-md p-2 font-medium text-sm rounded-lg px-4">
                        Restablecer contraseña
                    </button>
                @endif
            @endif
            @if ($cuser->has('users:edit') || $cuser->isDev())
                <form id="edit-user-form" class="grid gap-4 px-1 w-full dinamic-form" method="POST" role="form"
                    action="/api/users/{{ $user->id }}">
                    @include('modules.users.form', [
                        'user' => $user,
                    ])
                </form>
            @else
                <div class="space-y-2">
                    <h2 class="tracking-tight pt-5 text-xl font-semibold">
                        Detalles del usuario
                    </h2>
                    <div class="pl-3 border-l ml-2 space-y-2 mt-3">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold tracking-tight">DNI:</p>
                            <p>{{ $user->dni }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold tracking-tight">Apellidos:</p>
                            <p>{{ $user->last_name }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold tracking-tight">Nombres:</p>
                            <p>{{ $user->first_name }}</p>
                        </div>
                    </div>
                    <h2 class="tracking-tight pt-5 text-xl font-semibold">
                        Horarios preterminado
                    </h2>
                    <div>
                        <p>
                            @if ($user->groupSchedule)
                                {{ $user->first_name }} tiene todos los horarios del grupo: <a
                                    href="/users/{{ $user->id }}/schedules" class="text-blue-600 hover:underline">
                                    {{ $user->groupSchedule->name }}</a>
                            @else
                                Sin grupo de horarios
                            @endif
                        </p>
                    </div>
                    <h2 class="tracking-tight pt-5 text-xl font-semibold">
                        Correo electrónico
                    </h2>
                    <div class="pl-3 border-l ml-2 space-y-2 mt-3">
                        <p>
                            <a href="mailto:{{ $user->email }}"
                                class="text-blue-700 flex items-center gap-2 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-mail">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                                {{ $user->email }}</a>
                        </p>
                    </div>
                    <h2 class="tracking-tight pt-5 text-xl font-semibold">
                        Organización
                    </h2>
                    <div class="pl-3 border-l ml-2 space-y-2 mt-3">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold flex items-center gap-2 tracking-tight">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-hotel">
                                    <path d="M10 22v-6.57" />
                                    <path d="M12 11h.01" />
                                    <path d="M12 7h.01" />
                                    <path d="M14 15.43V22" />
                                    <path d="M15 16a5 5 0 0 0-6 0" />
                                    <path d="M16 11h.01" />
                                    <path d="M16 7h.01" />
                                    <path d="M8 11h.01" />
                                    <path d="M8 7h.01" />
                                    <rect x="4" y="2" width="16" height="20" rx="2" />
                                </svg>Area:
                            </p>
                            <p>{{ $user->role_position->department->area->name }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold flex items-center gap-2 tracking-tight">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-door-open">
                                    <path d="M13 4h3a2 2 0 0 1 2 2v14" />
                                    <path d="M2 20h3" />
                                    <path d="M13 20h9" />
                                    <path d="M10 12v.01" />
                                    <path
                                        d="M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z" />
                                </svg>
                                Departamento:
                            </p>
                            <p>{{ $user->role_position->department->name }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold tracking-tight">Cargo:</p>
                            <p>{{ $user->role_position->job_position->name }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold flex items-center gap-2 tracking-tight"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-luggage">
                                    <path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2" />
                                    <path d="M8 18V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v14" />
                                    <path d="M10 20h4" />
                                    <circle cx="16" cy="20" r="2" />
                                    <circle cx="8" cy="20" r="2" />
                                </svg>Puesto:</p>
                            <p>{{ $user->role_position->name }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if ($cuser->has('users:edit') || $cuser->isDev())
            <div class="pt-4 border-t">
                <button type="submit" form="edit-user-form"
                    class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                    Guardar cambios
                </button>
            </div>
        @endif
    </div>
@endsection
