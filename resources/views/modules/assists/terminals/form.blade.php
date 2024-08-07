@php
    $database_name = isset($terminal) ? $terminal->database_name : null;
    $name = isset($terminal) ? $terminal->name : null;
@endphp

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input autofocus required type="text" name="name" placeholder= "{{ $code ?? 'Nombre' }}"
        value="{{ $name }}" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre de la base de datos.</span>
    <input required value="{{ $database_name }}" type="text" name="database_name" placeholder="Ej. PL-Alameda"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>
