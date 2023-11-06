    <div class="grid grid-cols-5 h-[250px] text-base border rounded-xl divide-x overflow-hidden border-neutral-300">
        <span class="col-span-1">
            <textarea rows="5" required name="objetivo" type="text" placeholder="Objetivo"
                class="w-full border-0 h-full outline-none focus:bg-neutral-100 focus:outline-transparent transition-all">{{ $objetivo->objetivo }}</textarea>
        </span>
        <span class="col-span-2">
            <textarea rows="5" required name="descripcion" type="text" placeholder="Descripcion"
                class="w-full border-0 h-full outline-none focus:bg-neutral-100 focus:outline-transparent transition-all">{{ $objetivo->descripcion }}</textarea>
        </span>
        <span class="col-span-2">
            <textarea rows="7" required name="indicadores" type="text" placeholder="Indicadores"
                class="w-full border-0 h-full outline-none focus:bg-neutral-100 focus:outline-transparent transition-all">{{ $objetivo->indicadores }}</textarea>
        </span>
    </div>
