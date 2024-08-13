@php
    $code = $role->code ?? null;
    $name = $role->name ?? null;
    $id_job_position = $role->id_job_position ?? null;
    $id_department = $role->id_department ?? null;
@endphp

<label class="label">
    <span>Codigo</span>
    <input type="text" name="code" placeholder= "{{ $code ?? $newCode }}" value="{{ $code }}">
</label>
<label class="label">
    <span>Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre del cargo">
</label>
<label class="label">
    <span>Puesto</span>
    <select name="id_job_position">
        @foreach ($jobPositions as $job)
            <option @if ($job->id == $id_job_position) selected @endif value="{{ $job->id }}">
                {{ $job->name }}
            </option>
        @endforeach
    </select>
</label>
<label class="label">
    <span>Departamento</span>
    <select name="id_department">
        @foreach ($departments as $department)
            <option @if ($department->id == $id_department) selected @endif value="{{ $department->id }}">
                {{ $department->name }}
            </option>
        @endforeach
    </select>
</label>
