@php
    $code = isset($department) ? $department->code : null;
    $name = isset($department) ? $department->name : null;
    $id_area = isset($department) ? $department->id_area : null;

@endphp
<label class="label">
    <span>Codigo</span>
    <input autofocus required type="text" name="code" placeholder= "{{ $code ?? 'Código' }}"
        value="{{ $code }}">
</label>

<label class="label">
    <span>Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del departamento">
</label>

<label class="label">
    <span>
        Area
    </span>
    <select name="id_area">
        <option value="">Seleccione una area</option>
        @foreach ($areas as $area)
            <option value="{{ $area->id }}" {{ $area->id == $id_area ? 'selected' : '' }}>{{ $area->name }}
            </option>
        @endforeach
    </select>
</label>
