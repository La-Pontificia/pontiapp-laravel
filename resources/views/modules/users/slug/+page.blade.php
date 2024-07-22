@extends('modules.users.slug.+layout')

@section('title', 'Usuario: ' . $user->first_name . ', ' . $user->last_name)


@section('layout.users.slug')
    <div class="p-4 space-y-4 flex h-full flex-col">
        <div class="flex-grow w-full overflow-y-auto ">
            @if ($current_user->hasPrivilege('users:edit'))
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
                            {{ $user->first_name }} tiene todos los horarios del grupo: <a
                                href="/users/{{ $user->id }}/schedules" class="text-blue-600 hover:underline">
                                {{ $user->groupSchedule->name }}</a>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-door-open">
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
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-luggage">
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
        @if ($current_user->hasPrivilege('users:edit'))
            <div class="pt-4 border-t">
                <button type="submit" form="edit-user-form"
                    class="bg-blue-700 hover:bg-blue-600 disabled:opacity-40 disabled:pointer-events-none flex items-center rounded-xl p-2.5 gap-1 text-white font-semibold px-3">
                    Guardar cambios
                </button>
            </div>
        @endif
    </div>
@endsection
