<div class="flex p-1 gap-3 items-center">
    <label class="relative">
        <div class="absolute inset-y-0 flex items-center pl-2 opacity-60">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-search">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
        <input value="{{ request()->query('query') }}" type="search" id="search-user-input"
            placeholder="Buscar colaborador..."
            class=" w-[200px] text-black outline-0 border border-neutral-300 hover:bg-[#dfdfdf] flex items-center rounded-md gap-2 p-2 text-sm px-3 pl-9">
    </label>
    <select class="dinamic-select bg-transparent p-1 border-transparent rounded-lg cursor-pointer" name="job_position">
        <option value="0">Todos los puestos</option>
        @foreach ($job_positions as $job)
            <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }} value="{{ $job->id }}">
                {{ $job->name }}</option>
        @endforeach
    </select>
    <select class="dinamic-select bg-transparent p-1 border-transparent rounded-lg cursor-pointer" name="role">
        <option value="0">Todos los cargos</option>
        @foreach ($roles as $role)
            <option {{ request()->query('role') === $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                {{ $role->name }}</option>
        @endforeach
    </select>
</div>
