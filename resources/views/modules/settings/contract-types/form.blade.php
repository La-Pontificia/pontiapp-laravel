@php
    $name = isset($contract) ? $contract->name : null;
    $description = isset($contract) ? $contract->description : null;

@endphp

<label class="label">
    <span>Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del tipo de contrato">
</label>

<label class="label">
    <span>
        Descripción
    </span>
    <textarea name="description" class="min-h-[100px]"></textarea>
</label>
