@extends('layouts.headers')

@section('title', '404')
@section('app')
    <div class="flex flex-col h-svh bg-black text-white">
        <div class="w-full grid h-full place-content-center">
            <div class="text-center space-y-3">
                <h1 class="text-4xl font-serif tracking-tight">Error 404</h1>
                <p class="text-sm max-w-[35ch] text-stone-300">
                    La página no existe, por favor intenta de nuevo
                    o volver al <a href="/" class="text-blue-400 hover:underline">inicio</a>.
                </p>

            </div>
        </div>
        <footer class="p-4 text-center text-xs text-stone-400">
            Desarrollado por <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
                class=" font-semibold hover:underline">Daustinn</a> &copy; 2024
        </footer>
    </div>
@endsection
