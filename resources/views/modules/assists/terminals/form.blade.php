@php
    $database_name = isset($terminal) ? $terminal->database_name : null;
    $name = isset($terminal) ? $terminal->name : null;
@endphp

<label class="label">
    <span>Nombre</span>
    <input autofocus required type="text" name="name" placeholder= "{{ $code ?? 'Nombre' }}"
        value="{{ $name }}">
</label>

<label class="label">
    <span>Nombre de la base de datos.</span>
    <input required value="{{ $database_name }}" type="text" name="database_name" placeholder="Ej. PL-Alameda">
    <p class="text-sm">
        Por favor ingrese el nombre tal cual de la base de datos a la que soportará el sistema.
    </p>
</label>
