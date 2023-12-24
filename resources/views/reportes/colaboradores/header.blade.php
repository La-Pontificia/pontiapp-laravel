<header class="p-4 shadow-md rounded-xl">
    <nav class="flex gap-3 flex-wrap">
        <select name="area"
            class="bg-neutral-200 combobox-dinamic font-semibold rounded-full border-neutral-400 w-[200px]">
            <option selected value="">Area</option>
            @foreach ($areas as $area)
                <option {{ $areaRecover == $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                    {{ $area->nombre_area }}
                </option>
            @endforeach
        </select>
        <select name="departamento"
            class="bg-neutral-200 combobox-dinamic font-semibold rounded-full border-neutral-400 w-[180px]">
            <option selected value="">Departamento</option>
            @foreach ($departamentos as $departamento)
                <option {{ $departamentoRecover == $departamento->id ? 'selected' : '' }}
                    value="{{ $departamento->id }}">
                    {{ $departamento->nombre_departamento }}
                </option>
            @endforeach
        </select>
        <select name="cargo"
            class="bg-neutral-200 combobox-dinamic font-semibold rounded-full border-neutral-400 w-[180px]">
            <option selected value="">Cargo</option>
            @foreach ($cargos as $cargo)
                <option {{ $cargoRecover == $cargo->id ? 'selected' : '' }} value="{{ $cargo->id }}">
                    {{ $cargo->nombre_cargo }}
                </option>
            @endforeach
        </select>
        <select name="puesto"
            class="bg-neutral-200 combobox-dinamic font-semibold rounded-full border-neutral-400 w-[180px]">
            <option selected value="">Puesto</option>
            @foreach ($puestos as $puesto)
                <option {{ $puestoRecover == $puesto->id ? 'selected' : '' }} value="{{ $puesto->id }}">
                    {{ $puesto->nombre_puesto }}
                </option>
            @endforeach
        </select>
        <select name="estado"
            class="bg-neutral-200 combobox-dinamic font-semibold rounded-full border-neutral-400 w-[130px]">
            <option selected value="">Estado</option>
            <option {{ $estadoRecover == 1 ? 'selected' : '' }} value="1">
                Activos
            </option>
            <option {{ $estadoRecover == 2 ? 'selected' : '' }} value="2">
                Inactivos
            </option>
        </select>
        <div class="pl-2 ml-auto">
            <button id="exportBtn" name="colaboradores" data-url="/reportes/colaboradores"
                class="bg-slate-900 disabled:opacity-40 text-white font-semibold rounded-full min-w-max p-2 px-5">Exportar
                excel</button>
        </div>
    </nav>
</header>
