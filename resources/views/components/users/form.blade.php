@php
    $rolesUsers = [
        'user' => 'Usuario',
        'admin' => 'Administrador',
        'dev' => 'Desarrollador',
    ];
    $domains = ['elp.edu.pe', 'ilp.edu.pe', 'gmail.com'];
    $system_privileges = [
        [
            'name' => 'Usuarios',
            'privileges' => [
                'view_users' => 'Ver usuarios',
                'create_users' => 'Agregar usuarios',
                'assign_email' => 'Asignar correo',
                'edit_users' => 'Actualizar usuarios',
                'disable_users' => 'Deshabilitar usuarios',
            ],
        ],
        [
            'name' => 'Asistencias',
            'privileges' => [
                'view_attendance' => 'Ver asistencias',
                'create_schedule' => 'Crear horarios',
                'edit_schedule' => 'Actualizar horarios',
                'delete_schedule' => 'Remover horarios',
            ],
        ],
        [
            'name' => 'EDAS',
            'privileges' => [
                'create_edas' => 'Registrar EDAS',
                'closed_edas' => 'Cerrar EDAS',
                'assign_supervisor' => 'Asignar supervisor',
            ],
        ],
        [
            'name' => 'Reportes',
            'privileges' => [
                'view_reports' => 'Ver reportes',
                'generate_reports' => 'Generar reportes',
            ],
        ],
        [
            'name' => 'Asistencias',
            'privileges' => [
                'view_attendance' => 'Ver asistencias',
                'create_schedule' => 'Crear horario',
                'edit_schedule' => 'Editar horario',
                'delete_schedule' => 'Eliminar horario',
            ],
        ],
    ];

    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;
@endphp

@if ($user)
    <input type="hidden" name="id" value="{{ $user->id }}">
@endif

