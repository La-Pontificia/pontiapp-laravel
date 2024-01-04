<div class="p-2 grid gap-2">
    @if ($enableCode)
        <label>Código
            <input value="{{ $departamento->codigo }}" required type="text" class="p-3 w-full rounded-full px-4"
                name="codigo" placeholder="Ingrese el código ">
        </label>
    @endif

    <label>Nombre
        <input value="{{ $departamento->nombre }}" type="text" class="p-3 w-full rounded-full px-4" name="nombre"
            placeholder="Ingrese el nombre">
    </label>

    <label for="">
        <span>Area</span>
        <select required name="id_area" class="p-3 w-full rounded-full px-4">
            <option selected value="">Selecciona una area</option>
            @foreach ($areas as $area)
                <option {{ $departamento->id_area == $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                    {{ $area->nombre }}
                </option>
            @endforeach
        </select>
    </label>

</div>
