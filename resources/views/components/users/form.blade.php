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
                'create_users' => 'Crear usuarios',
                'edit_users' => 'Editar usuarios',
                'delete_users' => 'Eliminar usuarios',
                'assign_supervisor' => 'Asignar supervisor',
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
        [
            'name' => 'EDAS',
            'privileges' => [
                'view_edas' => 'Ver EDAS',
                'create_edas' => 'Crear EDAS',
                'edit_edas' => 'Editar EDAS',
                'restart_edas' => 'Reiniciar EDAS',
            ],
        ],
        [
            'name' => 'Objetivos',
            'privileges' => [
                'view_objetivos' => 'Ver Objetivos',
                'create_objetivos' => 'Crear Objetivos',
                'edit_objetivos' => 'Editar Objetivos',
                'send_objetivos' => 'Editar Objetivos',
                'delete_objetivos' => 'Eliminar Objetivos',
            ],
        ],
        [
            'name' => 'Reportes',
            'privileges' => [
                'view_reports' => 'Ver reportes',
                'generate_reports' => 'Generar reportes',
            ],
        ],
    ];
@endphp

<div>
    @if ($user)
        <input type="hidden" name="id" value="{{ $user->id }}">
    @endif
</div>
<div>
    <div class="relative rounded-full overflow-hidden w-28 border aspect-square">
        <input type="file" name="profile" id="input-profile"
            class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" accept="image/*">
        <img id="preview-profile" class="w-full h-full object-cover"
            src={{ $user && $user->profile === ' ' ? $user->profile : 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg' }}
            alt="">
    </div>
</div>

<div class="grid grid-cols-12 gap-4">
    <label class="flex flex-col col-span-5 font-normal text-sm">
        <span class="block pb-1">DNI</span>
        <input name="dni" id="dni-input" value="{{ $user ? $user->dni : '' }}" required type="number"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
    </label>
</div>
<div class="grid grid-cols-12 gap-4">
    <label class="flex flex-col col-span-6 font-normal text-sm">
        <span class="block pb-1">Nombres</span>
        <input value="{{ $user ? $user->first_name : '' }}" name="first_name" id="first_name-input" required
            type="text" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
    </label>
    <label class="flex flex-col col-span-6 font-normal text-sm">
        <span class="block pb-1">Apellidos</span>
        <input value="{{ $user ? $user->last_name : '' }}" name="last_name" id="last_name-input" required type="text"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
    </label>
</div>
<label class="flex flex-col font-normal text-sm relative">
    <span class="block pb-1">Correo Institucional</span>
    <div class="relative">
        <div class="absolute inset-y-0 flex items-center pl-2 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-at-sign">
                <circle cx="12" cy="12" r="4" />
                <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
            </svg>
        </div>
        <input required value="{{ $user ? $username : '' }}" name="username" type="text"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 pl-8 rounded-lg">
        <div class="absolute inset-y-0 right-0 pr-2">
            <select required name="domain" type="text"
                class="bg-transparent text-center border-0 h-full w-[150px] px-6">
                @foreach ($domains as $domain)
                    <option {{ $user && $domain === 'elp.edu.pe' ? 'selected' : '' }} value="{{ $domain }}">
                        {{ '@' . $domain }}</option>
                @endforeach
            </select>
        </div>
    </div>
</label>
<div class="grid grid-cols-12 gap-4">
    <label class="flex flex-col col-span-6 font-normal text-sm">
        <span class="block pb-1">Puesto</span>
        <select name="id_job_position" id="job-position-select" required type="text"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($job_positions as $item)
                <option {{ $user && $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
                    value="{{ $item->id }}">
                    {{ $item->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="flex flex-col col-span-6 font-normal text-sm">
        <span class="block pb-1">Cargo</span>
        <select name="id_role" id="role-select" required type="text"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($roles as $role)
                <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
                    value="{{ $role->id }}">
                    {{ $role->name }}</option>
            @endforeach
        </select>
    </label>

</div>
<div class="grid grid-cols-12 gap-4">
    <label class="flex col-span-8 flex-col font-normal text-sm relative">
        <span class="block pb-1">Sede</span>
        <select name="id_branch" required class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($branches as $branch)
                <option {{ $user && $user->id_branch === $branch->id ? 'selected' : '' }} value="{{ $branch->id }}">
                    {{ $branch->name }}</option>
            @endforeach
        </select>
    </label>
</div>

<div class="border-t">
    <h1 class="font-semibold text-lg py-2">Jefe Inmediato (Supervisor)</h1>
    <div class="gap-5">
        <label class="flex col-span-12 flex-col font-normal text-sm relative">
            <input autocomplete="off"
                value="{{ $user && $user->id_supervisor ? $user->supervisor->first_name . ' ' . $user->supervisor->last_name : '' }}"
                id="search-supervisor" type="search"
                data-id="{{ $user && $user->supervisor ? $user->id_supervisor : '' }}" placeholder="Buscar colaborador"
                class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">

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
</div>



<div class="border-t">
    <h1 class="font-semibold text-lg py-2"> Privilegios y Rol del usuario</h1>
    <label class="flex flex-col col-span-4 font-normal text-sm">
        <span class="block pb-1">Rol</span>
        <select name="role" required type="text"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($rolesUsers as $key => $value)
                <option {{ $user && $user->role === $key ? 'selected' : '' }} value="{{ $key }}">
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </label>
    <div>
    </div>
    @if ($user)
        <div class="grid grid-cols-3 gap-5">
            @foreach ($system_privileges as $system_privilege)
                <div>
                    <h2 class="font-semibold text-base py-2">{{ $system_privilege['name'] }}</h2>
                    <div class="flex flex-col gap-4">
                        @foreach ($system_privilege['privileges'] as $key => $value)
                            <label class="flex items-center col-span-4">
                                <input value="{{ $key }}" {{ $user->hasPrivilege($key) ? 'checked' : '' }}
                                    type="checkbox" name="privileges[]"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2">
                                <span class="ms-2 text-black">{{ $value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
