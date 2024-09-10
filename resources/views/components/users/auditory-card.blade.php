<div class="flex p-3 items-center gap-3">
    @include('commons.avatar', [
        'key' => $cuser->id,
        'src' => $cuser->profile,
        'className' => 'w-12',
        'alt' => $cuser->names(),
        'altClass' => 'text-lg',
    ])
    <div>
        <p class="text-sm">
            {{ $cuser->last_name }},
            {{ $cuser->first_name }}
        </p>
        <p class="text-xs text-neutral-500">
            Seguimiento y control con auditoria.
        </p>
    </div>
</div>
