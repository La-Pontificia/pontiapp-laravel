@extends('modules.settings.+layout')

@section('title', 'Ajustes del sistema: Tipos de contrato')

@section('layout.settings')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Tipos de contrato.</h2>
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
                <span>Agregar nuevo tipo de contrato.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo tipo de contrato.
                    </header>
                    <form action="/contract-types" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.contract-types.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($contracts as $contract)
                    <div class="flex relative hover:bg-neutral-100 items-center p-2.5 gap-2">
                        @svg('fluentui-handshake-20-o', 'w-6 h-6 mr-2')
                        <div class="flex-grow">
                            <p class="font-semibold">{{ $contract->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                @php
                                    $hasOne = $contract->users->count() == 1;
                                @endphp
                                {{ $contract->users->count() }} {{ $hasOne ? 'usuario asignado' : 'usuarios asignados' }}.
                            </p>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $contract->id }}"
                            data-modal-toggle="dialog-{{ $contract->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('fluentui-edit-20', 'w-5 h-5')
                        </button>
                        <div id="dialog-{{ $contract->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar tipo de contrato: {{ $contract->name }}
                                </header>
                                <form action="/contract-types/{{ $contract->id }}" method="POST"
                                    id="dialog-{{ $contract->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.contract-types.form', [
                                        'contract' => $contract,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $contract->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $contract->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $contract->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                        </button>
                        <div id="dropdown-{{ $contract->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Estas a punto de eliminar el tipo de contrato: {{ $contract->name }}. Esta acción no se puede deshacer."
                                data-param="/contract-types/delete/{{ $contract->id }}"
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
                    {!! $contracts->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
