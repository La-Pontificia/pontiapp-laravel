<nav class="flex gap-2">
    <div class="w-full items-center flex overflow-x-auto p-0.5">
        <div class="flex flex-grow gap-2 items-center">

            @if ($current_user->hasPrivilege('users:create'))
                <a href="{{ route('users.create') }}"
                    class="bg-blue-700 shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <span class="max-lg:hidden"> Nuevo usuario</span>
                </a>
            @endif

            <div class="flex gap-1 items-center p-1">
                <input value="{{ request()->query('q') }}" type="search" placeholder="Filtrar por usuario"
                    class="dinamic-search w-[200px] text-black outline-0 border border-neutral-300 flex items-center rounded-full gap-2 p-1.5 text-sm px-3 bg-neutral-100">
                <select
                    class="dinamic-select bg-white rounded-full p-1 px-3 focus:bg-blue-200 focus:outline-none focus:border-blue-700 border-neutral-300 cursor-pointer"
                    name="job_position">
                    <option value="0">Todos los puestos</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
                <select
                    class="dinamic-select bg-white rounded-full p-1 px-3 focus:bg-blue-200 focus:outline-none focus:border-blue-700 border-neutral-300 cursor-pointer"
                    name="role">
                    <option value="0">Todos los cargos</option>
                    @foreach ($roles as $role)
                        <option {{ request()->query('role') === $role->id ? 'selected' : '' }}
                            value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center gap-2">
            {{-- <button
                class="bg-[#ECECEC] text-black hover:bg-[#dfdfdf] flex items-center rounded-md gap-2 p-2 text-sm font-semibold px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-download">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" x2="12" y1="15" y2="3" />
                </svg>

                <span class="max-lg:hidden">Importar</span>
            </button> --}}
            <button
                class="bg-white hover:shadow-md flex items-center rounded-full gap-2 p-2 text-sm font-semibold px-3">
                <svg width="20" height="20" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_iconCarrier">
                        <defs>
                            <linearGradient id="a" x1="4.494" y1="-2092.086" x2="13.832" y2="-2075.914"
                                gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse">
                                <stop offset="0" stop-color="#18884f"></stop>
                                <stop offset="0.5" stop-color="#117e43"></stop>
                                <stop offset="1" stop-color="#0b6631"></stop>
                            </linearGradient>
                        </defs>
                        <title>file_type_excel</title>
                        <path
                            d="M19.581,15.35,8.512,13.4V27.809A1.192,1.192,0,0,0,9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5Z"
                            style="fill:#185c37"></path>
                        <path d="M19.581,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5L19.581,16l5.861,1.95L30,16V9.5Z"
                            style="fill:#21a366"></path>
                        <path d="M8.512,9.5H19.581V16H8.512Z" style="fill:#107c41"></path>
                        <path
                            d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z"
                            style="opacity:0.10000000149011612;isolation:isolate"></path>
                        <path
                            d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                            style="opacity:0.20000000298023224;isolation:isolate"></path>
                        <path
                            d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                            style="opacity:0.20000000298023224;isolation:isolate"></path>
                        <path
                            d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z"
                            style="opacity:0.20000000298023224;isolation:isolate"></path>
                        <path
                            d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z"
                            style="fill:url(#a)"></path>
                        <path
                            d="M5.7,19.873l2.511-3.884-2.3-3.862H7.758L9.013,14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359,3.84,2.419,3.905H10.821l-1.45-2.711A2.355,2.355,0,0,1,9.2,16.8H9.176a1.688,1.688,0,0,1-.168.351L7.515,19.873Z"
                            style="fill:#fff"></path>
                        <path d="M28.806,3H19.581V9.5H30V4.191A1.192,1.192,0,0,0,28.806,3Z" style="fill:#33c481">
                        </path>
                        <path d="M19.581,16H30v6.5H19.581Z" style="fill:#107c41"></path>
                    </g>
                </svg>
                <span class="max-lg:hidden">Exportar</span>
            </button>
        </div>
    </div>

</nav>
