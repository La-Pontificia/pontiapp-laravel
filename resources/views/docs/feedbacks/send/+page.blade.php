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
    <div class="py-10 space-y-5 px-10">
        <h1 class="text-center max-w-md mx-auto tracking-tighter font-bold text-white text-3xl">
            Envia un bug o sugerencia
        </h1>
        <p class="opacity-60 max-w-md text-lg text-center mx-auto">
            ¿Necesitar ayuda? ¿Encontraste un error? ¿Tiene alguna sugerencia? ¡Háganos saber!
        </p>
        <form data-redirect-to-response action="/api/system/feedback" method="POST"
            class="max-w-3xl dinamic-form grid gap-5 font-medium mx-auto w-full">
            <label class="flex flex-col">
                <span class="text-sm opacity-50 block pb-1">
                    Como podemos ayudar?
                </span>
                <select data-no-styles name='type' required
                    class="bg-stone-900 focus:outline-none p-3 rounded-xl border-stone-800">
                    <option value=''>Selecciona una opción</option>
                    @foreach ($options as $key => $value)
                        <option value='{{ $key }}'>{{ $value }}</option>
                    @endforeach
                </select>
            </label>
            <label class="flex flex-col">
                <span class="text-sm opacity-50 block pb-1">
                    ¿Qué tan urgente es?
                </span>
                <select data-no-styles name='urgency' required
                    class="bg-stone-900 focus:outline-none p-3 rounded-xl border-stone-800">
                    <option value=''>Selecciona una opción</option>
                    @foreach ($urgency as $key => $value)
                        <option value='{{ $key }}'>{{ $value }}</option>
                    @endforeach
                </select>
            </label>
            <label class="flex flex-col">
                <span class="text-sm opacity-50 block pb-1">
                    Asunto
                </span>
                <input data-no-styles name='subject' class="bg-stone-900 focus:outline-none p-3 rounded-xl border-stone-800"
                    required>
            </label>
            <label class="flex flex-col">
                <span class="text-sm opacity-50 block pb-1">
                    Mensaje
                </span>
                <textarea rows="8" data-no-styles name='message'
                    class="bg-stone-900 resize-none focus:outline-none p-3 rounded-xl border-stone-800" required></textarea>
                <p class="text-xs pt-1 opacity-50">
                    Agregue detalles adicionales y enumere los pasos relevantes que haya tomado.
                </p>
            </label>
            <label class="flex flex-col">
                <span class="text-sm opacity-50 block pb-1">
                    Archivos adjuntos (opcional)
                </span>
                <input data-no-styles
                    class="bg-stone-900 file:bg-transparent file:border-none file:text-stone-300 resize-none focus:outline-none p-3 rounded-xl border-stone-800"
                    accept="image/*" value="advadv" type='file' name='attachments[]' multiple>
            </label>
            <button class="ml-auto bg-rose-600 text-white p-2 px-16 font-semibold rounded-lg shadow-xl shadow-rose-500/20">
                Enviar
            </button>
        </form>
    </div>
@endsection
