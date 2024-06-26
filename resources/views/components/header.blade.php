<nav class=" bg-[#eaeaea] border-b h-14 w-full z-30">
    <div class="flex w-full gap-5 items-center h-full px-3">
        <div class="flex-grow flex items-center">
            <button id="toogle-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-grip">
                    <circle cx="12" cy="5" r="1" />
                    <circle cx="19" cy="5" r="1" />
                    <circle cx="5" cy="5" r="1" />
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="19" cy="12" r="1" />
                    <circle cx="5" cy="12" r="1" />
                    <circle cx="12" cy="19" r="1" />
                    <circle cx="19" cy="19" r="1" />
                    <circle cx="5" cy="19" r="1" />
                </svg>
            </button>
            <div class="p-4 w-fit">
                <div class="flex items-center justify-center w-full max-md:p-4">
                    <img src="/elp.webp" class="w-20" />
                </div>
            </div>
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
