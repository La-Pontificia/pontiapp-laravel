<?php
$hasta = request()->query('hasta');
$desde = request()->query('desde');
$estado = request()->query('estado');
$eva = request()->query('eva');
$cuestionario = request()->query('cuestionario');

?>

<nav class="flex gap-2 items-center">
    <div class="flex gap-2 items-center rounded-full border p-1">
        <select class="bg-neutral-200 rounded-full combobox-dinamic border-neutral-400 w-[120px]" name="desde">
            <option value="" selected>Año</option>
            @foreach ($edasList as $edaLi)
                <option {{ $desde == $edaLi->año ? 'selected' : '' }} value="{{ $edaLi->año }}">
                    {{ $edaLi->año }}
                </option>
            @endforeach
        </select>
        <span class="text-neutral-400">Hasta</span>
        <select class="bg-neutral-200 rounded-full combobox-dinamic border-neutral-400 w-[120px]" name="hasta">
            <option value="" selected>Año</option>
            @foreach ($edasList as $edaLi)
                <option {{ $hasta == $edaLi->año ? 'selected' : '' }} value="{{ $edaLi->año }}">
                    {{ $edaLi->año }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="">
        <select name="estado" class="bg-neutral-200 combobox-dinamic rounded-full border-neutral-400 w-[150px]">
            <option value="" selected>Estado</option>
            <option {{ $estado == '1' ? 'selected' : '' }} value="1">Sin aprobar</option>
            <option {{ $estado == '2' ? 'selected' : '' }} value="2">Aprobados</option>
            <option {{ $estado == '3' ? 'selected' : '' }} value="3">Cerrados</option>
        </select>
    </div>
    <div class="">
        <select name="cuestionario" class="bg-neutral-200 combobox-dinamic rounded-full border-neutral-400 w-[150px]">
            <option value="" selected>Cuestionario</option>
            <option {{ $cuestionario == '1' ? 'selected' : '' }} value="1">Enviados</option>
            <option {{ $cuestionario == '2' ? 'selected' : '' }} value="2">No enviados</option>
        </select>
    </div>
    <div class="flex gap-2 justify-center">
        <button type="button" id="toggleeva2"
            class="flex items-center text-sm font-semibold gap-2 min-w-max line-clamp-1 px-4 w-full text-left py-2 {{ $mostrareva2 ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'hover:bg-gray-300 bg-gray-200' }} rounded-full max-w-max">
            <span class="w-5 h-5 block">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                    <path
                        d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </span>
            Eva 2
        </button>
    </div>
    <div class=" ml-auto">
        <button id="exportBtn" name="edas" data-url="/reportes/edas" id="exportarBtn"
            {{ count($edas) < 1 ? 'disabled' : '' }}
            class="bg-slate-900 disabled:opacity-40 text-white font-semibold rounded-full min-w-max p-2 px-5">Exportar
            excel</button>
    </div>
</nav>


<script>
    document.getElementById('toggleeva2').addEventListener('click', function() {
        const urlSearchParams = new URLSearchParams(window.location.search);
        const eva1ParamExists = urlSearchParams.has('eva2');
        if (eva1ParamExists) {
            urlSearchParams.delete('eva2');
        } else {
            urlSearchParams.append('eva2', '1');
        }
        const baseUrl = window.location.href.split('?')[0];
        const newUrl = baseUrl + '?' + urlSearchParams.toString();
        window.history.replaceState({
            path: newUrl
        }, '', newUrl);
        location.reload();
    });
</script>
