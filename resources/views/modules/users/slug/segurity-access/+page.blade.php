@extends('modules.users.slug.+layout')

@section('title', 'Detalles: ' . $user->first_name . ', ' . $user->last_name)

@php
    $hasEdit = $cuser->has('users:edit') || $cuser->isDev();
@endphp

@section('layout.users.slug')
    <div class="p-2 grid max-w-2xl mx-auto w-full gap-7">
        <div class="grid grid-cols-2 gap-3">
            <label class="label">
                <span>Correo institucional</span>
                @if ($hasEdit)
                    <input class="bg-white" type="email" form="form-user" required name="email" value="{{ $user->email }}"
                        placeholder="Correo institucional">
                @else
                    <p class="font-semibold">
                        {{ $user->email }}
                    </p>
                @endif
            </label>
            @if ($hasEdit)
                <div class="flex col-span-2 items-center gap-2">
                    <form method="POST" action="/api/users/update-segurity-access/{{ $user->id }}" id="form-user"
                        class="dinamic-form">
                        <button type="submit" form="form-user" class="primary">
                            @svg('fluentui-person-mail-24-o', 'w-5 h-5')
                            Actualizar email
                        </button>
                    </form>
                </div>
            @endif
        </div>
        <div class="grid gap-2">
            <div class="label">
                <span>Contraseña</span>
                <div class="grid w-full gap-2">
                    @if (($cuser->has('users:reset-password') && !$user->has('development')) || $cuser->isDev())
                        <button data-atitle="Restablecer contraseña" style="width: 100%; border-radius: 0.5rem;"
                            data-adescription="Al confimar la contraseña se restablecerá al DNI del usuario: {{ $user->dni }}. ¿Desea continuar?"
                            data-param="/api/users/reset-password/{{ $user->id }}"
                            class="dinamic-alert justify-center secondary ">
                            @svg('fluentui-person-key-20-o', 'w-5 h-5')
                            Restablecer contraseña
                        </button>
                    @endif

                    @if ($cuser->has('users:reset-password') || $cuser->id === $user->id || $cuser->isDev())
                        <button style="width: 100%; border-radius: 0.5rem;" data-modal-target="dialog"
                            data-modal-toggle="dialog" class="secondary justify-center">
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
                    @endif
                </div>
            </div>
        </div>
        @if ($cuser->has('users:toggle-disable') || $cuser->isDev())
            <div>
                <label class="label w-fit">
                    <span>Estado de la cuenta.</span>
                    <div>
                        <button data-atitle="{{ $user->status ? 'Desactivar' : 'Activar' }} usuario"
                            data-adescription="No podrás deshacer esta acción."
                            data-param="/api/users/toggle-status/{{ $user->id }}" class="secondary dinamic-alert">
                            Cuenta: {{ $user->status ? 'Activo' : 'Inactivo' }}
                        </button>
                    </div>
                </label>
            </div>
        @endif
    </div>
@endsection
