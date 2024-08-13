@php
    $code = $job->code ?? null;
    $name = $job->name ?? null;
    $level = $job->level ?? null;
@endphp

<label class="label">
    <span>Codigo</span>
    <input type="text" name="code" placeholder= "{{ $code ?? $newCode }}" value="{{ $code }}">
</label>

<div class="grid grid-cols-2 gap-3">
    <label class="label">
        <span>Nivel</span>
        <input required value="{{ $level }}" type="number" name="level" placeholder="Nivel" value="">
    </label>

    <label class="label">
        <span>Nombre</span>
        <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del puesto">
    </label>
</div>
