<header class="h-20 px-5 flex justify-between items-center max-w-7xl mx-auto w-full">
    <div class="flex-grow basis-0 flex text-neutral-800 items-center gap-3">
        <div class=" flex items-center gap-2">
            <a href="/" class="px-2">
                <img src="/lp.webp" class="w-28 invert grayscale" alt="Logo La Pontifica" />
            </a>
            <span class="h-[25px] border-r border-stone-700"></span>
            <a href="/docs" class="text-blue-600 font-semibold tracking-tight text-base">
                <h2>
                    Docs
                </h2>
            </a>
        </div>
    </div>
    <div>
        <label class="relative lg:block hidden">
            <div class="absolute inset-y-0 pointer-events-none flex items-center px-2">
                @svg('fluentui-search-20-o', 'h-7 w-7 text-blue-500')
            </div>
            <input data-no-styles type="text"
                class="p-3 min-w-[350px] focus:outline-none bg-stone-900 border border-stone-800 placeholder:text-stone-600 font-semibold rounded-xl px-4 pl-10"
                placeholder="Buscar">
        </label>
    </div>
    <div class="flex flex-grow basis-0 justify-end">
        <a href="/" title="Ir a la página principal" class="p-3 rounded-xl text-sm font-semibold px-4">
            @include('commons.avatar', [
                'key' => $cuser->id,
                'src' => $cuser->profile,
                'className' => 'w-10',
                'alt' => $cuser->names(),
                'altClass' => 'text-sm',
            ])
        </a>
    </div>
</header>
