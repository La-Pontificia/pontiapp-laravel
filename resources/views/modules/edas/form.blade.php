<label class="label autocomplete" data-atitle="full_name" data-value="id" data-adescription="email"
    data-param="/api/users/search">
    <span>Colaborador</span>
    <input type="text" name="user_id" data-strategy="dataset">
    <ul class="autocomplete-result-list"></ul>
</label>

<label class="label">
    <span>Año</span>
    <select class="w-full" name="year_id">
        @foreach ($years as $year)
            <option {{ request()->query('year') === $year->id ? 'selected' : '' }} value="{{ $year->id }}">
                {{ $year->name }}</option>
        @endforeach
    </select>
</label>
