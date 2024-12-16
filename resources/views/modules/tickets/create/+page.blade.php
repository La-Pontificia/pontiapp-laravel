@extends('modules.tickets.create.+layout')

@section('title', 'Registro de Tickets')

@section('layout.tickets.create')
    <div id="create-ticket-fast-panel"
        class="flex-grow group data-[maximize]:fixed transition-all data-[maximize]:inset-0 data-[maximize]:z-[999] flex">
        <div class="flex-grow relative flex bg-white rounded-xl shadow-md">
            <div class="absolute top-2 right-2">
                <button id="maximize-create-ticket-fast-panel">
                    @svg('fluentui-arrow-maximize-20-o', 'h-6 w-6 text-gray-500 m-2')
                </button>
            </div>
            <div class="grid place-content-center w-full">
                <div class="text-center">
                    <div class="flex items-center justify-center">
                        <img src="/286.Passports.webp" class="w-[200px]" alt="">
                    </div>
                    <p class="text-base opacity-80">
                        Por favor escanea tu Carnet o DNI para continuar.
                    </p>
                    <div id="listening-barcode"></div>
                </div>
            </div>
            <div class="group-data-[maximize]:flex hidden absolute bottom-0 w-full justify-center p-2">
                <img src="/elp.webp" class="w-[100px]" alt="">
            </div>
        </div>
    </div>
@endsection
