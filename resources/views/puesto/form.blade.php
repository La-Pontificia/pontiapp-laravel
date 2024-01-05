<div class="grid gap-2 p-3 w-full">
    @if ($enableCode)
        <input required type="text" name="codigo" placeholder="Código" value="{{ $puesto->codigo }}"
            class="p-3 w-full rounded-full px-4">
    @endif
    <input required type="number" name="nivel" placeholder="Nivel" value="{{ $puesto->nivel }}"
        class="p-3 w-full rounded-full px-4">
    <input required type="text" name="nombre" placeholder="Nombre" value="{{ $puesto->nombre }}"
        class="p-3 w-full rounded-full px-4">
</div>
