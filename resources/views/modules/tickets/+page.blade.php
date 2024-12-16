@extends('modules.tickets.+layout')

@section('title', 'Gestión Tickets')

@php
    $states = [
        'pending' => [
            'name' => 'Pendiente',
            'color' => 'bg-yellow-200 text-yellow-800',
        ],
        'in_progress' => [
            'name' => 'En progreso',
            'color' => 'bg-blue-200 text-blue-800',
        ],
        'finished' => [
            'name' => 'Finalizado',
            'color' => 'bg-green-200 text-green-800',
        ],
    ];
@endphp

@section('layout.tickets')
    <div class="w-full flex flex-col flex-grow">
        <nav class="px-2">
            <div>
                <h1 class="font-semibold text-lg">
                    Gestión Tickets
                </h1>
            </div>
            <a href="/tickets/create" class="primary mt-4 gradient">
                @svg('fluentui-add-circle-20', 'h-6 w-6')
                Registrar nuevo
            </a>
        </nav>
        <div class="p-2 overflow-y-auto flex flex-grow flex-col">
            <div class="bg-white overflow-y-auto border border-neutral-200 shadow-md flex-grow rounded-2xl">
                <table class="w-full">
                    <thead class="border-b">
                        <tr class="[&>th]:font-semibold text-sm [&>th]:p-3 [&>th]:px-5 text-left">
                            <th>
                                <p>#Numero</p>
                            </th>

                            <th>
                                <p>Estado</p>
                            </th>

                            <th class="w-full">
                                <p>Asunto</p>
                            </th>

                            <th class="w-full">
                                <p>Institución</p>
                            </th>

                            <th>
                                <p>Nombres</p>
                            </th>

                            <th>
                                <p>Apellidos</p>
                            </th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody id="tickets_tbody" class="divide-y text-sm divide-neutral-200/80">
                        @foreach ($tickets as $ticket)
                            <tr class="[&>td]:p-2 [&>td>p]:text-nowrap [&>td]:px-3">
                                <td>
                                    <p class="text-center font-semibold text-lg">
                                        {{ '#' . $ticket->number }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <span
                                            class="rounded-full px-2 font-medium py-1 text-xs {{ $states[$ticket->state]['color'] }}">
                                            {{ $states[$ticket->state]['name'] }}
                                        </span>
                                    </p>
                                </td>
                                <td>
                                    <p class="line-clamp-2">
                                        {{ $ticket->affair }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $ticket->business->name }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $ticket->names }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $ticket->lastnames() }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </p>
                                </td>
                                <td>
                                    <a class="secondary text-nowrap" href="/tickets/{{ $ticket->id }}"
                                        class="text-blue-500">
                                        Ver más
                                    </a>
                                </td>
                                <td>
                                    <button class="rounded-full relative p-2 hover:bg-stone-200 transition-colors"
                                        data-dropdown-toggle="dropdown-{{ $ticket->id }}">
                                        @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                                    </button>
                                    <div id="dropdown-{{ $ticket->id }}" class="dropdown-content hidden">
                                        <button
                                            class="p-2 hover:bg-stone-100 text-left w-full block rounded-md text-red-500">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($tickets->count() > 19)
                    <footer class="px-5 py-4">
                        {!! $tickets->links() !!}
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
