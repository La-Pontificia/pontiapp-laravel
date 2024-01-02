@extends('layouts.headers')

@section('app')
    <div class="h-[calc(100svh-100px)] w-full grid place-content-center">
        <div class="text-center">
            <div>
                <img width="300" src="/sad.png" alt="">
            </div>
            <h1 class="text-7xl font-mono">404</h1>
            <p class="text-xl mb-2 text-neutral-400">OPPS.. Recurso no encontrado</p>
            <a href="/" class="p-3 block rounded-full text-white font-semibold bg-black px-4">
                Ir a inicio
            </a>
        </div>
    </div>
@endsection
