@extends('modules.tickets.create.+layout')

@section('title', 'Registro manual de Tickets')

@section('layout.tickets.create')
    <div class="w-full flex p-5 flex-col flex-grow">
        <nav class="px-2">
            <h1 class="font-semibold text-lg">
                Registro de Tickets
            </h1>
        </nav>
        <div class="p-2 overflow-y-auto flex flex-grow flex-col">
            <div class="max-w-lg">
                <form id="search_person">
                    <label class="label">
                        <span>
                            Número de documento de identidad
                        </span>
                        <input autofocus class="w-[270px] p-3" placeholder="Ingrese el número y presione enter" required
                            type="number" name="document-id">
                    </label>
                </form>
                <form id="ticket_form" class="grid gap-3 mt-5">
                    <label class="label">
                        <input required id="document-id" name="document-id" type="hidden">
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="label">
                            <span>
                                Apellido Paterno
                            </span>
                            <input required id="paternal-surname" name="paternal-surname">
                        </label>
                        <label class="label">
                            <span>
                                Apellido Materno
                            </span>
                            <input required id="maternal-surname" name="maternal-surname">
                        </label>
                    </div>
                    <label class="label">
                        <span>
                            Nombres
                        </span>
                        <input id="names" required name="names">
                    </label>
                    <label class="label">
                        <span>
                            Institución
                        </span>
                        <select name="business-unit">
                            @foreach ($unitBusiness as $business)
                                <option value="{{ $business->id }}">
                                    {{ $business->acronym }} - {{ $business->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="label">
                        <span>
                            Asunto
                        </span>
                        <textarea class="resize-none" rows="6" placeholder="Escriba aquí el asunto del ticket" required name="affair"></textarea>
                    </label>
                    <div>
                        <button class="primary">
                            Generar ticket
                        </button>
                    </div>
                </form>
            </div>
            {{-- <div class="bg-white overflow-y-auto border border-neutral-200 shadow-md flex-grow rounded-2xl">
        </div> --}}
        </div>
    </div>
@endsection
