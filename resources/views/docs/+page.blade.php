@extends('docs.+layout')

@section('title', 'Docs - Feedbacks')
@php
    $options = [
        'tecnical_problems' => 'Problema técnico',
        'suggestions' => 'Sugerencia',
        'complaints' => 'Queja',
        'others' => 'Otros',
    ];
    $urgency = [
        'high' => 'Alta',
        'medium' => 'Media',
        'low' => 'Baja',
    ];

@endphp
@section('content')
    <div class="py-10 flex-grow grid place-content-center space-y-2 px-10">
        <span class="mx-auto text-4xl block">🚧</span>
        <h2 class="text-sm opacity-60 text-center">
            Estamos construyendo esta página
        </h2>
        <div class="flex justify-center">
            <a href="/" class="text-blue-600 text-xs font-semibold flex items-center gap-2 tracking-tight">
                @svg('fluentui-arrow-left-20', 'w-5 h-5')
                Volver atras
            </a>
        </div>
    </div>
@endsection
