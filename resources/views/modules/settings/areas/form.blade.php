@php
    $code = isset($area) ? $area->code : null;
    $name = isset($area) ? $area->name : null;

@endphp
<label class="label">
    <span>Codigo</span>
    <input autofocus required type="text" name="code" placeholder= "{{ $code ?? 'Código' }}"
        value="{{ $code }}">
</label>

<label class="label">
    <span>Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre de la area">
</label>
