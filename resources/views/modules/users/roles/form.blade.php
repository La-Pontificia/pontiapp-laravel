@php
    $code = $role->code ?? null;
    $name = $role->name ?? null;
    $id_job_position = $role->id_job_position ?? null;
    $id_department = $role->id_department ?? null;
@endphp

<div class="grid gap-2">
    <label>
        <span class="block pb-1 text-sm font-semibold opacity-50 ">Codigo</span>
        <input required type="text" name="code" placeholder= "{{ $code ?? $newCode }}" value="{{ $code }}"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
    </label>
    <label>
        <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
        <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del cargo"
            class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
    </label>
    <label>
        <span class="block pb-1 text-sm font-semibold opacity-50 ">Puesto</span>
        <select name="id_job_position" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($jobPositions as $job)
                <option @if ($job->id == $id_job_position) selected @endif value="{{ $job->id }}">
                    {{ $job->name }}
                </option>
            @endforeach
        </select>
    </label>
    <label>
        <span class="block pb-1 text-sm font-semibold opacity-50 ">Departamento</span>
        <select name="id_department" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
            @foreach ($departments as $department)
                <option @if ($department->id == $id_department) selected @endif value="{{ $department->id }}">
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </label>
    {{-- <div class="autocompletes" data-atitle="full_name" data-value="id" data-adescription="email"
        data-params="/api/users/search">
        <input {{ $userId ? "data-value=$userId" : '' }} name="id_user" required value="{{ $names }}"
            data-strategy="dataset" class="autocomplete-input" placeholder="Buscar usuario" aria-label="Search user">
        <ul class="autocomplete-result-list" class="bg-white"></ul>
    </div>
    <div class="flex items-center gap-1">
        <input value="{{ $username }}" required type="text" name="username" placeholder="Nombre de usuario"
            class="w-full">
        <select style="width: 200px" required name="domain">
            @foreach ($domains as $domain)
                <option {{ $userDomain === $domain->domain ? 'selected' : '' }} value="{{ $domain->domain }}">
                    {{ '@' . $domain->domain }}</option>
            @endforeach
        </select>
    </div>
    <textarea name="description" required class="min-h-32" placeholder="Descripción">{{ $description }}</textarea>
    <div>
        <p class="text-xs font-semibold opacity-50 p-2">Accesos</p>
        <div class="grid gap-2 grid-cols-2">
            @foreach ($access as $item)
                <label class="inline-flex items-center cursor-pointer">
                    <input {{ $emailAccess && in_array($item['value'], $emailAccess) ? 'checked' : '' }}
                        data-notoutline-styles type="checkbox" name="access[]" value="{{ $item['value'] }}"
                        class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 font-medium text-gray-900">{{ $item['name'] }}</span>
                </label>
            @endforeach
        </div>

    </div> --}}
</div>
