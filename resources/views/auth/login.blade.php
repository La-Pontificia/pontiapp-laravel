@extends('layouts.app')

@section('content')
    <section class="">
        <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
            <div class="bg-white shadow sm:rounded-lg flex justify-center items-center flex-1">
                <div class="p-3 sm:p-3">
                    <div>
                        <img src="/elp.gif" class="w-60 mx-auto" />
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-full flex-1">
                            <div class="my-4 border-b text-center">
                                <div
                                    class="leading-none px-2 inline-block text-lg text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                                    Inicia sesion con tu cuenta
                                </div>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mx-auto max-w-sm p-5">

                                    <input required autofocus id="email"
                                        class="w-full px-3 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-base focus:outline-none focus:border-gray-400 focus:bg-white"
                                        type="number" name="email" value="{{ old('email') }}"
                                        placeholder="Nombre de usuario" />

                                    @error('email')
                                        <span class="text-sm px-2 text-red-500" role="alert">
                                            {{ $message == 'These credentials do not match our records.' ? 'Estas credenciales no coinciden con nuestros registros.' : '' }}
                                        </span>
                                    @enderror

                                    <input required
                                        class="w-full px-3 py-3 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-base focus:outline-none focus:border-gray-400 focus:bg-white mt-3"
                                        type="password" name="password" placeholder="Contraseña" />

                                    @error('password')
                                        <span class="text-sm px-2 text-red-500" role="alert">
                                            {{ $message == 'These credentials do not match our records.' ? 'Estas credenciales no coinciden con nuestros registros.' : '' }}
                                        </span>
                                    @enderror
                                    <button type="submit"
                                        class="mt-3 h-11 tracking-wide font-semibold bg-blue-700 text-white w-full py-2 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                        <span class="ml-3">
                                            Entrar
                                        </span>
                                    </button>
                                    <span class="border-t border-neutral-300 mt-6 pt-4 block">
                                        <button type="button"
                                            class="w-full mt-2 gap-2 justify-center text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2 text-center inline-flex items-center dark:focus:ring-gray-800 dark:bg-white dark:border-gray-300 dark:text-gray-900 dark:hover:bg-gray-200 mr-2 mb-2">
                                            <img src="/microsoft-365.png" class="w-6" alt="">
                                            Microsoft 365
                                        </button>
                                    </span>
                                    <p class="mt-6 text-xs text-gray-600 text-center">
                                        I agree to abide by templatana's
                                        <a href="#" class="border-b border-gray-500 border-dotted">
                                            Terms of Service
                                        </a>
                                        and its
                                        <a href="#" class="border-b border-gray-500 border-dotted">
                                            Privacy Policy
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-indigo-100 h-full text-center hidden lg:flex">
                    <img src="/ponti-back.png" class="object-cover w-full h-full" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