<div class="p-4 space-y-2">
    {{-- User Profile Image --}}
    <div class="flex items-center gap-4">
        <div class="relative rounded-full overflow-hidden w-40 border aspect-square">
            <input type="file" name="profile" id="input-profile"
                class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" accept="image/*">
            <img id="preview-profile" class="w-full h-full object-cover" src={{ $profile }} alt="">
        </div>
        <button onclick="document.getElementById('input-profile').click()"
            class="bg-white font-semibold tracking-tight p-2 rounded-full px-3 shadow-md hover:shadow-lg">
            Subir foto
        </button>
    </div>

    {{-- User Profile Details --}}
    <h2 class="tracking-tight pt-5 text-xl font-semibold">
        Detalles del usuario
    </h2>
    <div>
        <p class="text-sm text-yellow-500 pb-3 max-w-[50ch]">
            Ingresa el documento de identidad para hacer una busqueda rapida a la Reniec.
        </p>
        <div class="rounded-2xl [&>div]:divide-x divide-y max-w-[500px] border bg-white shadow-md">
            <div class="gap-4">
                <input style="border-radius: 1rem 1rem 0px 0px;border:0px;" name="dni" id="dni-input"
                    value="{{ $user ? $user->dni : '' }}" required type="number" class="w-full"
                    placeholder="Documento de Identidad">
            </div>
            <div class="grid grid-cols-2">
                <div>
                    <input style="border-radius: 0px;border:0px;" placeholder="Apellidos"
                        value="{{ $user ? $user->last_name : '' }}" name="last_name" id="last_name-input" required
                        type="text">
                </div>
                <div>
                    <input style="border-radius: 0px;border:0px;" placeholder="Nombres"
                        value="{{ $user ? $user->first_name : '' }}" name="first_name" id="first_name-input" required
                        type="text">
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div>
                    <select style="border-radius: 0px;border:0px;" name="id_job_position" id="job-position-select"
                        required>
                        @foreach ($job_positions as $item)
                            <option
                                {{ $user && $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
                                value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select style="border-radius: 0px;border:0px;" name="id_role" id="role-select" required>
                        @foreach ($roles as $role)
                            <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
                                value="{{ $role->id }}">
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <select style="border-radius: 0px 0px 1rem 1rem;border:0px;" name="id_branch" required>
                    @foreach ($branches as $branch)
                        <option {{ $user && $user->id_branch === $branch->id ? 'selected' : '' }}
                            value="{{ $branch->id }}">
                            {{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Emails --}}
    <h2 class="tracking-tight pt-5 text-xl font-semibold">
        Emails
    </h2>

    <div class="rounded-2xl space-y-4 max-w-[500px] border bg-white shadow-md">
        <table class="w-full">
            <thead class="text-left">
                <tr>
                    <th class="w-full"></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="email-table" class="divide-y">
                <tr class="[&>td]:p-3 group">
                    <td>
                        <a href="mailto:help@daustinn.com" class="hover:underline flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" class="group-hover:text-blue-600"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg> help@daustinn.com</a>
                    </td>
                    <td>
                        <p class="text-sm">
                            Activo
                        </p>
                    </td>
                    <td>
                        <button type="button" data-dropdown-toggle="dropdown-email-2"
                            class="group-hover:opacity-100 opacity-0 hover:bg-neutral-200/80 rounded-md p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-ellipsis">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                                <circle cx="5" cy="12" r="1" />
                            </svg>
                        </button>
                        <div id="dropdown-email-2"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-80">
                            <p class="text-sm text-neutral-500 p-2">
                                Este correo se asignó Asignado el 10 de octubre de 2021 por <a href=""
                                    class="text-blue-500 hover:underline">David Bendezu</a> porque el usuario no tiene
                                un
                                correo institucional.
                            </p>
                            <button type="button" class="p-2 hover:bg-neutral-100 text-left rounded-md w-full">
                                Dar de baja
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="[&>td]:p-3 group">
                    <td>
                        <a href="mailto:help@daustinn.com" class="hover:underline flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" class="group-hover:text-blue-600"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg> help@daustinn.com</a>
                        {{-- <p class="text-sm text-neutral-500">
                            Este correo se asignó Asignado el 10 de octubre de 2021 por que el usuario no tiene un
                            correo institucional.
                        </p> --}}
                    </td>
                    <td>
                        <p class="text-sm">
                            Activo
                        </p>
                    </td>
                    <td>
                        <button type="button" data-dropdown-toggle="dropdown-email-3"
                            class="group-hover:opacity-100 opacity-0 hover:bg-neutral-200/80 rounded-md p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                                <circle cx="5" cy="12" r="1" />
                            </svg>
                        </button>
                        <div id="dropdown-email-3"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-44">
                            <button type="button" class="p-2 hover:bg-neutral-100 text-left rounded-md w-full">
                                Dar de baja
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Roles and Permissions --}}
    <h2 class="tracking-tight pt-5 text-xl font-semibold">
        Permisos y Roles
    </h2>
    {{-- <label class="flex flex-col font-normal text-sm relative">
        <span class="block pb-1">Correo Institucional</span>
        <div class="relative">
            <input required value="{{ $user ? $username : '' }}" name="username" type="text">
            <div class="absolute inset-y-0 right-0 pr-2">
                <select data-notstyles required name="domain" type="text"
                    class="bg-transparent text-center border-0 h-full w-[150px] px-6">
                    @foreach ($domains as $domain)
                        <option {{ $user && $domain === 'elp.edu.pe' ? 'selected' : '' }} value="{{ $domain }}">
                            {{ '@' . $domain }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </label> --}}

    {{-- <div class="border-t">
        <h1 class="font-semibold text-lg py-2">Jefe Inmediato (Supervisor)</h1>
        <div class="gap-5">
            <label class="flex col-span-12 flex-col font-normal text-sm relative">
                <input autocomplete="off"
                    value="{{ $user && $user->id_supervisor ? $user->supervisor->first_name . ' ' . $user->supervisor->last_name : '' }}"
                    id="search-supervisor" type="search"
                    data-id="{{ $user && $user->supervisor ? $user->id_supervisor : '' }}" placeholder="Buscar colaborador"
                    >
    
                @if ($user && $user->supervisor)
                    <p class="py-1">
                        <span class=" text-[#0b67bb]">Actualmente supervisado por: </span>
                        {{ $user->supervisor->first_name . ' ' . $user->supervisor->last_name }}
                    </p>
                @endif
                <div id="list-users" class="py-2">
    
                </div>
            </label>
        </div>
    </div> --}}

    <div class="rounded-2xl mb-2 max-w-[700px]">
        <select name="role" required type="text" style="width: fit-content"
            class="bg-neutral-100 border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($rolesUsers as $key => $value)
                <option {{ $user && $user->role === $key ? 'selected' : '' }} value="{{ $key }}">
                    Rol: {{ $value }}
                </option>
            @endforeach
        </select>
        @if (!$user)
            <p class="py-2 px-1 text-sm max-w-[40ch]">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex" width="15" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-triangle-alert">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                Los permisos se realizará una vez que el usuario haya sido registrado.
            </p>
        @endif
        @if ($user)
            <div class="grid grid-cols-3 gap-5 px-2">
                @foreach ($system_privileges as $system_privilege)
                    <div>
                        <h2 class="font-semibold text-base py-2">{{ $system_privilege['name'] }}</h2>
                        <div class="flex flex-col gap-4">
                            @foreach ($system_privilege['privileges'] as $key => $value)
                                <label class="flex items-center col-span-4">
                                    <input value="{{ $key }}"
                                        {{ $user && $user->hasPrivilege($key) ? 'checked' : '' }} type="checkbox"
                                        name="privileges[]"
                                        class="w-6 h-6 rounded-lg text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2">
                                    <span class="ms-2 text-black text-nowrap">{{ $value }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
