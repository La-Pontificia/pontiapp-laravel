@extends('layouts.app')

@section('title', 'Mantenimiento: Edas (años)')

@section('content')
    <div class="w-full flex flex-col overflow-y-auto">
        <nav class="border-b mb-2 p-2 flex items-center gap-3">
            <button data-modal-target="create-year-modal" data-modal-toggle="create-year-modal"
                class="bg-sky-600 px-4 hover:bg-sky-700 text-nowrap transition-colors text-white font-semibold p-2 rounded-md">
                Registar nuevo año
            </button>

            <!-- Create modal -->
            <div id="create-year-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-center justify-between p-3 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Registrar nueva area
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="create-year-modal">
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

                        <form method="POST" action="/api/years" role="form" id="create-year-form"
                            class="p-3 dinamic-form grid gap-3" enctype="multipart/form-data">
                            @csrf
                            @include('components.year.form', [
                                'name' => '',
                                'status' => true,
                            ])
                        </form>

                        <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                            <button form="create-year-form" data-modal-hide="static-modal" type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Guardar</button>
                            <button data-modal-hide="create-year-modal" type="button"
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
                        <th class="text-center">Año</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($years->isEmpty())
                        <tr>
                            <td class="text-center" colspan="5">
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
                        @foreach ($years as $index => $year)
                            <tr class="even:bg-neutral-200">
                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="font-medium text-center">{{ $year->name }}</td>
                                <td class="font-semibold {{ $year->status ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $year->status ? 'Abierto' : 'Cerrado' }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                            <img src={{ $year->createdBy->profile }} class="w-full h-full object-cover"
                                                alt="">
                                        </div>
                                        <div>
                                            <a href="/profile/{{ $year->createdBy->id }}"
                                                title="Ver perfil de {{ $year->createdBy->last_name }}, {{ $year->createdBy->first_name }}"
                                                class="hover:underline hover:text-indigo-600 text-sm text-nowrap">
                                                {{ $year->createdBy->last_name }},
                                                {{ $year->createdBy->first_name }}
                                            </a>
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($year->created_at)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex p-1 items-center gap-3">
                                        @if ($year->updatedBy)
                                            <div class="w-8 rounded-xl overflow-hidden aspect-square">
                                                <img src={{ $year->updatedBy->profile }} class="w-full h-full object-cover"
                                                    alt="">
                                            </div>
                                        @endif
                                        <div>
                                            @if ($year->updatedBy)
                                                <a href="/profile/{{ $year->updatedBy->id }}"
                                                    title="Ver perfil de {{ $year->updatedBy->last_name }}, {{ $year->updatedBy->first_name }}"
                                                    class="hover:underline hover:text-indigo-600 text-sm text-nowrap">
                                                    {{ $year->updatedBy->last_name }},
                                                    {{ $year->updatedBy->first_name }}
                                                </a>
                                            @endif
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($year->updated_at)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button data-modal-target="edit-year-modal-{{ $year->id }}"
                                        data-modal-toggle="edit-year-modal-{{ $year->id }}"
                                        class="font-semibold text-sm hover:underline text-blue-600">
                                        Editar
                                    </button>
                                    <div id="edit-year-modal-{{ $year->id }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow">
                                                <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                    <h3 class="text-lg font-semibold text-gray-900">
                                                        Editar area
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="edit-year-modal-{{ $year->id }}">
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

                                                <form method="POST" action="/api/years/{{ $year->id }}"
                                                    role="form" id="edit-year-form-{{ $year->id }}"
                                                    class="p-3 dinamic-form grid gap-3" enctype="multipart/form-data">
                                                    @csrf
                                                    @include('components.year.form', [
                                                        'name' => $year->name,
                                                        'status' => $year->status,
                                                    ])
                                                </form>

                                                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                    <button form="edit-year-form-{{ $year->id }}"
                                                        data-modal-hide="static-modal" type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Actualizar cambios</button>
                                                    <button data-modal-hide="edit-year-modal-{{ $year->id }}"
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
            {!! $years->links() !!}
        </footer>
    </div>
@endsection
