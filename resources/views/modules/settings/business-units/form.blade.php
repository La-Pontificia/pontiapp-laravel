@php
    $name = isset($business) ? $business->name : null;
    $acronym = isset($business) ? $business->acronym : null;
    $domain = isset($business) ? $business->domain : null;
    $services = isset($business) ? $business->services : [];
    $business_services = [
        [
            'code' => 'pontisis',
            'name' => 'Sistema Académico',
        ],
        [
            'code' => 'aula_virtual',
            'name' => 'Aula Virtual',
        ],
        [
            'code' => 'ms_365',
            'name' => 'MS. 365 - Microsoft 365',
        ],
        [
            'code' => 'eda',
            'name' => 'EDA',
        ],
    ];
@endphp


<label class="label">
    <span>Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre de la unidad de negocio">
</label>

<label class="label">
    <span>Siglas (Nombre corto)</span>
    <input required value="{{ $acronym }}" type="text" name="acronym" placeholder="Siglas">
</label>

<label class="label">
    <span>Dominio</span>
    <input required value="{{ $domain }}" type="text" name="domain" placeholder="Ej. elp.edu.pe">
</label>

<label class="label">
    <span>Servicios</span>
    <div class="grid grid-cols-2 gap-2">
        @foreach ($business_services as $business_service)
            <label>
                <input type="checkbox" name="services[]" value="{{ $business_service['code'] }}"
                    {{ in_array($business_service['code'], $services) ? 'checked' : '' }}>
                {{ $business_service['name'] }}
            </label>
        @endforeach
    </div>
</label>
