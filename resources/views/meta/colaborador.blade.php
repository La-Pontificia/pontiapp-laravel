@extends('layouts.meta')

@section('content-meta')
    @include('meta.listaEdas', ['eda' => null, 'eda' => $id_colab, 'id_eda' => null])
    <div class="grid place-content-center p-10">
        <h1 class="text-center max-w-[25ch] font-semibold text-lg mx-auto pb-5">Bienvenido a la sección de tus Edas La
            Pontificia
        </h1>
        <img src="/gente-negocios-discutiendo-graficos_23-2148462714.avif" alt="">
    </div>
@endsection
