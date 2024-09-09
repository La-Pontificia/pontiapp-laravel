@extends('modules.users.slug.+layout')

@section('title', 'Contratación: ' . $user->first_name . ', ' . $user->last_name)

@php
    $hasEdit = $cuser->has('users:edit') || $cuser->isDev();
@endphp

@section('layout.users.slug')
    <div class="flex items-center gap-3 font-medium p-2">
        <a href="/users/{{ $user->id }}" class="text-neutral-800 flex p-1 hover:bg-neutral-200 rounded-full">
            svg'bx-left-arrow-alt', 'w-6 h-6 opacity-70')
        </a>
        Contratación
    </div>
    <div class="p-4 grid gap-7">
        <div class="gap-1 flex flex-col">
            <form class="grid gap-3" id="form">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 grid-cols-2 gap-5">
                    <label class="label">
                        <span>
                            Fecha entrada
                        </span>
                        @if ($hasEdit && $cuser->id !== $user->id)
                            <input required type="date" value="{{ $user->entry_date }}">
                        @else
                            <p class="font-semibold">
                                {{ $user->entry_date ?? 'Sin fecha.' }}
                            </p>
                        @endif
                    </label>
                    <label class="label">
                        <span>
                            Fecha salida
                        </span>
                        @if ($hasEdit && $cuser->id !== $user->id)
                            <input required type="date" value="{{ $user->exit_date }}">
                        @else
                            <p class="font-semibold">
                                {{ $user->exit_date ?? 'Sin fecha.' }}
                            </p>
                        @endif
                    </label>
                </div>
            </form>
            <div class="flex items-center gap-2">
                <button class="primary dinamic-alert" data-param='/api/users/{{ $user->id }}/contract/history'
                    data-adescription='Se pasará la fecha de ingreso y salida actual al historial.'
                    data-atitle='¿Estas seguro?'>
                    svg'bx-down-arrow-alt', 'w-6 h-6 opacity-70')
                    Pasar a historial
                </button>
                <button class="primary" form="form">
                    Actualizar
                </button>
            </div>
            <div class="pt-5 border-t">
                <p>
                    Historial de cambios.
                </p>
            </div>
        </div>
    </div>
@endsection
