@extends('layouts.app')

@section('title', 'La Pontificia - Iniciar Sesión')

@section('content')
    <section class="">
        <div class="min-h-svh max-sm:w-full text-gray-900 flex justify-center max-sm:justify-start">
            <div
                class="flex flex-col max-sm:w-full gap-4 relative sm:rounded-lg justify-center items-center max-sm:justify-start max-sm:items-start">
                <div class="p-6 relative z-10 w-[450px] max-sm:w-full max-w-full  ">
                    <div class="w-full">
                        <h1 class="text-2xl max-w-[20ch] mx-auto pb-3 text-center font-semibold tracking-tight">
                            Centro de Administración La Pontificia
                        </h1>
                        <div class="w-full">
                            <form method="POST" action="/api/login" class="grid gap-2">
                                @csrf
                                <div class="divide-y border rounded-xl">
                                    <input required autofocus class="w-full border-0 p-3 rounded-t-xl" name="email"
                                        type="email" value="{{ old('email') }}" placeholder="Correo electrónico" />

                                    <input required class="w-full p-3 rounded-b-xl" name="password"
                                        value="{{ old('password') }}" placeholder="Contraseña" />
                                </div>
                                @error('email')
                                    <span class="text-sm px-2 text-red-500" role="alert">
                                        Credenciales incorrectas. Intente de nuevo.
                                    </span>
                                @enderror

                                <button type="submit"
                                    class="p-3 rounded-xl font-semibold bg-black text-white w-full hover:text-neutral-300">
                                    <span class="ml-3">
                                        Entrar
                                    </span>
                                </button>
                            </form>
                            <div class="flex items-center gap-2 mt-2 text-sm">
                                <span class="w-full border-b block"></span>
                                <p class="text-nowrap">o continuar con</p>
                                <span class="w-full border-b block"></span>
                            </div>
                            <a title="Aun no disponible" href="{{ route('login.azure') }}"
                                class="w-full mt-2 gap-2 rounded-xl justify-center text-gray-900 bg-white hover:border-blue-600 border border-neutral-200 text-sm p-4 text-center inline-flex items-center">
                                <img src="/RE1Mu3b.png" class="w-24" alt="">
                            </a>
                            @if (session('error'))
                                <div class="text-base max-w-max p-2 text-red-600">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            @2024 <a href="https://elp.edu.pe" target="_blank"
                                class="border-b border-gray-500 border-dotted">
                                Grupo La Pontificia.
                            </a> All rights reserved.
                        </p>
                        {{-- <p class="opacity-60 text-center text-xs mt-2">Developed by <a href="https://daustinn.com"
                                class="hover:underline" target="_blank">Daustinn</a>
                            & <a href="https://www.instagram.com/diana_margoth000" class="hover:underline"
                                target="_blank">Diana</a>
                        </p> --}}
                    </div>
                </div>
                <div class="flex items-center justify-center w-full max-md:p-5 p-10 gap-10">
                    <img src="/elp.webp" alt="Logo - Escuela Superior La Pontificia" class="h-8" />
                    <img src="/ilp.webp" alt="Logo - Instituto La Pontificia" class="h-8" />
                    <img src="/ec.webp" alt="Logo - Educación Continua La Pontificia" class="h-8 invert" />
                </div>
            </div>
            <div class="fixed max-sm:hidden pointer-events-none inset-0 opacity-60">
                <img src="/2_11d9e3bcdfede9ce5ce5ace2d129f1c4.svg" class="object-cover w-full h-full" alt="">
            </div>
        </div>
    </section>
@endsection
