@extends('modules.tickets.settings.+layout')

@section('title', 'Ajustes de Unidades de Negocios')

@section('layout.tickets.settings')
    <div class="w-full flex py-5 pt-3 px-1 flex-col flex-grow">
        <nav class="px-2 pb-2">
            <h1 class="font-semibold text-lg">
                Ajustes de Unidades de Negocios
            </h1>
            <p>
                Por favor selecciona las unidades de negocio que deseas habilitar para el modulo de Tickets.
            </p>
        </nav>
        <div class="w-fit">
            <form action="/api/tickets/settings/business-units" method="POST" class="dinamic-form">
                <div class="flex p-2 font-medium flex-col shadow-md rounded-xl gap-1">
                    @foreach ($businessUnits as $unit)
                        @php
                            $checked = $ticketBusinessUnits->pluck('business_unit_id')->contains($unit->id);
                        @endphp
                        <label class="flex p-2 rounded-lg hover:bg-white items-center gap-2">
                            <input {{ $checked ? 'checked' : '' }} type="checkbox" name="business_units[]"
                                value="{{ $unit->id }}">
                            <div>
                                <span class="block"> {{ $unit->name }} </span>
                                <p class="flex items-center font-normal text-sm gap-2">
                                    @svg('fluentui-globe-20-o', 'w-5 h-5')
                                    {{ $unit->domain }}
                                </p>
                            </div>
                        </label>
                    @endforeach
                </div>
                <button class="primary mt-3 gradient">
                    Actualizar Unidades de Negocios
                </button>
            </form>
        </div>
    </div>
@endsection
