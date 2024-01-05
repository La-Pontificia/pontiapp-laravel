<div class="grid gap-2 w-full">

    <label>
        Nombre
        <input required type="text" name="nombre" placeholder="Ingrese el nombre" value="{{ $sede->nombre }}"
            class="p-3 w-full rounded-full px-4">
    </label>
    <label>
        Dirección
        <input required type="text" name="direccion" placeholder="Ingresa la direccion" value="{{ $sede->direccion }}"
            class="p-3 w-full rounded-full px-4">
    </label>
</div>
