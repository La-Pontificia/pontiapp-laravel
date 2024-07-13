@php

    $domains = ['elp.edu.pe', 'ilp.edu.pe', 'gmail.com'];

    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;

    $has_assign_email = $current_user->hasPrivilege('assign_email');

@endphp

@if ($user)
    <input type="hidden" name="id" value="{{ $user->id }}">
@endif

<div class="p-4 space-y-2">
    {{-- User Profile Image --}}
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
                <input style="border-radius: 1rem 1rem 0px 0px;border:0px;" name="dni" id="dni-input" required
                    type="number" class="w-full" placeholder="Documento de Identidad">
            </div>
            <div class="grid grid-cols-2">
                <div>
                    <input style="border-radius: 0px;border:0px;" placeholder="Apellidos" value=""
                        name="last_name" id="last_name-input" required type="text">
                </div>
                <div>
                    <input style="border-radius: 0px;border:0px;" placeholder="Nombres" value="" name="first_name"
                        id="first_name-input" required type="text">
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div>
                    <select style="border-radius: 0px;border:0px;" name="id_job_position" id="job-position-select"
                        required>
                        @foreach ($job_positions as $item)
                            <option value="{{ $item->id }}">
                                Puesto: {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select style="border-radius: 0px;border:0px;" name="id_role" id="role-select" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                Cargo: {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <select style="border-radius: 0px 0px 1rem 1rem;border:0px;" name="id_branch" required>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">
                            Sede: {{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <label class="inline-flex pt-4 items-center cursor-pointer">
        <input checked data-notoutline-styles type="checkbox" name="create_profile_collaborator" class="sr-only peer">
        <div
            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
        </div>
        <span class="ms-3 font-medium text-gray-900">Crear perfil de colaborador.</span>
    </label>

    {{-- Emails --}}
    <div>
        <h2 class="tracking-tight pt-5 text-xl font-semibold">
            Email
        </h2>
        <p class="text-xs">
            Se enviará un correo al usuario con las instrucciones para activar su cuenta.
        </p>
    </div>
    <div class="max-w-[500px]">
        <div class="flex items-center gap-1">
            <input required type="text" name="username" placeholder="Nombre de usuario" class="w-full">
            <select style="width: 170px" required name="domain">
                @foreach ($domains as $domain)
                    <option value="{{ $domain }}">
                        {{ '@' . $domain }}</option>
                @endforeach
            </select>
        </div>
    </div>

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

    {{-- Roles --}}
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
                    <option value="{{ $role->id }}">
                        {{ $role->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
