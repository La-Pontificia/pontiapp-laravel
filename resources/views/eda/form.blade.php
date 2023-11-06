    <div class="box-body grid grid-cols-2 gap-2">
        <span>
            <input type="number" name="año" required value="{{ $newEda->year }}" placeholder="Año"
                class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
            {!! $errors->first('year', '<div class="invalid-feedback">:message</div>') !!}
        </span>
    </div>
