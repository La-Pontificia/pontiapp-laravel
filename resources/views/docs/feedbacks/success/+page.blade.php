@extends('docs.+layout')

@section('title', 'Docs - Feedback enviado')

@section('content')
    <div class="py-10 space-y-5 px-10">
        <div class="max-w-xl mx-auto w-full text-center">
            <h1 class="text-center max-w-md pb-3 mx-auto font-bold tracking-tight text-white text-3xl">
                Gracias por tu feedback 🚀
            </h1>
            <p class="opacity-70">
                Solucionaremos el problema lo antes posible o tomaremos en cuenta tu
                sugerencia.
            </p>
        </div>
        <div class="flex justify-center">
            <a href="/" class="text-blue-600 font-semibold flex items-center gap-2 tracking-tight">
                @svg('fluentui-arrow-left-20', 'w-5 h-5')
                Volver a la página principal
            </a>
        </div>
    </div>
@endsection
