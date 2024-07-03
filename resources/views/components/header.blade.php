<nav class=" bg-[#eaeaea] border-b h-14 w-full z-30">
    <div class="flex w-full gap-5 items-center h-full px-3">
        <div class="flex-grow flex gap-2 items-center">
            <button id="toogle-sidebar" class="p-1 rounded-lg hover:bg-neutral-300 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    class="icon-xl-heavy">
                    <path fill="currentColor" class="opacity-50" fill-rule="evenodd"
                        d="M8.857 3h6.286c1.084 0 1.958 0 2.666.058.729.06 1.369.185 1.961.487a5 5 0 0 1 2.185 2.185c.302.592.428 1.233.487 1.961.058.708.058 1.582.058 2.666v3.286c0 1.084 0 1.958-.058 2.666-.06.729-.185 1.369-.487 1.961a5 5 0 0 1-2.185 2.185c-.592.302-1.232.428-1.961.487C17.1 21 16.227 21 15.143 21H8.857c-1.084 0-1.958 0-2.666-.058-.728-.06-1.369-.185-1.96-.487a5 5 0 0 1-2.186-2.185c-.302-.592-.428-1.232-.487-1.961C1.5 15.6 1.5 14.727 1.5 13.643v-3.286c0-1.084 0-1.958.058-2.666.06-.728.185-1.369.487-1.96A5 5 0 0 1 4.23 3.544c.592-.302 1.233-.428 1.961-.487C6.9 3 7.773 3 8.857 3M6.354 5.051c-.605.05-.953.142-1.216.276a3 3 0 0 0-1.311 1.311c-.134.263-.226.611-.276 1.216-.05.617-.051 1.41-.051 2.546v3.2c0 1.137 0 1.929.051 2.546.05.605.142.953.276 1.216a3 3 0 0 0 1.311 1.311c.263.134.611.226 1.216.276.617.05 1.41.051 2.546.051h.6V5h-.6c-1.137 0-1.929 0-2.546.051M11.5 5v14h3.6c1.137 0 1.929 0 2.546-.051.605-.05.953-.142 1.216-.276a3 3 0 0 0 1.311-1.311c.134-.263.226-.611.276-1.216.05-.617.051-1.41.051-2.546v-3.2c0-1.137 0-1.929-.051-2.546-.05-.605-.142-.953-.276-1.216a3 3 0 0 0-1.311-1.311c-.263-.134-.611-.226-1.216-.276C17.029 5.001 16.236 5 15.1 5zM5 8.5a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1M5 12a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <img src="/elp.webp" class="w-20" />
        </div>
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bell">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
            </svg>
        </button>
        <button type="button" class="w-9 aspect-square pointer-events-auto rounded-full overflow-hidden"
            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
            data-dropdown-placement="bottom">
            <img class="w-full h-full object-cover" src={{ $current_user->profile }} alt="">
        </button>
        <div class="z-50 hidden w-[170px] overflow-hidden pointer-events-auto border text-sm font-medium my-2 list-none bg-white divide-y divide-gray-100 rounded-2xl shadow-2xl"
            id="user-dropdown">
            <ul aria-labelledby="user-menu-button">
                <li>
                    <a href="/edas/{{ $current_user->id }}"
                        class="block px-4 w-full py-2 text-gray-700 hover:bg-gray-100">
                        Mis edas
                    </a>
                </li>
                <li>
                    <button data-modal-target="change-modal-profile" data-modal-toggle="change-modal-profile"
                        class="block px-4 w-full py-2 text-left text-gray-700 hover:bg-gray-100">Mi cuenta</button>
                </li>
            </ul>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cerrar
                    sesión</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </div>
    </div>
</nav>
