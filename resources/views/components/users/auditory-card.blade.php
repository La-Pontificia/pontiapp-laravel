<div class="flex p-3 items-center gap-3">
    @include('commons.avatar', [
        'src' => $current_user->profile,
        'className' => 'w-12',
        'alt' => $current_user->first_name . ' ' . $current_user->last_name,
        'altClass' => 'text-lg',
    ])
    <div>
        <p class="text-sm">
            {{ $current_user->last_name }},
            {{ $current_user->first_name }}
        </p>
        <p class="text-xs text-neutral-500">
            Seguimiento y control con auditoria.
        </p>
    </div>
</div>
