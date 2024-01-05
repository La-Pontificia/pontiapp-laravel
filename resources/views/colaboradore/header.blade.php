@php
    $cargoRecover = request()->query('cargo');
    $puestoRecover = request()->query('puesto');
    $qRecover = request()->query('q');
    $hasCreate = in_array('crear_colaborador', $colaborador_actual->privilegios);
@endphp

<header>
    <h2 class="p-2 pt-0 font-bold text-2xl">Gestion de usuarios / Colaboradores</h2>
    <div class="flex flex-wrap gap-2">
        @if ($hasCreate)
            <button data-modal-target="crear-modal" data-modal-toggle="crear-modal"
                class="flex rounded-full items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center"
                type="button">
                <svg class="w-4" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
                Registrar colaborador
            </button>
        @endif
        <select name="puesto" class="combobox-dinamic font-semibold rounded-full border-neutral-400 w-[180px]">
            <option selected value="">Puesto</option>
            @foreach ($puestos as $puesto)
                <option {{ $puestoRecover == $puesto->id ? 'selected' : '' }} value="{{ $puesto->id }}">
                    {{ $puesto->nombre }}
                </option>
            @endforeach
        </select>
        <select name="cargo" class="combobox-dinamic font-semibold rounded-full border-neutral-400 w-[180px]">
            <option selected value="">Cargo</option>
            @foreach ($cargos as $cargo)
                <option {{ $cargoRecover == $cargo->id ? 'selected' : '' }} value="{{ $cargo->id }}">
                    {{ $cargo->nombre }}
                </option>
            @endforeach
        </select>
        <form class="w-full" action="/colaboradores">
            <input type="search" value="{{ $qRecover }}" name="q"
                class="font-semibold rounded-full border-neutral-400 w-full" placeholder="Buscar colaborador">
        </form>
    </div>

</header>
