@php
    $username = isset($user) ? $user->username : null;
    $userAccess = isset($user) ? $user->email_access : [];

@endphp
<label class="label">
    <span>Nombre de usuario</span>
    <input type="text" value="{{ $username }}" required name="username" placeholder="Nombre de usuario">
</label>
<div class="border-t p-3 flex flex-col gap-2">
    <h2>Servicios y accesos</h2>
    @foreach ($business_units as $business)
        <div class="rounded-lg">
            <div class="flex items-center gap-2 access-button">
                <button type="button" class="flex items-center gap-2 toggle-access">
                    svg'bxs-buildings', 'h-5 w-5')
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
