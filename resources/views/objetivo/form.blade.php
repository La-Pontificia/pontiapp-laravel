<div class="grid grid-cols-1 gap-2">
    <span>
        <input type="text" required name="objetivo" value="{{ $objetivo->objetivo }}" placeholder="Nombre de objetivo"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
    </span>
   
    <span>
        <textarea rows="5" required name="descripcion" type="text" value="{{ $objetivo->descripcion }}" placeholder="Descripcion"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600"></textarea>
    </span>

    <span>
        <textarea rows="7" required name="indicadores" type="text" value="{{ $objetivo->indicadores }}" placeholder="Indicadores"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600"></textarea>
    </span>

    <span>
        <input type="number" required name="porcentaje" value="{{ $objetivo->porcentaje }}" placeholder="Porcentaje"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
    </span>

   
</div>
