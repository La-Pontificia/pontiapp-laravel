@extends('modules.users.slug.+layout')

@section('title', 'Organización: ' . $user->first_name . ', ' . $user->last_name)

@php
    $hasEdit = $cuser->has('users:edit') || $cuser->isDev();
@endphp

@section('layout.users.slug')
    <div class="p-2 flex-grow max-w-4xl w-full flex flex-col mx-auto">
        <div class="flex flex-col max-w-sm mx-auto w-full items-center">
            @include('modules.users.slug.organization.person', [
                'person' => $user,
            ])
            @if ($user->people->count() !== 0)
                <div class="w-[1px] h-5 bg-stone-400 mx-auto ">
                </div>
            @endif
        </div>
        @if ($user->people->count() !== 0)
            <div class="label bg-stone-200/40 border p-2 rounded-md">
                <span>
                    {{ $user->names() }} supervisa a ({{ $user->people->count() }})
                    {{ $user->people->count() > 1 ? 'personas' : 'persona' }}
                </span>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($user->people as $person)
                        <a {{ $user->id === $person->id ? 'data-current="true"' : '' }}
                            class="hover:bg-white/10 w-full flex items-center gap-2 rounded-lg p-2 text-left hover:shadow-lg"
                            href="/users/{{ $person->id }}/organization">
                            <div class="">
                                @include('commons.avatar', [
                                    'src' => $person->profile,
                                    'className' => 'w-10 mx-auto',
                                    'key' => $person->id,
                                    'alt' => $person->first_name . ' ' . $person->last_name,
                                    'altClass' => 'text-xl',
                                ])
                            </div>
                            <div class="overflow-hidden">
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
                    @endforeach
                </div>
            </div>
        @endif
        @if (count($user->companions()) !== 0)
            <div class="label p-2">
                <span>
                    {{ $user->names() }} trabaja con
                </span>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($user->companions() as $person)
                        <a {{ $user->id === $person->id ? 'data-current="true"' : '' }}
                            class="hover:bg-white/10 w-full flex items-center gap-2 rounded-lg p-2 text-left hover:shadow-lg"
                            href="/users/{{ $person->id }}/organization">
                            <div class="">
                                @include('commons.avatar', [
                                    'src' => $person->profile,
                                    'className' => 'w-10 mx-auto',
                                    'key' => $person->id,
                                    'alt' => $person->first_name . ' ' . $person->last_name,
                                    'altClass' => 'text-lg',
                                ])
                            </div>
                            <div class="overflow-hidden">
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
                    @endforeach
                </div>
            </div>
        @endif
        {{--         
        @if ($hasEdit)
            <div class="flex items-center gap-2 pt-2 border-t">
                <form method="POST" action="/api/users/organization/{{ $user->id }}" id="form-user"
                    class="dinamic-form">
                    <button type="submit" form="form-user" class="primary gap-2 flex">
                        @svg('fluentui-people-edit-20-o', 'w-5 h-5')
                        <span>
                            Guardar cambios
                        </span>
                    </button>
                </form>
            </div>
        @endif --}}
    </div>
@endsection
