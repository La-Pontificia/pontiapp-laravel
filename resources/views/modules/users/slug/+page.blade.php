@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)

@php
    $domains = ['elp.edu.pe', 'ilp.edu.pe', 'gmail.com'];

@endphp

@section('layout.users.slug')
    <div class="p-4 space-y-4 flex flex-col">

        <form id="update-user-button-submit">
            {{-- Información general --}}
            <div class="space-y-1">
                <h2 class="tracking-tight text-xl font-semibold">
                    Información general
                </h2>
                <div>
                    <p class="text-sm text-yellow-500 pb-3 max-w-[50ch]">
                        Ingresa el documento de identidad para hacer una busqueda rapida a la Reniec.
                    </p>
                    <div class="rounded-2xl [&>div]:divide-x divide-y max-w-[500px] border bg-white shadow-md">
                        <div class="gap-4">
                            <input style="border-radius: 1rem 1rem 0px 0px;border:0px;" name="dni" id="dni-input"
                                value="{{ $user->dni }}" required type="number" class="w-full"
                                placeholder="Documento de Identidad">
                        </div>
                        <div class="grid grid-cols-2">
                            <div>
                                <input style="border-radius: 0px;border:0px;" placeholder="Apellidos"
                                    value="{{ $user->last_name }}" name="last_name" id="last_name-input" required
                                    type="text">
                            </div>
                            <div>
                                <input style="border-radius: 0px;border:0px;" placeholder="Nombres"
                                    value="{{ $user->first_name }}" name="first_name" id="first_name-input" required
                                    type="text">
                            </div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div>
                                <select style="border-radius: 0px;border:0px;" name="id_job_position"
                                    id="job-position-select" required>
                                    @foreach ($job_positions as $item)
                                        <option {{ $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">
                                            Puesto: {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select style="border-radius: 0px;border:0px;" name="id_role" id="role-select" required>
                                    @foreach ($roles as $role)
                                        <option {{ $user->role_position->id === $role->id ? 'selected' : '' }}
                                            value="{{ $role->id }}">
                                            Cargo: {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <select style="border-radius: 0px 0px 1rem 1rem;border:0px;" name="id_branch" required>
                                @foreach ($branches as $branch)
                                    <option {{ $user->id_branch === $branch->id ? 'selected' : '' }}
                                        value="{{ $branch->id }}">
                                        Sede: {{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="py-3 px-1 grid gap-2">
                        <p class="font-semibold [&>span]:font-normal">Area:
                            <span>{{ $user->role_position->department->area->name }}</span>
                        </p>
                        <p class="font-semibold [&>span]:font-normal">Departamento:
                            <span>{{ $user->role_position->department->name }}</span>
                        </p>
                        <p class="font-semibold [&>span]:font-normal">Cargo:
                            <span>{{ $user->role_position->job_position->name }}</span>
                        </p>
                        <p class="font-semibold [&>span]:font-normal">Puesto:
                            <span>{{ $user->role_position->name }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Rol --}}
            <div class="max-w-[500px] space-y-2">
                <div class="px-1">
                    <h2 class="tracking-tight pt-3 text-xl font-semibold">
                        Rol
                    </h2>
                    <p class="text-xs">
                        Selecciona el rol que tendrá el usuario. Los permisos se asignarán una vez que el usuario haya sido
                        registrado. Si este usuario necesita privilegios especifícos, <a href="/users/roles"
                            class="text-blue-600 hover:underline">crea uno aquí.</a>
                    </p>
                </div>
                <div>
                    <div class="flex items-center gap-1">
                        <select required name="id_role_user">
                            @foreach ($user_roles as $role)
                                <option {{ $role->id === $user->role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                    {{ $role->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>

        {{-- Emails --}}
        <div class="space-y-1">
            <div class="pb-2 px-1">
                <h2 class="font-semibold text-lg">Correos electrónicos</h2>
                <p class="text-xs">
                    El usuario puede iniciar sesión con cualquiera de estos correos electrónicos.
                </p>
            </div>
            <div class="space-y-3">
                <div class="rounded-2xl space-y-4 max-w-[500px] border bg-white shadow-sm">
                    <table class="w-full">
                        <thead class="text-left">
                            <tr>
                                <th class="w-full"></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="email-table" class="divide-y">
                            @foreach ($user->emails as $email)
                                <tr data-id="{{ $email->id }}"
                                    class="[&>td]:p-3 {{ $email->discharged ? 'text-red-500 line-through' : '' }} group">
                                    <td>
                                        <a href="mailto:{{ $email->email }}"
                                            class="hover:underline flex items-center text-blue-700 gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.6"
                                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                            </svg>
                                            {{ $email->email }}</a>
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            @if ($email->discharged)
                                                Dada de baja el
                                                {{ \Carbon\Carbon::parse($email->discharged)->translatedFormat('d \d\e F') }}
                                            @else
                                                Desde {{ $email->created_at->translatedFormat('d \d\e F') }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <button type="button" data-dropdown-toggle="dropdown-email-{{ $email->id }}"
                                            class="group-hover:opacity-100 opacity-0 hover:bg-neutral-200/80 rounded-md p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-ellipsis">
                                                <circle cx="12" cy="12" r="1" />
                                                <circle cx="19" cy="12" r="1" />
                                                <circle cx="5" cy="12" r="1" />
                                            </svg>
                                        </button>
                                        <div id="dropdown-email-{{ $email->id }}"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-80">
                                            <p class="text-sm text-neutral-500 p-2">
                                                Este correo se asignó el
                                                {{ $email->created_at->translatedFormat('d \d\e F') }}
                                                por <a href="/profile/{{ $email->assignedBy->id }}"
                                                    class="text-blue-500 hover:underline">{{ $email->assignedBy->first_name . ' ' . $email->assignedBy->last_name }}</a>
                                                <br>
                                                <br>
                                                <b>Motivo:</b> {{ $email->reason }}.
                                            </p>
                                            @if ($email->discharged)
                                                <p class="text-sm text-neutral-500 p-2">
                                                    Este correo se dio de baja el
                                                    {{ \Carbon\Carbon::parse($email->discharged)->translatedFormat('d \d\e F') }}
                                                    por <a href="/profile/{{ $email->dischargedBy->id }}"
                                                        class="text-blue-500 hover:underline">{{ $email->dischargedBy->first_name . ' ' . $email->dischargedBy->last_name }}</a>.
                                                </p>
                                            @else
                                                <button type="button" data-id="{{ $email->id }}"
                                                    class="p-2 discharge-email hover:bg-neutral-100 text-red-600 text-left rounded-md w-full">
                                                    Dar de baja
                                                </button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($current_user->hasPrivilege('users:asing_email'))
                    <button type="button" data-modal-target="assign-email-modal" data-modal-toggle="assign-email-modal"
                        class="bg-white hover:shadow-md transition-all shadow-sm px-4 text-black border font-semibold p-2 rounded-xl">
                        Asignar correo
                    </button>
                @endif
            </div>
        </div>

        @if ($current_user->hasPrivilege('users:asing_email'))
            <!-- Assign email modal-->
            <div id="assign-email-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-2xl shadow">
                        <div class="flex items-center justify-between p-3 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Asignar correo
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="assign-email-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                        @include('components.users.auditory-card')
                        <form method="POST" action="/api/emails/assign" role="form" id="assign-email-form"
                            class="dinamic-form" enctype="multipart/form-data">
                            <div class="p-3 grid gap-3">
                                <input type="hidden" value="{{ $user->id }}" name="id_user">
                                <div class="flex items-center gap-1">
                                    <input required type="text" name="username" placeholder="Nombre de usuario"
                                        class="w-full">
                                    <select style="width: 170px" required name="domain">
                                        @foreach ($domains as $domain)
                                            <option {{ $user && $domain === 'elp.edu.pe' ? 'selected' : '' }}
                                                value="{{ $domain }}">
                                                {{ '@' . $domain }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <textarea required placeholder="Descripción (Motivo)" name="reason" cols="20" rows="5"></textarea>
                            </div>
                        </form>

                        <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                            <button form="assign-email-form" type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                Guardar</button>
                            <button data-modal-hide="assign-email-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="pt-4 sticky bottom-0 bg-[#f1f0f4] border-t">
            <button id="update-user-button-submit" type="submit" id="button-submit-user" form="user-form"
                class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                Guardar cambios
            </button>
        </div>
    </div>
@endsection
