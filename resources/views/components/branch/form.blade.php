<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required value="{{ $name ? $name : '' }}" type="text" name="name" placeholder="Nombre del sede"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>

<label>
    <span class="block pb-1 text-sm font-semibold opacity-50 ">Nombre</span>
    <input required type="text" name="address" placeholder= "{{ $address ? $address : 'Dirección' }}"
        value="{{ $address ? $address : '' }}"
        class="bg-neutral-100 w-full border-2 border-neutral-400 p-1 px-2 rounded-lg">
</label>
