@extends('modules.tickets.+layout')

@section('title', 'Tickets en tiempo real')


@section('layout.tickets')
    <div class="w-full flex flex-col flex-grow gap-2">
        <nav class="px-2">
            <div>
                <h1 class="font-semibold text-lg">
                    Tickets en tiempo real
                </h1>
            </div>
        </nav>
        <div class="flex relative flex-grow rounded-xl shadow-md bg-white">
            <div class="absolute top-2 right-2">
                <button id="maximize-create-ticket-fast-panel">
                    @svg('fluentui-arrow-maximize-20-o', 'h-6 w-6 text-gray-500 m-2')
                </button>
            </div>
        </div>
    </div>
@endsection
