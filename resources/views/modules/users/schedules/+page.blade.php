@extends('modules.users.+layout')

@section('title', 'Horarios')

@section('layout.users')
    <div class="text-black w-full flex-col space-y-3 flex-grow flex overflow-y-auto">

        @if ($cuser->has('users:schedules:create') || $cuser->isDev())
            <button type="button" data-modal-target="create-scheldule-modal" data-modal-toggle="create-scheldule-modal"
                class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                <span class="max-lg:hidden">Nuevo grupo de horario</span>
            </button>
            <div id="create-scheldule-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-xl max-h-full">
                    <div class="relative bg-white rounded-2xl shadow">
                        <div class="flex items-center justify-between p-3 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Nuevo horario
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="create-scheldule-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                        @include('components.users.auditory-card')
                        <form action="/api/schedules/group" method="POST" id="schedule-form-group"
                            class="p-3 dinamic-form grid gap-4">
                            <input autofocus type="text" required placeholder="Nombre" name="name">
                        </form>
                        <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                            <button form="schedule-form-group" type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                Guardar</button>
                            <button id="button-close-scheldule-modal" data-modal-hide="create-scheldule-modal"
                                type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <h2 class="py-3 pb-0 font-semibold tracking-tight text-lg px-2">
            Gestion de horarios
        </h2>
        @if ($cuser->has('users:schedules:show') || $cuser->isDev())
            <div class="h-full flex-grow overflow-auto">
                <table class="w-full text-left" id="table-users">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-2 [&>th]:px-4">
                            <th class="w-max font-semibold tracking-tight">Nombre</th>
                            <th>Horarios</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($group_schedules->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay horarios registrados
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($group_schedules as $group)
                                <tr
                                    class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-4">
                                    <td>
                                        <div class="flex gap-2 items-center">
                                            <p class="text-nowrap flex items-center gap-2">
                                                @svg('heroicon-o-calendar-days', 'w-5 h-5')
                                                {{ $group->name }}
                                            </p>
                                            @if ($cuser->has('users:schedules:edit') || $cuser->isDev())
                                                <button class="text-green-600"
                                                    data-modal-target="edit-scheldule-modal-{{ $group->id }}"
                                                    data-modal-toggle="edit-scheldule-modal-{{ $group->id }}">
                                                    @svg('heroicon-o-pencil-square', 'w-5 h-5')
                                                </button>
                                                <div id="edit-scheldule-modal-{{ $group->id }}"
                                                    data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-xl max-h-full">
                                                        <div class="relative bg-white rounded-2xl shadow">
                                                            <div
                                                                class="flex items-center justify-between p-3 border-b rounded-t">
                                                                <h3 class="text-lg font-semibold text-gray-900">
                                                                    Editar horario
                                                                </h3>
                                                                <button type="button"
                                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                                    data-modal-hide="edit-scheldule-modal-{{ $group->id }}">
                                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 14 14">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            @include('components.users.auditory-card')
                                                            <form action="/api/schedules/group/{{ $group->id }}"
                                                                method="POST" id="schedule-form-group-{{ $group->id }}"
                                                                class="p-3 dinamic-form grid gap-4">
                                                                <input autofocus value="{{ $group->name }}" type="text"
                                                                    required placeholder="Nombre" name="name">
                                                            </form>
                                                            <div
                                                                class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                                <button form="schedule-form-group-{{ $group->id }}"
                                                                    type="submit"
                                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                                                    Guardar</button>
                                                                <button id="button-close-scheldule-modal"
                                                                    data-modal-hide="edit-scheldule-modal-{{ $group->id }}"
                                                                    type="button"
                                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="relative">
                                        <div class="flex items-center gap-2">
                                            <a href="/users/schedules/{{ $group->id }}"
                                                class="text-blue-700 text-nowrap hover:underline">
                                                {{ $group->schedules->count() }}
                                                {{ $group->schedules->count() === 1 ? 'horario' : 'horarios' }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="opacity-70 flex items-center gap-2">
                                            @svg('heroicon-o-clock', 'w-5 h-5')
                                            Registrado el {{ \Carbon\Carbon::parse($group->created_at)->isoFormat('LL') }}
                                            por
                                            {{ $group->createdBy->first_name }} {{ $group->createdBy->last_name }}
                                        </p>
                                    </td>
                                    <td>
                                        <button class="opacity-60 relative hover:opacity-100"
                                            data-dropdown-toggle="dropdown-{{ $group->id }}">
                                            <svg width="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-ellipsis-vertical">
                                                <circle cx="12" cy="12" r="1" />
                                                <circle cx="12" cy="5" r="1" />
                                                <circle cx="12" cy="19" r="1" />
                                            </svg>
                                        </button>

                                        <div id="dropdown-{{ $group->id }}"
                                            class="z-10 hidden bg-white border divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                                            <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar?"
                                                data-adescription="No podrás deshacer esta acción."
                                                data-param="/api/schedules/group/delete/{{ $group->id }}"
                                                class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md text-red-600 hover:bg-gray-10">
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @else
            @include('+403', [
                'message' => 'No tienes permisos para ver los horarios',
            ])
        @endif
    </div>
@endsection
