<aside id="cta-sidebar"
    class="z-40 w-[250px] min-w-[250px] transition-all h-full max-md:top-12 max-md:bg-white max-md:border-r overflow-y-auto max-md:-translate-x-full max-md:fixed"
    aria-label="Sidebar">
    <div class="h-full pr-0 flex flex-col">
        {{-- <div class="flex items-center p-2 px-3 text-sm gap-3 border-b">
            @include('commons.avatar', [
                'src' => $current_user->profile,
                'className' => 'w-10',
                'alt' => $current_user->first_name . ' ' . $current_user->last_name,
                'altClass' => 'text-sm',
            ])
            <div>
                <p class="line-clamp-1 leading-4 text-ellipsis overflow-hidden font-semibold">
                    {{ $current_user->first_name }} {{ $current_user->last_name }}
                </p>
            </div>
            <button class="hover:underline text-nowrap text-blue-500 tracking-tight font-semibold">
                Mi perfil
            </button>
        </div> --}}
        @include('components.modules.nav')
        <footer class="p-5 hover:[&>a]:underline text-xs text-black text-center">
            <a href="">
                Terminos y condiciones
            </a>
            ·
            <a href="">
                Política de privacidad
            </a>
            ·
            <a href="">
                Ayuda
            </a>
            ·
            <a href="">
                Contáctanos
            </a>
        </footer>
    </div>
</aside>
