@php

    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;

    $has_assign_email = $cuser->has('assign_email');

    $userDomain = $user ? explode('@', $user->email)[1] : null;
    $username = $user ? explode('@', $user->email)[0] : null;

    $domains = ['lapontificia.edu.pe', 'ilp.edu.pe', 'elp.edu.pe', 'ec.edu.pe', 'idiomas.edu.pe'];

@endphp

@if ($user)
    <input type="hidden" name="id" value="{{ $user->id }}">
@endif

<div class="space-y-2">
    {{-- User Profile Image --}}
    @if (!$user)
        <div class="flex items-center gap-4">
            <div class="relative rounded-full overflow-hidden w-40 border aspect-square">
                <input data-notoutline-styles type="file" name="profile" id="input-profile"
                    class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" accept="image/*">
                <img id="preview-profile" class="w-full h-full object-cover" src={{ $profile }} alt="">
            </div>
            <button onclick="document.getElementById('input-profile').click()" type="button"
                class="bg-white font-semibold tracking-tight p-2 rounded-full px-3 shadow-md hover:shadow-lg">
                Subir foto
            </button>
        </div>
    @endif

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
                                Puesto: {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select style="border-radius: 0px;border:0px;" name="id_role" id="role-select" required>
                        @foreach ($roles as $role)
                            <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
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
                        <option {{ $user && $user->id_branch === $branch->id ? 'selected' : '' }}
                            value="{{ $branch->id }}">
                            Sede: {{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if ($user)
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
    @endif

    {{-- Email --}}
    <div>
        <h2 class="tracking-tight pt-5 text-xl font-semibold">
            Email
        </h2>
    </div>
    <div class="max-w-[500px]">
        <div class="flex items-center gap-1">
            <input value="{{ $username }}" required type="text" name="username" placeholder="Nombre de usuario"
                class="w-full">
            <select style="width: 170px" required name="domain">
                @foreach ($domains as $domain)
                    <option {{ $userDomain === $domain ? 'selected' : '' }} value="{{ $domain }}">
                        {{ '@' . $domain }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (!$user)
        <div class="pt-5 max-w-[500px]">
            <h2 class="tracking-tight text-xl font-semibold">
                Contraseña
            </h2>
            <p class="text-xs">
                Por defecto la contrasea será el documento de identidad del usuario.
                Se pedirá al usuario que cambie
                en su primer inicio de sesión.
            </p>
        </div>
        <div class="max-w-[500px]">
            <div class="flex items-center gap-1">
                <input type="password" name="password" class="w-full">
            </div>
        </div>
    @endif

    {{-- Group Schedules --}}

    <div class="max-w-[500px]">
        <h2 class="tracking-tight pt-5 text-xl font-semibold">
            Horario preterminado
        </h2>
        <div class="relative mt-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute z-10 w-4 text-stone-500 top-3.5 left-3"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-calendar-plus-2">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
                <path d="M10 16h4" />
                <path d="M12 14v4" />
            </svg>
            <select style="padding-left: 35px" name="group_schedule_id">
                <option disabled selected>Grupo de horario</option>
                @foreach ($group_schedules as $scheldule)
                    <option {{ $user && $user->group_schedule_id === $scheldule->id ? 'selected' : '' }}
                        value="{{ $scheldule->id }}">{{ $scheldule->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Role --}}
    <div class="max-w-[500px]">
        <h2 class="tracking-tight pt-5 text-xl font-semibold">
            Rol
        </h2>
        <p class="text-xs">
            Selecciona el rol que tendrá el usuario. Los permisos se asignarán una vez que el usuario haya sido
            registrado. Si este usuario necesita privilegios especifícos, <a href="/users/roles"
                class="text-blue-600 hover:underline">crea uno aquí.</a>
        </p>
    </div>

    <div class="max-w-[500px]">
        <div class="flex items-center gap-1">
            <select required name="id_role_user">
                @foreach ($user_roles as $role)
                    <option {{ $user && $user->id_role_user === $role->id ? 'selected' : '' }}
                        value="{{ $role->id }}">
                        {{ $role->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
