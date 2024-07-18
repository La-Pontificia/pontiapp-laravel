@php
    $code = $jobPosition->code ?? null;
    $name = $jobPosition->name ?? null;
    $level = $jobPosition->level ?? null;
@endphp

<div class="grid gap-2">
    <label>
        <span class="block pb-1 text-sm font-semibold opacity-50 ">Codigo</span>
        <input required type="text" name="code" placeholder= "{{ $code ?? $newCode }}" value="{{ $code }}"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
    </label>

    <div class="flex gap-3">
        <label class="block w-[100px]">
            <span class="block pb-1 text-sm font-semibold opacity-50 ">Nivel</span>
            <input required value="{{ $level }}" type="number" name="level" placeholder="Nivel" value=""
                class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
        </label>

        <label class="w-full block">
            <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
            <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del puesto"
                class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
        </label>
    </div>
</div>
