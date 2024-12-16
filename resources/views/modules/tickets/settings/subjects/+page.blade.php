@extends('modules.tickets.settings.+layout')

@section('title', 'Ajustes de asuntos de Tickets')

@section('layout.tickets.settings')
    <div class="w-full flex pt-5 px-1 flex-col flex-grow">
        <nav class="px-2 pb-2">
            <h1 class="font-semibold text-lg">
                Ajustes de asuntos de Tickets

            </h1>
            <p>
                Crea y modifica los asuntos que se pueden seleccionar al crear un ticket.
            </p>
        </nav>
        <nav>
            <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                <span>Nuevo asunto.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Crear nuevo asunto
                    </header>
                    {{-- <form action="/api/branches" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.branches.form')
                    </form> --}}
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
        </nav>
        <div class="flex flex-grow bg-white rounded-xl shadow-md w-full">
            <div class="w-full">
            </div>
        </div>
    </div>
@endsection
