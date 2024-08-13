@php
    $name = isset($branch) ? $branch->name : null;
    $address = isset($branch) ? $branch->address : null;

@endphp

<label class="label">
    <span>Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del sede">
</label>

<label class="label">
    <span>Nombre</span>
    <input required type="text" name="address" placeholder= "{{ $address ? $address : 'Dirección' }}"
        value="{{ $address }}">
</label>
