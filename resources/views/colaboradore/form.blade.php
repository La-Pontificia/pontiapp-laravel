<div class="grid gap-3 md:grid-cols-2">
    <label>
        Nombres
        <input value="{{ $colaborador->nombres }}" type="text" required name="nombres" placeholder="Ingrese los nombres"
            class="p-3 w-full rounded-full px-4">
    </label>
    <label>
        Apellidos
        <input value="{{ $colaborador->apellidos }}" type="text" required name="apellidos"
            placeholder="Ingrese los apellidos" class="p-3 w-full rounded-full px-4">
    </label>

    <label>
        DNI
        <input value="{{ $colaborador->dni }}" type="text" required name="dni" placeholder="Ingrese el DNI"
            pattern="[0-9]{8}" title="Ingresa un DNI válido de 8 dígitos" class="p-3 w-full rounded-full px-4">
    </label>
    <label class="col-span-2 relative">
        Correo Institucional
        <input value="{{ $colaborador->correo_institucional }}" type="email"
            title="Ingrese una dirección de correo electrónico válida" name="correo_institucional"
            placeholder="Ingrese el correo institucional" class="p-3 w-full rounded-full px-4">
    </label>
    <label class="relative">
        Puesto
        <select name="id_puesto" id="selectPuesto" class="p-3 w-full rounded-full px-4">
            <option value="" selected>Selecciona un puesto</option>
            @foreach ($puestos as $puesto)
                <option {{ $isEdit && $colaborador->cargo->id_puesto == $puesto->id ? 'selected' : '' }}
                    value="{{ $puesto->id }}">
                    {{ $puesto->nombre }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="">
        Cargo
        <select required name="id_cargo" id="selectCargo" class="p-3 w-full rounded-full px-4">
            <option selected value="">Selecciona un cargo</option>
            @foreach ($cargos as $cargo)
                <option {{ $isEdit && $colaborador->cargo->id == $cargo->id ? 'selected' : '' }}
                    value="{{ $cargo->id }}">
                    {{ $cargo->nombre }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="col-span-2">
        Sede
        <select required name="id_sede" class="p-3 w-full rounded-full px-4">
            <option selected value="">Selecciona un sede</option>
            @foreach ($sedes as $sede)
                <option {{ $colaborador->id_sede == $sede->id ? 'selected' : '' }} value="{{ $sede->id }}">
                    {{ $sede->nombre }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="col-span-2">
        Rol
        <select required name="rol" class="p-3 w-full rounded-full px-4">
            <option selected value="0">
                Colaborador
            </option>
            <option {{ $colaborador->rol == 1 ? 'selected' : '' }} value="1">
                Administrador
            </option>
            <option {{ $colaborador->rol == 2 ? 'selected' : '' }} value="2">
                Developer
            </option>
        </select>
    </label>

</div>

{{-- ETIQUETA LOADING --}}
<div id="loading" class="absolute hidden inset-0  place-content-center bg-white/70">
    <div role="status">
        <svg aria-hidden="true" class="w-14 h-14 mr-2 text-gray-200 animate-spin :text-gray-600 fill-blue-600"
            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill" />
        </svg>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const loading = document.getElementById("loading")
        const selectCargo = document.getElementById('selectCargo')


        function loadingActive() {
            loading.classList.add('grid');
            loading.classList.remove('hidden');
        }

        function loadingRemove() {
            loading.classList.add('hidden');
            loading.classList.remove('grid');
        }


        selectPuesto.addEventListener('change', async function() {
            const id_puesto = this.value;
            try {
                loadingActive()
                const response = await axios.get(`/cargos/json/${id_puesto}`)
                selectCargo.innerHTML = '<option value="" selected >Selecciona un cargo</option>';
                const cargos = response.data;
                cargos.forEach(function(cargo) {
                    const option = document.createElement('option');
                    option.value = cargo.id;
                    option.textContent = cargo.nombre;
                    selectCargo.appendChild(option);
                });

            } catch (error) {
                console.log(error)
            } finally {
                loadingRemove()
            }
        });
    })
</script>
