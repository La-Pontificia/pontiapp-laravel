@extends('layouts.app')

@section('content')
    <section class="">
        <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
            <div class="flex flex-col gap-4 relative sm:rounded-lg justify-center items-center">
                <div class="p-6 relative z-10 w-[450px] max-w-full bg-white shadow-md">
                    <img src="/elp.gif" class="w-24 mx-auto sm:mx-0" />
                    <div class="w-full">
                        <h1 class=" text-center inline-block text-2xl text-gray-900 font-semibold bg-white ">
                            Iniciar sesión
                        </h1>
                        <p class="text-sm opacity-75 py-1">Para poder iniciar
                            sesión en una cuenta debe ser creado previamente por un administrador.
                        </p>
                        <form id="form-credentials" class="hidden" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mx-auto max-w-sm py-5">
                                <div id="credentials-forms">
                                    <input required autofocus id="email"
                                        class="w-full py-2 appearance-none focus:border-blue-500 border-b border-gray-300 placeholder-gray-500 text-base focus:outline-none focus:bg-white"
                                        name="email" value="{{ old('email') }}" placeholder="Nombre de usuario" />

                                    @error('email')
                                        <span class="text-sm px-2 text-red-500" role="alert">
                                            {{ $message == 'These credentials do not match our records.' ? 'Estas credenciales no coinciden con nuestros registros.' : '' }}
                                        </span>
                                    @enderror

                                    <input required
                                        class="w-full outline-0 py-2 mt-3 px-0 appearance-none border-0 border-b border-gray-300 placeholder-gray-500 text-base focus:outline-none focus:border-gray-400 focus:bg-white"
                                        type="password" value="{{ old('password') }}" name="password"
                                        placeholder="Contraseña" />

                                    @error('password')
                                        <span class="text-sm px-2 text-red-500" role="alert">
                                            {{ $message == 'These credentials do not match our records.' ? 'Estas credenciales no coinciden con nuestros registros.' : '' }}
                                        </span>
                                    @enderror
                                    <button type="submit"
                                        class="mt-3 h-10 tracking-wide  bg-blue-800/90 text-white w-full rounded-sm hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                        <span class="ml-3">
                                            Entrar
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="w-full" id="form-azure">
                            <a href="/login/azure"
                                class="w-full mt-2 gap-2 justify-center text-gray-900 bg-white hover:bg-gray-100 shadow-sm border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 text-sm px-5 h-12 text-center inline-flex items-center">
                                <img src="/RE1Mu3b.png" class="w-20" alt="">
                            </a>

                            @if (session('error'))
                                <div class="text-base max-w-max p-2 text-red-600">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            @2024 <a href="https.//elp.edu.pe" target="_blank"
                                class="border-b border-gray-500 border-dotted">
                                Escuela Superior La Pontificia.
                            </a> All rights reserved.
                        </p>
                        <p class="opacity-60 text-center text-sm mt-2">Developed by <a href="https://daustinn.com"
                                class="hover:underline" target="_blank">Daustinn</a>
                            & <a href="https://daustinn.com" class="hover:underline" target="_blank">Diana</a>
                        </p>
                    </div>
                </div>
                <div class="relative z-10 w-full">
                    <button id="button-credentials"
                        class="p-1 py-2 font-semibold bg-white hover:opacity-90 flex justify-start px-5 gap-2 items-center w-full shadow-md">
                        <svg class="w-10" fill="currentColor" viewBox="0 0 32 32" id="icon"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M16,22a4,4,0,1,0-4-4A4,4,0,0,0,16,22Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,16,16Z"></path>
                            <rect x="14" y="6" width="4" height="2"></rect>
                            <path
                                d="M24,2H8A2.002,2.002,0,0,0,6,4V28a2.0023,2.0023,0,0,0,2,2H24a2.0027,2.0027,0,0,0,2-2V4A2.0023,2.0023,0,0,0,24,2ZM20,28H12V26a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1Zm2,0V26a3,3,0,0,0-3-3H13a3,3,0,0,0-3,3v2H8V4H24V28Z">
                            </path>
                            <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" fill="none"
                                class="cls-1" width="32" height="32"></rect>
                        </svg>
                        <div class="text-left flex flex-col">
                            <p class="leading-4">Credenciales</p>
                            <p class="text-sm font-normal opacity-60">Utiliza tu nombre de usuario y contraseña</p>
                        </div>
                    </button>
                    <button id="button-azure"
                        class="p-1 py-2 font-semibold bg-white hover:opacity-90 hidden justify-start px-5 gap-2 items-center w-full shadow-md">
                        <svg class="w-8" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                            <g id="SVGRepo_iconCarrier">
                                <path fill="#F35325" d="M1 1h6.5v6.5H1V1z"></path>
                                <path fill="#81BC06" d="M8.5 1H15v6.5H8.5V1z"></path>
                                <path fill="#05A6F0" d="M1 8.5h6.5V15H1V8.5z"></path>
                                <path fill="#FFBA08" d="M8.5 8.5H15V15H8.5V8.5z"></path>
                            </g>
                        </svg>
                        <div class="text-left flex flex-col">
                            <p class="leading-4">Microsoft</p>
                            <p class="text-sm font-normal opacity-60">Utiliza tu correo institucional</p>
                        </div>
                    </button>
                </div>
            </div>
            <div class="fixed inset-0">
                <img src="/2_11d9e3bcdfede9ce5ce5ace2d129f1c4.svg" class="object-cover w-full h-full" alt="">
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const formCredentials = document.getElementById('form-credentials')
        const formAzure = document.getElementById('form-azure')

        const buttonCredentials = document.getElementById('button-credentials')
        const buttonAzure = document.getElementById('button-azure')

        buttonCredentials.addEventListener('click', () => {
            toggle(0)
        })

        buttonAzure.addEventListener('click', () => {
            toggle(1)
        })

        function toggle(value) {
            if (value === 0) {
                formCredentials.classList.remove('hidden')
                formAzure.classList.add('hidden')
                buttonCredentials.classList.add('hidden')
                buttonAzure.classList.remove('hidden')
                buttonAzure.classList.add('flex')

            } else if (value === 1) {
                formCredentials.classList.add('hidden')
                formAzure.classList.remove('hidden')
                buttonCredentials.classList.remove('hidden')
                buttonAzure.classList.add('hidden')
            }
        }
    </script>
@endsection
