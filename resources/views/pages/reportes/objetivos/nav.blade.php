<?php
$hasta = request()->query('hasta');
$desde = request()->query('desde');
$estado = request()->query('estado');
$eva = request()->query('eva');

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
        <select id="eva" class="bg-neutral-200 rounded-lg border-neutral-400 w-[150px]" name="">
            <option value="" selected>Evaluacion</option>
            <option {{ $eva == '1' ? 'selected' : '' }} value="1">Eva 01</option>
            <option {{ $eva == '2' ? 'selected' : '' }} value="2">Eva 02</option>
        </select>
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
        <button id="excel" class="bg-slate-900 text-white font-semibold rounded-full min-w-max p-2 px-5">Exportar
            excel</button>
    </div>
</nav>

<script>
    function handleSelectChange(selectId, paramName) {
        var selectedValue = document.getElementById(selectId).value;
        var currentURL = window.location.href;

        currentURL = currentURL.replace(/[?&]page(=([^&#]*)|&|#|$)/, '');

        var regex = new RegExp("[?&]" + paramName + "(=([^&#]*)|&|#|$)");
        if (regex.test(currentURL)) {
            currentURL = currentURL.replace(new RegExp("([?&])" + paramName + "=.*?(&|#|$)"), '$1' + paramName + '=' +
                selectedValue + '$2');
        } else {
            currentURL += (currentURL.indexOf('?') === -1 ? '?' : '&') + paramName + '=' + selectedValue;
        }

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

    document.getElementById('eva').addEventListener('change', function() {
        handleSelectChange('eva', 'eva');
    });
</script>
