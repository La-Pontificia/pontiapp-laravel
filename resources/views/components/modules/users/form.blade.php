@php

    $profileDefault = 'https://res.cloudinary.com/dc0t90ahb/image/upload/v1706396604/gxhlhgd1aa7scbneae3s.jpg';
    $profile = $user ? ($user->profile ? $user->profile : $profileDefault) : $profileDefault;

    $has_assign_email = $current_user->hasPrivilege('assign_email');

    $userDomain = $email ? explode('@', $email->email)[1] : 'elp.edu.pe';

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
    </div>

    <div class="max-w-[500px]">
        <div class="flex items-center gap-1">
            <input required type="text" name="username" placeholder="Nombre de usuario" class="w-full">
            <select style="width: 170px" required name="domain">
                @foreach ($domains as $domain)
                    <option value="{{ $domain }}">
                        {{ '@' . $domain->domain }}</option>
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

    {{-- Emails --}}
    {{-- @if ($user)
        <h2 class="tracking-tight pt-5 text-xl font-semibold">
            Emails
        </h2>
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
                                <a href="mailto:{{ $email->email }}" class="hover:underline flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                        class="group-hover:text-blue-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-mail">
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
        @if ($has_assign_email)
            <button type="button" data-modal-target="assign-email-modal" data-modal-toggle="assign-email-modal"
                class="bg-white hover:shadow-md transition-all shadow-sm px-4 text-black border font-semibold p-2 rounded-xl">
                Asignar correo
            </button>
        @endif
    @endif --}}

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
                    <option value="{{ $role->id }}">
                        {{ $role->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
