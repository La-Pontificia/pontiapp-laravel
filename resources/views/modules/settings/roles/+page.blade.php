@extends('modules.users.+layout')

@section('title', 'Puestos de trabajo')



@section('layout.users')
    <div class="text-black w-full flex-col flex-grow flex overflow-auto">
        <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
            class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-plus">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            <span class="max-lg:hidden">Nuevo cargo</span>
        </button>

        <div id="dialog" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                <div class="flex items-center justify-between p-3 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Crear cargo
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="dialog">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                @include('components.users.auditory-card')
                <form action="/api/roles" method="POST" id="dialog-form" class="p-3 dinamic-form grid gap-4">
                    @include('modules.settings.roles.form', [
                        'role' => null,
                    ])
                </form>
                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                    <button form="dialog-form" type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                        Guardar</button>
                    <button id="button-close-scheldule-modal" data-modal-hide="dialog" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                </div>
            </div>
        </div>

        <h2 class="py-3 pb-0 font-semibold tracking-tight text-lg px-1">
            Gestión de cargos
        </h2>
        <div class="py-2 px-1 flex items-center gap-2">
            <div>
                <select class="dinamic-select" name="job-position">
                    <option value="0">Todos los puestos</option>
                    @foreach ($jobPositions as $job)
                        <option {{ request()->query('job-position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">
                            {{ $job->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="dinamic-select" name="department">
                    <option value="0">Todos los departamentos</option>
                    @foreach ($departments as $department)
                        <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                            value="{{ $department->id }}">
                            {{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-grow">
                <input value="{{ request()->query('q') }}" class="dinamic-search" type="text" placeholder="Buscar...">
            </div>
        </div>
        <div class="overflow-auto flex-grow">
            <table class="w-full text-left" id="table-users">
                <thead class="">
                    <tr
                        class="[&>th]:font-medium bg-white [&>th]:text-nowrap [&>th]:p-3 first:[&>th]:rounded-l-xl last:[&>th]:rounded-r-xl">
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Departamento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($roles->count() === 0)
                        <tr class="">
                            <td colspan="11" class="text-center py-4">
                                <div class="p-10">
                                    No hay horarios registrados
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($roles as $role)
                            <tr
                                class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-4">
                                <td>
                                    <button class="absolute inset-0" data-modal-target="dialog-{{ $role->id }}"
                                        data-modal-toggle="dialog-{{ $role->id }}">
                                    </button>
                                    <div id="dialog-{{ $role->id }}" data-modal-backdrop="static" tabindex="-1"
                                        aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                                            <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    Editar puesto
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="dialog-{{ $role->id }}">
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
                                            <form action="/api/roles/{{ $role->id }}" method="POST"
                                                id="dialog-{{ $role->id }}-form" class="p-3 dinamic-form grid gap-4">
                                                @include('modules.settings.roles.form', [
                                                    'role' => $role,
                                                ])
                                            </form>
                                            <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                <button form="dialog-{{ $role->id }}-form" type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                                    Actualizar</button>
                                                <button id="button-close-scheldule-modal"
                                                    data-modal-hide="dialog-{{ $role->id }}" type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-nowrap font-semibold">
                                        {{ $role->code }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ $role->name }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ $role->job_position->name }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ $role->department->name }}
                                    </p>
                                </td>
                                <td>
                                    <p class="opacity-70 text-nowrap">
                                        {{ \Carbon\Carbon::parse($role->created_at)->isoFormat('LL') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <footer class="px-5 pt-4">
            {!! $roles->links() !!}
        </footer>
    </div>
@endsection
