@php
    $number = isset($module) ? $module->number : '';
    $name = isset($module) ? $module->name : '';
    $business_id = isset($module) ? $module->business_id : '';
@endphp

<label class="label">
    <span>Unidad de negocio</span>
    <select name="business">
        <option value="" selected>Ninguna</option>
        @foreach ($businessUnits as $business)
            <option {{ $business_id === $business->id ? 'selected' : '' }} value="{{ $business->id }}">
                {{ $business->businessUnit->name }}</option>
        @endforeach
    </select>
</label>

<label class="label">
    <span>Número del modulo</span>
    <input value="{{ $number }}" type="number" placeholder="#" name="number" class="p-3 w-[120px]" required>
</label>


<label class="label">
    <span>Nombre del modulo</span>
    <input value="{{ $name }}" type="text" name="name" required>
</label>
