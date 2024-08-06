@php
    $name = isset($businessUnit) ? $businessUnit->name : null;
    $domain = isset($businessUnit) ? $businessUnit->domain : null;
    $services = isset($businessUnit) ? $businessUnit->services : [];
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


<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required value="{{ $name }}" type="text" name="name" placeholder="Nombre de la unidad de negocio">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50">Dominio</span>
    <input required value="{{ $domain }}" type="text" name="domain" placeholder="Ej. elp.edu.pe">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Servicios</span>
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
