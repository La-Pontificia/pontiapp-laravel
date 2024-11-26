<div class="flex">
    <div id="search"
        class="max-md:absolute hidden w-full data-[open]:block md:block max-md:p-2 max-md:inset-0 max-md:w-full max-md:overflow-y-auto">
        <div class="flex flex-col max-md:h-svh max-md:overflow-y-auto">
            <label class="relative">
                <div class="absolute inset-y-0 z-[21] flex items-center px-2 pointer-events-none">
                    @svg('fluentui-search-28-o', 'w-5 h-5 text-blue-600')
                </div>
                <input autocomplete="off" type="search" id="search-input" placeholder="Buscar"
                    style="border: 0; padding-left: 35px"
                    class="rounded-lg md:w-[500px] w-full z-20 max-w-full drop-shadow-[0_1px_1px_rgba(0,0,0,.20)] hover:shadow-[0_1px_5px_rgba(0,0,0,.10)] border">
            </label>
            <template id="search-item-template">
                <div>
                    <a href=""
                        class="hover:bg-stone-100 group text-stone-400 items-center gap-2 rounded-lg flex p-2">
                        <div class="aspect-square w-8 h-8 p-1 bg-stone-50 rounded-full border border-stone-300">
                            @svg('fluentui-person-20-o', 'w-full h-full')
                        </div>
                        <div class="flex flex-col flex-grow">
                            <h2 class="text-black leading-4">
                                Unknown
                            </h2>
                            <p class="text-xs text-stone-600">
                                Unknown
                            </p>
                        </div>
                        <div
                            class="-rotate-45 group-hover:text-blue-600 group-hover:translate-x-1 group-hover:-translate-y-0.5">
                            @svg('fluentui-arrow-left-20', 'w-4 h-4 -rotate-180')
                        </div>
                    </a>
                </div>
            </template>
            <div id="search-overlay" class="fixed inset-0 hidden data-[open]:block bg-black/50"></div>
            <div id="search-result-modal"
                class="fixed hidden inset-0 pointer-events-none data-[open]:flex md:pl-14 max-md:px-2 max-md:flex-col md:justify-center z-10 md:pt-12 pt-12 pb-2 overflow-y-auto">
                <div
                    class="bg-white shadow-xl md:w-[500px] pointer-events-auto w-full p-2 rounded-lg h-max overflow-y-auto">
                    <h2 class="text-stone-600 text-sm">
                        Personas
                    </h2>
                    <div id="search-result" class="flex divide-y [&>div]:py-0.5 flex-col">

                    </div>
                    <div data-open id="search-empty-result" class="p-20 hidden data-[open]:grid place-content-center">
                        <p>
                            Realiza una búsqueda
                        </p>
                    </div>
                    <div id="search-notmatch-result" class="p-20 hidden data-[open]:grid place-content-center">
                        <p>
                            No se encontraron resultados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
