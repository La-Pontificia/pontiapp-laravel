@extends('modules.users.+layout')

@section('title', 'Correos y accesos')

@section('layout.users')
    <div class="w-full max-w-5xl mx-auto">
        <h2 class="py-5">Acceso con correos institucionales.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <div class="w-full flex gap-2 p-2">
                <label class="relative w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        svg'bx-search', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('q') }}" placeholder="Filtrar usuarios..." type="search"
                        class="w-full pl-9 dinamic-search">
                </label>
                <button class="secondary">
                    <img src="/excel.webp" class="w-4 h-4" alt="">
                    <span>
                        Exportar
                    </span>
                </button>
            </div>
            <div class="flex flex-col divide-y">
                @if ($cuser->has('users:user-roles:show') || $cuser->isDev())
                    @forelse ($users as $user)
                        <div class="flex relative items-center p-3 gap-2">
                            @include('commons.avatar', [
                                'src' => $user->profile,
                                'className' => 'w-8',
                                'key' => $user->id,
                                'alt' => $user->first_name . ' ' . $user->last_name,
                                'altClass' => 'text-base',
                            ])
                            <div class="flex-grow">
                                <p>
                                    {{ $user->last_name . ', ' . $user->first_name }}
                                </p>
                                <p class="line-clamp-2 flex text-sm items-center gap-1 text-neutral-600">
                                    svg'bx-envelope', 'w-3 h-3')
                                    {{ $user->email }}
                                </p>
                            </div>
                            <div>
                                <p class="flex items-center gap-2 text-sm text-neutral-700">
                                    svg'bx-user-circle', 'w-5 h-5')
                                    {{ explode('@', $user->email)[0] }}
                                </p>
                            </div>
                            <button type="button" data-modal-target="dialog-{{ $user->id }}"
                                data-modal-toggle="dialog-{{ $user->id }}"
                                class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                                svg'bx-pencil', 'w-4 h-4')
                            </button>
                            {{-- <form action="/api/users/email-access/{{ $user->id }}"
                                method="POST" id="dialog-{{ $user->id }}-form"
                                class="p-3 dinamic-form grid gap-4 overflow-y-auto">
                                @include('modules.users.emails-access.form', [
                                    'user' => $user,
                                ])
                            </form> --}}
                            <div id="dialog-{{ $user->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        {{ $user->first_name }} tiene los siguientes accesos en distintos dominios y unidad
                                        de negocios.
                                    </header>
                                    <form action="/api/users/email-access/{{ $user->id }}" method="POST"
                                        id="dialog-{{ $user->id }}-form"
                                        class="dinamic-form body grid gap-4 overflow-y-auto">
                                        @include('modules.users.emails-access.form', [
                                            'user' => $user,
                                        ])
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $user->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-{{ $user->id }}-form" type="submit">
                                            Guardar</button>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @endforelse
                    <footer class="px-5 pt-4">
                        {!! $users->links() !!}
                    </footer>
                @else
                    <p class="p-20 grid place-content-center text-center">
                        No tienes permisos para visualizar estos datos.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
