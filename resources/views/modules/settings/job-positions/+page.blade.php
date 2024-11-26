@extends('modules.users.+layout')

@section('title', 'Puestos de trabajo')

@section('layout.users')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Puestos de trabajo.</h2>
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
                <span>Agregar nuevo puesto.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo puesto
                    </header>
                    <form action="/api/job-positions" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.job-positions.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($jobs as $job)
                    <div class="flex relative hover:bg-neutral-100 items-center p-2.5 gap-2">
                        @svg('fluentui-toolbox-20-o', 'w-6 h-6 mr-2')
                        <div class="flex-grow">
                            <p class="font-semibold">{{ $job->code }}-{{ $job->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                {{ $job->roles->count() }} cargos asociados.
                            </p>
                        </div>
                        <div class="px-2">
                            <span class="text-sm text-nowrap bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                Nivel {{ $job->level }}
                            </span>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $job->id }}"
                            data-modal-toggle="dialog-{{ $job->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('fluentui-edit-20', 'w-5 h-5')
                        </button>
                        <div id="dialog-{{ $job->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar puesto: {{ $job->name }}
                                </header>
                                <form action="/api/job-positions/{{ $job->id }}" method="POST"
                                    id="dialog-{{ $job->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.job-positions.form', [
                                        'job' => $job,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $job->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $job->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $job->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                        </button>
                        <div id="dropdown-{{ $job->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Se eliminará el puesto de trabajo y todos los cargos asociados."
                                data-param="/api/job-positions/delete/{{ $job->id }}"
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
                    {!! $jobs->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
