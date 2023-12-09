<?php
$hasta = request()->query('hasta');
$desde = request()->query('desde');
$estado = request()->query('estado');

?>

<nav class="flex gap-3 divide-x">
    <div class="flex gap-2 items-center ">
        <select id="desde" class="bg-neutral-200 rounded-lg border-neutral-400 w-[120px]" name="">
            <option value="" selected>Año</option>
            @foreach ($edas as $eda)
                <option {{ $desde == $eda->id ? 'selected' : '' }} value="{{ $eda->id }}">
                    {{ $eda->año }}
                </option>
            @endforeach
        </select>
        <span class="text-neutral-400">Hasta</span>
        <select id="hasta" class="bg-neutral-200 rounded-lg border-neutral-400 w-[120px]" name="">
            <option value="" selected>Año</option>
            @foreach ($edas as $eda)
                <option {{ $hasta == $eda->id ? 'selected' : '' }} value="{{ $eda->id }}">
                    {{ $eda->año }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="pl-2 flex gap-2">
        <div class="flex items-center border border-gray-200 rounded-xl dark:border-gray-700">
            <input id="eva01" type="checkbox" value="" name="bordered-checkbox"
                class="w-4 h-4 text-blue-600 ms-2 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
            <label for="eva01" class="w-full py-2 mr-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                Eva 01
            </label>
        </div>
        <div class="flex items-center border border-gray-200 rounded-xl ">
            <input checked id="eva02" type="checkbox" value="" name="bordered-checkbox"
                class="w-4 h-4 text-blue-600 ms-2 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
            <label for="eva02" class="w-full mr-2 py-2 ms-2 text-sm font-medium text-gray-900">
                Eva 02
            </label>
        </div>
    </div>
    <div class="pl-2">
        <select id="estado" class="bg-neutral-200 rounded-lg border-neutral-400 w-[150px]" name=""
            id="">
            <option value="" selected>Estado</option>
            <option {{ $estado == '1' ? 'selected' : '' }} value="1">Sin aprobar</option>
            <option {{ $estado == '2' ? 'selected' : '' }} value="2">Aprobados</option>
            <option {{ $estado == '3' ? 'selected' : '' }} value="3">Cerrados</option>
        </select>
    </div>
    <div class="pl-2 ml-auto">
        <button id="excel" class="bg-neutral-200 min-w-max rounded-lg border-neutral-400 border p-2 px-5">Exportas
            excel</button>
    </div>
</nav>

<script>
    function handleSelectChange(selectId, paramName) {
        var selectedValue = document.getElementById(selectId).value;
        var currentURL = window.location.href;

        // Elimina el parámetro 'page' del URL actual
        currentURL = currentURL.replace(/[?&]page(=([^&#]*)|&|#|$)/, '');

        // Reemplaza o agrega el nuevo parámetro de selección
        var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
        if (regex.test(currentURL)) {
            currentURL = currentURL.replace(new RegExp("([?&])" + paramName + "=.*?(&|#|$)"), '$1' + paramName + '=' +
                selectedValue + '$2');
        } else {
            currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' + selectedValue;
        }

        // Redirige a la nueva URL
        window.location.href = currentURL;
    }

    document.getElementById('desde').addEventListener('change', function() {
        handleSelectChange('desde', 'desde');
    });

    document.getElementById('hasta').addEventListener('change', function() {
        handleSelectChange('hasta', 'hasta');
    });

    document.getElementById('estado').addEventListener('change', function() {
        handleSelectChange('estado', 'estado');
    });

    document.getElementById('eva01').addEventListener('change', function() {
        handleSelectChange('puesto', 'id_puesto');
    });
</script>
