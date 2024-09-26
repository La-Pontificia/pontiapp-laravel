@extends('modules.settings.+layout')

@section('title', 'Ajustes del sistema: Unidades de negocio')
@php
    $business_services = [
        [
            'code' => 'pontisis',
            'name' => 'Sistema Académico',
        ],
        [
            'code' => 'aula_virtual',
            'name' => 'Aula Virtual',
        ],
        [
            'code' => 'ms_365',
            'name' => 'MS. 365 - Microsoft 365',
        ],
        [
            'code' => 'eda',
            'name' => 'EDA',
        ],
    ];
@endphp

@section('layout.settings')
    {{-- <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
            class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-plus">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            <span class="max-lg:hidden">Agregar nueva unidad</span>
        </button>

        <div id="dialog" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                <div class="flex items-center justify-between p-3 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Agrega nueva unidad de negocio
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
                <form action="/settings/business-units" method="POST" id="dialog-form" class="p-3 dinamic-form grid gap-4">
                    @include('modules.settings.business-units.form')
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
                        <th class="w-full">Nombre</th>
                        <th>Dominio</th>
                        <th>Servicios</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($businessUnits->count() === 0)
                        <tr class="">
                            <td colspan="11" class="text-center py-4">
                                <div class="p-10">
                                    No hay nada por aquí
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($businessUnits as $unit)
                            <tr
                                class="[&>td]:py-4 hover:border-transparent hover:[&>td]shadow-md relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                <td>
                                    <div class="flex gap-3 items-center">
                                        <button title="Click para editar" class="absolute inset-0"
                                            data-modal-target="dialog-{{ $unit->id }}"
                                            data-modal-toggle="dialog-{{ $unit->id }}">
                                        </button>

                                        <div id="dialog-{{ $unit->id }}" data-modal-backdrop="static" tabindex="-1"
                                            aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-md max-h-full bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                    <h3 class="text-lg font-semibold text-gray-900">
                                                        Editar unidad de negocio
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="dialog-{{ $unit->id }}">
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
                                                <form action="/settings/business-units/{{ $unit->id }}" method="POST"
                                                    id="dialog-{{ $unit->id }}-form"
                                                    class="p-3 dinamic-form grid gap-4">
                                                    @include('modules.settings.business-units.form', [
                                                        'businessUnit' => $unit,
                                                    ])
                                                </form>
                                                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                    <button form="dialog-{{ $unit->id }}-form" type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                                        Guardar</button>
                                                    <button id="button-close-scheldule-modal"
                                                        data-modal-hide="dialog-{{ $unit->id }}" type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-medium text-nowrap">{{ $unit->name }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ $unit->domain }}
                                    </p>
                                </td>
                                <td>
                                    <div class="text-nowrap flex items-center gap-2">
                                        @foreach ($unit->services as $service)
                                            @php
                                                $name = collect($business_services)->where('code', $service)->first()[
                                                    'name'
                                                ];
                                            @endphp
                                            <div
                                                class="p-1 px-2 block rounded-full bg-violet-600 text-xs font-medium shadow-md shadow-violet-400/40 text-white">
                                                {{ $name }}</div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-normal flex-grow text-nowrap">
                                            <span class="block">
                                                {{ $unit->createdBy->last_name }},
                                                {{ $unit->createdBy->first_name }}</span>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-nowrap">
                                        {{ \Carbon\Carbon::parse($unit->created_at)->isoFormat('LL') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <footer class="px-5 pt-4">
            {!! $businessUnits->links() !!}
        </footer>
    </div> --}}
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Unidades de negocio.</h2>
        <form class="flex dinamic-form-to-params pb-4 items-center gap-4">
            <label class="relative mt-6 ml-auto w-full max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..." type="search"
                    class="pl-9 w-full bg-white">
            </label>
            <button class="primary mt-6">
                Filtrar
            </button>
        </form>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                <span>Nuevo</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nueva unidad de negocio.
                    </header>
                    <form action="/api/business-units" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.business-units.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($businesses as $business)
                    <div class="flex relative hover:bg-neutral-100 items-start p-2.5 gap-2">
                        @svg('fluentui-building-multiple-20-o', 'w-6 h-6 mr-2')
                        <div class="flex-grow">
                            <p class="font-semibold">{{ $business->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                @svg('fluentui-globe-20-o', 'w-5 h-5')
                                {{ $business->domain }}
                            </p>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $business->id }}"
                            data-modal-toggle="dialog-{{ $business->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('fluentui-edit-20', 'w-5 h-5')
                        </button>
                        <div id="dialog-{{ $business->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar sede: {{ $business->name }}
                                </header>
                                <form action="/api/business-units/{{ $business->id }}" method="POST"
                                    id="dialog-{{ $business->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.business-units.form', [
                                        'business' => $business,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $business->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $business->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $business->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                        </button>
                        <div id="dropdown-{{ $business->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Esta acción no se puede deshacer."
                                data-param="/api/business-units/delete/{{ $business->id }}"
                                class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="p-20 grid place-content-center text-center">
                        No hay nada que mostrar.
                    </p>
                @endforelse
                <footer class="px-5 py-4">
                    {!! $businesses->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
