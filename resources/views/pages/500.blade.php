@extends('layouts.headers')

@section('app')
    <div class="flex flex-col h-svh">
        <div class="w-full grid h-full place-content-center">
            <div class="text-center space-y-3">
                <h1 class="text-7xl font-semibold tracking-tight">500</h1>
                <p class="text-sm">
                    A ocurrido un error, por favor intenta de nuevo.
                    "<span class="text-blue-600">{{ $error }}</span>"
                </p>
                <a href="/"
                    class="w-fit mx-auto block rounded-full font-semibold border-2 text-blue-700 hover:bg-blue-200 border-blue-700 py-1.5 px-4">
                    Ir a inicio
                </a>
            </div>
        </div>
        <footer class="p-4 text-center text-xs">
            Desarrollado por <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
                class=" font-semibold hover:underline">Daustinn</a> &copy; 2024
        </footer>
    </div>
@endsection
