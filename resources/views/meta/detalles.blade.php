<div class="p-4 ml-auto w-[300px] bg-neutral-100 border rounded-md">
    <div class="flex items-center pb-2">
        <h3 class="text-blue-600">Detalles</h3>
        @if ($cerrado)
            <span class="bg-red-600 ml-auto p-1 rounded-md text-white font-medium">Cerrado</span>
        @endif
    </div>
    <div class="border-t flex flex-col gap-1">
        <div>
        </div>
        @if ($edaSeleccionado->fecha_cerrado)
            <div class="text-sm opacity-70">
                {{ \Carbon\Carbon::parse($edaSeleccionado->fecha_cerrado)->format('d \d\e F \d\e\l Y') }}
            </div>
        @endif
        <div class="flex items-center gap-3">
            <span class="font-medium">Promedio:</span>
            <h5 class="font-semibold ml-auto bg-neutral-300 w-5 h-5 grid place-content-center rounded-md">
                {{ $edaSeleccionado->promedio }}</h5>
        </div>
        <div class="flex items-center gap-3">
            <span class="font-medium">Autocalificacion:</span>
            <h5 class="font-semibold ml-auto bg-neutral-300 w-5 h-5 grid place-content-center rounded-md">
                {{ $autocalificacion }}</h5>
        </div>
    </div>
</div>
