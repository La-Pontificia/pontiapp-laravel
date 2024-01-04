<div class="p-2 grid gap-2">
    @if ($enableCode)
        <label>Código
            <input value="{{ $cargo->codigo }}" required type="text" class="p-3 w-full rounded-full px-4" name="codigo"
                placeholder="Ingrese el código ">
        </label>
    @endif
    <label>Nombre
        <input value="{{ $cargo->nombre }}" type="text" class="p-3 w-full rounded-full px-4" name="nombre"
            placeholder="Ingrese el nombre">
    </label>
    <label for="">
        <span>Puesto</span>
        <select required name="id_puesto" class="p-3 w-full rounded-full px-4">
            <option selected value="">Selecciona un puesto</option>
            @foreach ($puestos as $puesto)
                <option {{ $cargo->id_puesto == $puesto->id ? 'selected' : '' }} value="{{ $puesto->id }}">
                    {{ $puesto->nombre }}
                </option>
            @endforeach
        </select>
    </label>
    <label for="">
        <span>Departamento</span>
        <select required name="id_departamento" class="p-3 w-full rounded-full px-4">
            <option selected value="">Selecciona un departamento</option>
            @foreach ($departamentos as $departamento)
                <option {{ $cargo->id_departamento == $departamento->id ? 'selected' : '' }}
                    value="{{ $departamento->id }}">
                    {{ $departamento->nombre }}
                </option>
            @endforeach
        </select>
    </label>
</div>
