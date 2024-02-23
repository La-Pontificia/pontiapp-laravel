@extends('layouts.headers')

@section('app')
    <div style="" id="app" class="h-screen">
        @guest
            @if (Route::has('login'))
                <main class="min-h-screen bg-[#fffdfc]">
                    @yield('content')
                </main>
            @endif
        @else
            @php
                $hasMantenimiento = in_array('mantenimiento', $colaborador_actual->privilegios);
                $reportes = in_array('reportes', $colaborador_actual->privilegios);
                $auditoria = in_array('auditoria', $colaborador_actual->privilegios);
                $edas = in_array('mis_edas', $colaborador_actual->privilegios);
                $colaboradores = in_array('ver_colaboradores', $colaborador_actual->privilegios);
            @endphp
            <div style="" id="app" class="h-screen">
                <nav
                    class="fixed pl-[250px] max-sm:pl-0 border-b :border-gray-700 w-full border-gray-200 backdrop-blur-md z-30">
                    <div class=" flex w-full gap-3 px-4 items-center h-16">
                        <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar"
                            aria-controls="cta-button-sidebar" type="button"
                            class="inline-flex items-center p-2 mt-2  text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ">
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>

                        <div class="flex ml-auto items-center md:order-2">
                            <button type="button"
                                class="flex text-sm  rounded-full text-white w-full p-1  items-center gap-2 md:mr-0 focus:ring-4 focus:ring-gray-300 bg-[#2b3235]"
                                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                                data-dropdown-placement="bottom">
                                <span class="w-[40px] min-w-[40px] h-[40px] block overflow-hidden rounded-full">
                                    <img class="w-full h-full object-cover"
                                        src={{ $colaborador_actual->perfil ? $colaborador_actual->perfil : '/profile-user.png' }}
                                        alt="">
                                </span>
                                <span class="font-medium max-sm:hidden pr-3">
                                    {{ $colaborador_actual->nombres }}
                                    {{ $colaborador_actual->apellidos }}
                                </span>
                                @if ($colaborador_actual->rol == 1 || $colaborador_actual->rol == 2)
                                    <span class="p-2 py-1 rounded-full font-normal bg-[#fc5200] text-sm text-white">
                                        {{ $colaborador_actual->rol == 1 ? 'Admin' : 'Developer' }}
                                    </span>
                                @endif
                            </button>
                            <div class="z-50 hidden font-medium my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-2xl shadow :bg-gray-700 :divide-gray-600"
                                id="user-dropdown">
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="/meta/{{ $colaborador_actual->id }}"
                                            class="block px-4 w-full py-2 text-gray-700 hover:bg-gray-100">
                                            Mis edas
                                        </a>
                                    </li>
                                    <li>
                                        <button data-modal-target="change-modal" data-modal-toggle="change-modal"
                                            class="block px-4 py-2 text-left text-gray-700 hover:bg-gray-100">Cambiar
                                            contraseña</button>
                                    </li>
                                    <li>
                                        <button data-modal-target="change-modal-profile"
                                            data-modal-toggle="change-modal-profile"
                                            class="block px-4 w-full py-2 text-left text-gray-700 hover:bg-gray-100">Cambiar
                                            foto</button>
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
                    </div>
                </nav>
                <aside id="cta-button-sidebar"
                    class="fixed top-0 left-0 z-40 w-[250px] h-screen transition-transform -translate-x-full sm:translate-x-0"
                    aria-label="Sidebar">
                    <div class="h-full px-3 py-5 pt-2 flex flex-col overflow-y-auto bg-[#020b0f] shadow-lg">
                        <a href="/" class="flex  justify-center py-5 items-center">
                            <span class="w-36 block text-slate-200">
                                <svg version="1.0" 
                             viewBox="0 0 1483.000000 569.000000"
                            preserveAspectRatio="xMidYMid meet">
                           
                           <g transform="translate(0.000000,569.000000) scale(0.100000,-0.100000)"
                           fill="currentColor" stroke="none">
                           <path d="M1865 5536 c-41 -18 -82 -67 -96 -117 -8 -27 -19 -41 -33 -44 -215
                           -43 -399 -118 -560 -227 -266 -180 -463 -440 -566 -746 -36 -108 -505 -2559
                           -521 -2722 -29 -307 58 -643 237 -913 210 -315 535 -535 917 -619 l102 -23
                           5865 0 5865 0 105 23 c265 59 506 185 697 365 191 181 328 402 398 643 29 99
                           492 2529 507 2658 13 114 4 290 -22 416 -59 292 -187 528 -399 741 -218 217
                           -461 345 -771 405 -91 18 -261 19 -4497 22 l-4403 2 0 31 c0 16 -7 43 -15 59
                           -33 64 59 60 -1427 60 -1102 -1 -1359 -3 -1383 -14z m402 -151 c41 -17 70 -40
                           84 -67 8 -15 3 -21 -25 -34 -34 -17 -35 -16 -66 9 -60 51 -165 29 -209 -44
                           -66 -109 -4 -212 117 -194 32 5 54 16 76 38 l31 32 -63 3 c-52 2 -63 6 -58 18
                           3 9 6 24 6 35 0 18 8 19 105 19 l105 0 -7 -32 c-22 -115 -114 -190 -234 -190
                           -64 0 -105 18 -143 62 -53 63 -56 144 -8 233 55 103 187 154 289 112z m2060
                           -6 c171 -83 102 -360 -100 -398 -125 -23 -217 41 -225 158 -5 74 10 123 56
                           173 75 83 181 109 269 67z m-1512 -11 c15 -12 34 -37 41 -55 25 -58 -8 -135
                           -70 -170 -18 -10 -18 -13 7 -77 15 -36 27 -71 27 -77 0 -6 -16 -9 -37 -7 -35
                           3 -38 6 -63 68 -25 62 -28 65 -63 68 -35 3 -36 2 -42 -35 -17 -95 -19 -98 -58
                           -101 -20 -2 -37 1 -37 5 0 11 46 277 61 351 l10 52 98 0 c86 0 102 -3 126 -22z
                           m309 -110 c-13 -73 -24 -143 -24 -155 0 -55 103 -69 135 -19 11 17 65 268 65
                           303 0 2 18 3 40 3 22 0 40 -1 40 -2 0 -2 -13 -74 -29 -160 -20 -107 -36 -167
                           -50 -186 -23 -33 -71 -59 -116 -63 -73 -5 -97 1 -131 35 -41 41 -42 57 -14
                           217 30 172 25 159 69 159 l38 0 -23 -132z m666 117 c61 -31 77 -124 32 -184
                           -37 -51 -80 -71 -148 -71 l-62 0 -12 -70 -12 -70 -39 0 c-21 0 -39 2 -39 5 0
                           3 16 94 35 202 19 108 35 198 35 200 0 2 41 3 90 3 62 0 100 -5 120 -15z
                           m9795 -448 c374 -102 640 -371 736 -743 19 -72 23 -115 23 -229 l0 -140 -238
                           -1245 c-131 -685 -249 -1279 -263 -1320 -107 -324 -361 -561 -708 -662 l-80
                           -23 -5805 -3 c-6420 -2 -5886 -8 -6071 62 -236 88 -436 268 -547 491 -77 156
                           -106 280 -105 455 0 120 9 173 237 1365 130 682 246 1271 257 1309 81 273 304
                           520 570 632 l81 34 38 -42 38 -43 1369 0 1369 0 41 27 c24 16 48 43 59 67 l19
                           41 4440 -3 4440 -2 100 -28z"/>
                           <path d="M4162 5303 c-47 -23 -75 -67 -80 -128 -5 -65 15 -100 67 -116 106
                           -32 218 79 189 188 -17 67 -101 93 -176 56z"/>
                           <path d="M2656 5312 c-3 -5 -8 -32 -12 -60 l-7 -52 56 0 c48 0 58 4 76 26 26
                           33 26 49 1 74 -20 20 -103 29 -114 12z"/>
                           <path d="M3647 5313 c-3 -5 -8 -34 -12 -65 l-7 -58 38 0 c55 0 87 19 98 59 8
                           30 7 36 -13 52 -23 19 -95 27 -104 12z"/>
                           <path d="M1912 3508 c-95 -497 -172 -909 -172 -916 0 -10 167 -12 858 -10 857
                           3 857 3 897 25 52 28 100 78 119 125 20 46 21 138 2 182 -21 50 -76 107 -126
                           130 -44 20 -62 21 -613 24 l-569 3 5 22 c13 51 247 1287 247 1301 0 14 -28 16
                           -238 16 l-238 0 -172 -902z"/>
                           <path d="M5458 4252 c-123 -2 -128 -3 -133 -25 -6 -26 -235 -1324 -235 -1332
                           0 -3 177 -5 393 -5 l394 0 17 103 c10 56 20 114 23 130 l6 27 -262 0 c-245 0
                           -262 1 -257 18 3 9 46 249 96 532 49 283 92 523 94 532 2 10 1 19 -2 20 -4 2
                           -64 2 -134 0z"/>
                           <path d="M6423 3875 c-219 -61 -378 -255 -414 -507 -29 -196 59 -393 206 -462
                           137 -65 348 -50 463 34 23 16 44 30 46 30 2 0 2 -18 -1 -40 l-6 -40 125 0 124
                           0 83 473 c45 259 83 479 84 487 2 13 -18 15 -123 15 l-125 0 -9 -55 c-5 -30
                           -11 -57 -13 -59 -2 -3 -19 14 -38 37 -20 22 -61 53 -93 69 -49 24 -71 28 -157
                           30 -65 2 -118 -2 -152 -12z m238 -236 c74 -25 127 -87 142 -166 9 -44 -8 -137
                           -34 -191 -92 -190 -367 -238 -474 -84 -28 41 -30 50 -30 130 1 66 6 98 22 133
                           38 84 116 153 203 180 39 11 133 10 171 -2z"/>
                           <path d="M2700 3768 c0 -2 -20 -106 -45 -233 -25 -126 -45 -233 -45 -237 0 -5
                           190 -8 423 -8 235 0 451 -5 487 -10 194 -31 351 -188 381 -382 32 -204 -96
                           -415 -299 -491 -54 -20 -78 -21 -512 -27 l-455 -5 -75 -392 -75 -393 -87 0
                           c-65 0 -86 3 -83 13 6 17 145 751 145 765 0 9 -63 12 -240 12 -132 0 -240 -3
                           -240 -7 0 -3 -54 -289 -120 -634 -66 -345 -120 -630 -120 -633 0 -4 255 -5
                           567 -4 l567 3 75 395 76 395 285 6 c248 5 295 9 365 28 317 85 569 326 663
                           632 156 509 -148 1045 -669 1180 -79 21 -112 22 -526 26 -244 3 -443 3 -443 1z"/>
                           <path d="M9425 2618 c-32 -17 -76 -61 -91 -90 -8 -15 -14 -49 -14 -77 0 -123
                           142 -170 244 -81 83 73 87 178 10 239 -30 24 -114 29 -149 9z"/>
                           <path d="M12025 2618 c-32 -17 -76 -61 -91 -90 -8 -15 -14 -49 -14 -77 0 -132
                           151 -172 256 -67 69 69 72 159 8 215 -29 26 -43 31 -87 31 -29 0 -61 -6 -72
                           -12z"/>
                           <path d="M10193 2605 c-170 -37 -293 -161 -334 -337 l-13 -57 -70 -3 -70 -3
                           -18 -95 c-9 -52 -17 -107 -17 -122 -1 -28 0 -28 64 -28 36 0 65 -3 65 -7 0 -3
                           -27 -158 -60 -345 -33 -186 -60 -347 -60 -358 0 -19 7 -20 119 -20 66 0 122 4
                           125 8 3 4 33 169 67 365 l63 357 143 0 143 0 -5 -22 c-2 -13 -30 -167 -61
                           -343 -30 -176 -58 -330 -61 -343 l-5 -23 128 3 128 3 82 465 c46 256 83 475
                           83 488 l1 22 -265 0 c-175 0 -265 3 -265 10 0 26 30 78 59 103 55 46 127 60
                           273 55 146 -6 128 -19 148 102 6 36 13 77 16 91 5 26 3 27 -59 38 -85 15 -267
                           13 -344 -4z"/>
                           <path d="M5285 2588 c-10 -26 -241 -1348 -237 -1353 3 -3 63 -5 133 -5 l128 0
                           10 53 c6 28 20 106 31 172 11 66 25 144 31 173 l10 52 142 0 c78 0 170 5 205
                           10 196 32 350 162 413 347 30 87 33 232 6 308 -36 105 -131 196 -240 232 -70
                           23 -624 33 -632 11z m553 -268 c54 -33 74 -75 69 -145 -5 -73 -32 -129 -86
                           -178 -56 -51 -120 -67 -263 -67 -105 0 -118 2 -118 17 0 20 58 361 65 381 3 9
                           43 12 152 12 130 0 152 -2 181 -20z"/>
                           <path d="M8810 2441 l-124 -37 -12 -59 c-6 -33 -15 -77 -18 -97 l-7 -38 -84 0
                           c-47 0 -85 -1 -85 -3 0 -2 -9 -52 -20 -112 -11 -60 -20 -115 -20 -122 0 -10
                           21 -13 80 -13 70 0 80 -2 80 -17 0 -10 -16 -106 -35 -213 -19 -107 -35 -226
                           -35 -265 1 -168 94 -239 313 -238 54 1 100 3 103 5 2 3 11 43 19 89 8 46 17
                           96 21 112 l6 27 -71 0 c-83 0 -118 12 -130 43 -6 16 2 84 25 218 18 106 36
                           204 39 217 5 21 10 22 110 22 57 0 107 4 110 10 6 10 45 206 45 227 0 10 -29
                           13 -110 13 -109 0 -110 0 -105 23 2 12 12 63 20 112 9 50 18 100 21 113 5 27
                           16 28 -136 -17z"/>
                           <path d="M6583 2215 c-133 -37 -255 -125 -331 -239 -69 -103 -93 -177 -99
                           -307 -5 -92 -2 -116 16 -172 44 -130 142 -228 270 -268 95 -29 240 -27 338 6
                           149 50 273 157 342 296 50 99 64 168 59 289 -3 88 -7 104 -41 173 -47 94 -112
                           161 -197 201 -60 28 -74 31 -185 33 -81 2 -137 -2 -172 -12z m255 -262 c85
                           -53 112 -150 76 -273 -59 -199 -303 -298 -440 -178 -53 46 -68 83 -68 163 0
                           184 151 333 327 321 42 -3 72 -12 105 -33z"/>
                           <path d="M7831 2210 c-57 -21 -68 -28 -119 -74 l-33 -31 7 53 7 52 -121 0
                           c-67 0 -123 -4 -126 -8 -3 -5 -41 -215 -86 -468 -44 -252 -83 -469 -85 -482
                           l-6 -23 128 3 127 3 52 290 c55 307 61 331 100 382 82 107 275 124 334 29 29
                           -48 26 -88 -30 -412 -27 -159 -50 -290 -50 -291 0 -2 56 -3 125 -3 121 0 125
                           1 130 23 3 12 28 153 57 312 59 333 63 412 28 493 -28 65 -102 134 -167 156
                           -66 23 -203 21 -272 -4z"/>
                           <path d="M11156 2215 c-156 -44 -305 -168 -371 -308 -66 -138 -80 -302 -35
                           -420 68 -179 218 -277 424 -277 169 0 304 56 406 168 33 36 60 68 60 72 0 7
                           -187 130 -198 130 -4 0 -24 -18 -45 -39 -21 -21 -54 -47 -75 -57 -46 -22 -158
                           -30 -206 -14 -191 63 -177 364 21 473 117 63 236 57 309 -17 23 -22 43 -47 45
                           -54 3 -10 35 2 112 43 59 31 109 61 112 65 11 18 -35 88 -94 142 -86 81 -144
                           101 -296 104 -80 2 -136 -1 -169 -11z"/>
                           <path d="M12640 2211 c-93 -30 -142 -61 -221 -140 -129 -130 -185 -278 -177
                           -469 3 -86 7 -106 39 -172 43 -90 103 -154 179 -189 45 -21 73 -26 161 -29
                           140 -5 204 12 314 84 l27 18 -7 -42 -7 -42 125 0 125 0 6 27 c9 45 166 937
                           166 945 0 5 -56 8 -124 8 l-125 0 -12 -60 -12 -60 -57 53 c-38 36 -74 58 -110
                           70 -71 23 -216 22 -290 -2z m275 -240 c49 -22 99 -77 115 -127 27 -80 -10
                           -218 -79 -296 -18 -21 -60 -51 -93 -68 -52 -25 -73 -30 -135 -30 -53 0 -84 5
                           -112 19 -92 47 -133 142 -111 254 22 115 76 188 172 237 51 25 73 30 132 30
                           47 0 85 -7 111 -19z"/>
                           <path d="M9295 2188 c-9 -41 -165 -935 -165 -947 0 -8 39 -11 125 -11 69 0
                           125 2 125 4 0 2 38 221 85 487 47 266 85 485 85 486 0 2 -56 3 -125 3 -121 0
                           -125 -1 -130 -22z"/>
                           <path d="M11891 2158 c-16 -82 -161 -907 -161 -918 0 -6 50 -10 124 -10 l124
                           0 6 28 c9 44 166 939 166 946 0 3 -56 6 -124 6 l-125 0 -10 -52z"/>
                           </g>
                           </svg>
                            </span>
                        </a>
                        <div
                            class="grid [&>a>svg]:w-10 [&>a>svg]:mx-auto [&>a>svg]:h-full grid-cols-2 [&>a]:rounded-2xl gap-2 font-medium text-neutral-400">
                            @if ($edas)
                                <a href="/meta/{{ $colaborador_actual->id }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is("meta/$colaborador_actual->id*") ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M3 9H21M3 15H21M9 9L9 20M15 9L15 20M6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V7.2C21 6.0799 21 5.51984 20.782 5.09202C20.5903 4.71569 20.2843 4.40973 19.908 4.21799C19.4802 4 18.9201 4 17.8 4H6.2C5.0799 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.07989 3 7.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                    <span class="flex-1 text-sm">Mis edas</span>
                                </a>
                            @endif
                            @if ($colaboradores)
                                <a href="{{ route('colaboradores.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('colaboradores*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M18.14 21.62C17.26 21.88 16.22 22 15 22H8.99998C7.77998 22 6.73999 21.88 5.85999 21.62C6.07999 19.02 8.74998 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M15 2H9C4 2 2 4 2 9V15C2 18.78 3.14 20.85 5.86 21.62C6.08 19.02 8.75 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62C20.86 20.85 22 18.78 22 15V9C22 4 20 2 15 2ZM12 14.17C10.02 14.17 8.42 12.56 8.42 10.58C8.42 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58C15.58 12.56 13.98 14.17 12 14.17Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M15.58 10.58C15.58 12.56 13.98 14.17 12 14.17C10.02 14.17 8.42004 12.56 8.42004 10.58C8.42004 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                    <span class="flex-1 text-sm">Colaboradores</span>
                                </a>
                            @endif
                            @if ($auditoria)
                                <a href="{{ route('auditoria.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('auditoria*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Auditoria</span>
                                </a>
                            @endif
                            @if ($reportes)
                                <a href="{{ route('reportes.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('reportes*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M10.11 11.1501H7.46005C6.83005 11.1501 6.32007 11.6601 6.32007 12.2901V17.4101H10.11V11.1501V11.1501Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M12.7613 6.6001H11.2413C10.6113 6.6001 10.1013 7.11011 10.1013 7.74011V17.4001H13.8913V7.74011C13.8913 7.11011 13.3913 6.6001 12.7613 6.6001Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M16.5482 12.8501H13.8982V17.4001H17.6882V13.9901C17.6782 13.3601 17.1682 12.8501 16.5482 12.8501Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                    <span class="flex-1 text-sm">Reportes</span>
                                </a>
                            @endif
                            @if ($hasMantenimiento)
                                <div class="border-b col-span-2 my-1 border-neutral-700"></div>
                                <h2 class="col-span-2 text-xs opacity-70">MANTENIMIENTO</h2>
                                <a href="{{ route('edas.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('edas*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Edas (Data)</span>
                                </a>

                                <a href="{{ route('cuestionarios.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('cuestionarios*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M8 2V5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M16 2V5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M21 8.5V13.63C20.11 12.92 18.98 12.5 17.75 12.5C16.52 12.5 15.37 12.93 14.47 13.66C13.26 14.61 12.5 16.1 12.5 17.75C12.5 18.73 12.78 19.67 13.26 20.45C13.63 21.06 14.11 21.59 14.68 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M7 11H13" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M7 16H9.62" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M23 17.75C23 18.73 22.72 19.67 22.24 20.45C21.96 20.93 21.61 21.35 21.2 21.69C20.28 22.51 19.08 23 17.75 23C16.6 23 15.54 22.63 14.68 22C14.11 21.59 13.63 21.06 13.26 20.45C12.78 19.67 12.5 18.73 12.5 17.75C12.5 16.1 13.26 14.61 14.47 13.66C15.37 12.93 16.52 12.5 17.75 12.5C18.98 12.5 20.11 12.92 21 13.63C22.22 14.59 23 16.08 23 17.75Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M17.75 20.25C17.75 18.87 18.87 17.75 20.25 17.75C18.87 17.75 17.75 16.63 17.75 15.25C17.75 16.63 16.63 17.75 15.25 17.75C16.63 17.75 17.75 18.87 17.75 20.25Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                    <span class="flex-1 text-sm">Cuestionarios</span>
                                </a>

                                <a href="{{ route('areas.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('areas*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Areas</span>
                                </a>

                                <a href="{{ route('departamentos.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('departamentos*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Departamentos</span>
                                </a>

                                <a href="{{ route('puestos.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('puestos*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Puestos</span>
                                </a>

                                <a href="{{ route('cargos.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('cargos*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Cargos</span>
                                </a>

                                <a href="{{ route('sedes.index') }}"
                                    class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('sedes*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 text-sm">Sedes</span>
                                </a>

                                {{-- // modals --}}
                            @endif
                        </div>
                    </div>
                </aside>
                <main class="min-h-screen bg-[#fffdfc]">
                    @yield('content')
                </main>
                @include('profile.change-password')
                @include('profile.change-profile')
            </div>
        @endguest
    </div>
@endsection
