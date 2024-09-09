@if ($person->supervisor)
    @include('modules.users.slug.organization.person', [
        'person' => $person->supervisor,
    ])
    <div class="w-[1px] h-5 bg-stone-400 mx-auto ">

    </div>
@endif

<a {{ $user->id === $person->id ? 'data-current="true"' : '' }}
    class="hover:bg-white w-full data-[current]:outline-blue-600 outline outline-1 outline-transparent bg-white/50 flex items-center gap-2 rounded-lg p-2 text-left shadow-md hover:shadow-lg"
    href="/users/{{ $person->id }}/organization">
    <div class="">
        @include('commons.avatar', [
            'src' => $person->profile,
            'className' => 'w-14 mx-auto',
            'key' => $person->id,
            'alt' => $person->first_name . ' ' . $person->last_name,
            'altClass' => 'text-xl',
        ])
    </div>
    <div>
        <p class="font-semibold text-sm">
            {{ $person->names() }}
        </p>
        <p class="text-xs opacity-70 text-nowrap text-ellipsis">
            {{ $person->role_position->name }}
        </p>
        <p class="text-xs text-nowrap overflow-ellipsis">
            {{ $person->role_position->department->name }}
        </p>
    </div>
</a>
