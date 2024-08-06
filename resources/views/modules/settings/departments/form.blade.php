@php
    $code = isset($department) ? $department->code : null;
    $name = isset($department) ? $department->name : null;
    $id_area = isset($department) ? $department->id_area : null;

@endphp
<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Codigo</span>
    <input autofocus required type="text" name="code" placeholder= "{{ $code ?? 'Código' }}"
        value="{{ $code }}" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del departamento"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <select name="id_area">
        <option value="">Seleccione una area</option>
        @foreach ($areas as $area)
            <option value="{{ $area->id }}" {{ $area->id == $id_area ? 'selected' : '' }}>{{ $area->name }}
            </option>
        @endforeach
    </select>
</label>
