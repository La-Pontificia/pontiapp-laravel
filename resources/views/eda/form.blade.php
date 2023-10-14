    <div class="box-body grid grid-cols-2 gap-2">
        <span>
            <input type="number" name="year" required value="{{ $newEda->year }}" placeholder="Año"
                class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
            {!! $errors->first('year', '<div class="invalid-feedback">:message</div>') !!}
        </span>
        <span>
            <select required name="n_evaluacion" value="{{ $newEda->n_evaluacion }}"
                class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
                <option value="" disabled selected>N° evaluación</option>
                <option value="1">Evaluacion N° 1</option>
                <option value="2">Evaluacion N° 2</option>
            </select>
            {!! $errors->first('n_evaluacion', '<div class="invalid-feedback">:message</div>') !!}
        </span>
        {{-- <span>
            <input required name="f_inicio" type="date" value="{{ $newEda->f_inicio }}" placeholder="Año"
                class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
            {!! $errors->first('f_inicio', '<div class="invalid-feedback">:message</div>') !!}
        </span>
        <span>
            <input required name="f_fin" type="date" value="{{ $newEda->f_fin }}" placeholder="F. fin"
                class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
            {!! $errors->first('f_fin', '<div class="invalid-feedback">:message</div>') !!}
        </span> --}}
        <span class="pt-2 block">
            <label class="relative inline-flex items-center cursor-pointer">
                <input name="wearing" type="checkbox" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Usar al guardar</span>
            </label>
        </span>
    </div>
