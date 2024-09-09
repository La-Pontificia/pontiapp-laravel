@extends('modules.users.+layout')

@section('title', 'Horarios')

@section('layout.users')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Grupo de horarios establecidos.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('schedules:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                    svg'bx-plus', 'w-5 h-5')
                    <span>Nuevo</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Agregar nuevo grupo
                        </header>
                        <form action="/api/schedules/group" method="POST" id="dialog-form"
                            class="dinamic-form body grid gap-4">
                            <input autofocus type="text" required placeholder="Nombre" name="name">
                        </form>

                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Guardar</button>
                        </footer>
                    </div>
                </div>
            @endif
            <div class="flex flex-col divide-y">
                @if ($cuser->has('schedules:show') || $cuser->isDev())
                    @forelse ($group_schedules as $group)
                        <div class="flex relative items-center p-3 gap-2">
                            svg'bx-calendar', 'w-5 h-5 mr-2')
                            <div class="flex-grow">
                                <p>{{ $group->name }}</p>
                                <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                    svg'bx-calendar-week', 'w-4 h-4')
                                    {{ count($group->schedules) }} horarios y usados por svg'bx-group', 'w-4 h-4')
                                    {{ count($group->users) }}
                                    usuarios.
                                </p>
                            </div>

                            @if ($group->default)
                                <span class="text-sm text-nowrap bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Por
                                    defecto</span>
                            @endif

                            <button type="button" data-modal-target="dialog-{{ $group->id }}"
                                data-modal-toggle="dialog-{{ $group->id }}"
                                class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                                svg'bx-pencil', 'w-4 h-4')
                            </button>
                            <div id="dialog-{{ $group->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar horario: {{ $group->name }}
                                    </header>
                                    <form action="/api/schedules/group/{{ $group->id }}" method="POST"
                                        id="dialog-{{ $group->id }}-form"
                                        class="dinamic-form body grid gap-4 overflow-y-auto">
                                        <input autofocus value="{{ $group->name }}" type="text" required
                                            placeholder="Nombre" name="name">
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $group->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-{{ $group->id }}-form" type="submit">
                                            Guardar</button>
                                    </footer>
                                </div>
                            </div>
                            <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $group->id }}">
                                svg'bx-dots-vertical-rounded', 'w-4 h-4')
                            </button>
                            <div id="dropdown-{{ $group->id }}" class="dropdown-content hidden">
                                @if ($cuser->has('schedules:edit') || $cuser->isDev())
                                    <button data-atitle="¿Estás seguro de seleccionar por defecto este grupo?"
                                        data-adescription="Todos los usuarios que se registren a partir de ahora, tendrán este grupo de horarios por defecto."
                                        data-param="/api/schedules/group/default/{{ $group->id }}"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Por defecto
                                    </button>
                                @endif
                                @if ($cuser->has('schedules:delete') || $cuser->isDev())
                                    <button data-atitle="¿Estás seguro de eliminar?"
                                        data-adescription="No podrás deshacer esta acción."
                                        data-param="/api/schedules/group/delete/{{ $group->id }}"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Eliminar
                                    </button>
                                @endif
                            </div>
                            <a title="Ver horarios" href="/users/schedules/{{ $group->id }}"
                                class="rounded-full p-2 hover:bg-neutral-200 transition-colors block">
                                svg'bx-chevron-right', 'w-5 h-5')
                            </a>
                        </div>
                    @empty
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @endforelse
                @else
                    <p class="p-20 grid place-content-center text-center">
                        No tienes permisos para visualizar estos datos.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
