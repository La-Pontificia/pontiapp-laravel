@php
    $code = isset($area) ? $area->code : null;
    $name = isset($area) ? $area->name : null;

@endphp
<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Codigo</span>
    <input autofocus required type="text" name="code" placeholder= "{{ $code ?? 'Código' }}"
        value="{{ $code }}" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre de la area"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>
