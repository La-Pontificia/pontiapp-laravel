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

<div class="space-y-2 max-w-xl">
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

    <div class="max-w-[500px]">
        <p class="text-sm">
            Selecciona el rol que tendrá el usuario. Los permisos se asignarán una vez que el usuario haya sido
            registrado. Si este usuario necesita privilegios especifícos, <a href="/users/user-roles"
                class="text-blue-600 hover:underline">crea uno aquí.</a>
        </p>
    </div>

    <div class="max-w-[300px]">
        <label class="label">
            <span>Rol y privilegios</span>
            <select required name="id_role_user" class="bg-white">
                @foreach ($user_roles as $role)
                    <option {{ $user && $user->id_role_user === $role->id ? 'selected' : '' }}
                        value="{{ $role->id }}">
                        {{ $role->title }}
                    </option>
                @endforeach
            </select>
        </label>
    </div>

    {{-- User Profile Details --}}
    <h2 class="tracking-tight pt-5 text-xl font-semibold">
        Detalles del usuario
    </h2>
    <div>
        <p class="text-sm text-yellow-500 pb-3 max-w-[50ch]">
            Ingresa el documento de identidad para hacer una busqueda rapida a la Reniec.
        </p>
        <div class="grid gap-4">
            <label class="label w-[200px]">
                <span>Documento de Identidad</span>
                <input name="dni" id="dni-input" autocomplete="off" value="{{ $user ? $user->dni : '' }}" required
                    class="bg-white" type="number">
            </label>
            <div class="grid grid-cols-2 gap-4">
                <label class="label">
                    <span>Apellidos</span>
                    <input autocomplete="off" class="bg-white" value="{{ $user ? $user->last_name : '' }}"
                        name="last_name" id="last_name-input" required type="text">
                </label>
                <label class="label">
                    <span>Nombres</span>
                    <input autocomplete="off" class="bg-white" value="{{ $user ? $user->first_name : '' }}"
                        name="first_name" id="first_name-input" required type="text">
                </label>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <label class="label">
                    <span>
                        Puesto de Trabajo
                    </span>
                    <select name="id_job_position" id="job-position-select" required class="bg-white">
                        @foreach ($job_positions as $item)
                            <option
                                {{ $user && $user->role_position->job_position->id === $item->id ? 'selected' : '' }}
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
                    <select class="bg-white" name="id_role" id="role-select" required>
                        @foreach ($roles as $role)
                            <option {{ $user && $user->role_position->id === $role->id ? 'selected' : '' }}
                                value="{{ $role->id }}">
                                Cargo: {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <label class="label w-[200px]">
                <span>
                    Sede
                </span>
                <select class="bg-white" name="id_branch" required>
                    @foreach ($branches as $branch)
                        <option {{ $user && $user->id_branch === $branch->id ? 'selected' : '' }}
                            value="{{ $branch->id }}">
                            Sede: {{ $branch->name }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>

    <div class="label pt-6">
        <span>Email</span>
        <div class="flex gap-4">
            <input class="bg-white" pattern="^[a-zA-Z]*$" value="{{ $username }}" required type="text"
                name="username" class="w-full" placeholder="Nombre de usuario">
            <select class="bg-white" style="width: 170px" required name="domain">
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
                <input type="password" name="password" class="w-full bg-white">
            </div>
        </div>
    @endif

    {{-- Group Schedules --}}

    <label class="label pt-3">
        <span>Grupo de horario</span>
        <div class="relative">
            <div class="absolute top-0 inset-y-0 grid place-content-center left-3">
                @svg('fluentui-calendar-ltr-24-o', 'w-4 text-stone-500')
            </div>
            <select style="padding-left: 35px" name="group_schedule_id" class="bg-white">
                <option disabled selected>Grupo de horario</option>
                @foreach ($group_schedules as $scheldule)
                    <option {{ $user && $user->group_schedule_id === $scheldule->id ? 'selected' : '' }}
                        value="{{ $scheldule->id }}">{{ $scheldule->name }}</option>
                @endforeach
            </select>
        </div>
    </label>

</div>
