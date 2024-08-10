@extends('modules.settings.+layout')

@section('title', 'Ajustes del sistema: Sedes')

@section('layout.settings')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
            class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-plus">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            <span class="max-lg:hidden">Agregar nuevo sede</span>
        </button>

        <div id="dialog" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                <div class="flex items-center justify-between p-3 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Agrega nuevo sede
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
                <form action="/api/branches" method="POST" id="dialog-form" class="p-3 dinamic-form grid gap-4">
                    @include('modules.settings.branches.form')
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
        <div class="overflow-auto flex-grow">
            <table class="w-full text-left text-sm">
                <thead class="border-b">
                    <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-4 [&>th]:px-2">
                        <th class="w-full">Sede</th>
                        <th>Dirección</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($branches->count() === 0)
                        <tr class="">
                            <td colspan="11" class="text-center py-4">
                                <div class="p-10">
                                    No hay nada por aquí
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($branches as $branch)
                            <tr
                                class="[&>td]:py-4 hover:border-transparent hover:[&>td]shadow-md relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                <td>
                                    <p class="text-nowrap">
                                        {{ $branch->name }}
                                    </p>

                                    <button title="Click para editar" class="absolute inset-0"
                                        data-modal-target="dialog-{{ $branch->id }}"
                                        data-modal-toggle="dialog-{{ $branch->id }}">
                                    </button>

                                    <div id="dialog-{{ $branch->id }}" data-modal-backdrop="static" tabindex="-1"
                                        aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                                            <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    Editar sede
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="dialog-{{ $branch->id }}">
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
                                            <form action="/api/branches/{{ $branch->id }}" method="POST"
                                                id="dialog-{{ $branch->id }}-form" class="p-3 dinamic-form grid gap-4">
                                                @include('modules.settings.branches.form', [
                                                    'branch' => $branch,
                                                ])
                                            </form>
                                            <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                <button form="dialog-{{ $branch->id }}-form" type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                                    Guardar</button>
                                                <button id="button-close-scheldule-modal"
                                                    data-modal-hide="dialog-{{ $branch->id }}" type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ $branch->address }}
                                    </p>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-normal flex-grow text-nowrap">
                                            <span class="block">
                                                {{ $branch->createdBy->last_name }},
                                                {{ $branch->createdBy->first_name }}</span>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ \Carbon\Carbon::parse($branch->created_at)->isoFormat('LL') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <footer class="px-5 pt-4">
            {!! $branches->links() !!}
        </footer>
    </div>
@endsection
