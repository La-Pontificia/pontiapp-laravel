@extends('layouts.app')

@section('title', 'La Pontificia - Iniciar Sesión')

@section('content')
    <section class="">
        <div class="min-h-svh max-sm:w-full text-white flex max-sm:justify-start">
            <div class="flex h-full w-full">
                <div style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.70), rgba(0, 0, 0, 0.70)), url('/background.jpg');"
                    class="w-full min-h-svh bg-center bg-cover grid place-content-center">
                    <div
                        class="flex flex-col flex-grow justify-center gap-4 relative sm:rounded-lg items-center max-sm:justify-start max-sm:items-start">
                        <div class="flex-grow  flex flex-col justify-center">
                            <div class="p-10 relative z-10 w-[450px] max-sm:w-full max-w-full">
                                <div class="w-full ">
                                    {{-- <h1 class="text-2xl max-w-[20ch] mx-auto pb-3 text-center font-bold tracking-tighter">
                                        Centro de Administración La Pontificia
                                    </h1> --}}
                                    <div class="py-7">
                                        <img src="/lp.webp" class="w-32 drop-shadow-md mx-auto" />
                                    </div>
                                    {{-- <p class="pb-3 text-center mt-5">
                                        Ingresa tus credenciales para continuar.
                                    </p> --}}
                                    <div class="w-full">
                                        <form method="POST" action="/api/login" class="grid gap-5">
                                            @csrf
                                            <div class="space-y-3 font-semibold text-black">
                                                <input style="padding: 17px; border-radius: 10px" required autofocus
                                                    name="email" type="email" value="{{ old('email') }}"
                                                    class="h-12 font-normal" placeholder="Correo electrónico" />
                                                <input type="password" style="padding: 17px; border-radius: 10px" required
                                                    name="password" value="{{ old('password') }}" class="h-12 font-normal"
                                                    placeholder="Contraseña" />
                                            </div>
                                            @error('email')
                                                <span class="text-sm px-2 text-red-500" role="alert">
                                                    Credenciales incorrectas. Intente de nuevo.
                                                </span>
                                            @enderror

                                            <button type="submit"
                                                class="p-4 rounded-xl font-semibold bg-black text-white w-full hover:text-neutral-300">
                                                <span class="ml-3">
                                                    Entrar
                                                </span>
                                            </button>
                                        </form>
                                        <div class="flex items-center gap-2 mt-4 text-sm">
                                            <span class="w-full border-b border-neutral-500 block"></span>
                                            <p class="text-nowrap">o tambien</p>
                                            <span class="w-full border-b border-neutral-500 block"></span>
                                        </div>
                                        <a href="{{ route('login.azure') }}"
                                            class="w-full shadow-md hover:shadow-lg mt-4 gap-2 rounded-xl justify-center text-gray-900 bg-white hover:border-blue-600 text-sm p-4 text-center inline-flex items-center">
                                            <img src="/RE1Mu3b.png" class="w-24" alt="">
                                        </a>
                                        @if (session('error'))
                                            <div class="text-base max-w-max p-2 text-red-600">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                    </div>
                                    <p class="mt-6 text-xs text-gray-100 text-center">
                                        @2024 <a href="https://lp.com.pe" target="_blank"
                                            class="border-b border-gray-500 border-dotted">
                                            Grupo La Pontificia.
                                        </a> All rights reserved.
                                    </p>
                                </div>
                                <div class="flex items-center mt-6 justify-center w-full  gap-5">
                                    <img src="/elp.webp" alt="Logo - Escuela Superior La Pontificia" class="h-6" />
                                    <img src="/ilp.webp" alt="Logo - Instituto La Pontificia" class="h-6" />
                                    <img src="/ec.webp" alt="Logo - Educación Continua La Pontificia" class="h-6 invert" />
                                </div>
                            </div>
                        </div>
                        <footer class="p-4 text-center w-full text-xs text-white drop-shadow-md">
                            Developed by <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
                                class=" font-semibold hover:underline">Daustinn</a> &copy; 2024
                        </footer>
                    </div>
                </div>
            </div>
            <div class="fixed max-sm:hidden pointer-events-none inset-0 opacity-60">
                <img src="/2_11d9e3bcdfede9ce5ce5ace2d129f1c4.svg" class="object-cover w-full h-full" alt="">
            </div>
        </div>
    </section>
@endsection
