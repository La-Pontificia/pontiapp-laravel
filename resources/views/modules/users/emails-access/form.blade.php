@php
    $username = isset($user) ? $user->username : null;
    $userAccess = isset($user) ? $user->email_access : [];

@endphp
<div class="gap-2 flex px-1 flex-col overflow-y-auto">
    <label>
        <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre de usuario</span>
        <input type="text" value="{{ $username }}" required name="username" placeholder="Nombre de usuario">
    </label>
    <div class="border-t p-3 overflow-y-auto flex flex-col gap-2">
        <h2>Servicios y accesos</h2>
        @foreach ($business_units as $business)
            <div class="rounded-lg">
                <div class="flex items-center gap-2 access-button">
                    <button type="button" class="flex items-center gap-2 toggle-access">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-building-2">
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                            <path d="M10 6h4" />
                            <path d="M10 10h4" />
                            <path d="M10 14h4" />
                            <path d="M10 18h4" />
                        </svg>
                        <span>{{ $business->name }}</span>
                        <span class="opacity-50">{{ '@' . $business->domain }}</span>
                    </button>
                </div>
                <div class="mt-2 pl-10 gap-3 access-list">
                    @foreach ($business->services as $service)
                        @php
                            $value = $business->id . ':' . $service;
                        @endphp
                        <label class="flex items-center gap-2 label-child">
                            <input type="checkbox" name="access[]"
                                {{ is_array($userAccess) && in_array($value, $userAccess) ? 'checked' : '' }}
                                value="{{ $value }}" class="rounded-md p-2.5 border-neutral-400 child-checkbox"
                                data-child-id="{{ $value }}">
                            <span>{{ $service }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
