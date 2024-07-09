<div class="bg-white shadow-md w-fit max-sm:w-full rounded-2xl border border-neutral-200">
    <div class="border-b p-2 px-3">
        <p class="text-base font-semibold">
            <a title="Ir al perfil de {{ $user->first_name }} {{ $user->last_name }}" href="/profile/{{ $user->id }}"
                class="hover:underline">
                {{ $user->last_name }}, {{ $user->first_name }}
            </a>
        </p>
    </div>
    <div class="flex w-fit items-center gap-6 p-3">
        @include('commons.avatar', [
            'src' => $user->profile,
            'className' => 'w-24 max-sm:w-14',
            'alt' => $user->first_name . ' ' . $user->last_name,
            'altClass' => 'text-3xl',
        ])
        <div class="flex flex-col gap-1">
            <p class="font-normal text-neutral-600">
                {{ $user->role_position->name }} • {{ $user->role_position->department->name }}
            </p>
            <p>
                <a href="mailto:{{ $user->email() }}" class="flex items-center hover:underline gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-mail opacity-60">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    {{ $user->email() }}
                </a>
            </p>
            <p class="font-normal text-neutral-600">
                <a title="Ir al perfil de {{ $user->first_name }} {{ $user->last_name }}"
                    href="/profile/{{ $user->id }}" class="hover:underline text-blue-600">
                    Ver perfil
                </a>
            </p>
            {{-- @if ($user->id_supervisor)
                <p class="text-neutral-600 max-sm:hidden inline-flex items-center gap-2">
                    Supervisado por:
                    <a title="Ir al perfil de {{ $user->supervisor->first_name }} {{ $user->supervisor->last_name }}"
                        href="/profile/" class="text-blue-700 inline-flex gap-1 items-center hover:underline">

                        {{ $user->supervisor->last_name }},
                        {{ $user->supervisor->first_name }}
                    </a>
                </p>
            @endif --}}
        </div>
    </div>
</div>
