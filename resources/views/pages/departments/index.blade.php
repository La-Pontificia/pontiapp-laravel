@extends('layouts.app')

@section('title', 'Mantenimiento: departamentos')

@section('content')
    <div class="w-full flex flex-col overflow-y-auto">
        <nav class="border-b mb-2 p-2 flex items-center gap-3">
            <button data-modal-target="create-department-modal" data-modal-toggle="create-department-modal"
                class="bg-sky-600 px-4 hover:bg-sky-700 transition-colors text-white font-semibold p-2 rounded-md">
                Crear departamento
            </button>
            <select class="dinamic-select bg-transparent p-1 border-transparent rounded-lg cursor-pointer" name="area">
                <option value="0">Todas las areas</option>
                @foreach ($areas as $area)
                    <option {{ request()->query('area') === $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                        {{ $area->name }}</option>
                @endforeach
            </select>
            <!-- Create modal -->
            <div id="create-department-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-center justify-between p-3 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Registrar nuevo departamento
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="create-department-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex p-2 items-center gap-3">
                            <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                <img src={{ $current_user->profile }} class="w-full h-full object-cover" alt="">
                            </div>
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

                        <form method="POST" action="/api/departments" role="form" id="edit-department-form"
                            class="p-3 dinamic-form grid gap-3" enctype="multipart/form-data">
                            @csrf
                            @include('components.department.form', [
                                'code' => $newCode,
                                'name' => '',
                                'id_area' => null,
                            ])
                        </form>

                        <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                            <button form="edit-department-form" data-modal-hide="static-modal" type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Guardar</button>
                            <button data-modal-hide="create-department-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <input value="{{ request()->get('q') }}" type="search"
                    class="p-2 dinamic-search px-3 rounded-lg border-neutral-300" placeholder="Buscar...">
            </div>
        </nav>
        <div class="w-full overflow-y-auto">
            <table class="w-full">
                <thead class="border-b text-left">
                    <tr class="text-sm [&>th]:p-2 [&>th]:font-semibold uppercase">
                        <th class="text-center">N°</th>
                        <th class="text-center">Codigo</th>
                        <th>Departamento</th>
                        <th>Area</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($departments->isEmpty())
                        <tr>
                            <td class="text-center" colspan="20">
                                <div class="p-20">
                                    <svg class="mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="30"
                                        height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-table-rows-split">
                                        <path d="M14 10h2" />
                                        <path d="M15 22v-8" />
                                        <path d="M15 2v4" />
                                        <path d="M2 10h2" />
                                        <path d="M20 10h2" />
                                        <path d="M3 19h18" />
                                        <path d="M3 22v-6a2 2 135 0 1 2-2h14a2 2 45 0 1 2 2v6" />
                                        <path d="M3 2v2a2 2 45 0 0 2 2h14a2 2 135 0 0 2-2V2" />
                                        <path d="M8 10h2" />
                                        <path d="M9 22v-8" />
                                        <path d="M9 2v4" />
                                    </svg>
                                    No se encontraron registros
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($departments as $index => $department)
                            <tr class="even:bg-neutral-200">
                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="font-medium text-center">{{ $department->code }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->area->name }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                            <img src={{ $department->createdBy->profile }}
                                                class="w-full h-full object-cover" alt="">
                                        </div>
                                        <div>
                                            <a href="/profile/{{ $department->createdBy->id }}"
                                                title="Ver perfil de {{ $department->createdBy->last_name }}, {{ $department->createdBy->first_name }}"
                                                class="hover:underline hover:text-indigo-600 text-sm text-nowrap">
                                                {{ $department->createdBy->last_name }},
                                                {{ $department->createdBy->first_name }}
                                            </a>
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($department->created_at)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex p-1 items-center gap-3">
                                        @if ($department->updatedBy)
                                            <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                                <img src={{ $department->updatedBy->profile }}
                                                    class="w-full h-full object-cover" alt="">
                                            </div>
                                        @endif
                                        <div>
                                            @if ($department->updatedBy)
                                                <a href="/profile/{{ $department->updatedBy->id }}"
                                                    title="Ver perfil de {{ $department->updatedBy->last_name }}, {{ $department->updatedBy->first_name }}"
                                                    class="hover:underline hover:text-indigo-600 text-sm text-nowrap">
                                                    {{ $department->updatedBy->last_name }},
                                                    {{ $department->updatedBy->first_name }}
                                                </a>
                                            @endif
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($department->updated_at)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button data-modal-target="edit-area-modal-{{ $department->id }}"
                                        data-modal-toggle="edit-area-modal-{{ $department->id }}"
                                        class="font-semibold text-sm hover:underline text-blue-600">
                                        Editar
                                    </button>
                                    <div id="edit-area-modal-{{ $department->id }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow">
                                                <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                    <h3 class="text-lg font-semibold text-gray-900">
                                                        Editar departamento
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="edit-area-modal-{{ $department->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="flex p-2 items-center gap-3">
                                                    <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                                        <img src={{ $current_user->profile }}
                                                            class="w-full h-full object-cover" alt="">
                                                    </div>
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

                                                <form method="POST" action="/api/departments/{{ $department->id }}"
                                                    role="form" id="edit-department-form-{{ $department->id }}"
                                                    class="p-3 dinamic-form grid gap-3" enctype="multipart/form-data">
                                                    @csrf
                                                    @include('components.department.form', [
                                                        'code' => $department->code,
                                                        'name' => $department->name,
                                                        'id_area' => $department->id_area,
                                                    ])
                                                </form>

                                                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                    <button form="edit-department-form-{{ $department->id }}"
                                                        data-modal-hide="static-modal" type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Actualizar cambios</button>
                                                    <button data-modal-hide="edit-area-modal-{{ $department->id }}"
                                                        type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <footer class="px-5 pt-4">
            {!! $departments->links() !!}
        </footer>
    </div>
@endsection
