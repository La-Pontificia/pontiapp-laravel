<div class="space-y-3">
    <div class="p-4 w-[300px] max-md:w-full bg-neutral-100 border rounded-2xl">
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
    @if ($eliminarEda)
        <div>
            <button id="btn-eliminar-eda" data-id="{{ $edaSeleccionado->id }}"
                class="p-2 w-full rounded-md flex justify-center gap-2 items-center bg-red-700 text-white">
                <svg class="w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3 6.38597C3 5.90152 3.34538 5.50879 3.77143 5.50879L6.43567 5.50832C6.96502 5.49306 7.43202 5.11033 7.61214 4.54412C7.61688 4.52923 7.62232 4.51087 7.64185 4.44424L7.75665 4.05256C7.8269 3.81241 7.8881 3.60318 7.97375 3.41617C8.31209 2.67736 8.93808 2.16432 9.66147 2.03297C9.84457 1.99972 10.0385 1.99986 10.2611 2.00002H13.7391C13.9617 1.99986 14.1556 1.99972 14.3387 2.03297C15.0621 2.16432 15.6881 2.67736 16.0264 3.41617C16.1121 3.60318 16.1733 3.81241 16.2435 4.05256L16.3583 4.44424C16.3778 4.51087 16.3833 4.52923 16.388 4.54412C16.5682 5.11033 17.1278 5.49353 17.6571 5.50879H20.2286C20.6546 5.50879 21 5.90152 21 6.38597C21 6.87043 20.6546 7.26316 20.2286 7.26316H3.77143C3.34538 7.26316 3 6.87043 3 6.38597Z"
                        fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12404C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001ZM10.2463 12.1886C10.2051 11.7548 9.83753 11.4382 9.42537 11.4816C9.01321 11.525 8.71251 11.9119 8.75372 12.3457L9.25372 17.6089C9.29494 18.0427 9.66247 18.3593 10.0746 18.3159C10.4868 18.2725 10.7875 17.8856 10.7463 17.4518L10.2463 12.1886ZM14.5746 11.4816C14.9868 11.525 15.2875 11.9119 15.2463 12.3457L14.7463 17.6089C14.7051 18.0427 14.3375 18.3593 13.9254 18.3159C13.5132 18.2725 13.2125 17.8856 13.2537 17.4518L13.7537 12.1886C13.7949 11.7548 14.1625 11.4382 14.5746 11.4816Z"
                        fill="currentColor"></path>
                </svg>
                Eliminar Eda
            </button>
        </div>
    @endif
</div>
