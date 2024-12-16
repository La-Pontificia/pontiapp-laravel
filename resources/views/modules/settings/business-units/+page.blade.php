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
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Unidades de negocio.</h2>
        <form class="flex dinamic-form-to-params pb-4 items-center gap-4">
            <label class="relative mt-6 ml-auto w-full max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input style="padding-left: 35px" value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..."
                    type="search" class="pl-9 w-full bg-white">
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
                    <div class="flex relative hover:bg-stone-100 items-start p-2.5 gap-2">
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
                            class="rounded-full p-2 hover:bg-stone-200 transition-colors">
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
                        <button class="rounded-full p-2 hover:bg-stone-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $business->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                        </button>
                        <div id="dropdown-{{ $business->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Esta acción no se puede deshacer."
                                data-param="/api/business-units/delete/{{ $business->id }}"
                                class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
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
