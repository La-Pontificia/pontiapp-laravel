<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Codigo</span>
    <input required type="text" name="code" placeholder= "{{ $code ? $code : 'Código' }}"
        value="{{ $code ? $code : '' }}" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required value="{{ $name ? $name : '' }}" type="text" name="name" placeholder="Nombre del departamento"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Area</span>
    <select name="id_area" class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
        @foreach ($areas as $area)
            <option @if ($area->id == $id_area) selected @endif value="{{ $area->id }}">{{ $area->name }}
            </option>
        @endforeach
    </select>
</label>
