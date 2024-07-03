<aside id="cta-sidebar"
    class="z-40 w-[300px] min-w-[300px] transition-all h-full max-sm:top-12 max-sm:bg-white max-sm:border-r overflow-y-auto max-sm:-translate-x-full max-sm:fixed"
    aria-label="Sidebar">
    <div class="h-full pr-0 flex flex-col">
        <div class="flex items-center p-2 px-3 text-sm gap-3 border-b">
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
        </div>
        @include('components.nav-sidebar')
        <footer class="p-5 text-sm text-black opacity-60 text-center">
            La pontificia &copy; 2024
        </footer>
    </div>
</aside>
