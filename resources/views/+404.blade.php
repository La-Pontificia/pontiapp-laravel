@extends('layouts.headers')

@section('title', '404')

@section('app')
    <div class="flex flex-col h-svh bg-black text-white">
        <div class="flex-grow text-center grid place-content-center">
            <h2>
                <span class="text-5xl font-semibold">404</span>
                <br>
                <span class="text-sm">The page doesn't exist.</span>
            </h2>
            <a href="/" class="mt-4 bg-white text-black p-2 rounded-md px-3 text-sm font-medium">Volver al inicio</a>
        </div>
        <footer class="p-4 text-center text-xs text-white/80">
            developed by <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
                class=" font-semibold hover:underline">Daustinn</a> &copy; {{ date('Y') }}
        </footer>
    </div>
@endsection
