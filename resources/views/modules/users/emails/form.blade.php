@php
    $username = $email ? explode('@', $email->email)[0] : null;
    $userDomain = $email ? explode('@', $email->email)[1] : null;
    $names = $email ? $email->user->first_name . ' ' . $email->user->last_name : null;
    $userId = $email ? $email->user->id : null;
    $description = $email ? $email->description : null;
    $emailAccess = $email ? json_decode($email->access, true) : null;
@endphp
<div class="grid gap-2">
    <div class="autocompletes" data-atitle="full_name" data-value="id" data-adescription="email"
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

    </div>
</div>
