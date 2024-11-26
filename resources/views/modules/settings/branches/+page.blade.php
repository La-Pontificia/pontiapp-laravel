@extends('modules.settings.+layout')

@section('title', 'Ajustes del sistema: Sedes')

@section('layout.settings')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Sedes.</h2>
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
                <span>Nuevo sede.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo sede
                    </header>
                    <form action="/api/branches" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.branches.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($branches as $branch)
                    <div class="flex relative hover:bg-neutral-100 items-start p-2.5 gap-2">
                        @svg('fluentui-location-20-o', 'w-6 h-6 mr-2')
                        <div class="flex-grow">
                            <p class="font-semibold">{{ $branch->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                {{ $branch->address }}
                            </p>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $branch->id }}"
                            data-modal-toggle="dialog-{{ $branch->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('fluentui-edit-20', 'w-5 h-5')
                        </button>
                        <div id="dialog-{{ $branch->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar sede: {{ $branch->name }}
                                </header>
                                <form action="/api/branches/{{ $branch->id }}" method="POST"
                                    id="dialog-{{ $branch->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.branches.form', [
                                        'branch' => $branch,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $branch->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $branch->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $branch->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                        </button>
                        <div id="dropdown-{{ $branch->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Esta acción no se puede deshacer."
                                data-param="/api/branches/delete/{{ $branch->id }}"
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
                    {!! $branches->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
