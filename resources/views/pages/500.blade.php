@extends('layouts.headers')

@section('app')
    <div class="flex flex-col h-svh bg-gradient-to-tr text-black from-yellow-400 via-rose-400 to-violet-400 ">
        <div class="w-full grid h-full place-content-center">
            <div class="text-center space-y-3">
                <h2 class="text-2xl font-bold">
                    500 | Error del servidor
                </h2>
                <p class="text-sm max-w-[35ch] text-black">
                    A ocurrido un error, por favor intenta de nuevo
                    o volver al <a href="/" class="font-bold hover:underline">inicio</a>.
                </p>
            </div>
        </div>
        <footer class="p-4 text-center text-xs text-black">
            Desarrollado por <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
                class=" font-semibold hover:underline">Daustinn</a> &copy; 2024
        </footer>
    </div>
@endsection
