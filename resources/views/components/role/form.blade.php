<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Codigo</span>
    <input required type="text" name="code" placeholder= "{{ $code ? $code : 'Código' }}"
        value="{{ $code ? $code : '' }}" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>
<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Puesto</span>
    <select name="id_job_position" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
        @foreach ($jobPositions as $job)
            <option @if ($job->id == $id_job_position) selected @endif value="{{ $job->id }}">{{ $job->name }}
            </option>
        @endforeach
    </select>
</label>
<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required value="{{ $name ? $name : '' }}" type="text" name="name" placeholder="Nombre del cargo"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
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
